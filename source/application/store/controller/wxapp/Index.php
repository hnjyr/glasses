<?php

namespace app\store\controller\wxapp;

use app\store\controller\Controller;
use app\store\controller\Setting;
use app\store\model\Category as CategoryModel;
use app\store\model\sharing\Category as SharingCategoryModel;
use app\store\model\article\Category as ArticleCategoryModel;
use app\store\model\WxappPage as WxappPageModel;
use app\store\model\WxappCategory as WxappCategoryModel;
use app\common\library\sms\Driver as SmsDriver;
use think\Db;
use app\common\model\Setting as SettingModel;
use think\Session;


/**
 * 小程序页面管理
 * Class Page
 * @package app\store\controller\wxapp
 */
class Index extends Controller
{
    /**
     * 页面列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        return $this->fetch('index');
    }

    public function login()
    {
        $mobile = $this->request->get('mobile');
        $this->assign('mobile',$mobile);
        return $this->fetch('login');

    }

    /**
     * @return array
     * @throws \think\Exception
     * 发送验证码
     */
    public function smscode(){
        $phone = $this->request->post('phone');
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

    public function orderList()
    {
        $data = $this->request->post();
        if($data){
            $code = Db::name('sms_code')->where('phone',$data['mobile'])->order('create_time desc')->value('code');
            if($code != $data['code']){
                return $this->renderError("验证码不正确!",[]);
            }
            Session::set('wxapp_mobile',$data['mobile']);
            return $this->renderSuccess('登录成功');
        }
        return $this->renderError("登录失败,请联系管理员!",[]);
        
    }

    public function userlist()
    {
        $mobile = Session::get('wxapp_mobile');
        if($mobile){
            $list = Db::name('new_order')->where('mobile',$mobile)->select()->each(function ($item,$key){
                $item['shop_name'] = Db::name('user')->where('user_id',$item['user_id'])->value('shop_name');
                $item['goods_count'] = $item['frame_num'] + $item['lens_num'] + $item['glasses_case_num'] + $item['glasses_cloth_num']+ $item['contact_lens_num'];
                return $item;
            });
            if($list){
                $this->assign('list',$list);
                return $this->fetch('user_list');
            }
        }

    }
    
    
    public function indexList($order_id)
    {
        if($order_id){
            $list = Db::name('new_order')->where('id',$order_id)->find();
            if($list){
                $this->assign('list',$list);
                return $this->fetch('index_list');
            }
        }
    }
    



}
