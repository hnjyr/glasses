<?php

namespace app\store\controller\setting;

use app\store\controller\Controller;
use think\Session;
use think\Db;
use app\store\model\setting\SalesModel as SalesModel;


class Sales extends Controller
{
    /**
     * 用户列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new SalesModel;
        $admin_info = Session::get('yoshop_store')['user'];
        $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
        if ($user_info['is_super'] == 1 ){
            $list = $model->getAll();
        }else{
            $this_user = Db::name('user')->where(['pid'=>$user_info['user_id']])->column('user_id');
            if(!empty($this_user)){
                array_push($this_user,$user_info['user_id']);
                $list = $model->getLists($this_user);
            }else{
                $list = $model->getList($user_info['user_id']);
            }
        }
        return $this->fetch('index', compact('list'));
    }

    /**
     * 添加管理员
     * @return array|mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function add()
    {
        $model = new SalesModel;
        $admin_info = Session::get('yoshop_store')['user'];
        $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
//        dump($this->postData());die();
        // 新增记录
        if ($this->request->isAjax()){
            if ($model->add($this->postData(),$user_info['user_id'])) {
                return $this->renderSuccess('添加成功', url('setting.sales/index'));
            }
        }

        return $this->fetch('add');
    }
    public function edit()
    {
        // 订单详情
        $model = new SalesModel;
        $sales_id = $this->request->param('sales_id');
//        dump($this->request->param('sales_id'));die();

        $admin_info = Session::get('yoshop_store')['user'];
        $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
//        $detail = SalesModel::edit($sales_id,$user_info['user_id']);
        $detail = $model->detail($sales_id,$user_info['user_id']);
        if ($this->request->isAjax()){

            $data = $this->postData();
            if ($model->edit($data,$user_info['user_id'])) {
                return $this->renderSuccess('修改成功', url('setting.sales/index'));
            }
        }

        return $this->fetch('detail',compact('detail'));

    }

    public function del_sales($sales_id)
    {
//        $model = new SalesModel;
        $res = Db::name('sales')->where('sales_id',$sales_id)->update(['delete_time'=>time(),'is_delete'=>1]);
        if ($res){
            return $this->renderSuccess('删除成功',url('setting.sales/index'));
        }

//        return $this->fetch('add');
    }



}
