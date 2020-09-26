<?php

namespace app\store\service\statistics\data;

use app\common\service\Basics as BasicsService;
use app\store\model\NewOrder;
use app\store\model\Order as OrderModel;
use app\common\library\helper;
use think\Session;
use think\Db;
/**
 * 近7日走势
 * Class Trade7days
 * @package app\store\service\statistics\data
 */
class Trade7days extends BasicsService
{
    /* @var OrderModel $GoodsModel */
    private $OrderModel;

    /**
     * 构造方法
     */
    public function __construct()
    {
        /* 初始化模型 */
        $this->OrderModel = new NewOrder();
    }

    /**
     * 近7日走势
     * @return array
     * @throws \think\Exception
     */
    public function getTransactionTrend()
    {
        // 最近七天日期
        $lately7days = $this->getLately7dayss();
//        dump($lately7days);die();
        return [
            'date' => helper::jsonEncode($lately7days),
            'order_total' => helper::jsonEncode($this->getOrderTotalByDate($lately7days)),
            'order_total_price' => helper::jsonEncode($this->getOrderTotalPriceByDate($lately7days)),
            'week_order_total' => array_sum($this->getOrderTotalByDate($lately7days)),
            'week_order_total_price' => array_sum($this->getOrderTotalPriceByDate($lately7days)),
        ];
    }

    /**
     * 近30日走势
     * @return array
     * @throws \think\Exception
     */
    public function getTransactionTrends()
    {
        // 最近30天日期
        $lately30days = $this->getLately30days();
        return [
            'date' => helper::jsonEncode($lately30days),
            'order_total' => helper::jsonEncode($this->getOrderTotalByDate($lately30days)),
            'order_total_price' => helper::jsonEncode($this->getOrderTotalPriceByDate($lately30days)),
            'month_order_total' => array_sum($this->getOrderTotalByDate($lately30days)),
            'month_order_total_price' => array_sum($this->getOrderTotalPriceByDate($lately30days)),
        ];
    }

    /**
     * 近一年走势
     * @return array
     * @throws \think\Exception
     */
    public function getTransactionYearsTrends()
    {

        // 最近30天日期
        $latelyMonths = $this->getLatelyMonths();

        return [
            'date' => helper::jsonEncode($latelyMonths),
            'order_total' => helper::jsonEncode($this->getOrderTotalByMonth($latelyMonths)),
            'order_total_price' => helper::jsonEncode($this->getOrderTotalPriceByMonth($latelyMonths)),
            'year_order_total' => array_sum($this->getOrderTotalByMonth($latelyMonths)),
            'year_order_total_price' => array_sum($this->getOrderTotalPriceByMonth($latelyMonths))
        ];
    }

    /**
     * 最近七天日期
     */
    private function getLately7days()
    {
        /*// 获取当前周几
        $date = [];
        for ($i = 0; $i < 7; $i++) {
            $date[] = date('Y-m-d', strtotime('-' . $i . ' days'));
        }
        return array_reverse($date);*/
        $time = time();
        //获取当前周几
        $week = date('w', $time);
        $date = [];
        for ($i=1; $i<8; $i++){
            $date[$i] = date('Y-m-d' ,strtotime( '+' . $i-$week .' days', $time));
            if ($i == 1){
                $date[$i] .= "\r\n周一";
            }
            if ($i == 2){
                $date[$i] .= "\r\n周二";
            }
            if ($i == 3){
                $date[$i] .= "\r\n周三";
            }
            if ($i == 4){
                $date[$i] .= "\r\n周四";
            }
            if ($i == 5){
                $date[$i] .= "\r\n周五";
            }
            if ($i == 6){
                $date[$i] .= "\r\n周六";
            }
            if ($i == 7){
                $date[$i] .= "\r\n周日";
            }
        }
//            dump(array_reverse(array_reverse($date)));die();
        return array_reverse(array_reverse($date));
    }

    private function getLately7dayss()
    {
        /*// 获取当前周几
        $date = [];
        for ($i = 0; $i < 7; $i++) {
            $date[] = date('Y-m-d', strtotime('-' . $i . ' days'));
        }
        return array_reverse($date);*/
        $time = time();
        //获取当前周几
        $week = date('w', $time);
        $date = [];
        for ($i=1; $i<8; $i++){
            $date[$i] = date('Y-m-d' ,strtotime( '+' . $i-$week .' days', $time));
        }
//            dump(array_reverse(array_reverse($date)));die();
        return array_reverse(array_reverse($date));
    }
    /**
     * 最近30天日期
     */
    private function getLately30days()
    {
        // 获取当前周几
       /* $date = [];
        for ($i = 0; $i < 30; $i++) {
            $date[] = date('Y-m-d', strtotime('-' . $i . ' days'));
        }
        return array_reverse($date);*/
        $dayNum = date('t',time());//获取当月多少天

        $firstday = strtotime(date('Y-m-01'));//获取当月第一天

        $date = [];
        for ($i=0; $i<$dayNum; $i++){
            $date[$i] = date('Y-m-d',$firstday+$i*86400);
        }
//            dump(array_reverse($date));die();
        return $date;
    }

    /**
     * 最近30天日期
     */
    private function getLatelyMonths()
    {
        // 获取当前周几
       /* $date = [];
        for ($i = 1; $i < 13; $i++) {
            $date[] = date('m', strtotime('-' . $i . ' month'));
        }
        return array_reverse($date);*/
        $firstday = strtotime(date('Y-01'));//获取当年第一月

        $date = [];
        for ($i=0; $i<13; $i++){
            $dayNum = date('t',strtotime('-'.$i.' month'));
            $date[$i] = date('Y-m',strtotime( '+' . $i .' month', $firstday+$i*$dayNum));
        }

//        dump( array_reverse($date));die();
        return $date;
    }

    /**
     * 获取订单总量 (指定日期)
     * @param $days
     * @return array
     * @throws \think\Exception
     */
    private function getOrderTotalByDate($days)
    {
        $data = [];

        foreach ($days as $day) {

            $data[] = $this->getOrderTotal($day);
        }
        return $data;
    }

    /**
     * 获取订单总量 (指定月份)
     * @param $days
     * @return array
     * @throws \think\Exception
     */
    private function getOrderTotalByMonth($days,$user_id = null)
    {
       /* $data = [];
        foreach ($days as $day) {
            $data[] = $this->getOrderTotals($day);
        }
        return $data;*/
        $arr = [$user_id];

        $data = [];
        for ($i = 0;$i<count($days)-1;$i++){
            $data[] = $this->getOrderTotals($days[$i],$days[$i+1]);

        }
        /* foreach ($days as $key=>$day) {
             $data[] = $this->getOrderTotalMonth($days[$key-1],$days[$key+1],$arr);
         }*/
//        dump($data);die();
        return $data;
    }


    /**
     * 获取订单总量
     * @param null $day
     * @return string
     * @throws \think\Exception
     */
    private function getOrderTotal($day = null)
    {

        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        if ($admin_info['is_super'] == 1){
            return number_format($this->OrderModel->getPayOrderTotal($day, $day));
        }else{
            $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
            if($this_user){
                return number_format($this->OrderModel->getPayOrderTotal($day, $day,$this_user));
            }else{
                return number_format($this->OrderModel->getPayOrderTotal($day, $day,$admin_info['user_id']));
            }
        }
    }

    /**
     * 获取订单总量
     * @param null $day
     * @return string
     * @throws \think\Exception
     */
    private function getOrderTotals($stratday = null,$endday = null)
    {
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        if ($admin_info['is_super'] == 1){
            return number_format($this->OrderModel->getPayOrderTotals($stratday, $endday));
        }else{
            $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
            if($this_user){
                return number_format($this->OrderModel->getPayOrderTotals($stratday, $endday,$this_user));
            }else{
                return number_format($this->OrderModel->getPayOrderTotals($stratday, $endday,$admin_info['user_id']));
            }
        }
    }

    /**
     * 获取某天的总销售额
     * @param null $day
     * @return string
     */
    private function getOrderTotalPrice($day = null)
    {
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        if ($admin_info['is_super'] == 1){
            return helper::number2($this->OrderModel->getOrderTotalPrice($day, $day));
        }else{
            $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
            if($this_user){
                return helper::number2($this->OrderModel->getOrderTotalPrice($day, $day,$this_user));
            }else{
                return helper::number2($this->OrderModel->getOrderTotalPrice($day, $day,$admin_info['user_id']));
            }
        }

    }

    /**
     * 获取某天的总销售额
     * @param null $day
     * @return string
     */
    private function getOrderTotalPrices($stratday, $endday)
    {
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        if ($admin_info['is_super'] == 1){
            return helper::number2($this->OrderModel->getOrderTotalPrices($stratday, $endday));
        }else{
            $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
            if($this_user){
                return helper::number2($this->OrderModel->getOrderTotalPrices($stratday, $endday,$this_user));
            }else{
                return helper::number2($this->OrderModel->getOrderTotalPrices($stratday, $endday,$admin_info['user_id']));
            }
        }

    }

    /**
     * 获取订单总量 (指定日期)
     * @param $days
     * @return array
     */
    private function getOrderTotalPriceByDate($days)
    {
        $data = [];
        foreach ($days as $day) {
            $data[] = $this->getOrderTotalPrice($day);
        }
        return $data;
    }

    /**
     * 获取订单总量 (指定日期)
     * @param $days
     * @return array
     */
    private function getOrderTotalPriceByMonth($days,$user_id=null)
    {
        /*$data = [];
        foreach ($days as $day) {
            $data[] = $this->getOrderTotalPrices($day);
        }
        return $data;*/

        $arr = [$user_id];
        $data = [];
        for ($i = 0;$i<count($days)-1;$i++){
                $data[] = $this->getOrderTotalPrices($days[$i],$days[$i+1]);
        }
        return $data;

    }



}