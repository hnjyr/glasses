<?php

namespace app\store\controller\inventory\glasses;

use app\store\model\inventory\glasses\model\IndexModel as IndexModel;
use app\store\controller\Controller;
use think\Db;
use think\Session;


/**
 * 订单管理
 * Class Order
 * @package app\store\controller
 */
class Model extends Controller
{


    /**
     * 全部订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
//        dump($this->request->get('type'));
        $brand_id = $this->request->get('brand_id');
        return $this->getList('型号列表', 'all',$brand_id);
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
        $detail = IndexModel::detail($order_id);
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
        $model = new IndexModel;
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
        $model = new IndexModel;
        return $model->exportCheckedLists($this->request->param());


    }


    public function getmodel()
    {
        $brand_id = $this->request->post('glasses_brand');

        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();

        $model = new IndexModel;
        return $model->getModel($admin_info['user_id'],$brand_id);
    }


    /**
     * 订单列表
     * @param string $title
     * @param string $dataType
     * @return mixed
     * @throws \think\exception\DbException
     */
    private function getList($title, $dataType,$brand_id= null)
    {
        // 订单列表
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();

        $model = new IndexModel;
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        if(!empty($this_user)){
            array_push($this_user,$admin_info['user_id']);
            $list = $model->getLists($this->request->param(),$this_user,$brand_id);
        }else{
            $list = $model->getLists($this->request->param(),$admin_info['user_id'],$brand_id);
        }
            // 自提门店列表
        $this->assign('admin_info',$admin_info);
        return $this->fetch('index', compact('title', 'dataType', 'list', 'shopList'));


    }

    /**
     * 添加订单
     * @return array|mixed
     * @throws \think\exception\PDOException
     */
    public function add()
    {

//        dump($this->postData());die();
        if (!$this->request->isAjax()) {
            return $this->fetch(
                'add'
            );
        }
        $admin_info = Session::get('yoshop_store')['user'];
        $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
        $model = new IndexModel;
        $data = $this->postData();
        $data['user_id'] = $user_info['user_id'];
        $data['brand_id'] = $data['brand_id'];
        $data['model'] = $data['model'];
        if ($model->add($data)) {
            return $this->renderSuccess('添加成功', url('inventory.glasses.model/index&&brand_id='.$data['brand_id']));
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
        $model = new IndexModel;
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


