<?php

namespace app\api\controller;

use app\api\model\SalesmanOrder as SalesmanOrderModel;
use app\api\service\order\SalesmanCheckout as CheckoutModel;
use app\api\validate\order\SalesmanCheckout as CheckoutValidate;
use think\Db;
use app\common\model\Region;


/**
 * 订单控制器
 * Class Order
 * @package app\api\controller
 */
class SalesmanOrder extends Controller
{
    /* @var \app\api\model\User $user */
    private $user;

    /* @var CheckoutValidate $validate */
    private $validate;

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        // 用户信息
//        $this->user = $this->getUser();
        // 验证类
        $this->validate = new CheckoutValidate;
    }

    /**
     * 订单确认-立即购买
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function buyNow()
    {
        // 实例化结算台服务
        $Checkout = new CheckoutModel;
        // 订单结算api参数
        $params = $Checkout->setParam($this->getParam([
            'goods_id' => 0,
            'goods_num' => 0,
            'goods_sku_id' => 0,
            'address_id' => '',
        ]));
        $data = $this->request->post();
        if(!$data['token']){
            return $this->renderError('请先登录!');
        }
        $token = Db::name('user_token')->where('token',$data['token'])->find();
        if (!$token){
            return $this->renderError([],'请先登录!');
        }
        $this->user = Db::name('salesman')->find($token['user_id']);
        // 表单验证
        if (!$this->validate->scene('buyNow')->check($params)) {
            return $this->renderError($this->validate->getError());
        }
        // 立即购买：获取订单商品列表
        $model = new SalesmanOrderModel;
        $goodsList = $model->getOrderGoodsListByNow(
            $params['goods_id'],
            $params['goods_sku_id'],
            $params['goods_num']
        );
        // 获取订单确认信息
        $orderInfo = $Checkout->onCheckout($this->user, $goodsList);
        $orderInfo['address'] = Db::name('user_address')->where('address_id',$data['address_id'])->find();
        if ($this->request->isGet()) {
            return $this->renderSuccess($orderInfo);
        }

        // 订单结算提交
        if ($Checkout->hasError()) {
            return $this->renderError($Checkout->getError());
        }

        // 创建订单
        if (!$Checkout->createOrder($orderInfo)) {
            return $this->renderError($Checkout->getError() ?: '订单创建失败');
        }
        // 构建微信支付请求
        $payment = $model->onOrderPayment($this->user, $Checkout->model, $params['pay_type']);
        // 返回结算信息
        return $this->renderSuccess([
            'order_id' => $Checkout->model['order_id'],   // 订单id
            'pay_type' => $params['pay_type'],  // 支付方式
            'payment' => $payment               // 微信支付参数
        ], ['success' => '支付成功', 'error' => '订单未支付']);
    }



    /**
     * 再次支付
     * @param int $order_id 订单id
     * @param int $payType 支付方式
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function pay()
    {
        // 获取订单详情
        $data = $this->request->post();
        $order_id = $data['order_id'];
        $payType = $data['pay_type'];
        $token = $data['token'];
        if(!$order_id || !$payType || !$token){
            return $this->renderError('参数不正确!');
        }
        $token = Db::name('user_token')->where('token',$token)->find();
        if (!$token){
            return $this->renderError([],'请先登录!');
        }
        $this->user = Db::name('salesman')->find($token['user_id']);
        $model = SalesmanOrderModel::getUserOrderDetail($order_id, $this->user['salesman_id']);
        // 订单支付事件
        if (!$model->onPay($payType)) {
            return $this->renderError($model->getError() ?: '订单支付失败');
        }
        // 构建微信支付请求
        $payment = $model->onOrderPayment($this->user, $model, $payType);
        // 支付状态提醒
        return $this->renderSuccess([
            'order_id' => $model['order_id'],   // 订单id
            'pay_type' => $payType,             // 支付方式
            'payment' => $payment               // 微信支付参数
        ], ['success' => '支付成功', 'error' => '订单未支付']);
    }

    /**
     * 订单结算提交的参数
     * @param array $define
     * @return array
     */
    private function getParam($define = [])
    {
        return array_merge($define, $this->request->param());
    }

}
