<?php

namespace app\common\model;

use think\Hook;
use app\common\model\store\shop\Order as ShopOrder;
use app\common\service\Order as OrderService;
use app\common\service\order\Complete as OrderCompleteService;
use app\common\enum\OrderType as OrderTypeEnum;
use app\common\enum\DeliveryType as DeliveryTypeEnum;
use app\common\enum\order\PayType as PayTypeEnum;
use app\common\enum\order\PayStatus as PayStatusEnum;
use app\common\library\helper;

/**
 * 订单模型
 * Class Order
 * @package app\common\model
 */
class NewOrder extends BaseModel
{
    protected $name = 'new_order';
    protected $createTime  = 'create_time';


    /**
     * 关联用户表
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->belongsTo("app\\{$module}\\model\\User");
    }





}
