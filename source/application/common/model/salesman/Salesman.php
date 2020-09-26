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
class Salesman extends BaseModel
{
    protected $name = 'salesman';

    /**
     * @var array 追加字段
     */
    protected $append = ['region'];

    /**
     * 验证用户名是否重复
     * @param $user_name
     * @return bool
     */
    public static function checkExist($user_name)
    {
        return !!static::useGlobalScope(false)
            ->where('user_name', '=', $user_name)
            ->where('is_delete', '=', 0)
            ->value('salesman_id');
    }

    public static function checkCity($province_id,$city_id,$region_id,$type)
    {
        return !!static::useGlobalScope(false)
            ->where('province_id', '=', $province_id)
            ->where('type', '=', $type)
            ->where('city_id', '=', $city_id)
            ->where('region_id', '=', $region_id)
            ->where('is_delete', '=', 0)
            ->value('salesman_id');
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
