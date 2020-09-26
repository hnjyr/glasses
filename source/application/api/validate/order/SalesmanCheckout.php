<?php

namespace app\api\validate\order;

use think\Validate;

class SalesmanCheckout extends Validate
{
    /**
     * 验证规则
     * @var array
     */
    protected $rule = [

        // 商品id
        'goods_id' => [
            'require',
            'number',
            'gt' => 0
        ],
        //姓名
        'name' => [
            'require',
        ],
        'phone' => [
            'require',
        ],
        'city_id' => [
            'require',
        ],

        'region_id' => [
            'require',
        ],

        'province_id' => [
            'require',
        ],
        'detail' => [
            'require',
        ],

        // 购买数量
        'goods_num' => [
            'require',
            'number',
            'gt' => 0
        ],

        // 商品sku_id
        'goods_sku_id' => [
            'require',
        ],

//        // 购物车id集
//        'cart_ids' => [
//            'require',
//        ],

    ];

    /**
     * 验证场景
     * @var array
     */
    protected $scene = [
        'buyNow' => ['goods_id', 'goods_num', 'goods_sku_id'],
        'setAddress' => ['name', 'phone', 'city_id','region_id','province_id','detail'],
//        'cart' => ['cart_ids'],
    ];

}
