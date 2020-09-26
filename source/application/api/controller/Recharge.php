<?php

namespace app\api\controller;

use app\api\model\Setting as SettingModel;
use app\api\model\recharge\Plan as PlanModel;
use app\api\model\recharge\Order as OrderModel;
use app\api\service\Payment as PaymentService;
use app\common\enum\OrderType as OrderTypeEnum;

use think\Db;
/**
 * 用户充值管理
 * Class Recharge
 * @package app\api\controller
 */
class Recharge extends Controller
{
    /**
     * 充值中心
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 用户信息
        $userInfo = $this->getUser();
        // 充值套餐列表
        $planList = (new PlanModel)->getList();
        // 充值设置
        $setting = SettingModel::getItem('recharge');
        return $this->renderSuccess(compact('userInfo', 'planList', 'setting'));
    }

    /**
     * 确认充值
     * @param null $planId
     * @param int $customMoney
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function submit($planId = null, $customMoney = 0,$pay_type=20)
    {
        // 用户信息
        $userInfo = $this->getUser();
        // 生成充值订单
        $model = new OrderModel;
        if (!$model->createOrder($userInfo, $planId, $customMoney)) {
            return $this->renderError($model->getError() ?: '充值失败');
        }
        $data =  $this->pay($userInfo, $model['order_no'], $pay_type);

        $time = time();
        Db::name('paysign')->where('create_time','<',$time-180)->delete();
        if($pay_type ==  20){
            if(!$data['returnmsg']){
                $sign = $data['prepayid'];
                $pop['sign'] = $sign;
                $pop['create_time'] = $time;
                $pop['order_no'] = $model['order_no'];
                Db::name('paysign')->insert($pop);
                $data = ['prepayid'=>$model['order_no']];
            }
        }
        // 构建微信支付
        // 充值状态提醒
        $message = ['success' => '充值成功', 'error' => '订单未支付'];
        return $this->renderSuccess($data, $message);
    }

    public function pay($user,$order_no,$type)
    {
        $amount = Db::name('order')->where('order_no',$order_no)->value('pay_price');
        $url = 'http://'.$_SERVER['HTTP_HOST'].'/index.php?s=/api/page/notifyurl';
        $op = [
            'channelid'=>config('channelid'),
            'merid'=>config('merid'),
            'termid'=>config('termid'),
            'tradetrace'=>$order_no.'_1',
            // 'opt'=>'wxPreOrder',
            // 'tradetype'=>'JSAPI',
            'tradeamt'=>1,
            // 'tradeamt'=>$amount*100,
            'body'=>'订单支付_'.$order_no,
            'notifyurl'=>$url,
        ];
        if($type == 20){
            $op['openid'] = $user['open_id'];
            $op['tradetype'] = 'JSAPI';
            $op['opt'] = 'wxPreOrder';
        }elseif($type == 30){
            $op['tradetype'] = 'NATIVE';
            $op['opt'] = 'apPreOrder';
        }else{
            // $op['tradetype'] = 'NATIVE';
            // $op['opt'] = 'upPreOrder';

            $op['opt'] = 'dirBankPay';
            $op['tradetype'] = 'APP';
            $op['returnurl'] = 'dirBankPay';
        }
        return getPayData($op);
    }

}