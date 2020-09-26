<?php

namespace app\api\controller;

use app\api\model\User as UserModel;
use app\common\model\Setting as SettingModel;
use app\common\library\sms\Driver as SmsDriver;
use think\Db;

/**
 * 用户管理
 * Class User
 * @package app\api
 */
class User extends Controller
{
    /**
     * 用户自动登录
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function tokenlogin()
    {
        $model = new UserModel;
        return $this->renderSuccess([
            'user_id' => $model->tokenlogin($this->request->post()),
            'token' => $model->getToken()
        ]);
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException  查询是否开户
     */
    public function isOpen()
    {
        $data = $this->request->post();
        $res = Db::name('user')->where(['username'=>$data['phone'],'status'=>1])->find();
        if($res){
            return $this->renderSuccess([],'查询成功');
        }
        return $this->renderError([],'查询失败');

    }

    public function login()
    {
        $model = new UserModel;
        return $this->renderSuccess([
            'user_id' => $model->login2($this->request->post()),
            'token' => $model->getToken()
        ]);
    }
    public function register()
    {
        $model = new UserModel;
        return $this->renderSuccess([
            'user_id' => $model->register2($this->request->post()),
            'token' => $model->getToken()
        ]);
    }

    public function smscode(){
        $phone = $this->request->post('phone');
        $userinfo =  model('user')->where('username',$phone)->where('status',1)->find();
        if(!$userinfo){
            return $this->renderError('用户不存在');
        }
        $smsConfig = SettingModel::getItem('sms', '10001');
        $SmsDriver = new SmsDriver($smsConfig);
        $code = rand(1000,9999);
        $op['phone'] = $phone;
        $op['code'] = $code;
        $op['create_time'] = time();
        Db::name('sms_code')->insert($op);
        $info = $SmsDriver->sendSmscode('register', ['code' => $code],true,$phone);
        if($info){
            return $this->renderSuccess('发送成功');
        }else{
            return $this->renderError('发送失败');
        }

    }
    // 地址库
    public function address(){
        $list = model('region')->field('id as code,pid,name')->select()->toarray();
        $data = $this->generateTree($list);
        return $this->renderSuccess([
            'list' =>$data,
        ]);
    }
     // 地址库
     public function userEdit(){
        $nickName = $this->request->post('nickName');
        $avatarUrl = $this->request->post('avatarUrl');
        $birthday = $this->request->post('birthday');
        $op = [];
        if($nickName){
            $op['nickName'] = $nickName;
        }
        if($avatarUrl){
            $op['avatarUrl'] = $avatarUrl;
        }
        if($birthday){
            $op['birthday'] = $birthday;
        }
        if(empty($op)){
            return $this->renderError('未传入任何参数');
        }
        $user = $this->getUser(false);
        model('user')->where('user_id',$user['user_id'])->update($op);
        return $this->renderSuccess('修改成功');

    }

    
    public function generateTree($data){
    $items = array();
    foreach($data as $v){
        $items[$v['code']] = $v;
    }
    $tree = array();
    foreach($items as $k => $item){

        if(isset($items[$item['pid']])){
            $items[$item['pid']]['childs'][] = &$items[$k];
        }else{
            $tree[] = &$items[$k];
        }
    }
    return $tree;
}

    /**
     * 当前用户详情
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function detail()
    {
        // 当前用户信息
        $userInfo = $this->getUser();
        return $this->renderSuccess(compact('userInfo'));
    }

}
