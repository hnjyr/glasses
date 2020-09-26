<?php

namespace app\store\controller;

use app\store\model\NewOrder as NewOrderModel;
use app\store\model\new_order\Glasses as GlassesModel;
use app\store\model\new_order\Contact as ContactModel;
use app\store\model\new_order\Other as OtherModel;
use app\store\model\Express as ExpressModel;
use app\store\model\Store as StoreModel;
use app\store\model\store\shop\Clerk as ShopClerkModel;
use app\store\model\store\Shop as ShopModel;

use app\api\model\Order as OrderApiModel;
use think\Db;
use think\Session;


/**
 * 订单管理
 * Class Order
 * @package app\store\controller
 */
class Sales extends Controller
{


    /**
     * 全部订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function all_list()
    {
        return $this->getList('全部订单列表', 'all');
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
        $detail = NewOrderModel::detail($order_id);
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
        $model = new NewOrderModel;
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
        $model = new NewOrderModel;
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
            $model = new NewOrderModel;
            $list = $model->getList($dataType, $this->request->param());
            // 自提门店列表
            $this->assign('admin_info',$admin_info);
            return $this->fetch('index', compact('title', 'dataType', 'list', 'shopList'));
        }else{
            $model = new NewOrderModel;
            $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
            if(!empty($this_user)){
                array_push($this_user,$admin_info['user_id']);
                $list = $model->getLists($this->request->param(),$this_user);
            }else{
                $list = $model->getLists($this->request->param(),$admin_info['user_id']);
            }
            // 自提门店列表
            $this->assign('admin_info',$admin_info);
            return $this->fetch('index', compact('title', 'dataType', 'list', 'shopList'));
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
        $model = new NewOrderModel;
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
        $glassesmodel = new GlassesModel;
        $contactmodel = new ContactModel;
//        $arr=array(array());
        $admin_info = Session::get('yoshop_store')['user'];
        $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
        if($user_info['is_super'] == 1){
            $glasseslist = $glassesmodel->getSalesList($this->request->param());
            $contactlist = $contactmodel->getSalesList($this->request->param());
            foreach ($glasseslist as $key=>$value){
                $glasseslist[$key]['glasses_month_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->whereTime('create_time','m')->sum('pay_total');
                $glasseslist[$key]['contact_month_total']  = Db::name('contact_order')->where('sales',$value['sales'])->whereTime('create_time','m')->sum('pay_total');
                $glasseslist[$key]['month_total'] = $glasseslist[$key]['glasses_month_total'] + $glasseslist[$key]['contact_month_total'];

                $glasseslist[$key]['glasses_years_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->whereTime('create_time','y')->sum('pay_total');
                $glasseslist[$key]['contact_years_total']  = Db::name('contact_order')->where('sales',$value['sales'])->whereTime('create_time','y')->sum('pay_total');
                $glasseslist[$key]['years_total']  = $glasseslist[$key]['glasses_years_total'] + $glasseslist[$key]['contact_years_total'];


                $glasseslist[$key]['glasses_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->sum('pay_total');
                $glasseslist[$key]['contact_total']  = Db::name('contact_order')->where('sales',$value['sales'])->sum('pay_total');
                $glasseslist[$key]['total']  = $glasseslist[$key]['glasses_total'] + $glasseslist[$key]['contact_total'];

                $glasseslist[$key]['shop_name']  = Db::name('user')->where('user_id',$value['user_id'])->value('shop_name');
            }

            foreach ($glasseslist as $key=> $value){
                $arr[$value['total']]['user_id']= $value['user_id'];
                $arr[$value['total']]['month_total']= $value['month_total'];
                $arr[$value['total']]['years_total']= $value['years_total'];
                $arr[$value['total']]['shop_name']= $value['shop_name'];
                $arr[$value['total']]['sales']= $value['sales'];
            }
            if (!empty($arr)){
                krsort($arr);
            }
            /*foreach ($contactlist as $key=>$value){
                $contactlist[$key]['glasses_month_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->whereTime('create_time','m')->sum('pay_total');
                $contactlist[$key]['contact_month_total']  = Db::name('contact_order')->where('sales',$value['sales'])->whereTime('create_time','m')->sum('pay_total');
                $contactlist[$key]['month_total'] = $contactlist[$key]['glasses_month_total'] + $contactlist[$key]['contact_month_total'];

                $contactlist[$key]['glasses_years_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->whereTime('create_time','y')->sum('pay_total');
                $contactlist[$key]['contact_years_total']  = Db::name('contact_order')->where('sales',$value['sales'])->whereTime('create_time','y')->sum('pay_total');
                $contactlist[$key]['years_total']  = $contactlist[$key]['glasses_years_total'] + $contactlist[$key]['contact_years_total'];


                $contactlist[$key]['glasses_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->sum('pay_total');
                $contactlist[$key]['contact_total']  = Db::name('contact_order')->where('sales',$value['sales'])->sum('pay_total');
                $contactlist[$key]['total']  = $contactlist[$key]['glasses_total'] + $contactlist[$key]['contact_total'];

                $contactlist[$key]['shop_name']  = Db::name('user')->where('user_id',$value['user_id'])->value('shop_name');
            }

            foreach ($contactlist as $key=> $value){
                $arr1[$value['total']]['user_id']= $value['user_id'];
                $arr1[$value['total']]['month_total']= $value['month_total'];
                $arr1[$value['total']]['years_total']= $value['years_total'];
                $arr1[$value['total']]['shop_name']= $value['shop_name'];
                $arr1[$value['total']]['sales']= $value['sales'];
            }
            if (!empty($arr1)){
                krsort($arr1);
            }*/

//            dump($arr);die();

        }else{
            $user_list = Db::name('user')->where('pid',$user_info['user_id'])->column('user_id');
            if($user_list){
                array_push($user_list,$user_info['user_id']);
                $glasseslist = $glassesmodel->getSalesLists($this->request->param(),$user_list);
                $contactlist = $contactmodel->getSalesLists($this->request->param(),$user_list);
                foreach ($glasseslist as $key=>$value){
                    $glasseslist[$key]['glasses_month_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->whereTime('create_time','m')->sum('pay_total');
                    $glasseslist[$key]['contact_month_total']  = Db::name('contact_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->whereTime('create_time','m')->sum('pay_total');
                    $glasseslist[$key]['month_total']  = $glasseslist[$key]['glasses_month_total'] + $glasseslist[$key]['contact_month_total'];
                    $glasseslist[$key]['glasses_years_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->whereTime('create_time','y')->sum('pay_total');
                    $glasseslist[$key]['contact_years_total']  = Db::name('contact_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->whereTime('create_time','y')->sum('pay_total');
                    $glasseslist[$key]['years_total']  = $glasseslist[$key]['glasses_years_total'] + $glasseslist[$key]['contact_years_total'];
                    $glasseslist[$key]['glasses_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->sum('pay_total');
                    $glasseslist[$key]['contact_total']  = Db::name('contact_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->sum('pay_total');
                    $glasseslist[$key]['total']  = $glasseslist[$key]['glasses_total'] + $glasseslist[$key]['contact_total'];
                    $glasseslist[$key]['shop_name']  = Db::name('user')->where('user_id',$value['user_id'])->value('shop_name');
                }
                foreach ($glasseslist as $key=> $value){
                    $arr[$value['total']]['user_id']= $value['user_id'];
                    $arr[$value['total']]['month_total']= $value['month_total'];
                    $arr[$value['total']]['years_total']= $value['years_total'];
                    $arr[$value['total']]['shop_name']= $value['shop_name'];
                    $arr[$value['total']]['sales']= $value['sales'];
                }
                if (!empty($arr)){
                    krsort($arr);
                }
                /*foreach ($contactlist as $key=>$value){
                    $contactlist[$key]['glasses_month_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->whereTime('create_time','m')->sum('pay_total');
                    $contactlist[$key]['contact_month_total']  = Db::name('contact_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->whereTime('create_time','m')->sum('pay_total');
                    $contactlist[$key]['month_total']  = $contactlist[$key]['glasses_month_total'] + $contactlist[$key]['contact_month_total'];
                    $contactlist[$key]['glasses_years_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->whereTime('create_time','y')->sum('pay_total');
                    $contactlist[$key]['contact_years_total']  = Db::name('contact_order')->where('sales',$value['sales'])->where('user_id','in',$user_list)->whereTime('create_time','y')->sum('pay_total');
                    $contactlist[$key]['years_total']  = $contactlist[$key]['glasses_years_total'] + $contactlist[$key]['contact_years_total'];
                    $contactlist[$key]['glasses_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->sum('pay_total');
                    $contactlist[$key]['contact_total']  = Db::name('contact_order')->where('sales',$value['sales'])->sum('pay_total');
                    $contactlist[$key]['total']  = $contactlist[$key]['glasses_total'] + $contactlist[$key]['contact_total'];
                    $contactlist[$key]['shop_name']  = Db::name('user')->where('user_id',$value['user_id'])->value('shop_name');
                }
                foreach ($contactlist as $key=> $value){
                    $arr1[$value['total']]['user_id']= $value['user_id'];
                    $arr1[$value['total']]['month_total']= $value['month_total'];
                    $arr1[$value['total']]['years_total']= $value['years_total'];
                    $arr1[$value['total']]['shop_name']= $value['shop_name'];
                    $arr1[$value['total']]['sales']= $value['sales'];
                }
                if (!empty($arr1)){
                    krsort($arr1);
                }*/
            }else{
                $glasseslist = $glassesmodel->getSalesLists($this->request->param(),$user_info['user_id']);
                $contactlist = $contactmodel->getSalesLists($this->request->param(),$user_info['user_id']);
                foreach ($glasseslist as $key=>$value){
                    $glasseslist[$key]['glasses_month_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->where('user_id',$user_info['user_id'])->whereTime('create_time','m')->sum('pay_total');
                    $glasseslist[$key]['contact_month_total']  = Db::name('contact_order')->where('sales',$value['sales'])->where('user_id',$user_info['user_id'])->whereTime('create_time','m')->sum('pay_total');
                    $glasseslist[$key]['month_total']  = $glasseslist[$key]['glasses_month_total'] + $glasseslist[$key]['contact_month_total'];
                    $glasseslist[$key]['glasses_years_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->where('user_id',$user_info['user_id'])->whereTime('create_time','y')->sum('pay_total');
                    $glasseslist[$key]['contact_years_total']  = Db::name('contact_order')->where('sales',$value['sales'])->where('user_id',$user_info['user_id'])->whereTime('create_time','y')->sum('pay_total');
                    $glasseslist[$key]['years_total']  = $glasseslist[$key]['glasses_years_total'] + $glasseslist[$key]['contact_years_total'];
                    $glasseslist[$key]['glasses_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->where('user_id',$user_info['user_id'])->sum('pay_total');
                    $glasseslist[$key]['contact_total']  = Db::name('contact_order')->where('sales',$value['sales'])->where('user_id',$user_info['user_id'])->sum('pay_total');
                    $glasseslist[$key]['total']  = $glasseslist[$key]['glasses_total'] + $glasseslist[$key]['contact_total'];
                    $glasseslist[$key]['shop_name']  = Db::name('user')->where('user_id',$value['user_id'])->value('shop_name');
                }
                foreach ($glasseslist as $key=> $value){
                    $arr[$value['total']]['user_id']= $value['user_id'];
                    $arr[$value['total']]['month_total']= $value['month_total'];
                    $arr[$value['total']]['years_total']= $value['years_total'];
                    $arr[$value['total']]['shop_name']= $value['shop_name'];
                    $arr[$value['total']]['sales']= $value['sales'];
                }
                if (!empty($arr)){
                    krsort($arr);
                }
                /*foreach ($contactlist as $key=>$value){
                    $contactlist[$key]['glasses_month_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->where('user_id',$user_info['user_id'])->whereTime('create_time','m')->sum('pay_total');
                    $contactlist[$key]['contact_month_total']  = Db::name('contact_order')->where('sales',$value['sales'])->where('user_id',$user_info['user_id'])->whereTime('create_time','m')->sum('pay_total');
                    $contactlist[$key]['month_total']  = $contactlist[$key]['glasses_month_total'] + $contactlist[$key]['contact_month_total'];
                    $contactlist[$key]['glasses_years_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->where('user_id',$user_info['user_id'])->whereTime('create_time','y')->sum('pay_total');
                    $contactlist[$key]['contact_years_total']  = Db::name('contact_order')->where('sales',$value['sales'])->where('user_id',$user_info['user_id'])->whereTime('create_time','y')->sum('pay_total');
                    $contactlist[$key]['years_total']  = $contactlist[$key]['glasses_years_total'] + $contactlist[$key]['contact_years_total'];
                    $contactlist[$key]['glasses_total']  = Db::name('glasses_order')->where('sales',$value['sales'])->sum('pay_total');
                    $contactlist[$key]['contact_total']  = Db::name('contact_order')->where('sales',$value['sales'])->sum('pay_total');
                    $contactlist[$key]['total']  = $contactlist[$key]['glasses_total'] + $contactlist[$key]['contact_total'];
                    $contactlist[$key]['shop_name']  = Db::name('user')->where('user_id',$value['user_id'])->value('shop_name');
                }
                foreach ($contactlist as $key=> $value){
                    $arr1[$value['total']]['user_id']= $value['user_id'];
                    $arr1[$value['total']]['month_total']= $value['month_total'];
                    $arr1[$value['total']]['years_total']= $value['years_total'];
                    $arr1[$value['total']]['shop_name']= $value['shop_name'];
                    $arr1[$value['total']]['sales']= $value['sales'];
                }
                if (!empty($arr1)){
                    krsort($arr1);
                }*/
            }
        }

        return $this->fetch('sales', compact(
            'glasseslist','arr'
        ));
    }

}


