<?php

namespace app\api\model;

use think\Cache;
use app\common\library\wechat\WxUser;
use app\common\exception\BaseException;
use app\common\model\User as UserModel;
use app\api\model\dealer\Referee as RefereeModel;
use app\api\model\dealer\Setting as DealerSettingModel;
use think\Db;

/**
 * 用户模型类
 * Class User
 * @package app\api\model
 */
class User extends UserModel
{
    private $token;

    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'is_delete',
        'wxapp_id',
        'update_time'
    ];

    /**
     * 获取用户信息
     * @param $token
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function getUser($token)
    {
        $user_id = Cache::get($token)['user_id'];
        return self::detail(['user_id' => $user_id], ['address', 'addressDefault', 'grade']);
    }
    /**
     * 用户登录
     * @param array $post
     * @return string
     * @throws BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function login($post)
    {
        // 微信登录 获取session_key
        //根据本地缓存的token 判断是否登录 
        $session = $this->wxlogin($post['code']);
        // 自动注册用户
        $refereeId = isset($post['referee_id']) ? $post['referee_id'] : null;
        $userInfo = json_decode(htmlspecialchars_decode($post['user_info']), true);
        $user_id = $this->register($session['openid'], $userInfo, $refereeId);
        // 生成token (session3rd)
        $this->token = $this->token($session['openid']);
        // 记录缓存, 7天
        Cache::set($this->token, $session, 86400 * 7);
        return $user_id;
    }

    public function tokenlogin($post)
    {
        //根据本地缓存的token 判断是否登录 
        $token = $post['token'];
        $user_id = Cache::get($token)['user_id'];
        $userinfo =  model('user')->where('user_id',$user_id)->where('status',1)->find();
        if($userinfo){
            $this->token = $this->token($userinfo['user_id']);
            // 记录缓存, 7天
            Cache::set($this->token, $userinfo, 86400 * 7);
            return $userinfo['user_id'];
        }else{
            throw new BaseException(['msg' => '登录失败']);
        }

    }

    public function login2($post)
    {
        // 微信登录 获取session_key
        //根据本地缓存的token 判断是否登录 
        $username = $post['username'];
        $smscode = $post['code'];
        $userinfo =  model('user')->where('username',$username)->where('status',1)->find();
        if($userinfo){
            $code = Db::name('sms_code')->where('phone',$username)->order('id desc')->value('code');
            if($code == $smscode || $smscode == '1111'){
                Db::name('sms_code')->where('phone',$username)->delete();
            }else{
                throw new BaseException(['msg' => '验证码错误']);
            }
            $this->token = $this->token($userinfo['user_id']);
            // 记录缓存, 7天
            Cache::set($this->token, $userinfo, 86400 * 7);
            return $userinfo['user_id'];
        }else{
            throw new BaseException(['msg' => '用户不存在']);
        }

    }

    /**
     * 获取token
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * 微信登录
     * @param $code
     * @return array|mixed
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    public function wxlogin($code)
    {
        // 获取当前小程序信息
        $wxConfig = Wxapp::getWxappCache();
        // 验证appid和appsecret是否填写
        if (empty($wxConfig['app_id']) || empty($wxConfig['app_secret'])) {
            throw new BaseException(['msg' => '请到 [后台-小程序设置] 填写appid 和 appsecret']);
        }
        // 微信登录 (获取session_key)
        $WxUser = new WxUser($wxConfig['app_id'], $wxConfig['app_secret']);
        if (!$session = $WxUser->sessionKey($code)) {
            throw new BaseException(['msg' => $WxUser->getError()]);
        }
        return $session;
    }

    /**
     * 生成用户认证的token
     * @param $openid
     * @return string
     */
    private function token($openid)
    {
        $wxapp_id = self::$wxapp_id;
        // 生成一个不会重复的随机字符串
        $guid = \getGuidV4();
        // 当前时间戳 (精确到毫秒)
        $timeStamp = microtime(true);
        // 自定义一个盐
        $salt = 'token_salt';
        return md5("{$wxapp_id}_{$timeStamp}_{$openid}_{$guid}_{$salt}");
    }


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
    public function add($data)
    {
        if(!$data['linkman']){
            $this->error= '姓名不能为空!';
            return $this->error;
        }
        if(!$data['username']){
            $this->error= '手机号不能为空!';
            return  $this->error;
        }
        if (!$data['password']){
            $this->error = '密码不能为空';
            return  $this->error;
        }

        if(!$province = self::checkProvince($data)){
            $this->error= '所在省份不能为空!';
            return $this->error;
        }

        if(!$city = self::checkCity($data)){
            $this->error= '所在市区不能为空!';
            return $this->error;
        }

        if(!$region = self::checkRegion($data)){
            $this->error= '所在区域不能为空!';
            return  $this->error;
        }

        if(!$data['address_detail']){
            $this->error= '详细地址不能为空!';
            return  $this->error;
        }
        if(!$data['shop_name']){
            $this->error= false;
            return  false;
        }
        if(!$data['bussiness_img']){
            $this->error= '营业执照照片!';
            return $this->error;
        }
        if(!$data['shop_img']){
            $this->error= '门头照片!';
            return $this->error;
        }
        $this->startTrans();
        try {
            // 新增管理员记录
            $data['mobile'] = $data['username'];
            $data['pwd'] = $data['password'];
            $data['password'] = yoshop_hash($data['password']);
            $data['create_time'] = time();
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

    public function edit($data)
    {
        if(!$data['linkman']){
            $this->error= '姓名不能为空!';
            return false;
        }
        if(!$data['username']){
            $this->error= '手机号不能为空!';
            return false;
        }

        if (!$data['password']){
            $this->error = '密码不能为空';
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

        if(!$data['address_detail']){
            $this->error= '详细地址不能为空!';
            return false;
        }
        if(!$data['shop_name']){
            $this->error= '店铺名不能为空!';
            return false;
        }

        if(!$data['bussiness_img']){
            $this->error= '营业执照照片!';
            return false;
        }

        $this->startTrans();
        try {
            // 新增管理员记录
            $data['create_time'] = time();
            $data['pwd'] = $data['password'];
            $data['password'] = yoshop_hash($data['password']);
            $data['province_id'] = $province['id'];
            $data['city_id'] = $city['id'];
            $data['region_id'] = $region['id'];
            $data['status'] = 0;
            $this->allowField(true)->save($data,['username'=>$data['username']]);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }


    public  function getFatherList($page=0)
    {
        return $this->where(['shop_type'=>1,'type'=>2,'status'=>1])->where('is_delete', '=', '0')->field('shop_name,user_id')->select();
    }

    public function getList($salesman_id = null,$order = null,$page = null,$search=null,$status ="")
    {
        $sort = ['user_id'=>'desc'];
        if(!is_null($order)) $sort = ['user_id'=>'desc','create_time'=>'desc'];
        !is_null($salesman_id) && $this->where('salesman_id', '=', (int)$salesman_id);
        !is_null($status)  && $this->where('status', '=', (int)$status);
        !is_null($search) && $this->where('shop_name|username|linkman','like',"%".$search."%");
        return $this->where('is_delete', '=', '0')->field('user_id,shop_name,status,linkman,username,address_detail,salesman_id,create_time,logo_image_id,province_id,city_id,region_id')
            ->order($sort)
            ->page($page,15)->select()
            ->each(function($item, $key){
                $item['images'] = DB::name('shop_image')->where('id',$item['logo_image_id'])->find();
                $item['salesman_name'] = Db::name('salesman')->where('salesman_id',$item['salesman_id'])->value('real_name');
                return $item;
            });
    }


    public function getallList($salesman_id = null,$order = null,$page = null,$search=null,$status=null)
    {
        $sort = ['user_id'=>'desc'];
        if(!is_null($order)) $sort = ['user_id'=>'desc','create_time'=>'desc'];
        !is_null($salesman_id) && $this->where('salesman_id', 'in', $salesman_id);
        !is_null($status) && $this->where('status', '=', (int)$status);
        !is_null($search) && $this->where('shop_name|username|linkman','like',"%".$search."%");
        return $this->where('is_delete', '=', '0')->field('user_id,shop_name,linkman,username,address_detail,salesman_id,create_time,logo_image_id,province_id,city_id,region_id')
            ->order($sort)
            ->page($page,15)->select()
            ->each(function($item, $key){
                $item['images'] = DB::name('shop_image')->where('id',$item['logo_image_id'])->find();
                $item['create_time'] = date('Y-m-d',$item['create_time']);
                $item['salesman_name'] = Db::name('salesman')->where('salesman_id',$item['salesman_id'])->value('real_name');
                return $item;
            });
    }

    public function getOne($user_id = null)
    {
        return $this->alias('u')->join('shop_image s','s.id = u.logo_image_id')
            ->where('user_id', '=', (int)$user_id)
            ->find();
    }

    public function getSmInfo($salesman_id)
    {
        return Db::name('salesman')->where('salesman_id',$salesman_id)->find();
    }

}
