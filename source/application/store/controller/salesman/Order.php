<?php

namespace app\store\controller\salesman;


use app\store\model\SalesmanOrder as SalesmanOrderModel;
use app\store\model\Express as ExpressModel;
use app\store\model\store\shop\Clerk as ShopClerkModel;
use app\store\controller\Controller;

use app\api\model\SalesmanOrder as OrderApiModel;
use think\Db;


/**
 * 订单管理
 * Class Order
 * @package app\store\controller
 */
class Order extends Controller
{
    /**
     * 待发货订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function delivery_list()
    {
        return $this->getList('待发货订单列表', 'delivery');
    }

    /**
     * 待收货订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function receipt_list()
    {
        return $this->getList('待收货订单列表', 'receipt');
    }

    /**
     * 待付款订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function pay_list()
    {
        return $this->getList('待付款订单列表', 'pay');
    }

    /**
     * 已完成订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function complete_list()
    {
        return $this->getList('已完成订单列表', 'complete');
    }

    /**
     * 已取消订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function cancel_list()
    {
        return $this->getList('已取消订单列表', 'cancel');
    }

    /**
     * 全部订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function all_list()
    {
        // 订单列表
        return $this->getList('全部订单列表', 'all');

        $model = new SalesmanOrderModel;
        $list = $model->getList('all', $this->request->param());
        // 自提门店列表
        return $this->fetch('index', compact('list'));

    }

    /**
     * 订单详情
     * @param $order_id
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function detail($order_id)
    {
        // 订单详情
        $detail = SalesmanOrderModel::detail($order_id);
        $detail['real_name'] = Db::name('salesman')->where('salesman_id',$detail['user_id'])->value('real_name');
        // 物流公司列表
        $expressList = ExpressModel::getAll();
        $express = $this->express($order_id,$detail['user_id']);
        if(!is_array($express)){
            $express = [];
        }
        return $this->fetch('detail', compact(
            'detail',
            'expressList',
            'express'
        ));
    }

    public function express($order_id,$user_id)
    {
        // 订单信息
        $order = OrderApiModel::getUserOrderDetail($order_id, $user_id);
        if (!$order['express_no']) {
            return '没有物流信息';
        }
        // 获取物流信息
        /* @var \app\store\model\Express $model */
        $model = $order['express'];
        $express = $model->dynamic($model['express_name'], $model['express_code'], $order['express_no']);
        if ($express === false) {
            return json($model->getError());
        }
        return $express['list'];
    }


    /**
     * 确认发货
     * @param $order_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function delivery($order_id)
    {
        $model = SalesmanOrderModel::detail($order_id);
        if ($model->delivery($this->postData('order'))) {
            return $this->renderSuccess('发货成功');
        }
        return $this->renderError($model->getError() ?: '发货失败');
    }

    /**
     * 修改订单价格
     * @param $order_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function updatePrice($order_id)
    {
        $model = SalesmanOrderModel::detail($order_id);
        if ($model->updatePrice($this->postData('order'))) {
            return $this->renderSuccess('修改成功');
        }
        return $this->renderError($model->getError() ?: '修改失败');
    }

    /**
     * 订单列表
     * @param string $title
     * @param string $dataType
     * @return mixed
     * @throws \think\exception\DbException
     */
    private function getList($title, $dataType)
    {
        $model = new SalesmanOrderModel;
        $list = $model->getList($dataType, $this->request->param());
        // 自提门店列表
//        $shopList = ShopModel::getAllList();
        return $this->fetch('index', compact('title', 'dataType', 'list', 'shopList'));


    }

}
