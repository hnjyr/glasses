<?php

namespace app\store\controller\customer;

use app\store\model\order\index\IndexModel as IndexModel;
use app\store\model\new_order\Glasses as GlassesModel;
use app\store\model\new_order\Contact as ContactModel;
use app\store\model\new_order\Other as OtherModel;
use app\store\controller\Controller;
//use app\store\model\order\index\IndexModel;
use think\Db;
use think\Session;


/**
 * 订单管理
 * Class Order
 * @package app\store\controller
 */
class History extends Controller
{


    /**
     * 全部订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        return $this->getList('历史记录', 'all');
    }
    public function del_order($order_id)
    {
        $model = new IndexModel();
        $res = Db::name('new_order')->where('id',$order_id)->update(['is_delete'=>1]);
        if ($res){
            return $this->renderSuccess('删除成功',url('order.index/all_list'));
        }
    }

    /**
     * 订单详情
     * @param $order_id
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function detail($order_id)
    {
        // 订单详情
        $detail = IndexModel()::detail($order_id);
        return $this->fetch('detail', compact(
            'detail',
            'expressList',
            'express',
            'shopClerkList'
        ));
    }


    public function export()
    {
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $model = new IndexModel();
        if ($admin_info['is_super'] == 1){
            return $model->exportList('all', $this->request->param());
        }else{
            $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
            if(!empty($this_user)){
                array_push($this_user,$admin_info['user_id']);
                return $model->exportLists($this->request->param(),$this_user);
            }else{
                return $model->exportLists($this->request->param(),$admin_info['user_id']);
            }
        }

    }
    public function exports()
    {
        /*$admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();*/
        $model = new IndexModel();
        return $model->exportCheckedLists($this->request->param());


    }





    /**
     * 订单列表
     * @param string $title
     * @param string $dataType
     * @return mixed
     * @throws \think\exception\DbException
     */
    private function getList($title, $dataType)
    {
        // 订单列表
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        if ($admin_info['is_super'] == 1){
            $glassesModel = new GlassesModel;
            $contactModel = new ContactModel;
            $glassesList = $glassesModel->getListss($dataType, $this->request->param());
            $contactList = $contactModel->getListss($dataType, $this->request->param());
            // 自提门店列表
            $this->assign('admin_info',$admin_info);
            return $this->fetch('index', compact('title', 'dataType', 'glassesList', 'contactList'));
        }else{
            $glassesModel = new GlassesModel;
            $contactModel = new ContactModel;

            $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
            if(!empty($this_user)){
                array_push($this_user,$admin_info['user_id']);
                $glassesList = $glassesModel->getListss( $this->request->param(),$this_user);
                $contactList = $contactModel->getListss($this->request->param(),$this_user);
            }else{
                $glassesList = $glassesModel->getListss($this->request->param(),$admin_info['user_id']);
                $contactList = $contactModel->getListss($this->request->param(),$admin_info['user_id']);

            }
            // 自提门店列表
            $this->assign('admin_info',$admin_info);
            return $this->fetch('index', compact('title', 'dataType', 'glassesList', 'contactList'));
        }

    }

    /**
     * 添加订单
     * @return array|mixed
     * @throws \think\exception\PDOException
     */
    public function add()
    {
        if (!$this->request->isAjax()) {
            return $this->fetch(
                'add'
            );
        }
        $admin_info = Session::get('yoshop_store')['user'];
        $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
        $model = new IndexModel();
        $data = $this->postData();
        $data['order_num'] = $model->createOrderNo();
        $data['user_id'] = $user_info['user_id'];
        $data['total'] = ($data['frame_num'] * $data['frame_price']) + ($data['lens_num'] * $data['lens_price']) + ($data['glasses_case_num'] * $data['glasses_case_price']) + ($data['glasses_cloth_num'] * $data['glasses_cloth_price']) + ($data['contact_lens_num'] * $data['contact_lens_price']);
        $data['pay_total'] = $data['total'] - $data['discount'];
        $data['point'] = $data['pay_total'];
        if ($model->add($data)) {
            if(Db::name('new_order_point')->where('mobile',$data['mobile'])->find()){
                Db::name('new_order_point')->where('mobile',$data['mobile'])->setInc('point',$data['point']);
            }else{
                Db::name('new_order_point')->insert([
                    'mobile'=>$data['mobile'],
                    'point'=>$data['point'],
                    'create_time'=>time()
               ]);
            }
            return $this->renderSuccess('添加成功', url('new_order/all_list'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    public function print_order($order_id)
    {
        $list = Db::name('new_order')->where('id',$order_id)->find();
        $addr = Db::name('user')->where('user_id',$list['user_id'])->find();
        if(!$list){
            return $this->renderError('订单不存在');
        }
        $list['addr'] = $addr['address_detail'];
//        include '/view/new_order/list.html';die;
        return $this->fetch('list', compact(
            'list'
        ));

    }

    public function sales_index()
    {
        $model = new IndexModel();
        $admin_info = Session::get('yoshop_store')['user'];
        $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
        if($user_info['is_super'] == 1){
            $list = $model->getSalesList($this->request->param());
            foreach ($list as $key=>$value){
                $list[$key]['month_total']  = Db::name('new_order')->where('sales',$value['sales'])->whereTime('create_time','m')->sum('pay_total');
                $list[$key]['years_total']  = Db::name('new_order')->where('sales',$value['sales'])->whereTime('create_time','y')->sum('pay_total');
                $list[$key]['shop_name']  = Db::name('user')->where('user_id',$value['user_id'])->value('shop_name');
            }
        }else{
            $user_list = Db::name('user')->where('pid',$user_info['user_id'])->column('user_id');
            if($user_list){
                array_push($user_list,$user_info['user_id']);
                $list = $model->getSalesLists($this->request->param(),$user_list);
                foreach ($list as $key=>$value){
                    $list[$key]['month_total']  = Db::name('new_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->whereTime('create_time','m')->sum('pay_total');
                    $list[$key]['years_total']  = Db::name('new_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->whereTime('create_time','y')->sum('pay_total');
                    $list[$key]['shop_name']  = Db::name('user')->where('user_id',$value['user_id'])->value('shop_name');
                }
            }else{
                $list = $model->getSalesLists($this->request->param(),$user_info['user_id']);
                foreach ($list as $key=>$value){
                    $list[$key]['month_total']  = Db::name('new_order')->where('sales',$value['sales'])->where('user_id',$user_info['user_id'])->whereTime('create_time','m')->sum('pay_total');
                    $list[$key]['years_total']  = Db::name('new_order')->where('sales',$value['sales'])->where('user_id',$user_info['user_id'])->whereTime('create_time','y')->sum('pay_total');
                    $list[$key]['shop_name']  = Db::name('user')->where('user_id',$value['user_id'])->value('shop_name');
                }
            }
        }

        return $this->fetch('sales_index', compact(
            'list'
        ));
    }

}


