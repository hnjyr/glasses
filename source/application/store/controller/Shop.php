<?php

namespace app\store\controller;

use app\store\model\store\Shop as ShopModel;
use think\Db;
/**
 * 门店管理
 * Class Shop
 * @package app\store\controller\store
 */
class Shop extends Controller
{
    /**
     * 门店列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new ShopModel;
        $list = $model->getList();
        return $this->fetch('index', compact('list'));
    }

    /**
     * 腾讯地图坐标选取器
     * @return mixed
     */
    public function getpoint()
    {
        $this->view->engine->layout(false);
        return $this->fetch('getpoint');
    }

    /**
     * 添加门店
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function add()
    {
        $model = new ShopModel;
        if (!$this->request->isAjax()) {
            return $this->fetch('add');
        }
        // 新增记录
        if ($model->add($this->postData('shop'))) {
            return $this->renderSuccess('添加成功', url('shop/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 编辑门店
     * @param $shop_id
     * @return array|bool|mixed
     * @throws \think\exception\DbException
     */
    public function edit($shop_id)
    {
        // 门店详情
        $model = ShopModel::detail($shop_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 新增记录
        if ($model->edit($this->postData('shop'))) {
            return $this->renderSuccess('更新成功', url('shop/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    public function agree($shop_id)
    {
        $model = ShopModel::detail($shop_id);
        if (!$model->setAgree()) {
            return $this->renderError($model->getError() ?: '审核失败');
        }
        $this->addUser($shop_id);
        return $this->renderSuccess('审核成功');
    }

    public function addUser($shop_id)
    {
        $model = ShopModel::detail($shop_id);
        $arr['gender'] = $model['sex'];
        $arr['city'] = $model['city_id'];
        $arr['province'] = $model['province_id'];
        $arr['country'] = $model['region_id'];
        $arr['wxapp_id'] = 10001;
        $arr['create_time'] = time();
        $arr['type'] = 2;
        $arr['username'] = $model['phone'];
        $arr['shop_id'] = $shop_id;
        if($arr){
            $res = Db::name('user')->insert($arr);
            if($res){
                return true;
            }else{
                return false;
            }
        }
    }


    public function disagree($shop_id)
    {
        $model = ShopModel::detail($shop_id);
        if (!$model->setDisAgree()) {
            return $this->renderError($model->getError() ?: '拒绝失败');
        }
        return $this->renderSuccess('拒绝成功');
    }

    /**
     * 删除门店
     * @param $shop_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($shop_id)
    {
        // 门店详情
        $model = ShopModel::detail($shop_id);
        if (!$model->setDelete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        $this->delUser($shop_id);
        return $this->renderSuccess('删除成功');
    }

    public function delUser()
    {
        return Db::name('user')->where('shop_id',$sho_id)->update(['is_delete'=>1]);
    }

}