<?php

namespace app\store\model\salesman;

use think\Session;
use app\common\model\salesman\Salesman as SalesmanModel;

/**
 * 商家用户模型
 * Class StoreUser
 * @package app\store\model
 */

class Salesman extends SalesmanModel
{
    /**
     * 获取用户列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        return $this->where('is_delete', '=', '0')
            ->order(['create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
    }

    /**
     * 新增记录
     * @param $data
     * @return bool|false|int
     * @throws \think\exception\DbException
     */
    public function add($data)
    {
        if (self::checkExist($data['user_name'])) {
            $this->error = '用户名已存在';
            return false;
        }
        if (self::checkCity($data['province_id'],$data['city_id'],$data['region_id'],$data['type'])) {
            $this->error = '该区域已有负责人';
            return false;
        }
        if ($data['password'] !== $data['password_confirm']) {
            $this->error = '确认密码不正确';
            return false;
        }
        if (empty($data['type'])) {
            $this->error = '请选择角色类型';
            return false;
        }
        $this->startTrans();
        try {
            // 新增管理员记录
            $data['password'] = yoshop_hash($data['password']);
            $data['wxapp_id'] = 10001;
            $this->allowField(true)->save($data);
            // 新增角色关系记录
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }

    /**
     * 更新记录
     * @param array $data
     * @return bool
     * @throws \think\exception\DbException
     */
    public function edit($data)
    {
        if ($this['user_name'] !== $data['user_name']
            && self::checkExist($data['user_name'])) {
            $this->error = '用户名已存在';
            return false;
        }
        if (self::checkCity($data['province_id'],$data['city_id'],$data['region_id'],$data['type'])) {
            $this->error = '该区域已有负责人';
            return false;
        }
        if (!empty($data['password']) && ($data['password'] !== $data['password_confirm'])) {
            $this->error = '确认密码不正确';
            return false;
        }
        if (empty($data['type'])) {
            $this->error = '请选择所属角色';
            return false;
        }
        if (!empty($data['password'])) {
            $data['password'] = yoshop_hash($data['password']);
        } else {
            unset($data['password']);
        }
        $this->startTrans();
        try {
            // 更新管理员记录
            $this->allowField(true)->save($data);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }

    /**
     * 软删除
     * @return false|int
     */
    public function setDelete()
    {
        // 删除对应的角色关系
        return $this->save(['is_delete' => 1]);
    }

    /**
     * 更新当前管理员信息
     * @param $data
     * @return bool
     */
    public function renew($data)
    {
        if ($data['password'] !== $data['password_confirm']) {
            $this->error = '确认密码不正确';
            return false;
        }
        if ($this['user_name'] !== $data['user_name']
            && self::checkExist($data['user_name'])) {
            $this->error = '用户名已存在';
            return false;
        }
        // 更新管理员信息
        if ($this->save([
                'user_name' => $data['user_name'],
                'password' => yoshop_hash($data['password']),
            ]) === false) {
            return false;
        }
        // 更新session
        Session::set('yoshop_store.user', [
            'store_user_id' => $this['store_user_id'],
            'user_name' => $data['user_name'],
        ]);
        return true;
    }

}
