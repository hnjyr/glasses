<?php

namespace app\store\controller;

use app\store\model\CustomerModel as CustomerModel;
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
 * 客户管理
 * Class Order
 * @package app\store\controller
 */
class Customer extends Controller
{


    /**
     * 全部客户列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        return $this->getList('客户列表', 'all');
    }

    /**
     * 客户详情
     * @param $order_id
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function detail($order_id)
    {
        // 订单详情
        $detail = CustomerModel::detail($order_id);
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
        $model = new CustomerModel();
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
        $model = new CustomerModel();
        return $model->exportCheckedLists($this->request->param());


    }





    /**
     * 客户列表
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
            $model = new CustomerModel();


            $glassesModel = new GlassesModel;
            $contactModel = new ContactModel;
            $otherModel = new OtherModel;
            $glassesList = $glassesModel->getInfoLists($dataType, $this->request->param());
            $contactList = $contactModel->getInfoLists($dataType, $this->request->param());
//            dump($glassesList);die();
            $otherList = $otherModel->getInfoList($dataType, $this->request->param());
            foreach ($glassesList as  $key=>$value){
                $arr[$key]['user_name'] = $value['user_name'];
                $arr[$key]['sex'] = $value['sex'];
                $arr[$key]['years'] = $value['years'];
                $arr[$key]['birthday'] = $value['birthday'];
                $arr[$key]['mobile'] = $value['mobile'];
                $arr[$key]['glasses_total_point'] = $value['glasses_total_point'];
                $arr[$key]['sales'] = $value['sales'];
            }
            $cout = isset($arr)?count($arr):0;

            if ($cout!=0){
                foreach ($contactList as  $key=>$value){
                    $arr[$key+$cout]['user_name'] = $value['user_name'];
                    $arr[$key+$cout]['sex'] = $value['sex'];
                    $arr[$key+$cout]['years'] = $value['years'];
                    $arr[$key+$cout]['birthday'] = $value['birthday'];
                    $arr[$key+$cout]['mobile'] = $value['mobile'];
                    $arr[$key+$cout]['contact_total_point'] = $value['contact_total_point'];
                    $arr[$key+$cout]['sales'] = $value['sales'];
                }

                $new_arr = $arr;

                $tmp_arr = array();
                foreach($new_arr as $k => $v)
                {
                    if(in_array($v['user_name'], $tmp_arr))   //搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
                    {
                        unset($new_arr[$k]); //销毁一个变量  如果$tmp_arr中已存在相同的值就删除该值
                    }
                    else {
                        $tmp_arr[$k] = $v['user_name'];  //将不同的值放在该数组中保存
                    }
                }

            }
            // 自提门店列表
            $this->assign('admin_info',$admin_info);
            return $this->fetch('index', compact('title', 'dataType', 'new_arr', 'contactList','otherList'));


        }else{
            $model = new CustomerModel();
            $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
            if(!empty($this_user)){
                $glassesModel = new GlassesModel;
                $contactModel = new ContactModel;
                $otherModel = new OtherModel;
                array_push($this_user,$admin_info['user_id']);
                $glassesList = $glassesModel->getInfoListss($this->request->param(),$this_user);
                $contactList = $contactModel->getInfoListss($this->request->param(),$this_user);
            }else{
                $glassesModel = new GlassesModel;
                $contactModel = new ContactModel;
                $otherModel = new OtherModel;
                $glassesList = $glassesModel->getInfoListss($this->request->param(),$admin_info['user_id']);
                $contactList = $contactModel->getInfoListss($this->request->param(),$admin_info['user_id']);
            }
//            dump($glassesList);die();
            foreach ($glassesList as  $key=>$value){
                $arr[$key]['user_name'] = $value['user_name'];
                $arr[$key]['sex'] = $value['sex'];
                $arr[$key]['years'] = $value['years'];
                $arr[$key]['birthday'] = $value['birthday'];
                $arr[$key]['mobile'] = $value['mobile'];
                $arr[$key]['glasses_total_point'] = $value['glasses_total_point'];
                $arr[$key]['sales'] = $value['sales'];
            }

            $cout = isset($arr)?count($arr):0;

            if ($cout!=0){
                foreach ($contactList as  $key=>$value){
                    $arr[$key+$cout]['user_name'] = $value['user_name'];
                    $arr[$key+$cout]['sex'] = $value['sex'];
                    $arr[$key+$cout]['years'] = $value['years'];
                    $arr[$key+$cout]['birthday'] = $value['birthday'];
                    $arr[$key+$cout]['mobile'] = $value['mobile'];
                    $arr[$key+$cout]['contact_total_point'] = $value['contact_total_point'];
                    $arr[$key+$cout]['sales'] = $value['sales'];
                }

                $new_arr = $arr;

                $tmp_arr = array();
                foreach($new_arr as $k => $v)
                {
                    if(in_array($v['user_name'], $tmp_arr))   //搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
                    {
                        unset($new_arr[$k]); //销毁一个变量  如果$tmp_arr中已存在相同的值就删除该值
                    }
                    else {
                        $tmp_arr[$k] = $v['user_name'];  //将不同的值放在该数组中保存
                    }
                }

            }

//            $arr = array_unique($arr);




            // 自提门店列表
            $this->assign('admin_info',$admin_info);
            return $this->fetch('index', compact('title', 'dataType', 'new_arr', 'contactList'));
        }

    }


    public function print_order($order_id)
    {
        $list = Db::name('new_order')->where('id',$order_id)->find();
        $addr = Db::name('user')->where('user_id',$list['user_id'])->find();
        if(!$list){
            return $this->renderError('客户不存在');
        }
        $list['addr'] = $addr['address_detail'];
//        include '/view/new_order/list.html';die;
        return $this->fetch('list', compact(
            'list'
        ));

    }

}


