<?php

namespace app\api\controller\salesman;
use app\common\library\helper;
use app\store\model\NewOrder as NewOrderModel;
use app\common\model\Store as StoreModel;
use app\api\controller\Controller;
use app\api\model\Order as OrderModel;
use app\api\model\Article as ArticleModel;
use app\store\model\Express;
use app\common\model\Region;
use app\store\model\NewOrder;
use think\DB;
use app\api\model\Shop as ShopModel;
use app\api\model\User as UserModel;
use app\api\model\Goods as GoodsModel;
use app\common\model\Setting as SettingModel;
use app\common\library\sms\Driver as SmsDriver;
use app\api\validate\order\SalesmanCheckout as CheckoutValidate;
use app\api\model\SalesmanOrder as SalesmanOrderModel;
use think\Request;

/**
 * 业务员管理
 * Class User
 * @package app\api
 */
class Index extends Controller
{

    /**
     * 用户自动登录
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function login()
    {
        $data = $this->request->post();
        // 验证用户名密码是否正确
        if (!$user = $this->getLoginUser($data['mobile'])) {
            return $this->renderError("用户不存在或被禁用!",[]);
        }

        if (($user['start_time']> time())  || ($user['end_time'] < time())){
            return $this->renderError("账号已过期,请联系管理员!");
        }
        $code = Db::name('sms_code')->where('phone',$data['mobile'])->order('create_time desc')->value('code');
        if($code != $data['code']){
            return $this->renderError("验证码不正确!",[]);
        }
        $u_token = DB::name('user_token')->where(['user_id' => $user['user_id']])->find();
        if ($u_token) {
            DB::name('user_token')->where(['id' => $u_token['id']])->delete();
        }
        $userTokenQuery = Db::name("user_token")
            ->where(['user_id'=>$user['user_id']]);
        $findUserToken = $userTokenQuery->find();
        $currentTime = time();
        $expireTime = $currentTime + 24 * 3600 * 180;
        $token = md5(uniqid()) . md5(uniqid());
        $return_token = $findUserToken['token'];
        $result = true;
        if (empty($findUserToken)) {
            $result = $userTokenQuery->insert([
                'token'       => $token,
                'user_id'     => $user['user_id'],
                'expire_time' => $expireTime,
                'create_time' => $currentTime,
            ]);
            $return_token = $token;
        }
        if (empty($result)) {
            return $this->renderError("登录失败!",[]);
        }
        return $this->renderSuccess(['token' => $return_token, 'user' => $user],"登录成功!");

    }
    public function new_login()
    {
        $data = $this->request->post();
        // 验证用户名密码是否正确
        if (!$user = $this->getLoginUser($data['mobile'])) {
            return $this->renderError("用户不存在或被禁用!",[]);
        }
        if ($user['password'] != yoshop_hash($data['password'])){
            return $this->renderError("密码不正确!",[]);
        }
        if (($user['start_time']> time())  || ($user['end_time'] < time())){
            return $this->renderError("账号已过期,请联系管理员!");
        }
        /*$code = Db::name('sms_code')->where('phone',$data['mobile'])->order('create_time desc')->value('code');
        if($code != $data['code']){
            return $this->renderError("验证码不正确!",[]);
        }*/
        $u_token = DB::name('user_token')->where(['user_id' => $user['user_id']])->find();
        if ($u_token) {
            DB::name('user_token')->where(['id' => $u_token['id']])->delete();
        }
        $userTokenQuery = Db::name("user_token")
            ->where(['user_id'=>$user['user_id']]);
        $findUserToken = $userTokenQuery->find();
        $currentTime = time();
        $expireTime = $currentTime + 24 * 3600 * 180;
        $token = md5(uniqid()) . md5(uniqid());
        $return_token = $findUserToken['token'];
        $result = true;
        if (empty($findUserToken)) {
            $result = $userTokenQuery->insert([
                'token'       => $token,
                'user_id'     => $user['user_id'],
                'expire_time' => $expireTime,
                'create_time' => $currentTime,
            ]);
            $return_token = $token;
        }
        if (empty($result)) {
            return $this->renderError("登录失败!",[]);
        }
        return $this->renderSuccess(['token' => $return_token, 'user' => $user],"登录成功!");

    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 检查用户token过期
     */
    public function isLogin()
    {
        $data = $this->request->post();
        if($data['token']){
            $u_token = DB::name('user_token')->where(['token' => $data['token']])->find();
            if($u_token){
                return $this->renderSuccess("登录成功!");
            }else{
                return $this->renderError("请先登录!");
            }
        }else{
            return $this->renderError("参数错误!");
        }

    }

    private function getLoginUser($user_name)
    {
        return DB::name('user')->where([
            'username' => $user_name,
            'is_delete' => 0,
            'status'=>1
        ])->find();
    }
    private function getLoginPwd($pwd)
    {
        return DB::name('user')->where([
            'password' =>yoshop_hash($pwd) ,
            'is_delete' => 0,
            'status'=>1
        ])->find();
    }

    public function isCode()
    {
        $data = $this->request->post();
        if($data['mobile']){
            $code = Db::name('sms_code')->where('phone',$data['mobile'])->order('create_time desc')->value('code');
            if($code == $data['code']){
                return $this->renderSuccess([],"成功!");
            }
            return $this->renderError("验证码错误!",[]);

        }

    }

    /**
     * @return array
     * @throws \think\Exception
     * 发送验证码
     */
    public function smscode(){
        $phone = $this->request->post('phone');
//        dump($this->request->post());die();
        $smsConfig = SettingModel::getItem('sms', '10001');
        $SmsDriver = new SmsDriver($smsConfig);
        $code = rand(1000,9999);
        $op['phone'] = $phone;
        $op['code'] = $code;
        $op['create_time'] = time();
        Db::name('sms_code')->insert($op);
        $info = $SmsDriver->sendSmscode('register', ['code' => $code],true,$phone);
        if($info){
            return $this->renderSuccess([],'发送成功');
        }else{
            return $this->renderError('发送失败',[]);
        }

    }

//    public function smscode(){
//        $phone = $this->request->post('phone');
//        $smsConfig = SettingModel::getItem('sms', '10001');
//        $SmsDriver = new SmsDriver($smsConfig);
//        $code = rand(1000,9999);
//        $op['phone'] = $phone;
//        $op['code'] = 1111;
//        $op['create_time'] = time();
//        $res = Db::name('sms_code')->insertGetId($op);
//        if($res){
//            return $this->renderSuccess([],'发送成功');
//        }else{
//            return $this->renderError('发送失败',[]);
//        }
//
//    }

    /**
     * 修改密码(找回密码)
     */
    public function editPassword()
    {
        $data = $this->request->post();

         $userinfo = Db::name('user')->where('username',$data['mobile'])->find();
            if($userinfo) {
                $code = Db::name('sms_code')->where('phone',$userinfo['username'])->order('create_time desc')->value('code');
                if($data['type'] == 1){  //修改密码
                    if ($data['pwd'] != $data['new_pwd']){
                        return $this->renderError("两次输入的密码不一致！",[]);
                    }
                    /*if(yoshop_hash($data['old_pwd']) == $userinfo['password']){*/
                    if($data['code'] == $code){
                        $res = Db::name('user')->where('user_id',$userinfo['user_id'])->update(['password'=>yoshop_hash($data['pwd']),'pwd'=>$data['pwd']]);
                        if($res){
                            return $this->renderSuccess([],"修改成功!");
                        }else{
                            return $this->renderError("修改失败,请联系后台管理员!",[]);
                        }
                    }else{
                        return $this->renderError("验证码错误!",[]);
                    }
                }
                if($data['type'] == 2){   //找回密码
                    $code = Db::name('sms_code')->where('phone',$userinfo['username'])->order('create_time desc')->value('code');
                    if($data['code'] == $code){
                        $res = Db::name('user')->where('username',$data['mobile'])->find();
                        if($res){
                            return $this->renderSuccess([$res['pwd']],"找回成功!");
                        }else{
                            return $this->renderError("用户不存在！",[]);
                        }
                    }else{
                        return $this->renderError("验证码错误!",[]);
                    }

                }
            }
    }

    /**
     * @return array获取所有总店列表
     */
    public function fatherList()
    {
        $model = new UserModel();
        $data = $this->request->post();
        $page = $data['page'] ? $data['page']  : 0;
        $list = $model->getFatherList($page);
        if($list){
            return $this->renderSuccess($list,"查询成功!");
        }
        return  $this->renderError("查询失败!",[]);
    }


    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException判断用户状态 0待审核 1启用 2禁用 3第一次申请
     */
    public function isStatus()
    {
        $data = $this->request->post();
        if($data['mobile']){
            $res = Db::name('user')->where('username',$data['mobile'])->find();
            if($res){
                return $this->renderSuccess(
                    ['status'=>$res['status'],'notes'=>$res['notes'],
                        'data'=>[
                            'username'=>$res['username'],
                            'password'=>$res['pwd'],
                            'start_time' => date("Y-m-d",$res['start_time']),
                            'end_time' => date("Y-m-d",$res['end_time']),
                            'http'=>$_SERVER['HTTP_HOST'] .'/index.php?s=/store/passport/login'
                        ],'is_alert'=>$res['is_alert'] ? $res['is_alert'] : 0,
                    ],"查询成功!");
            }else{
                return $this->renderSuccess(['status'=>3,'notes'=>''],"查询成功!");
            }
        }
        return  $this->renderError("查询失败!",[]);
    }


    /**
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException是否是第一次进入app(第一次进入需要给用户提示自己的账号密码)
     */
    public function isAlert()
    {
        $data = $this->request->post();
        $user = DB::name('user')->where('username', $data['mobile'])->where('is_alert',0)->find();
        $res = Db::name('user')->where('username', $data['mobile'])->update(['is_alert' => 1]);
        $list['start_time'] = date("Y-m-d",$user['start_time']) ;
        $list['end_time'] = date("Y-m-d",$user['end_time']) ;
        if ($res) {
            return $this->renderSuccess($list, "成功!");
        }else{
            return $this->renderError('失败!');
        }

    }


    /**
     * @return array
     * @throws \think\exception\DbException注册
     */
    public function register()
    {
        $model = new UserModel();
        $data = $this->request->post();
        if($data['data_type'] == 0){
            $result = Db::name('user')->where('username',$data['username'])->find();
            if($result){
                return  $this->renderError("不能重复申请!");
            }
            $res = $model->add($data);
        }else if($data['data_type'] == 1){
            $res = $model->edit($data);
        }else{
           $list = Db::name('user')->where('username',$data['username'])->find();
           $list['province_id'] = DB::name('region')->where(['id'=>$list['province_id']])->value('name');
           $list['city_id'] = DB::name('region')->where(['id'=>$list['city_id']])->value('name');
           $list['region_id'] = DB::name('region')->where(['id'=>$list['region_id']])->value('name');
           if($list){
               return $this->renderSuccess($list,"查询成功!");
           }else{
               return  $this->renderError("查询失败!");
           }
        }
        if($res){
            return $this->renderSuccess([],"申请成功,等待审核!");
        }
        return  $this->renderError("申请失败!");
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException我的信息展示
     */
    public function myindex()
    {
        $data = $this->request->post();
        if(!$data['token']){
            return $this->renderError('参数错误!');
        }
        $user_token = Db::name('user_token')->where('token',$data['token'])->find();
        if(!$user_token){
            return $this->renderError('请重新登录!');
        }
        $list = Db::name('store_user')->field('user_name as username')->where(['user_id'=>$user_token['user_id']])->find();
        $user = DB::name('user')->where('user_id',$user_token['user_id'])->find();
        $list['start_time'] = date("Y-m-d",$user['start_time']) ;
        $list['end_time'] = date("Y-m-d",$user['end_time']) ;
        $list['pwd'] =  Db::name('user')->field('pwd')->where(['user_id'=>$user_token['user_id']])->value('pwd');
        if($list){
            $list['http'] = $_SERVER['HTTP_HOST']  .'/index.php?s=/store/passport/login';
            return $this->renderSuccess($list,'查询成功');
        }
        return $this->renderError('查询失败!');
    }

    /**
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException修改头像
     */
    public function setHeadimage()
    {
        $data = $this->request->post();
        if(!$data['token']){
            return $this->renderError('参数错误!');
        }
        $user_token = Db::name('user_token')->where('token',$data['token'])->find();
        if(!$user_token){
            return $this->renderError('请重新登录!');
        }
        $res = Db::name('user')->where('user_id',$user_token['user_id'])->update(['avatarUrl'=>$data['head_img']]);
        if($res){
            return $this->renderSuccess([],'头像修改成功!');
        }
        return $this->renderError('头像修改失败!');
    }


    /**
     * 店铺营业额
     */
    public function shopSales()
    {
        $data = $this->request->post();
        if(!$data['token']){
            return $this->renderError('参数错误!');
        }
        $user_token = Db::name('user_token')->where('token',$data['token'])->find();
        if(!$user_token){
            return $this->renderError('请重新登录!');
        }
        $user_list = Db::name('user')->where('pid',$user_token['user_id'])->column('user_id');
        if($user_list){
            array_push($user_list,$user_token['user_id']);
        }else{
            $user_list =[];
            array_push($user_list,$user_token['user_id']);
        }
        $today = Db::name('new_order')->where('user_id','in',$user_list)->whereTime('create_time','today')->sum('pay_total');
        $month = Db::name('new_order')->where('user_id','in',$user_list)->whereTime('create_time','m')->sum('pay_total');
        $years = Db::name('new_order')->where('user_id','in',$user_list)->whereTime('create_time','y')->sum('pay_total');
        if($data['user_id']){
            $today = Db::name('new_order')->where('user_id',$data['user_id'])->whereTime('create_time','today')->sum('pay_total');
            $month = Db::name('new_order')->where('user_id',$data['user_id'])->whereTime('create_time','m')->sum('pay_total');
            $years = Db::name('new_order')->where('user_id',$data['user_id'])->whereTime('create_time','y')->sum('pay_total');
        }
        if($data['this_user_id']){
            $today = Db::name('new_order')->where('user_id',$data['this_user_id'])->whereTime('create_time','today')->sum('pay_total');
            $month = Db::name('new_order')->where('user_id',$data['this_user_id'])->whereTime('create_time','m')->sum('pay_total');
            $years = Db::name('new_order')->where('user_id',$data['this_user_id'])->whereTime('create_time','y')->sum('pay_total');
        }
        return  $this->renderSuccess(['today'=>$today,'month'=>$month,'year'=>$years],'查询成功');

    }


    /**
     *店铺列表
     */
    public function allShopList()
    {
        $data = $this->request->post();
        $model = New UserModel();
        if(!$data['token']){
            return $this->renderError('参数错误!');
        }
        $user_token = Db::name('user_token')->where('token',$data['token'])->find();
        if(!$user_token){
            return $this->renderError('参数错误!');
        }
        $list = Db::name('user')->where('pid',$user_token['user_id'])->field('shop_name,user_id')->select();
        if($data['province_id'] && $data['city_id'] && $data['region_id']){
            $province_id = UserModel::checkProvince($data)['id'];
            $city_id = UserModel::checkCity($data)['id'];
            $region_id = UserModel::checkRegion($data)['id'];
            if(!$province_id || !$city_id || !$region_id){
                return $this->renderError('参数错误!');
            }
            $list = Db::name('user')->where(['province_id'=>$province_id,'city_id'=>$city_id,'region_id'=>$region_id,'pid'=>$user_token['user_id']])->field('shop_name,user_id')->select();
        }
        if($list){
            return $this->renderSuccess($list,'查询成功!');
        }else{
            return $this->renderError('查询失败!');
        }

    }


    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbExceptionw 我的信息
     */
    public function myMessage()
    {
        $data = $this->request->post();
        $model = New UserModel();
        if(!$data['token']){
            return $this->renderError('参数错误!');
        }
        $user_token = Db::name('user_token')->where('token',$data['token'])->find();
        if(!$user_token){
            return $this->renderError('请重新登录!');
        }
        $user_info = DB::name('user')->where('user_id',$user_token['user_id'])->find();
        if(!$user_info){
            return $this->renderError('参数错误!');
        }
        $list = $model->find($user_info['user_id']);
        if($list){
            return $this->renderSuccess($list,'查询成功!');
        }else{
            return $this->renderError('查询失败!');
        }
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException订单列表
     */
    public function orderList()
    {
        $data = $this->request->post();
        $page = $data['page'] ? $data['page'] : 0;
        $model = New NewOrder();
        if(!$data['token']){
            return $this->renderError('参数错误!');
        }
        $user_token = Db::name('user_token')->where('token',$data['token'])->find();
        if(!$user_token){
            return $this->renderError('请重新登录!');
        }
        $user_list = Db::name('user')->where('pid',$user_token['user_id'])->column('user_id');
        if($user_list){
            array_push($user_list,$user_token['user_id']);
        }else {
            $user_list= [];
            array_push($user_list,$user_token['user_id']);
        }
        $list = Db::name('new_order')->where('user_id','in',$user_list)->page($page,15)->order('create_time desc')->select()->each(function ($item,$key){
            $item['create_time'] = date('Y-m-d H:i:s',$item['create_time']);
            $item['shop_name'] = Db::name('user')->where('user_id',$item['user_id'])->value('shop_name');
            $item['closeState'] = true;
            $item['goods_total'] = $item['frame_num'] + $item['lens_num'] + $item['glasses_case_num'] + $item['glasses_cloth_num'] + $item['contact_lens_num'];
            if($item['frame_num'] > 0){
                $item['count'] += 1;
            }
            if($item['lens_num'] > 0){
                $item['count'] += 1;
            }
            if($item['glasses_case_num'] > 0){
                $item['count'] += 1;
            }
            if($item['glasses_cloth_num'] > 0){
                $item['count'] += 1;
            }
            if($item['contact lens_num'] > 0){
                $item['count'] += 1;
            }
            return $item;
        });
        if($data['shop_name']){
            $list = $model->getOrderList(['shop_name'=>$data['shop_name']],$page,$user_list);
        }
        if($data['s_time'] && $data['e_time']){
            $list = $model->getOrderList(['s_time'=>$data['s_time'],'e_time'=>$data['e_time']],$page,$user_list);
        }
        if($data['user_id']){
            $list = Db::name('new_order')->where('user_id',$data['user_id'])->page($page,15)->order('create_time desc')->select()->each(function ($item,$key){
                $item['shop_name'] = Db::name('user')->where('user_id',$item['user_id'])->value('shop_name');
                $item['create_time'] = date('Y-m-d H:i:s',$item['create_time']);
                $item['closeState'] = true;
                $item['goods_total'] = $item['frame_num'] + $item['lens_num'] + $item['glasses_case_num'] + $item['glasses_cloth_num'] + $item['contact_lens_num'];
                if($item['frame_num'] > 0){
                    $item['count'] += 1;
                }
                if($item['lens_num'] > 0){
                    $item['count'] += 1;
                }
                if($item['glasses_case_num'] > 0){
                    $item['count'] += 1;
                }
                if($item['glasses_cloth_num'] > 0){
                    $item['count'] += 1;
                }
                if($item['contact_lens_num'] > 0){
                    $item['count'] += 1;
                }
                return $item;
            });
        }
        return $this->renderSuccess($list,'查询成功!');
    }


    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException订单详情
     */
    public function orderDetail()
    {
        $data = $this->request->post();
        $type = $data['type'] ? $data['type'] : 1;
        $model = New NewOrder();
        if(!$data['token']){
            return $this->renderError('参数错误!');
        }
        $user_token = Db::name('user_token')->where('token',$data['token'])->find();
        if(!$user_token){
            return $this->renderError('参数错误!');
        }
        if($type == 1){
            $list = Db::name('new_order')->where('id',$data['order_id'])->field('user_name,sex,years,mobile,birthday,create_time')->find();
            $list['create_time'] = date('Y-m-d H:i:s',$list['create_time']);
            $mobile = Db::name('user')->where('user_id',$user_token['user_id'])->value('username');
            $list['point'] = Db::name('new_order_point')->where('mobile',$mobile)->value('point') ?  Db::name('new_order_point')->where('mobile',$mobile)->value('point')  : 0;
        }
        if($type == 2){
            $list = Db::name('new_order')->where('id',$data['order_id'])->field('left_ball_mirror,left_cylinder,left_axis,left_add,right_ball_mirror,right_cylinder,right_axis,right_add,distance')->find();
        }
        if($type == 3){
            $list = Db::name('new_order')->where('id',$data['order_id'])->field('sales,optometry,working,cash,handle,inspectors')->find();
        }
        if($type == 4){
            $list = Db::name('new_order')->where('id',$data['order_id'])->field('frame,frame_num,frame_price,lens,lens_num,lens_price,glasses_case_num,glasses_case_price,glasses_cloth_num,glasses_cloth_price,contact_lens,contact_lens_num,contact_lens_price,test,notes,standard,discount,inspectors,total,pay_total')->find();
            $list['count'] = $list['frame_num'] + $list['lens_num']+ $list['glasses_case_num']+ $list['glasses_cloth_num']+$list['contact_lens_num'];
        }

        return $this->renderSuccess($list,'查询成功!');
    }



    /**
     * 历史订单
     */
    public function historyList()
    {
        $data = $this->request->post();
        $regModel = new Region();
        $page = $data['page'] ? $data['page']  : 0;
        $search = $data['key'];
        if($search){
            $where['order_no'] = ['like', "%".$search."%"];
        }
        $where['o.user_id'] = $data['user_id'];
        if($data['salesman_id']){
            $list = Db::name('order')->alias('o')
                ->join('order_address d','o.order_id = d.order_id')
                ->join('user u','u.user_id = o.user_id')
                ->join('order_goods gs','gs.order_id = o.order_id')
                ->field('u.shop_name,u.user_id,o.order_no,o.order_id,o.delivery_status,o.create_time as pay_time,o.pay_type,d.name,d.phone,d.province_id,d.city_id,d.region_id,d.detail,gs.total_num,o.order_price,o.express_price,o.pay_price,o.buyer_remark')
                ->where($where)
                ->limit(15)->order('o.create_time desc')->page($page)
                ->select()
            ->each(function ($item,$key){
                    $item['pay_time'] = date('Y-m-d H:i:s',$item['pay_time']);
                    $item['address'] = Region::getNameById($item['province_id']) . Region::getNameById($item['city_id']) .Region::getNameById($item['region_id']).$item['detail'];
                    $item['total_num_detail'] = Db::name('order_goods')->alias('g')->join('upload_file f','g.image_id = file_id')->field('f.file_name,g.goods_name')->where('order_id',$item['order_id'])->find();
                    if($item['total_num_detail']){
                        $item['total_num_detail']['file_name'] = "http://" .$_SERVER['HTTP_HOST'] ."/uploads/".$item['total_num_detail']['file_name'];
                    }
                    return $item;
                });
            return $this->renderSuccess(['list'=>$list,'count'=>count($list)],"查询成功!");
        }
    }



    public function getHomeData()
    {
        $data = $this->request->post();
        if(!$data['token']){
            return $this->renderError('参数错误!');
        }
        $user_token = Db::name('user_token')->where('token',$data['token'])->find();
        if(!$user_token){
            return $this->renderError('请重新登录!');
        }

        if ($data['user_id']){
            $userId = $data['user_id'];
        }
        if ($data['this_user_id']){
            $userId = $data['this_user_id'];
        }
        $lately7days = $this->getLately7days();
        $lately1year = $this->getLately1year();
        $data = [
            'widget_echarts' => [
                // 最近七天日期
                'date' => $lately7days,
                'order_total' => $this->getOrderTotalByDate($lately7days,$userId),
                'order_total_price' => $this->getOrderTotalPriceByDate($lately7days,$userId)
            ],
            'widget_echarts_year' => [
                // 最近七天日期
                'date' => $lately1year,
                'order_total' => $this->getOrderTotalByMonth($lately1year,$userId),
                'order_total_price' => $this->getOrderTotalPriceByMonth($lately1year,$userId)
            ],

        ];

//        return var_dump($data['widget_echarts_year']['order_total']);
        return $this->renderSuccess($data,"查询成功!");
//        return $data;
    }

    private function getLately7days()
    {
        // 获取当前周几
        $date = [];
        for ($i = 0; $i < 7; $i++) {
            $date[] = date('Y-m-d', strtotime('-' . $i . ' days'));
        }
        return array_reverse($date);
    }
    private function getLately1year()
    {
        // 获取当前月份
        //得到系统的年月
        $tmp_date=date("Ym");

        //切割出月份
        $month =substr($tmp_date,4,2);
        $date = [];

        for ($i = -1; $i < (int)$month; $i++) {
            $date[] = date('Y-m', strtotime('-' . ($i) . ' month'));
        }

        return array_reverse($date);
    }
    private function getOrderTotalByDate($days,$user_id)
    {
        $arr = [$user_id];

        $data = [];
        foreach ($days as $day) {
            $data[] = $this->getOrderTotal($day,$arr);
        }
        return $data;
    }
    private function getOrderTotalByMonth($days,$user_id)
    {
        $arr = [$user_id];

        $data = [];
        for ($i = 0;$i<count($days);$i++){
            $data[] = $this->getOrderTotalMonth($days[$i],$days[$i+1],$arr);
        }
       /* foreach ($days as $key=>$day) {
            $data[] = $this->getOrderTotalMonth($days[$key-1],$days[$key+1],$arr);
        }*/
        return $data;
    }
    private function getOrderTotalPriceByDate($days,$user_id)
    {
        $arr = [$user_id];
        $data = [];
        foreach ($days as $day) {
            $data[] = $this->getOrderTotalPrice($day,$arr);
        }
        return $data;
    }
    private function getOrderTotalPriceByMonth($days,$user_id)
    {
        $arr = [$user_id];
        $data = [];
        for ($i = 0;$i<count($days)-1;$i++){
            $data[] = $this->getOrderTotalPriceMonth($days[$i],$days[$i+1],$arr);
        }
        return $data;
    }
    private function getOrderTotal($day = null,$arr=[])
    {
        $OrderModel = new NewOrder();

        return number_format($OrderModel->getPayOrderTotal($day, $day,$arr));
    }
    private function getOrderTotalMonth($stratday = null,$endday = null,$arr=[])
    {
        $OrderModel = new NewOrder();

        return number_format($OrderModel->getPayOrderTotalByMonth($stratday, $endday,$arr));
    }
    private function getOrderTotalPrice($day = null,$arr=[])
    {
        $OrderModel = new NewOrder();
        return helper::number2($OrderModel->getOrderTotalPrice($day, $day,$arr));
    }


    private function getOrderTotalPriceMonth($stratday, $endday,$arr=[])
    {
        $OrderModel = new NewOrder();
        return helper::number2($OrderModel->getOrderTotalPriceByMonth($stratday, $endday,$arr));
    }


    public function sales_index()
    {
        $data = $this->request->post();
        $model = new NewOrderModel;
        if(!$data['token']){
            return $this->renderError('参数错误!');
        }
        $user_token = Db::name('user_token')->where('token',$data['token'])->find();
        if(!$user_token){
            return $this->renderError('请重新登录!');
        }

        if ($data['user_id']){
            $user_list = Db::name('user')->where('user_id',$data['user_id'])->column('user_id');
            if($user_list){
                array_push($user_list,$data['user_id']);
                $list = $model->getSalesLists($this->request->param(),$user_list);
                foreach ($list as $key=>$value){
                    $list[$key]['month_total']  = Db::name('new_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->whereTime('create_time','m')->sum('pay_total');
                    $list[$key]['years_total']  = Db::name('new_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->whereTime('create_time','y')->sum('pay_total');
                    $list[$key]['shop_name']  = Db::name('user')->where('user_id',$value['user_id'])->value('shop_name');
                }
            }else{
                $list = $model->getSalesLists($this->request->param(),$data['user_id']);
                foreach ($list as $key=>$value){
                    $list[$key]['month_total']  = Db::name('new_order')->where('sales',$value['sales'])->where('user_id',$data['user_id'])->whereTime('create_time','m')->sum('pay_total');
                    $list[$key]['years_total']  = Db::name('new_order')->where('sales',$value['sales'])->where('user_id',$data['user_id'])->whereTime('create_time','y')->sum('pay_total');
                    $list[$key]['shop_name']  = Db::name('user')->where('user_id',$value['user_id'])->value('shop_name');
                }
            }
        }
        if ($data['this_user_id']){
            $user_list = Db::name('user')->where('pid',$data['this_user_id'])->column('user_id');
            if($user_list){
                array_push($user_list,$data['this_user_id']);
                $list = $model->getSalesLists($this->request->param(),$user_list);
                foreach ($list as $key=>$value){
                    $list[$key]['month_total']  = Db::name('new_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->whereTime('create_time','m')->sum('pay_total');
                    $list[$key]['years_total']  = Db::name('new_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->whereTime('create_time','y')->sum('pay_total');
                    $list[$key]['shop_name']  = Db::name('user')->where('user_id',$value['user_id'])->value('shop_name');
                }
            }else{
                $list = $model->getSalesLists($this->request->param(),$data['this_user_id']);
                foreach ($list as $key=>$value){
                    $list[$key]['month_total']  = Db::name('new_order')->where('sales',$value['sales'])->where('user_id',$data['this_user_id'])->whereTime('create_time','m')->sum('pay_total');
                    $list[$key]['years_total']  = Db::name('new_order')->where('sales',$value['sales'])->where('user_id',$data['this_user_id'])->whereTime('create_time','y')->sum('pay_total');
                    $list[$key]['shop_name']  = Db::name('user')->where('user_id',$value['user_id'])->value('shop_name');
                }
            }
        }
//        return $list;
        return $this->renderSuccess(['list'=>$list],"查询成功!");
    }


    public function search(){
        $data = $this->request->post();
        $model = new NewOrderModel;
        $list = array();
        if(!$data['token']){
            return $this->renderError('参数错误!');
        }
        $user_token = Db::name('user_token')->where('token',$data['token'])->find();
        if(!$user_token){
            return $this->renderError('请重新登录!');
        }
        if (isset($data['sales']) && !empty($data['sales'])){
            $list = $model->getSalesOrders($this->request->param(),$data['sales']);
            foreach ($list as $key=>$value){
                $list[$key]['month_total']  = Db::name('new_order')->where('sales',$value['sales'])->where('user_id',$user_token['user_id'])->whereTime('create_time','m')->sum('pay_total');
                $list[$key]['years_total']  = Db::name('new_order')->where('sales',$value['sales'])->where('user_id',$user_token['user_id'])->whereTime('create_time','y')->sum('pay_total');
                $list[$key]['shop_name']  = Db::name('user')->where('user_id',$value['user_id'])->value('shop_name');
            }

            return $this->renderSuccess(['list'=>$list],"查询成功!");
        }
        return $this->renderError("请输入售货员！");
    }

}
