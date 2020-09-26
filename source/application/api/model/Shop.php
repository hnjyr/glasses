<?php

namespace app\api\model;

use app\common\model\Shop as ShopModel;
use think\Db;
/**
 * 系统设置模型
 * Class Setting
 * @package app\api\model
 */
class Shop extends ShopModel
{

    /**
     * @param $data
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException查询省份
     */
    public static function checkProvince($data)
    {
        return DB::name('region')->where(['name'=>$data['province_id'],'level'=>1])->find();
    }

    /**
     * @param $data
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException查询市区
     */
    public static function checkCity($data)
    {
        return DB::name('region')->where(['name'=>$data['city_id'],'level'=>2])->find();
    }

    /**
     * @param $data
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException查询区域
     */
    public static function checkRegion($data)
    {
        return DB::name('region')->where(['name'=>$data['region_id'],'level'=>3])->find();
    }
    /**
     * 新增记录
     * @param $data
     * @return bool|false|int
     * @throws \think\exception\DbException
     */
    public function add($data,$img_id)
    {
        if(!$data['salesman_id']){
            $this->error= '业务员不存在!';
            return false;
        }
        if(!$data['shop_name']){
            $this->error= '门店名字不能为空!';
            return false;
        }
        if(!$data['business_name']){
            $this->error= '营业执照名字不能为空!';
            return false;
        }
        if(!$data['phone']){
            $this->error= '联系人电话不能为空!';
            return false;
        }
        if(!$data['linkman']){
            $this->error= '联系人名字不能为空!';
            return false;
        }
        if(!$province = self::checkProvince($data)){
            $this->error= '所在省份不能为空!';
            return false;
        }
        if(!$city = self::checkCity($data)){
            $this->error= '所在市区不能为空!';
            return false;
        }
        if(!$region = self::checkRegion($data)){
            $this->error= '所在区域不能为空!';
            return false;
        }
        if(!$data['address']){
            $this->error= '详细地址不能为空!';
            return false;
        }
        $this->startTrans();
        try {
            // 新增管理员记录
            $data['create_time'] = time();
            $data['logo_image_id'] = $img_id;
            $data['province_id'] = $province['id'];
            $data['city_id'] = $city['id'];
            $data['region_id'] = $region['id'];
            $data['status'] = 0;
            $this->allowField(true)->save($data);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }

    public function addImage($data)
    {
        $file['business'] = isset($data['business']) ? isset($data['business']) : '';
        $file['business_2'] = isset($data['business_2']) ? isset($data['business_2']) : '';
        $file['title'] = isset($data['title']) ? isset($data['title']) : '';
        $file['title_2'] = isset($data['title_2']) ? isset($data['title_2']) : '';
        $file['shop_img'] = isset($data['shop_img']) ? isset($data['shop_img']) : '';
        $file['shop_img_2'] = isset($data['shop_img_2']) ? isset($data['shop_img_2']) : '';
        $file['shop_img_3'] = isset($data['shop_img_3']) ? isset($data['shop_img_3']) : '';
        $file['is_delete'] = 0;
        $file['create_time'] = time();
        if($file){
          return  Db::name('shop_image')->insertGetId($file);
        }
    }

    public function addImage2($data)
    {
        $file['business'] = isset($data['business']) ? isset($data['business']) : '';
        $file['business_2'] = isset($data['business_2']) ? isset($data['business_2']) : '';
        $file['is_delete'] = 0;
        $file['create_time'] = time();
        if($file){
            return  Db::name('shop_image')->insertGetId($file);
        }
    }

    public function getList()
    {
        return $this->where('is_delete', '=', '0')
            ->order(['create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
    }

}
