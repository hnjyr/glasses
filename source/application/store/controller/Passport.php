<?php

namespace app\store\controller;

use app\store\model\store\User as StoreUser;
use think\Session;
use think\Db;
use app\api\model\User as UserModel;
use app\api\controller\salesman\Index as IndexModel;

/**
 * 商户认证
 * Class Passport
 * @package app\store\controller
 */
class Passport extends Controller
{
    /**
     * 商户后台登录
     * @return array|bool|mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login()
    {
        if ($this->request->isAjax()) {
            $model = new StoreUser;
            if ($model->login($this->postData('User'))) {
                return $this->renderSuccess('登录成功', url('index/index'));
            }
            return $this->renderError($model->getError() ?: '登录失败');
        }
        $this->view->engine->layout(false);
        return $this->fetch('login', [
            // 系统版本号
            'version' => get_version(),
            'setting' =>get_setting()
        ]);
    }
    public function register()
    {


        if ($this->request->isAjax()) {

            $model = new UserModel();
            $data = $this->postData();
            
            $data = $data['Register'];
            if ($data['shop_type'] == 0){
                $data['type'] = 2;
                $data['pid'] = 0;
            }
            if ($data['shop_type'] == 1 && $data['type'] == 2){
                $data['pid'] = 0;
            }
        //    dump($data);die();
            $result = Db::name('user')->where('username',$data['username'])->find();
            if($result){
                return  $this->renderError("不能重复申请!");
            }
            $res = $model->add($data);
        //    dump($res);die();
            if($res){
                return $this->renderSuccess("申请成功,等待审核!",url('index/index'));
            }
            return  $this->renderError($res);
        }

        $fatherLsit = Db::name('user')->where(['shop_type'=>1,'type'=>2,'status'=>1])->where('is_delete', '=', '0')->field('shop_name,user_id')->select();;
        $version = get_version();
        $setting = get_setting();

        return $this->fetch('register', compact('fatherLsit','version','setting'));
    }
    public function is_user(){
        $data = $this->request->post();
        if (!$data['linkman'] || !$data['code'] || !$data['phone'] || !$data['password']){
            return $this->renderError("请填写完整信息！");
        }

        $code = Db::name('sms_code')->where('phone',$data['phone'])->order('create_time desc')->find();
        if($code['code'] != $data['code']){
            return $this->renderError("验证码错误!",[]);
        }
        // dump(time() - 60);die;
        if($code['create_time'] < (time() - 60)){
            return $this->renderError("验证码已过期!",[]);
        }
        $result = Db::name('user')->where('username',$data['phone'])->find();
        $result1 = Db::name('user')->where('linkman',$data['linkman'])->find();
        // dump($result);
        // dump($result1);die;
        if($result || $result1){
            return  $this->renderError("不能重复申请!");
        }
        return $this->renderSuccess('验证成功');
    }
    /**
     * 退出登录
     */
    public function logout()
    {
        Session::clear('yoshop_store');
        $this->redirect('passport/login');
    }


}
