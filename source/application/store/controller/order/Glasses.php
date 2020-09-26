<?php

namespace app\store\controller\order;

use app\store\model\order\glasses\GlassesModel as GlassesModel;
use app\store\controller\Controller;
use app\store\model\Express as ExpressModel;
//use app\store\model\order\glasses\GlassesModel as GlassesModel;
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
class Glasses extends Controller
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
        $detail = GlassesModel::detail($order_id);
        return $this->fetch('detail', compact(
            'detail',
            'expressList',
            'express',
            'shopClerkList'
        ));
    }
    public function del_order()
    {
        $model = new GlassesModel();
//        dump($this->request->param());die();
        $glasses = $this->request->param();
        $glasses_id = $glasses['glasses_id'];
        $res = Db::name('glasses_order')->where('glasses_id',$glasses_id)->update(['is_delete'=>1]);
        if ($res){
            return $this->renderSuccess('删除成功',url('order.glasses/all_list'));
        }
    }

    public function export()
    {
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $model = new GlassesModel;
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
        $model = new GlassesModel;
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
            $model = new GlassesModel;
            $list = $model->getList($dataType, $this->request->param());
            // 自提门店列表
            $this->assign('admin_info',$admin_info);
            return $this->fetch('index', compact('title', 'dataType', 'list'));
        }else{
            $model = new GlassesModel;
            $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
            if(!empty($this_user)){
                array_push($this_user,$admin_info['user_id']);
                $list = $model->getLists($this->request->param(),$this_user);
            }else{
                $list = $model->getLists($this->request->param(),$admin_info['user_id']);
            }
            // 自提门店列表
            $this->assign('admin_info',$admin_info);
            return $this->fetch('index', compact('title', 'dataType', 'list'));
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
        $model = new GlassesModel;
        $data = $this->postData();
        $data['glasses_no'] = $model->createOrderNo();
        $data['user_id'] = $user_info['user_id'];
        if ($data['frame_num'] == ''){
            $data['frame_num'] = 0;
        }
        if ($data['frame_price'] == ''){
            $data['frame_price'] = 0;
        }
        if ($data['glasses_cloth_num'] == ''){
            $data['glasses_cloth_num'] = 0;
        }
        if ($data['glasses_cloth_price'] == ''){
            $data['glasses_cloth_price'] = 0;
        }
        if ($data['glasses_les_num']== ''){
            $data['glasses_les_num'] = 0;
        }
        if ($data['glasses_les_price'] == ''){
            $data['glasses_les_price'] = 0;
        }
        if ($data['glasses_case_num'] == ''){
            $data['glasses_case_num'] = 0;
        }
        if ($data['glasses_case_price'] == ''){
            $data['glasses_case_price'] = 0;
        }
        if ($data['glasses_other_num'] == ''){
            $data['glasses_other_num'] = 0;
        }
        if ($data['glasses_other_price'] == ''){
            $data['glasses_other_price'] = 0;
        }
        if ($data['discount'] == ''){
            $data['discount'] = 0;
        }
        $data['total'] =
            ($data['frame_num'] * $data['frame_price']) +
            ($data['glasses_cloth_num'] * $data['glasses_cloth_price']) +
            ($data['glasses_les_num'] * $data['glasses_les_price']) +
            ($data['glasses_case_num'] * $data['glasses_case_price']) +
            ($data['glasses_other_num'] * $data['glasses_other_price']);
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
            return $this->renderSuccess('添加成功', url('order.glasses/all_list'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    public function print_order($order_id)
    {
        $list = Db::name('glasses_order')->where('glasses_id',$order_id)->find();
        $addr = Db::name('user')->where('user_id',$list['user_id'])->find();

        if(!$list){
            return $this->renderError('订单不存在');
        }
        $list['addr'] = $addr['address_detail'];
        $list['mobile'] = $addr['mobile'];
//        include '/view/new_order/list.html';die;
        return $this->fetch('list', compact(
            'list'
        ));

    }

    public function sales_index()
    {
        $model = new GlassesModel;
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


