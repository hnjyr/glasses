<?php

namespace app\store\service\order;

use app\store\model\OrderAddress as OrderAddressModel;
use think\Db;
/**
 * 订单导出服务类
 * Class Export
 * @package app\store\service\order
 */
class Export
{
    /**
     * 表格标题
     * @var array
     */
//    private $tileArray = [
//        '订单号', '商品信息', '订单总额', '优惠券抵扣', '积分抵扣', '运费金额', '后台改价', '实付款金额', '支付方式', '下单时间',
//        '买家', '买家留言', '配送方式', '自提门店名称', '自提联系人', '自提联系电话', '收货人姓名', '联系电话', '收货人地址',
//        '物流公司', '物流单号', '付款状态', '付款时间', '发货状态', '发货时间', '收货状态', '收货时间', '订单状态', '微信支付交易号', '是否已评价'
//    ];

    private $tileArray = [
        '订单号', '店铺名', '客户名字', '手机号', '积分', '瞳距', '左眼球镜', '左眼柱镜', '左眼轴线', '左眼ADD',
        '右眼球镜', '右眼柱镜', '右眼轴线', '右眼ADD', '镜框型号', '镜框数量', '镜框价格', '镜片型号', '镜片数量',
        '镜片价格', '眼镜盒数量', '眼镜盒价格', '眼镜布数量', '眼镜布价格', '隐形眼镜型号', '隐形眼镜数量', '隐形眼镜价格', '销售员', '验光师', '加工师','收银员','经手人'
        ,'检验员','说明','执行标准','折扣金额','合计金额','实收金额','检验结果','订单时间'
    ];

    /**
     * 订单导出
     * @param $list
     */
    public function orderList($list)
    {
        // 表格内容
        $dataArray = [];
        foreach ($list as $order) {
            /* @var OrderAddressModel $address */
            $address = $order['address'];
            $dataArray[] = [
                '订单号' => $this->filterValue($order['order_no']),
                '商品信息' => $this->filterGoodsInfo($order),
                '订单总额' => $this->filterValue($order['total_price']),
                '优惠券抵扣' => $this->filterValue($order['coupon_money']),
                '积分抵扣' => $this->filterValue($order['points_money']),
                '运费金额' => $this->filterValue($order['express_price']),
                '后台改价' => $this->filterValue("{$order['update_price']['symbol']}{$order['update_price']['value']}"),
                '实付款金额' => $this->filterValue($order['pay_price']),
                '支付方式' => $this->filterValue($order['pay_type']['text']),
                '下单时间' => $this->filterValue($order['create_time']),
                '买家' => $this->filterValue($order['user']['nickName']),
                '买家留言' => $this->filterValue($order['buyer_remark']),
                '配送方式' => $this->filterValue($order['delivery_type']['text']),
                '自提门店名称' => !empty($order['extract_shop']) ? $this->filterValue($order['extract_shop']['shop_name']) : '',
                '自提联系人' => !empty($order['extract']) ? $this->filterValue($order['extract']['linkman']) : '',
                '自提联系电话' => !empty($order['extract']) ? $this->filterValue($order['extract']['phone']) : '',
                '收货人姓名' => $this->filterValue($order['address']['name']),
                '联系电话' => $this->filterValue($order['address']['phone']),
                '收货人地址' => $this->filterValue($address ? $address->getFullAddress() : ''),
                '物流公司' => $this->filterValue($order['express']['express_name']),
                '物流单号' => $this->filterValue($order['express_no']),
                '付款状态' => $this->filterValue($order['pay_status']['text']),
                '付款时间' => $this->filterTime($order['pay_time']),
                '发货状态' => $this->filterValue($order['delivery_status']['text']),
                '发货时间' => $this->filterTime($order['delivery_time']),
                '收货状态' => $this->filterValue($order['receipt_status']['text']),
                '收货时间' => $this->filterTime($order['receipt_time']),
                '订单状态' => $this->filterValue($order['order_status']['text']),
                '微信支付交易号' => $this->filterValue($order['transaction_id']),
                '是否已评价' => $this->filterValue($order['is_comment'] ? '是' : '否'),
            ];
        }
        // 导出csv文件
        $filename = 'order-' . date('YmdHis');
        return export_excel($filename . '.csv', $this->tileArray, $dataArray);
    }

    /**
     * 订单导出
     * @param $list
     */
    public function orderLists($list)
    {
        // 表格内容
        $dataArray = [];
        foreach ($list as $order) {
            /* @var OrderAddressModel $address */
            $dataArray[] = [
                '订单号' => $this->filterValue($order['order_num']),
                '店铺名' => $this->getShopName($order['user_id']),
                '客户名字' => $this->filterValue($order['user_name']),
                '手机号' => $this->filterValue($order['mobile']),
                '积分' => $this->getPoint($order['mobile']),
                '瞳距' => $this->filterValue($order['distance']),
                '左眼球镜' => $this->filterValue($order['left_ball_mirror']),
                '左眼柱镜' => $this->filterValue($order['left_cylinder']),
                '左眼轴线' => $this->filterValue($order['left_axis']),
                '左眼ADD' => $this->filterValue($order['left_add']),
                '右眼球镜' => $this->filterValue($order['right_ball_mirror']),
                '右眼柱镜' => $this->filterValue($order['right_cylinder']),
                '右眼轴线' => $this->filterValue($order['right_axis']),
                '右眼ADD' => $this->filterValue($order['right_add']),
                '镜框型号' => $this->filterValue($order['frame']),
                '镜框数量' => $this->filterValue($order['frame_num']),
                '镜框价格' => $this->filterValue($order['frame_price']),
                '镜片型号' => $this->filterValue($order['lens']),
                '镜片数量' => $this->filterValue($order['lens_num']),
                '镜片价格' => $this->filterValue($order['lens_price']),
                '眼镜盒数量' => !empty($order['glasses_case_num']) ? $this->filterValue($order['glasses_case_num']) : '',
                '眼镜盒价格' => !empty($order['glasses_case_price']) ? $this->filterValue($order['glasses_case_price']) : '',
                '眼镜布数量' => !empty($order['glasses_cloth_num']) ? $this->filterValue($order['glasses_cloth_num']) : '',
                '眼镜布价格' => $this->filterValue($order['glasses_cloth_price']),
                '隐形眼镜型号' => $this->filterValue($order['contact_lens']),
                '隐形眼镜数量' => $this->filterValue($order['contact_lens_num']),
                '隐形眼镜价格' => $this->filterValue($order['contact_lens_price']),
                '销售员' => $this->filterValue($order['sales']),
                '验光师' => $this->filterValue($order['optometry']),
                '加工师' => $this->filterValue($order['working']),
                '收银员' => $this->filterValue($order['cash']),
                '经手人' => $this->filterValue($order['handle']),
                '检验员' => $this->filterValue($order['inspectors']),
                '说明' => $this->filterValue($order['notes']),
                '执行标准' => $this->filterValue($order['standard']),
                '折扣金额' => $this->filterValue($order['discount']),
                '合计金额' => $this->filterValue($order['total']),
                '实收金额' => $this->filterValue($order['pay_total']),
                '检验结果' => $this->filterTest($order['test']),
                '订单时间' => $this->filterTime($order['create_time']),
            ];
        }
        // 导出csv文件
        $filename = 'order-' . date('YmdHis');
        return export_excel($filename . '.csv', $this->tileArray, $dataArray);
    }
    public function glasses_orderLists($list)
    {
        // 表格内容
        $dataArray = [];
        foreach ($list as $order) {
            /* @var OrderAddressModel $address */
            $dataArray[] = [
                '订单号' => $this->filterValue($order['glasses_no']),
                '店铺名' => $this->getShopName($order['user_id']),
                '客户名字' => $this->filterValue($order['user_name']),
                '手机号' => $this->filterValue($order['mobile']),
                '积分' => $this->getPoint($order['point']),
                '瞳距' => $this->filterValue($order['distance']),
                '左眼球镜' => $this->filterValue($order['left_ball_mirror']),
                '左眼柱镜' => $this->filterValue($order['left_cylinder']),
                '左眼轴线' => $this->filterValue($order['left_axis']),
                '左眼ADD' => $this->filterValue($order['left_add']),
                '右眼球镜' => $this->filterValue($order['right_ball_mirror']),
                '右眼柱镜' => $this->filterValue($order['right_cylinder']),
                '右眼轴线' => $this->filterValue($order['right_axis']),
                '右眼ADD' => $this->filterValue($order['right_add']),
                '镜框型号' => $this->filterValue($order['left_glasses']),
                '镜框数量' => $this->filterValue($order['left_glasses_cloth_num']),
                '镜框价格' => $this->filterValue($order['left_glasses_cloth_price']),
                '右眼镜片型号' => $this->filterValue($order['right_frame']),
                '右眼镜片数量' => $this->filterValue($order['right_frame_num']),
                '右眼镜片价格' => $this->filterValue($order['right_frame_price']),
                '左眼镜片型号' => $this->filterValue($order['left_frame']),
                '左眼镜片数量' => $this->filterValue($order['left_frame_num']),
                '左眼镜片价格' => $this->filterValue($order['left_frame_price']),
                '眼镜盒型号' => !empty($order['glasses_les']) ? $this->filterValue($order['glasses_les']) : '',
                '眼镜盒数量' => !empty($order['glasses_les_num']) ? $this->filterValue($order['glasses_les_num']) : '',
                '眼镜盒价格' => !empty($order['glasses_les_price']) ? $this->filterValue($order['glasses_les_price']) : '',
                '眼镜布型号' => !empty($order['case']) ? $this->filterValue($order['case']) : '',
                '眼镜布数量' => !empty($order['glasses_case_num']) ? $this->filterValue($order['glasses_case_num']) : '',
                '眼镜布价格' => $this->filterValue($order['glasses_case_price']),
                '销售员' => $this->filterValue($order['sales']),
                '验光师' => $this->filterValue($order['optometry']),
                '加工师' => $this->filterValue($order['working']),
                '收银员' => $this->filterValue($order['cash']),
                '说明' => $this->filterValue($order['notes']),
                '折扣金额' => $this->filterValue($order['discount']),
                '合计金额' => $this->filterValue($order['total']),
                '实收金额' => $this->filterValue($order['pay_total']),
                '订单时间' => $this->filterTime($order['create_time']),
            ];
        }
        // 导出csv文件
        $filename = 'order-' . date('YmdHis');
        return export_excel($filename . '.csv', $this->tileArray, $dataArray);
    }

    public function contact_orderLists($list)
    {
        // 表格内容
        $dataArray = [];
        foreach ($list as $order) {
            /* @var OrderAddressModel $address */
            $dataArray[] = [
                '订单号' => $this->filterValue($order['contact_no']),
                '店铺名' => $this->getShopName($order['user_id']),
                '客户名字' => $this->filterValue($order['user_name']),
                '手机号' => $this->filterValue($order['mobile']),
                '积分' => $this->getPoint($order['point']),
                '右眼镜片型号' => $this->filterValue($order['contact']),
                '右眼镜片数量' => $this->filterValue($order['contact_num']),
                '右眼镜片价格' => $this->filterValue($order['contact_price']),
                '左眼镜片型号' => $this->filterValue($order['left_contact']),
                '左眼镜片数量' => $this->filterValue($order['left_contact_num']),
                '左眼镜片价格' => $this->filterValue($order['left_contact_price']),
                '护理液型号' => !empty($order['contact_solution']) ? $this->filterValue($order['contact_solution']) : '',
                '护理液数量' => !empty($order['solution_num']) ? $this->filterValue($order['solution_num']) : '',
                '护理液价格' => !empty($order['solution_price']) ? $this->filterValue($order['solution_price']) : '',
                '眼镜盒型号' => !empty($order['contact_les']) ? $this->filterValue($order['contact_les']) : '',
                '眼镜盒数量' => !empty($order['contact_les_num']) ? $this->filterValue($order['contact_les_num']) : '',
                '眼镜盒价格' => $this->filterValue($order['contact_les_price']),
                '销售员' => $this->filterValue($order['sales']),
                '验光师' => $this->filterValue($order['optometry']),
                '加工师' => $this->filterValue($order['working']),
                '收银员' => $this->filterValue($order['cash']),
                '说明' => $this->filterValue($order['notes']),
                '折扣金额' => $this->filterValue($order['discount']),
                '合计金额' => $this->filterValue($order['total']),
                '实收金额' => $this->filterValue($order['pay_total']),
                '订单时间' => $this->filterTime($order['create_time']),
            ];
        }
        // 导出csv文件
        $filename = 'order-' . date('YmdHis');
        return export_excel($filename . '.csv', $this->tileArray, $dataArray);
    }
    public function getShopName($user_id)
    {
        return Db::name('user')->where('user_id',$user_id)->value('shop_name');
    }

    public function getPoint($mobile)
    {
        return Db::name('new_order_point')->where('mobile',$mobile)->value('point');

    }
    /**
     * 批量发货模板
     */
    public function deliveryTpl()
    {
        // 导出csv文件
        $filename = 'delivery-' . date('YmdHis');
        return export_excel($filename . '.csv', ['订单号', '物流单号']);
    }

    /**
     * 格式化商品信息
     * @param $order
     * @return string
     */
    private function filterGoodsInfo($order)
    {
        $content = '';
        foreach ($order['goods'] as $key => $goods) {
            $content .= ($key + 1) . ".商品名称：{$goods['goods_name']}\n";
            !empty($goods['goods_attr']) && $content .= "　商品规格：{$goods['goods_attr']}\n";
            $content .= "　购买数量：{$goods['total_num']}\n";
            $content .= "　商品总价：{$goods['total_price']}元\n\n";
        }
        return $content;
    }

    /**
     * 表格值过滤
     * @param $value
     * @return string
     */
    private function filterValue($value)
    {
        return "\t" . $value . "\t";
    }

    /**
     * 日期值过滤
     * @param $value
     * @return string
     */
    private function filterTime($value)
    {
        if (!$value) return '';
        return $this->filterValue(date('Y-m-d H:i:s', $value));
    }

    private function filterTest($value)
    {
        if($value == 0){
            return "\t" . "合格" . "\t";
        }else{
            return "\t" . "不合格" . "\t";
         }
    }



}