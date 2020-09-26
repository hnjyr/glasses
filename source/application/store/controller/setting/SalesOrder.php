<?php

namespace app\store\controller\setting;

use app\store\model\NewOrder as NewOrderModel;
use app\store\controller\Controller;
use app\store\model\setting\SalesOrder as SalesOrderModel;
use app\store\model\setting\SalesModel as SalesModel;
use think\Db;
use think\Session;


/**
 * 订单管理
 * Class Order
 * @package app\store\controller
 */
class SalesOrder extends Controller
{


    /**
     * 全部订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        return $this->getList('日常消费列表', 'all');
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
        $model = new SalesOrderModel;

        $admin_info = Session::get('yoshop_store')['user'];
        $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
        if($user_info['is_super'] == 1){
            $list = $model->getSalesList($this->request->param());
            for ($i = 0 ;$i< count($list); $i++){
                for ($j = 0 ; $j < count($list[$i]) ; $j ++){
                    $data[$i]= $list[$i];
                }


            }
            foreach ($data as $key=>$value){
                $data[$key]['month_total']  = Db::name('sales_order')
                    ->join('sales','sales.sales_id = yoshop_sales_order.sales_id')
                    ->where('sales.user_id',$list[$key]['user_id'])
                    ->where('buy_sales_name',$list[$key]['sales_name'])
                    ->whereTime('create_time','m')->sum('price');
                $data[$key]['years_total']  = Db::name('sales_order')
                    ->join('sales','sales.sales_id = yoshop_sales_order.sales_id')
                    ->where('sales.user_id',$list[$key]['user_id'])
                    ->where('buy_sales_name',$list[$key]['sales_name'])->whereTime('create_time','y')->sum('price');
                $data[$key]['total']  = Db::name('sales_order')
                    ->join('sales','sales.sales_id = yoshop_sales_order.sales_id')
                    ->where('sales.user_id',$list[$key]['user_id'])
                    ->where('buy_sales_name',$list[$key]['sales_name'])->sum('price');
                $data[$key]['shop_name']  = Db::name('user')->where('user_id',$list[$key]['user_id'])->value('shop_name');
                $data[$key]['sales_order']  = Db::name('sales_order')
                    ->join('sales','sales.sales_id = yoshop_sales_order.sales_id')
                    ->where('sales.user_id',$list[$key]['user_id'])
                    ->paginate(15);

            }
//            dump($data);die();


        }else{
            $user_list = Db::name('user')->where('pid',$user_info['user_id'])->column('user_id');
            if($user_list){
                array_push($user_list,$user_info['user_id']);
                $list = $model->getSalesLists($this->request->param(),$user_list);
                for ($i = 0 ;$i< count($list); $i++){
                    for ($j = 0 ; $j < count($list[$i]) ; $j ++){
                        $data[$i]= $list[$i];
                    }


                }
                foreach ($data as $key=>$value){
                    $data[$key]['month_total']  = Db::name('sales_order')
                        ->join('sales','sales.sales_id = yoshop_sales_order.sales_id')->where('sales.user_id','in',$user_list)
                        ->where('buy_sales_name',$list[$key]['sales_name'])->whereTime('create_time','m')->sum('price');
                    $data[$key]['years_total']  = Db::name('sales_order')
                        ->join('sales','sales.sales_id = yoshop_sales_order.sales_id')->where('sales.user_id','in',$user_list)
                        ->where('buy_sales_name',$list[$key]['sales_name'])->whereTime('create_time','y')->sum('price');
                    $data[$key]['total']  = Db::name('sales_order')
                        ->join('sales','sales.sales_id = yoshop_sales_order.sales_id')->where('sales.user_id','in',$user_list)
                        ->where('buy_sales_name',$list[$key]['sales_name'])->sum('price');
                    $data[$key]['shop_name']  = Db::name('user')
                        ->where('user_id',$list[$key]['user_id'])->value('shop_name');
                    $data[$key]['sales_order']  = Db::name('sales_order')
                        ->join('sales','sales.sales_id = yoshop_sales_order.sales_id')
                        ->where('sales.user_id',$list[$key]['user_id'])
                        ->paginate(15);
                }


            }else{
                $list = $model->getSalesLists($this->request->param(),$user_info['user_id']);
                for ($i = 0 ;$i< count($list); $i++){
                    for ($j = 0 ; $j < count($list[$i]) ; $j ++){
                        $data[$i]= $list[$i];
                    }
                    foreach ($data as $key=>$value){
                        $data[$key]['total']  = Db::name('sales_order')->where('yoshop_sales_order.user_id',$user_info['user_id'])->where('buy_sales_name',$data[$key]['buy_sales_name'])->sum('price');
                        $data[$key]['shop_name']  = Db::name('user')->where('user_id',$user_info['user_id'])->value('shop_name');
                        $data[$key]['sales_order']  = Db::name('sales_order')->join('sales','sales.sales_id = yoshop_sales_order.sales_id')->where('sales.user_id',$user_info['user_id'])->paginate(15);
                        $data[$key]['zjtotal'] = Db::name('sales_order')->where('yoshop_sales_order.user_id',$user_info['user_id'])->sum('price');
                    }


                }

//                dump($data);die();
            }
        }
        return $this->fetch('index', compact('title', 'dataType', 'list', 'data'));

    }

    /**
     * 添加订单
     * @return array|mixed
     * @throws \think\exception\PDOException
     */
    public function add()
    {
        if (!$this->request->isAjax()) {
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
            return $this->fetch(
                'add',compact('list')
            );
        }
        $data = $this->postData();

        $admin_info = Session::get('yoshop_store')['user'];
        $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
        $sale_info = Db::name('sales')->where('sales_name',$data['buy_sales_name'])->find();
        $model = new SalesOrderModel;
        $data['sales_num'] = $model->createOrderNo();
        $data['sales_id'] = $sale_info['sales_id'];
        $data['user_id'] = $user_info['user_id'];
        $data['price'] = $data['price'];
        $data['buy_sales_name'] = $data['buy_sales_name'];
        $data['buy_name'] = $data['buy_name'];
//        $model->add($data);
        if ($model->add($data)){
            return $this->renderSuccess('添加成功', url('setting.sales_order/index'));
        }
        /*if ($model->add($data)) {
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
        }*///添加积分
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
        $model = new SalesOrderModel;
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


