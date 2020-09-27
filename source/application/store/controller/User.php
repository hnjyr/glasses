<?php

namespace app\store\controller;

use app\store\model\User as UserModel;
use app\store\model\user\Grade as GradeModel;
use think\Db;
use think\exception\ErrorException;

/**
 * 用户管理
 * Class User
 * @package app\store\controller
 */
class User extends Controller
{
    /**
     * 用户列表
     * @param string $nickName 昵称
     * @param int $gender 性别
     * @param int $grade 会员等级
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new UserModel;
        $list = $model->getList();
        return $this->fetch('index', compact('list'));
    }


    /**
     * 设置账号密码
     */
    public function setAccount()
    {

        $data = $this->request->post();
        if(!$data['id'] || !$data['start_time'] || !$data['end_time']){
            return $this->renderError('参数错误!');
        }
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        $res = $this->addUser($data);
        if($res){
            return $this->renderSuccess('发放成功');
        }
        return $this->renderError('发放失败!');
    }

    /**
     * @param $data
     * @return bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * 添加App用户,关联权限的几个表
     */
    public function addUser($data)
    {
        try{
            DB::startTrans();
            $user_info = Db::name('user')->find($data['id']);
            $store_user_arr['user_name'] = $user_info['linkman'];
            $store_user_arr['mobile'] = $user_info['mobile'];
            $store_user_arr['password'] = yoshop_hash($data['password']);
            $store_user_arr['real_name'] = $user_info['linkman'];
            $store_user_arr['is_super'] = 0;
            $store_user_arr['user_id'] = $user_info['user_id'];
            $store_user_arr['province_id'] = $user_info['province_id'];
            $store_user_arr['city_id'] = $user_info['city_id'];
            $store_user_arr['region_id'] = $user_info['region_id'];
            $store_user_arr['create_time'] = time();
            $store_user_id = Db::name('store_user')->insertGetId($store_user_arr);
            if($store_user_id){
                $arr['store_user_id'] = $store_user_id;
                $arr['role_id'] = 1;
                $arr['create_time'] = time();
                $res = Db('store_user_role')->insert($arr);
                if($res){
                    $result = Db('user')->where(['user_id'=>$user_info['user_id']])->update(['start_time'=>$data['start_time'],'end_time'=>$data['end_time'],'status'=>1]);
                    if($result){
                        Db::commit();
                        return true;
                    }else{
                        return false;
                    }
                }
            }
            return false;
        }catch (\ErrorException $exception) {
            Db::rollback();
            return $this->renderError($exception->getMessage());
        }


    }

    /**
     * @param $user_id
     * @return bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * 删除门店,user表和权限表
     */
    public function deleteUser($user_id)
    {
        try{
            $user_info = Db::name('user')->where('user_id',$user_id)->find();
            if(!$user_info){
                return false;
            }
            Db::startTrans();
            $res = Db::name('store_user')->where('user_id',$user_info['user_id'])->find();
            if($res){
                Db::name('store_user_role')->where('store_user_id',$res['store_user_id'])->delete();
                Db::name('store_user')->where('user_id',$user_info['user_id'])->delete();
                $result =  Db::name('user')->where('user_id',$user_info['user_id'])->delete();
                if($result){
                    Db::commit();
                    return true;
                }
            }
        }catch (\ErrorException $exception){
            Db::rollback();
            return false;
        }
    }


    /**
     * @param $user_id
     * @return array|bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException删除
     */
    public function delete($user_id)
    {
        if(!$user_id){
            return $this->renderError('删除失败!');
        }
        $user_status = Db::name('user')->where('user_id',$user_id)->value('status');
        if($user_status == 1){
            $res = $this->deleteUser($user_id);
        }else{
            $res = Db::name('user')->delete($user_id);
        }
        if($res){
            return  $this->renderSuccess('删除成功!');
        }
            return $this->renderError('删除失败!');
        
    }


    /**
     * 编辑门店
     * @param $shop_id
     * @return array|bool|mixed
     * @throws \think\exception\DbException
     */
    public function edit($user_id)
    {
        // 门店详情
        $model = UserModel::detail($user_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 新增记录
        if ($model->edit($this->postData('user'))) {
            return $this->renderSuccess('更新成功', url('user/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }


    public function agree($user_id)
    {
        $model = UserModel::detail($user_id);
        // dump($model);die;
        if (!$model->setAgree($model['linkman'],$model['username'])) {
            return $this->renderError($model->getError() ?: '审核失败');
        }

        return $this->renderSuccess('审核成功');
    }


    /**
     * @return array|bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException拒绝
     */
    public function disagree()
    {
        $data = $this->request->post();
        if(!$data['text']){
            return $this->renderError('拒绝原因不能为空!');
        }
       $res =  Db('user')->where('user_id',$data['id'])->update(['notes'=>$data['text'],'status'=>2]);
        if (!$res) {
            return $this->renderError('拒绝失败');
        }
        return $this->renderSuccess('拒绝成功');
    }


}
