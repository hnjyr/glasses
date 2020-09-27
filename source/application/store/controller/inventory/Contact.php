<?php

namespace app\store\controller\inventory;

use app\store\model\inventory\contact\IndexModel as IndexModel;
use app\store\controller\Controller;
use app\store\model\inventory\contact\specification\IndexModel as SpecIndexModel;
use app\store\model\inventory\contact\model\IndexModel as ModelIndexModel;
use app\store\model\inventory\contact\type\IndexModel as TypeIndexModel;
use app\store\model\inventory\contact\color\IndexModel as ColorIndexModel;
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
class Contact extends Controller
{


    /**
     * 全部订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        return $this->getList('品牌列表', 'all');
    }

    public  function getbrandlist (){
        // 订单列表
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();

        $model = new IndexModel;
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $modelList = $model->getLists($this->request->param(),$admin_info['user_id']);
        // 自提门店列表
        $this->assign('admin_info',$admin_info);


        foreach ($modelList as $key => $value){
            $list[$key]['brand_id'] = $value['brand_id'];
            $list[$key]['brand_name'] = $value['brand_name'];
        }

        return json_encode($list);
    }
    public  function gettypelist (){
        // 订单列表
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();

        $model = new TypeIndexModel;
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $brand = $this->getData();
        $brand_id = $brand['brand_id'];
        $modelList = $model->getLists($brand_id,$admin_info['user_id']);
        // 自提门店列表
        $this->assign('admin_info',$admin_info);


        foreach ($modelList as $key => $value){
            $list[$key]['type_id'] = $value['type_id'];
            $list[$key]['type'] = $value['type'];
        }

        return json_encode($list);
    }
    public  function getmodellist (){
        // 订单列表
        $brand = $this->getData();
        $brand_id = $brand['brand_id'];
        $type = $brand['type_id'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();

        $model = new ModelIndexModel;
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $modelList = $model->getLists($this->request->param(),$admin_info['user_id'],$type,$brand_id);
        // 自提门店列表
        $this->assign('admin_info',$admin_info);


        foreach ($modelList as $key => $value){
            $list[$key]['model_id'] = $value['model_id'];
            $list[$key]['model'] = $value['model'];
        }

        return json_encode($list);
    }
    public function getcolor(){
        // 订单列表
        $brand = $this->getData();
        $brand_id = $brand['brand_id'];
        $type = $brand['type_id'];
        $model_id = $brand['model_id'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();

        $model = new ColorIndexModel;
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $modelList = $model->getLists($this->request->param(),$admin_info['user_id'],$type,$brand_id,$model_id);
        // 自提门店列表
        $this->assign('admin_info',$admin_info);


        foreach ($modelList as $key => $value){
            $list[$key]['color_id'] = $value['color_id'];
            $list[$key]['color'] = $value['color'];
        }

        return json_encode($list);
    }

    public  function getspeclist (){
        // 订单列表
        $brand = $this->getData();
        $brand_id = $brand['brand_id'];
        $type = $brand['type_id'];
        $model_id = $brand['model_id'];
        $color = $brand['color_id'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();

        $model = new SpecIndexModel;
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $modelList = $model->getLists($this->request->param(),$admin_info['user_id'],$type,$brand_id,$model_id,$color);
        // 自提门店列表
        $this->assign('admin_info',$admin_info);


        foreach ($modelList as $key => $value){
            $list[$key]['specification_id'] = $value['specification_id'];
//            $list[$key]['color'] = $value['color'];
            $list[$key]['degree'] = $value['degree'];
            $list[$key]['price'] = $value['price'];
            $list[$key]['standard_inventory'] = $value['standard_inventory'];
            $list[$key]['now_inventory'] = $value['now_inventory'];
            $list[$key]['create_time'] = $value['create_time'];
            $list[$key]['inventory'] = $value['standard_inventory'] - $value['now_inventory'];
        }

        return json_encode($list);
    }

    public function del_brand(){
        $data = $this->postData();
        $brand_id = $data['brand_id'];
        $res = Db::name('contact_brand')->where('brand_id',$brand_id)->update(['is_delete'=>1]);
        if ($res){
            return $this->renderSuccess('删除成功');
        }
        return $this->renderError('删除失败');
    }
    public function del_model(){
        $data = $this->postData();
        $model_id = $data['model_id'];
        $res = Db::name('contact_model')->where('model_id',$model_id)->update(['is_delete'=>1]);
        if ($res){
            return $this->renderSuccess('删除成功');
        }
        return $this->renderError('删除失败');
    }
    public function del_spec(){
        $data = $this->postData();
        $specification_id = $data['specification_id'];
        $res = Db::name('contact_specification')->where('specification_id',$specification_id)->update(['is_delete'=>1]);
        if ($res){
            return $this->renderSuccess('删除成功');
        }
        return $this->renderError('删除失败');
    }

    public function update_brand(){
        $data = $this->postData();
        $brand_id = $data['brand_id'];
        $brand_name = $data['brand_name'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $res = Db::name('contact_brand')
            ->where('brand_id',$brand_id)
            ->where('user_id','in',$admin_info['user_id'])
            ->update(['brand_name'=>$brand_name]);
        if ($res){
            return $this->renderSuccess('修改成功');
        }
        return $this->renderError('修改失败');
    }
    public function update_model(){
        $data = $this->postData();
        $model_id = $data['model_id'];
        $model = $data['model'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $res = Db::name('contact_model')
            ->where('model_id',$model_id)
            ->where('user_id','in',$admin_info['user_id'])
            ->update(['model'=>$model]);

        if ($res){
            return $this->renderSuccess('修改成功');
        }
        return $this->renderError('修改失败');
    }
    public function update_spec(){
        $data = $this->postData();
        $specification_id = $data['specification_id'];
        $price = $data['price'];
        $color = $data['color'];
        $degree = $data['degree'];
        $now_inventory = $data['now_inventory'];
        $update_time = time();
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $res = Db::name('contact_specification')
            ->where('specification_id',$specification_id)
            ->where('user_id','in',$admin_info['user_id'])
            ->update(
                ['price'=>$price],
                ['color'=>$color],
                ['degree'=>$degree],
                ['now_inventory'=>$now_inventory],
                ['update_time'=>$update_time]
            );


        if ($res){
            return $this->renderSuccess('修改成功');
        }
        return $this->renderError('修改失败');
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
            $model = new IndexModel;
            $list = $model->getList($dataType, $this->request->param());
            // 自提门店列表
            $this->assign('admin_info',$admin_info);
            return $this->fetch('index', compact('title', 'dataType', 'list', 'shopList'));
        }else{
            $model = new IndexModel;
            $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
            $list = $model->getLists($this->request->param(),$admin_info['user_id']);
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
        $model = new IndexModel;
        $data = $this->postData();
        $data['user_id'] = $user_info['user_id'];
        $data['brand_name'] = $data['brand'];
        if ($model->add($data)) {
            return $this->renderSuccess('添加成功', url('inventory.contact/index'));
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


