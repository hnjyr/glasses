<?php

namespace app\store\model;

use app\common\library\helper;
use app\common\model\Store as StoreModel;
use app\store\model\NewOrder;
use think\Db;

/**
 * 商城模型
 * Class Store
 * @package app\store\model
 */
class Store extends StoreModel
{
    /* @var Goods $GoodsModel */
    private $GoodsModel;

    /* @var Order $GoodsModel */
    private $OrderModel;

    /* @var User $GoodsModel */
    private $UserModel;

    /**
     * 构造方法
     */
    public function initialize()
    {
        parent::initialize();
        /* 初始化模型 */
        $this->GoodsModel = new Goods;
        $this->OrderModel = new NewOrder();
        $this->UserModel = new User;
    }

    /**
     * 后台首页数据
     * @return array
     * @throws \think\Exception
     */
    public function getHomeData($user_id = null)
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        // 最近七天日期
        $lately7days = $this->getLately7days();
        $weekdays = $this->getWeekDays();
        $monthdays = $this->getMonthDays();
        $yeardays = $this->getYear();
        $data = [
            'widget-card' => [
                // 商品总量
                'goods_total' => $this->getGoodsTotal(),
                // 用户总量
                'user_total' => $this->getUserTotal($day = null,$user_id),
                // 订单总量
                'order_total' => $this->getOrderTotal($day = null,$user_id),
                // 评价总量
                'comment_total' => $this->getCommentTotal()
            ],
//            'widget-outline' => [
//                // 销售额(元)
//                'order_total_price' => [
//                    'tday' => $this->getOrderTotalPrice($today),
//                    'ytd' => $this->getOrderTotalPrice($yesterday)
//                ],
//                // 支付订单数
//                'order_total' => [
//                    'tday' => $this->getOrderTotal($today),
//                    'ytd' => $this->getOrderTotal($yesterday)
//                ],
//                // 新增用户数
//                'new_user_total' => [
//                    'tday' => $this->getUserTotal($today),
//                    'ytd' => $this->getUserTotal($yesterday)
//                ],
//                // 下单用户数
//                'order_user_total' => [
//                    'tday' => $this->getPayOrderUserTotal($today),
//                    'ytd' => $this->getPayOrderUserTotal($yesterday)
//                ]
//            ],
            'widget-echarts' => [
                // 最近七天日期
                'date' => helper::jsonEncode($lately7days),
                'order_total' => helper::jsonEncode($this->getOrderTotalByDate($lately7days,$user_id)),
                'order_total_price' => helper::jsonEncode($this->getOrderTotalPriceByDate($lately7days,$user_id)),



                'week_order_total' => array_sum($this->getOrderTotalByDate($weekdays,$user_id)),
                'week_order_total_price' => array_sum($this->getOrderTotalPriceByDate($weekdays,$user_id)),

                'month_date' => helper::jsonEncode($monthdays),
                'month_order_total' => array_sum($this->getOrderTotalByDate($monthdays,$user_id)),

                'month_order_totals' => helper::jsonEncode($this->getOrderTotalByDate($monthdays,$user_id)),
                'month_order_total_price' => array_sum($this->getOrderTotalPriceByDate($monthdays,$user_id)),

                'month_order_total_prices' => helper::jsonEncode($this->getOrderTotalPriceByDate($monthdays,$user_id)),


                'year_data' => helper::jsonEncode($yeardays),
                'year_order_total' => array_sum($this->getOrderTotalByMonth($yeardays,$user_id)),
                'year_order_totals' => helper::jsonEncode($this->getOrderTotalByMonth($yeardays,$user_id)),
                'year_order_total_price' => array_sum($this->getOrderTotalPriceByMonth($yeardays,$user_id)),
                'year_order_total_prices' => helper::jsonEncode($this->getOrderTotalPriceByMonth($yeardays,$user_id))
            ],

        ];

        return $data;
    }

    /**
     * 最近七天日期
     */
    private function getLately7days()
    {
        // 获取当前周几
        $date = [];
        for ($i = 0; $i < 7; $i++) {
            $date[] = date('Y-m-d', strtotime('-' . $i . ' days'));
        }
        return array_reverse($date);
    }
    private function getWeekDays(){

            $time = time();
            //获取当前周几
            $week = date('w', $time);
            $date = [];
            for ($i=1; $i<=7; $i++){
                $date[$i] = date('Y-m-d' ,strtotime( '+' . $i-$week .' days', $time));
            }
//            dump(array_reverse($date));
            return array_reverse($date);
    }
    private function getMonthDays(){

//        $time = date("m",time());//获取当月
        $dayNum = date('t',time());//获取当月多少天

        $firstday = strtotime(date('Y-m-01'));//获取当月第一天

        $date = [];
        for ($i=$dayNum; $i>=0; $i--){
            $date[$i] = date('Y-m-d',strtotime( '+' . $i .' day', $firstday));
        }
//            dump(array_reverse($date));die();
        return array_reverse($date);
    }
    private function getYear(){


        $firstday = strtotime(date('Y-01'));//获取当年第一月

        $date = [];
        for ($i=12; $i>-1; $i--){
            $date[$i] = date('Y-m',strtotime( '+' . $i .' month', $firstday));
        }

//        dump( array_reverse($date));die();
        return array_reverse($date);
    }

    /**
     * 获取商品总量
     * @return string
     * @throws \think\Exception
     */
    private function getGoodsTotal()
    {
        return number_format($this->GoodsModel->getGoodsTotal());
    }

    /**
     * 获取用户总量
     * @param null $day
     * @return string
     * @throws \think\Exception
     */
    private function getUserTotal($day = null,$user_id = null)
    {
        return number_format($this->UserModel->getUserTotal($day,$user_id));
    }

    /**
     * 获取订单总量
     * @param null $day
     * @return string
     * @throws \think\Exception
     */
    private function getOrderTotal($day = null,$user_id = null)
    {

        return number_format($this->OrderModel->getPayOrderTotal($day, $day,$user_id));
    }

    /**
     * 获取订单总量 (指定日期)
     * @param $days
     * @return array
     * @throws \think\Exception
     */
    private function getOrderTotalByDate($days,$user_id = null)
    {
        $data = [];
        foreach ($days as $day) {
            $data[] = $this->getOrderTotal($day,$user_id);
        }
        return $data;
    }

    /**
     * 获取评价总量
     * @return string
     */
    private function getCommentTotal()
    {
        $model = new Comment;
        return number_format($model->getCommentTotal());
    }

    /**
     * 获取某天的总销售额
     * @param null $day
     * @return string
     */
    private function getOrderTotalPrice($day = null,$user_id=null)
    {
        return helper::number2($this->OrderModel->getOrderTotalPrice($day, $day,$user_id));
    }

    /**
     * 获取订单总量 (指定日期)
     * @param $days
     * @return array
     */
    private function getOrderTotalPriceByDate($days,$user_id)
    {
        $data = [];
        foreach ($days as $day) {
            $data[] = $this->getOrderTotalPrice($day,$user_id);
        }
        return $data;
    }

    /**
     * 获取某天的下单用户数
     * @param $day
     * @return float|int
     */
    private function getPayOrderUserTotal($day)
    {
        return number_format($this->OrderModel->getPayOrderUserTotal($day));
    }

    private function getOrderTotalByMonth($days,$user_id = null)
    {
        $arr = [$user_id];

        $data = [];
        for ($i = 0;$i<count($days)-1;$i++){
            if (is_null($user_id)){
                $data[] = $this->getOrderTotalMonth($days[$i],$days[$i+1]);
            }else{
                $data[] = $this->getOrderTotalMonth($days[$i],$days[$i+1],$arr);
            }

        }
        /* foreach ($days as $key=>$day) {
             $data[] = $this->getOrderTotalMonth($days[$key-1],$days[$key+1],$arr);
         }*/
        return $data;
    }

    private function getOrderTotalMonth($stratday = null,$endday = null,$arr=[])
    {
        $OrderModel = new NewOrder();

        return number_format($OrderModel->getPayOrderTotalByMonth($endday,$stratday,$arr));
    }


    private function getOrderTotalPriceByMonth($days,$user_id)
    {
        $arr = [$user_id];
        $data = [];
        for ($i = 0;$i<count($days)-1;$i++){
            if (is_null($user_id)){
                $data[] = $this->getOrderTotalPriceMonth($days[$i],$days[$i+1]);
            }else{
                $data[] = $this->getOrderTotalPriceMonth($days[$i],$days[$i+1],$arr);
            }
        }
//        dump($days);die();
        return $data;
    }
    private function getOrderTotalPriceMonth($stratday, $endday,$arr=[])
    {
        $OrderModel = new NewOrder();
//        dump($endday);die;
        return helper::number2($OrderModel->getOrderTotalPriceByMonth($endday,$stratday,$arr));
    }



}