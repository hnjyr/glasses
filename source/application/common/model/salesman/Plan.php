<?php

namespace app\common\model\salesman;

use think\Session;
use app\common\model\BaseModel;
use app\common\model\Region as RegionModel;

/**
 * 商家用户模型
 * Class User
 * @package app\common\model
 */
class Plan extends BaseModel
{
    protected $name = 'salesman_plan';

    /**
     * @var array 追加字段
     */
    protected $append = ['region'];

    /**
     * 验证用户名是否重复
     * @param $user_name
     * @return bool
     */
    public static function checkExist($month,$salesman_id)
    {
        return !!static::useGlobalScope(false)
            ->where('month', '=', $month)
            ->where('salesman_id', '=', $salesman_id)
            ->where('is_delete', '=', 0)
            ->find();
    }


    /**
     * 商家用户详情
     * @param $where
     * @param array $with
     * @return static|null
     * @throws \think\exception\DbException
     */
    public static function detail($where, $with = [])
    {
        $where = ['salesman_id' => (int)$where];
        return static::get($where);
    }

    /**
     * 地区名称
     * @param $value
     * @param $data
     * @return array
     */
    public function getRegionAttr($value, $data)
    {
        return [
            'province' => RegionModel::getNameById($data['province_id']),
            'city' => RegionModel::getNameById($data['city_id']),
            'region' => $data['region_id'] == 0 ? '' : RegionModel::getNameById($data['region_id']),
        ];
    }




}
