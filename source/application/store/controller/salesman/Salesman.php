<?php

namespace app\store\controller\salesman;

use app\store\controller\Controller;
use app\store\model\salesman\Salesman as SalesmanModel;

/**
 * 商家用户控制器
 * Class StoreUser
 * @package app\store\controller
 */
class Salesman extends Controller
{
    /**
     * 用户列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new SalesmanModel;
        $list = $model->getList();
        return $this->fetch('index', compact('list'));
    }

    /**
     * 添加业务员
     * @return array|mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function add()
    {
        $model = new SalesmanModel;
        if (!$this->request->isAjax()) {
            // 角色列表
            $roleList = (new SalesmanModel)->getList();
            return $this->fetch('add', compact('roleList'));
        }
        // 新增记录
        if ($model->add($this->postData('user'))) {
            return $this->renderSuccess('添加成功', url('salesman.salesman/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 更新业务员
     * @param $user_id
     * @return array|mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit($user_id)
    {
        // 管理员详情
        $model = SalesmanModel::detail($user_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', [
                'model' => $model,
            ]);
        }
        // 更新记录
        if ($model->edit($this->postData('user'))) {
            return $this->renderSuccess('更新成功', url('salesman.salesman/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 删除业务员
     * @param $user_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($user_id)
    {
        // 管理员详情
        $model = SalesmanModel::detail($user_id);
        if (!$model->setDelete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

}
