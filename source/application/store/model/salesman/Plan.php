<?php

namespace app\store\model\salesman;

use think\Session;
use app\common\model\salesman\Plan as PlanModel;

/**
 * 商家用户模型
 * Class StoreUser
 * @package app\store\model
 */

class Plan extends PlanModel
{
    /**
     * 获取用户列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        return $this->alias('p')->join('salesman s','p.salesman_id = s.salesman_id')->field('p.*,s.real_name')
            ->where('p.is_delete', '=', '0')
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
        if (self::checkExist($data['month'],$data['salesman_id'])) {
            $this->error = '本月计划已存在,请勿重复添加!';
            return false;
        }
        $this->startTrans();
        try {
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
     * 更新记录
     * @param array $data
     * @return bool
     * @throws \think\exception\DbException
     */
    public function edit($data,$id)
    {
        $before = $this->find($id);
        if ($before['month'] != $data['month']){
            if (self::checkExist($data['month'],$data['salesman_id'])) {
                $this->error = '本月计划已存在,请勿重复添加!';
                return false;
            }
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


}
