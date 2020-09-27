<?php

namespace app\store\model\inventory\contact\color;

use app\common\model\BaseModel;
use app\common\model\NewOrder as NewOrderModel;
use app\store\model\User as UserModel;
use app\store\model\UserCoupon as UserCouponModel;
use app\store\service\order\Export as Exportservice;
use app\common\library\helper;
use app\common\enum\OrderType as OrderTypeEnum;
use app\common\enum\DeliveryType as DeliveryTypeEnum;
use app\common\service\Message as MessageService;
use app\common\service\order\Refund as RefundService;
use app\common\service\wechat\wow\Order as WowService;
use app\common\service\goods\source\Factory as FactoryStock;


/**
 * 订单管理
 * Class Order
 * @package app\store\model
 */
class IndexModel extends BaseModel
{
    protected $name = 'contact_color';

    /**
     * 订单列表
     * @param string $dataType
     * @param array $query
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($dataType, $query = [])
    {
        // 检索查询条件
//        dump($query);die();
        !empty($query) && $this->setWhere($query);
        // 获取数据列表
        return $this
            ->alias('contact_color')
            ->field('contact_color.*,user.shop_name,glasses_brand.brand_name')
            ->join('glasses_brand','glasses_brand.brand_id = contact_color.brand_id')
            ->join('user', 'user.user_id = contact_color.user_id')
            ->where($this->transferDataType($dataType))
            ->order(['contact_color.create_time' => 'desc'])
            ->paginate(10, false, [
                'query' => \request()->request()
            ]);
    }

    public function getColor($type = null, $user_id = null , $brand_id = null,$model_id = null)
    {
        return $this
            ->alias('contact_color')
            ->field('contact_color.*,user.shop_name')
            ->join('contact_brand','contact_brand.brand_id = contact_color.brand_id')
            ->join('contact_model','contact_model.model_id = contact_color.model_id')
            ->join('user', 'user.user_id = contact_color.user_id')
            ->where('contact_color.type_id',$type)
            ->where('contact_color.brand_id',$brand_id)
            ->where('contact_color.model_id',$model_id)
            ->where('contact_color.is_delete',0)
            ->order(['contact_color.create_time' => 'desc'])
            ->paginate(10, false, [
                'query' => \request()->request()
            ]);
    }


    public function getLists($query = [],$arr=[],$type = null,$brand_id = null,$model_id = null)
    {
        // 检索查询条件
//        dump($query);
        !empty($query) && $this->setWhere($query);
        // 获取数据列表
        if (!is_null($brand_id) && is_null($type) && is_null($model_id)){
            return $this
                ->alias('contact_color')
                ->field('contact_color.*,user.shop_name,contact_brand.brand_name')
                ->join('contact_brand','contact_brand.brand_id = contact_color.brand_id')
                ->join('contact_model','contact_model.model_id = contact_color.model_id')
                ->join('user', 'user.user_id = contact_color.user_id')
                ->where('contact_color.user_id','in',$arr)
                ->where('contact_color.brand_id',$brand_id)
                ->where('contact_color.is_delete',0)
                ->order(['contact_color.create_time' => 'desc'])
                ->paginate(10, false, [
                    'query' => \request()->request()
                ]);
        }else if (!is_null($brand_id) && !is_null($type) && is_null($model_id)){
            return $this
                ->alias('contact_color')
                ->field('contact_color.*,user.shop_name,contact_brand.brand_name')
                ->join('contact_brand','contact_brand.brand_id = contact_color.brand_id')
                ->join('contact_model','contact_model.model_id = contact_color.model_id')
                ->join('user', 'user.user_id = contact_color.user_id')
                ->where('contact_color.user_id','in',$arr)
                ->where('contact_color.brand_id',$brand_id)
                ->where('contact_color.is_delete',0)
                ->where('contact_color.type_id',$type)
                ->order(['contact_color.create_time' => 'desc'])
                ->paginate(10, false, [
                    'query' => \request()->request()
                ]);
        }else if (!is_null($brand_id) && !is_null($type) && !is_null($model_id)){
            return $this
                ->alias('contact_color')
                ->field('contact_color.*,user.shop_name,contact_brand.brand_name')
                ->join('contact_brand','contact_brand.brand_id = contact_color.brand_id')
                ->join('contact_model','contact_model.model_id = contact_color.model_id')
                ->join('user', 'user.user_id = contact_color.user_id')
                ->where('contact_color.user_id','in',$arr)
                ->where('contact_color.brand_id',$brand_id)
                ->where('contact_color.model_id',$model_id)
                ->where('contact_color.is_delete',0)
                ->where('contact_color.type_id',$type)
                ->order(['contact_color.create_time' => 'desc'])
                ->paginate(10, false, [
                    'query' => \request()->request()
                ]);
        }else{
            return $this
                ->alias('contact_color')
                ->field('contact_color.*,user.shop_name,contact_brand.brand_name')
                ->join('contact_brand','contact_brand.brand_id = contact_color.brand_id')
                ->join('contact_model','contact_model.model_id = contact_color.model_id')
                ->join('user', 'user.user_id = contact_color.user_id')
                ->where('contact_color.user_id','in',$arr)
                ->where('contact_color.is_delete',0)
                ->order(['contact_color.create_time' => 'desc'])
                ->paginate(10, false, [
                    'query' => \request()->request()
                ]);
        }

    }
    //选中复选框内的数据导出
    public function getCheckedLists($arr=[])
    {

        // 获取数据列表
        return $this
            ->alias('order')
            ->field('order.*,user.shop_name')
            ->join('user', 'user.user_id = order.user_id')
            ->where('order.order_num','in',$arr)
            ->where('order.is_delete', '=', 0)
            ->order(['order.create_time' => 'desc'])
            ->paginate(10, false, [
                'query' => \request()->request()
            ]);
    }

    /**
     * 订单列表(全部)
     * @param $dataType
     * @param array $query
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getListAll($dataType, $query = [])
    {
        // 检索查询条件
        !empty($query) && $this->setWhere($query);
        // 获取数据列表
        return $this->with(['goods.image', 'address', 'user', 'extract', 'extract_shop'])
            ->alias('order')
            ->field('order.*')
            ->join('user', 'user.user_id = order.user_id')
            ->where($this->transferDataType($dataType))
            ->where('order.is_delete', '=', 0)
            ->order(['order.create_time' => 'desc'])
            ->select();
    }

    /**
     * @param $query
     * @param int $page
     * @param $list
     * @return bool|false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException订单列表
     */
    public function getOrderList($query,$page=0,$list)
    {
        !empty($query) && $this->setWhere($query);
        return $this
            ->alias('order')
            ->field('order.*,user.shop_name')
            ->join('user', 'user.user_id = order.user_id')
            ->where('order.is_delete', '=', 0)
            ->where('order.user_id', 'in', $list)
            ->page($page,15)
            ->order(['order.create_time' => 'desc'])
            ->select()->each(function ($item,$key){
                $item['closeState'] = true;
                $item['goods_total'] = $item['frame_num'] + $item['lens_num'] + $item['glasses_case_num'] + $item['glasses_cloth_num'] + $item['contact_lens_num'];
                $item['closeState'] = true;
                $item['count'] = 0;
                if($item['frame_num'] > 0){
                    $item['count'] = $item['count']+ 1;
                }
                if($item['lens_num'] > 0){
                    $item['count'] = $item['count']+ 1;

                }
                if($item['glasses_case_num'] > 0){
                    $item['count'] = $item['count']+ 1;

                }
                if($item['glasses_cloth_num'] > 0){
                    $item['count'] = $item['count']+ 1;

                }
                if($item['contact_lens_num'] > 0){
                    $item['count'] = $item['count']+ 1;
                }
                return $item;

            });
    }

    /**
     * 生成订单号
     * @return string
     */
    public function createOrderNo()
    {
        return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    public function add($data)
    {
        $this->startTrans();
        try {
            // 新增管理员记录
            $data['create_time'] = date("Y-m-d",time());
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
     * 订单导出
     * @param $dataType
     * @param $query
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function exportList($dataType, $query)
    {
        // 获取订单列表
        $list = $this->getList($dataType, $query);
        // 导出csv文件
        return (new Exportservice)->orderLists($list);
    }

    public function exportLists($query=[], $arr=[])
    {
        // 获取订单列表
        $list = $this->getLists($query, $arr);
        // 导出csv文件
        return (new Exportservice)->orderLists($list);
    }
    public function exportCheckedLists($arr=[])
    {
        // 获取订单列表
        $list = $this->getCheckedLists($arr);
        // 导出csv文件
        return (new Exportservice)->orderLists($list);
    }

    /**
     * 批量发货模板
     */
    public function deliveryTpl()
    {
        return (new Exportservice)->deliveryTpl();
    }

    /**
     * 设置检索查询条件
     * @param $query
     */
    private function setWhere($query)
    {
        if (isset($query['shopName']) && !empty($query['shopName']) && !(isset($query['search']) && !empty($query['search']))){
            $this->where('user.shop_name', 'like', '%' . trim($query['shopName']) . '%');
        }
        if (isset($query['search']) && !empty($query['search']) && !(isset($query['shopName']) && !empty($query['shopName']))) {
            $this->where('sales|order_num|user_name|order.mobile', 'like', '%' . trim($query['search']) . '%');
        }
        if (isset($query['shopName']) && !empty($query['shopName']) && isset($query['search']) && !empty($query['search'])){
            $this->where('user.shop_name','like','%'.trim($query['shopName']).'%')->where('order_num|user_name|order.mobile', 'like', '%' . trim($query['search']) . '%');;
        }
        if (isset($query['start_time']) && !empty($query['start_time'])) {
            $this->where('order.create_time', '>=', strtotime($query['start_time']));
        }
        if (isset($query['end_time']) && !empty($query['end_time'])) {
            $this->where('order.create_time', '<', strtotime($query['end_time']) + 86400);
        }
        if (isset($query['shop_name']) && !empty($query['shop_name'])) {
            $this->where('user.shop_name', 'like', '%'.$query['shop_name'] .'%');
        }
        if (isset($query['user_id']) && !empty($query['user_id'])) {
            $this->where('order.user_id', 'in',$query['user_id']);
        }
        if (isset($query['s_time']) && !empty($query['e_time'])) {
            $this->where('order.create_time', 'between',[strtotime($query['s_time']),strtotime($query['e_time'])+86400]);
        }
        // 用户id
//        if (isset($query['user_arr']) && !empty($query['user_arr'])) {
//            $this->where('user.user_id', 'in', (int)$query['user_arr']);
//        }
    }

    /**
     * 转义数据类型条件
     * @param $dataType
     * @return array
     */
    private function transferDataType($dataType)
    {
        // 数据类型
        $filter = [];
        switch ($dataType) {
            case 'delivery':
                $filter = [
                    'pay_status' => 20,
                    'delivery_status' => 10,
                    'order_status' => ['in', [10, 21]]
                ];
                break;
            case 'receipt':
                $filter = [
                    'pay_status' => 20,
                    'delivery_status' => 20,
                    'receipt_status' => 10
                ];
                break;
            case 'pay':
                $filter = ['pay_status' => 10, 'order_status' => 10];
                break;
            case 'complete':
                $filter = ['order_status' => 30];
                break;
            case 'cancel':
                $filter = ['order_status' => 20];
                break;
            case 'all':
                $filter = [];
                break;
        }
        return $filter;
    }

    /**
     * 确认发货(单独订单)
     * @param $data
     * @return array|bool|false
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function delivery($data)
    {
        // 转义为订单列表
        $orderList = [$this];
        // 验证订单是否满足发货条件
        if (!$this->verifyDelivery($orderList)) {
            return false;
        }
        // 整理更新的数据
        $updateList = [[
            'order_id' => $this['order_id'],
            'express_id' => $data['express_id'],
            'express_remarks' => $data['express_remarks'],
            'express_no' => $data['express_no']
        ]];
        // 更新订单发货状态
        if ($status = $this->updateToDelivery($updateList)) {
            // 获取已发货的订单
            $completed = self::detail($this['order_id'], ['user', 'address', 'goods', 'express']);
            // 发送消息通知
            $this->sendDeliveryMessage([$completed]);
            // 同步好物圈订单
            (new WowService($this['wxapp_id']))->update([$completed]);
        }
        return $status;
    }

    /**
     * 批量发货
     * @param $data
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function batchDelivery($data)
    {
        // 获取csv文件中的数据
        if (!$csvData = $this->getCsvData()) {
            return false;
        }
        // 整理订单id集
        $orderNos = helper::getArrayColumn($csvData, 0);
        // 获取订单列表数据
        $orderList = helper::arrayColumn2Key($this->getListByOrderNos($orderNos), 'order_no');
        // 验证订单是否存在
        $tempArr = array_values(array_diff($orderNos, array_keys($orderList)));
        if (!empty($tempArr)) {
            $this->error = "订单号[{$tempArr[0]}] 不存在!";
            return false;
        }
        // 整理物流单号
        $updateList = [];
        foreach ($csvData as $item) {
            $updateList[] = [
                'order_id' => $orderList[$item[0]]['order_id'],
                'express_id' => $data['express_id'],
                'express_no' => $item[1],
            ];
        }
        // 验证订单是否满足发货条件
        if (!$this->verifyDelivery($orderList)) {
            return false;
        }
        // 更新订单发货状态(批量)
        if ($status = $this->updateToDelivery($updateList)) {
            // 获取已发货的订单
            $completed = $this->getListByOrderNos($orderNos, ['user', 'address', 'goods', 'express']);
            // 发送消息通知
            $this->sendDeliveryMessage($completed);
            //  同步好物圈订单
            (new WowService(self::$wxapp_id))->update($completed);
        }
        return $status;
    }

    /**
     * 确认发货后发送消息通知
     * @param array|\think\Collection $orderList
     * @return bool
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    private function sendDeliveryMessage($orderList)
    {
        // 实例化消息通知服务类
        $Service = new MessageService;
        foreach ($orderList as $item) {
            // 发送消息通知
            $Service->delivery($item, OrderTypeEnum::MASTER);
        }
        return true;
    }

    /**
     * 更新订单发货状态(批量)
     * @param $orderList
     * @return array|false
     * @throws \Exception
     */
    private function updateToDelivery($orderList)
    {
        $data = [];
        foreach ($orderList as $item) {
            $data[] = [
                'order_id' => $item['order_id'],
                'express_no' => $item['express_no'],
                'express_id' => $item['express_id'],
                'delivery_status' => 20,
                'delivery_time' => time(),
            ];
        }
        return $this->isUpdate()->saveAll($data);
    }

    /**
     * 验证订单是否满足发货条件
     * @param $orderList
     * @return bool
     */
    private function verifyDelivery($orderList)
    {
        foreach ($orderList as $order) {
            if (
                $order['pay_status']['value'] != 20
                || $order['delivery_type']['value'] != DeliveryTypeEnum::EXPRESS
                || $order['delivery_status']['value'] != 10
            ) {
                $this->error = "订单号[{$order['order_no']}] 不满足发货条件!";
                return false;
            }
        }
        return true;
    }

    /**
     * 获取csv文件中的数据
     * @return array|bool
     */
    private function getCsvData()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = \request()->file('iFile');
        if (empty($file)) {
            $this->error = '请上传发货模板';
            return false;
        }
        // 设置区域信息
        setlocale(LC_ALL, 'zh_CN');
        // 打开上传的文件
        $csvFile = fopen($file->getInfo()['tmp_name'], 'r');
        // 忽略第一行(csv标题)
        fgetcsv($csvFile);
        // 遍历并记录订单信息
        $orderList = [];
        while ($item = fgetcsv($csvFile)) {
            if (!isset($item[0]) || empty($item[0]) || !isset($item[1]) || empty($item[1])) {
                $this->error = '模板文件数据不合法';
                return false;
            }
            $orderList[] = $item;
        }
        if (empty($orderList)) {
            $this->error = '模板文件中没有订单数据';
            return false;
        }
        return $orderList;
    }

    /**
     * 修改订单价格
     * @param $data
     * @return bool
     */
    public function updatePrice($data)
    {
        if ($this['pay_status']['value'] != 10) {
            $this->error = '该订单不合法';
            return false;
        }
        // 实际付款金额
        $payPrice = bcadd($data['update_price'], $data['update_express_price'], 2);
        if ($payPrice <= 0) {
            $this->error = '订单实付款价格不能为0.00元';
            return false;
        }
        return $this->save([
                'order_no' => $this->orderNo(), // 修改订单号, 否则微信支付提示重复
                'order_price' => $data['update_price'],
                'pay_price' => $payPrice,
                'update_price' => helper::bcsub($data['update_price'], helper::bcsub($this['total_price'], $this['coupon_money'])),
                'express_price' => $data['update_express_price']
            ]) !== false;
    }

    /**
     * 审核：用户取消订单
     * @param $data
     * @return bool|mixed
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function confirmCancel($data)
    {
        // 判断订单是否有效
        if ($this['pay_status']['value'] != 20) {
            $this->error = '该订单不合法';
            return false;
        }
        // 订单取消事件
        $status = $this->transaction(function () use ($data) {
            if ($data['is_cancel'] == true) {
                // 执行退款操作
                (new RefundService)->execute($this);
                // 回退商品库存
                FactoryStock::getFactory($this['order_source'])->backGoodsStock($this['goods'], true);
                // 回退用户优惠券
                $this['coupon_id'] > 0 && UserCouponModel::setIsUse($this['coupon_id'], false);
                // 回退用户积分
                $User = UserModel::detail($this['user_id']);
                $describe = "订单取消：{$this['order_no']}";
                $this['points_num'] > 0 && $User->setIncPoints($this['points_num'], $describe);
            }
            // 更新订单状态
            return $this->save(['order_status' => $data['is_cancel'] ? 20 : 10]);
        });
        if ($status == true) {
            // 同步好物圈订单
            (new WowService(self::$wxapp_id))->update([$this]);
        }
        return $status;
    }

    /**
     * 获取已付款订单总数 (可指定某天)
     * @param null $startDate
     * @param null $endDate
     * @return int|string
     * @throws \think\Exception
     */
    public function getPayOrderTotal($startDate = null, $endDate = null,$arr=[],$user_id = null)
    {
        $filter = [
//            'pay_status' => PayStatusEnum::SUCCESS,
//            'order_status' => ['<>', OrderStatusEnum::CANCELLED],
        ];
        if (!is_null($startDate) && !is_null($endDate)) {
            $filter['create_time'] = [
                ['>=', strtotime($startDate)],
                ['<', strtotime($endDate) + 86400],
            ];
        }
        if(!empty($arr)){
            $filter['user_id'] = ['in',$arr];
        }
        if (!is_null($user_id)){
            $filter['user_id'] = $user_id;
        }
        return $this->getOrderTotal($filter);
    }
    public function getPayOrderTotalByMonth($startDate = null, $endDate = null,$arr=[])
    {
        $filter = [
//            'pay_status' => PayStatusEnum::SUCCESS,
//            'order_status' => ['<>', OrderStatusEnum::CANCELLED],
        ];
        if (!is_null($startDate) && !is_null($endDate)) {
            $filter['create_time'] = [
                ['>=', strtotime($startDate)],
                ['<', strtotime($endDate)],
            ];
        }
        if(!empty($arr)){
            $filter['user_id'] = ['in',$arr];
        }
        return $this->getOrderTotal($filter);
    }

    public function getOrderTotalPriceByMonth($startDate = null, $endDate = null,$arr=[],$user_id=null)
    {
        if (!is_null($startDate) && !is_null($endDate)) {
            $this->where('create_time', '>=', strtotime($startDate))
                ->where('create_time', '<', strtotime($endDate));
        }
        if(!empty($arr)){
            $this->where('user_id', 'in', $arr);
        }
        if(!is_null($user_id)){
            $this->where('user_id', $user_id);
        }
        return $this
            ->where('is_delete', '=', 0)
            ->sum('pay_total');
    }
    /**
     * 获取已付款订单总数 (可指定某月)
     * @param null $startDate
     * @param null $endDate
     * @return int|string
     * @throws \think\Exception
     */
    public function getPayOrderTotals($startDate = null, $endDate = null,$arr=[])
    {
        $filter = [
//            'pay_status' => PayStatusEnum::SUCCESS,
//            'order_status' => ['<>', OrderStatusEnum::CANCELLED],
        ];
        $month = $this->mFristAndLast(date('Y'),$startDate);
        if (!is_null($startDate) && !is_null($endDate)) {
            $filter['create_time'] = [
                ['>=', $month['firstday']],
                ['<', $month['lastday']],
            ];
        }
        if(!empty($arr)){
            $filter['user_id'] = ['in',$arr];
        }
        return $this->getOrderTotal($filter);
    }

   public function mFristAndLast($y = "", $m = "")
    {
        if ($y == "") $y = date("Y");
        if ($m == "") $m = date("m");
        $m = sprintf("%02d", intval($m));
        $y = str_pad(intval($y), 4, "0", STR_PAD_RIGHT);

        $m > 12 || $m < 1 ? $m = 1 : $m = $m;
        $firstday = strtotime($y . $m . "01000000");
        $firstdaystr = date("Y-m-01", $firstday);
        $lastday = strtotime(date('Y-m-d 23:59:59', strtotime("$firstdaystr +1 month -1 day")));

        return array(
            "firstday" => $firstday,
            "lastday" => $lastday
        );
    }

    /**
     * 获取订单总数量
     * @param array $filter
     * @return int|string
     * @throws \think\Exception
     */
    private function getOrderTotal($filter = [])
    {
        return $this->where($filter)
            ->where('is_delete', '=', 0)
            ->count();
    }

    /**
     * 获取某天的总销售额
     * @param null $startDate
     * @param null $endDate
     * @return float|int
     */
    public function getOrderTotalPrices($startDate = null, $endDate = null,$arr=[])
    {
        $month = $this->mFristAndLast(date('Y'),$startDate);
        if (!is_null($startDate) && !is_null($endDate)) {
            $this->where('create_time', '>=', $month['firstday'])
                ->where('create_time', '<', $month['lastday']);
        }
        if(!empty($arr)){
            $this->where('user_id', 'in', $arr);
        }
        return $this
            ->where('is_delete', '=', 0)
            ->sum('pay_total');
    }


    /**
     * 获取某天的总销售额
     * @param null $startDate
     * @param null $endDate
     * @return float|int
     */
    public function getOrderTotalPrice($startDate = null, $endDate = null,$arr=[])
    {
        if (!is_null($startDate) && !is_null($endDate)) {
            $this->where('create_time', '>=', strtotime($startDate))
                ->where('create_time', '<', strtotime($endDate) + 86400);
        }
        if(!empty($arr)){
            $this->where('user_id', 'in', $arr);
        }
        return $this
            ->where('is_delete', '=', 0)
            ->sum('pay_total');
    }

    /**
     * 获取某天的下单用户数
     * @param $day
     * @return float|int
     */
    public function getPayOrderUserTotal($day)
    {
        $startTime = strtotime($day);
        $userIds = $this->distinct(true)
            ->where('pay_time', '>=', $startTime)
            ->where('pay_time', '<', $startTime + 86400)
            ->where('pay_status', '=', 20)
            ->where('is_delete', '=', 0)
            ->column('user_id');
        return count($userIds);
    }

    public static function detail($order_id)
    {
        return  self::get($order_id);
    }

    public function getSalesList($query)
    {
        !empty($query) && $this->setWheres($query);
       return  $this->where('is_delete',0)->group('sales')->field('sales,pay_total,user_id')->order('sales asc')->paginate(10, false, [
           'query' => \request()->request()
       ]);

    }

    public function getSalesLists($query,$arr)
    {
        !empty($query) && $this->setWheres($query);
        return  $this->where('is_delete',0)->field('sales,pay_total,user_id')->where('user_id','in',$arr)->group('sales')->order('sales asc')->paginate(10, false, [
            'query' => \request()->request()
        ]);

    }
    public function getSalesOrders($query,$sales)
    {
        !empty($query) && $this->setWheres($query);
        return  $this->where('is_delete',0)->field('sales,pay_total,user_id')->where('sales',$sales)->group('sales')->order('sales asc')->paginate(10, false, [
            'query' => \request()->request()
        ]);

    }
    private function setWheres($query)
    {
        if (isset($query['search']) && !empty($query['search'])) {
            $this->where('sales', 'like', '%' . trim($query['search']) . '%');
        }

        // 用户id
//        if (isset($query['user_arr']) && !empty($query['user_arr'])) {
//            $this->where('user.user_id', 'in', (int)$query['user_arr']);
//        }
    }

}
