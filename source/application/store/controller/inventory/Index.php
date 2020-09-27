<?php

namespace app\store\controller\inventory;

use app\store\model\inventory\index\IndexModel as IndexModel;
use app\store\model\inventory\index\specification\IndexModel as SpecIndexModel;
use app\store\model\inventory\index\model\IndexModel as ModelIndexModel;
use app\store\model\inventory\index\refractive\IndexModel as RefIndexModel;
use app\store\controller\Controller;
use think\Db;
use think\Session;


/**
 * 订单管理
 * Class Order
 * @package app\store\controller
 */
class Index extends Controller
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
        $brand = $this->getData();
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();

        $model = new IndexModel;
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $modelList = $model->getLists($this->request->param(),$admin_info['user_id']);;
        // 自提门店列表
        $this->assign('admin_info',$admin_info);


        foreach ($modelList as $key => $value){
            $list[$key]['brand_id'] = $value['brand_id'];
            $list[$key]['brand_name'] = $value['brand_name'];
        }

        return json_encode($list);
    }
    public  function getrefracitivelist (){
        // 订单列表
        $brand = $this->getData();
        $brand_id = $brand['brand_id'];
        $type = $brand['type'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();

        $model = new RefIndexModel;
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $modelList = $model->getLists($this->request->param(),$admin_info['user_id'],$type,$brand_id);
        // 自提门店列表
        $this->assign('admin_info',$admin_info);


        foreach ($modelList as $key => $value){
            $list[$key]['refractive_id'] = $value['refractive_id'];
            $list[$key]['refractive_num'] = $value['refractive_num'];
        }

        $newArr = $valArr = array();
        foreach ($list as $key=>$value) {
            $valArr[$key] = $value['refractive_num'];
        }
        asort($valArr);
        reset($valArr);
        foreach($valArr as $key=>$value) {
            $newArr[$key] = $list[$key];
        }



        $keys = implode('', array_keys($newArr));
        if(is_numeric($keys)){
            $newArr = array_values($newArr);
        }



//        dump($newArr);die();


        return json_encode($newArr);
    }
    public  function getmodellist (){
        // 订单列表
        $brand = $this->getData();
        $brand_id = $brand['brand_id'];
        $type = $brand['type'];
        $refractive_id = $brand['refractive_id'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();

        $model = new ModelIndexModel;
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $modelList = $model->getLists($this->request->param(),$admin_info['user_id'],$type,$brand_id,$refractive_id);;
        // 自提门店列表
        $this->assign('admin_info',$admin_info);


        foreach ($modelList as $key => $value){
            $list[$key]['model_id'] = $value['model_id'];
            $list[$key]['model'] = $value['model'];
        }

        return json_encode($list);
    }



    public  function getspeclist (){
        // 订单列表
        $brand = $this->request->param();
        $brand_id = $brand['brand_id'];
        $type = $brand['type'];
        $model_id = $brand['model_id'];
        $refractive_id = $brand['refractive_id'];
//        dump($brand);die();
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();

        $model = new SpecIndexModel;
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $modelList = $model->getLists($this->request->param(),$admin_info['user_id'],$type,$brand_id,$model_id,$refractive_id);
        // 自提门店列表
        $this->assign('admin_info',$admin_info);



            foreach ($modelList as $key => $value){
                $list[$key]['specification_id'] = $value['specification_id'];
                $list[$key]['spherical_lens'] = $value['spherical_lens'];
                $list[$key]['cytdnder'] = $value['cytdnder'];
                $list[$key]['price'] = $value['price'];
                $list[$key]['standard_inventory'] = $value['standard_inventory'];
                $list[$key]['now_inventory'] = $value['now_inventory'];
                $list[$key]['create_time'] = $value['create_time'];
                $list[$key]['inventory'] = $value['standard_inventory'] - $value['now_inventory'];
            }


//            dump($list);die();
        return json_encode($list);
    }


    public  function channelDb ($db_type) {
        if ($db_type == 0){
            $db = 'brand';
        }else if($db_type == 1){
            $db = 'other_brand';
        }else if($db_type == 2){
            $db = 'glasses_brand';
        }else if ($db_type == 3){
            $db = 'contact_brand';
        }
        return $db;
    }
    public  function cDb ($db_type) {
        if ($db_type == 0){
            $db = 'model';
        }else if($db_type == 1){
            $db = 'other_model';
        }else if($db_type == 2){
            $db = 'glasses_model';
        }else if ($db_type == 3){
            $db = 'contact_model';
        }
        return $db;
    }
    public function del_brand(){
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $data = $this->request->param();
        $brand_id = $data['brand_id'];
        $db_type = $data['dbtype'];
//        dump($data);die();
        $db_name = $this->channelDb($db_type);
        $res = Db::name(''.$db_name.'')
            ->where('brand_id',$brand_id)
            ->where('user_id','in',$admin_info['user_id'])
            ->update(['is_delete'=>1]);


        if ($res){

            return json_encode($this->renderSuccess('删除成功'));
        }
        return json_encode($this->renderError('删除失败'));
    }
    public function del_type(){
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $data = $this->request->param();
        $type_id = $data['type_id'];

        $res = Db::name('contact_type')
            ->where('type_id',$type_id)
            ->where('user_id','in',$admin_info['user_id'])
            ->update(['is_delete'=>1]);


        if ($res){

            return json_encode($this->renderSuccess('删除成功'));
        }
        return json_encode($this->renderError('删除失败'));
    }
    public function del_model(){
        $data = $this->postData();
        $model_id = $data['model_id'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $db_type = $data['dbtype'];
        $db_name = $this->cDb($db_type);
        $res = Db::name(''.$db_name.'')
            ->where('model_id',$model_id)
            ->where('user_id','in',$admin_info['user_id'])
            ->update(['is_delete'=>1]);
        if ($res){

            return json_encode($this->renderSuccess('删除成功'));
        }
        return json_encode($this->renderError('删除失败'));
    }
    public function del_refracitive(){
        $data = $this->postData();
        $refracitive_id = $data['refractive_id'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $db_type = $data['dbtype'];
        $db_name = $this->channelDb($db_type);
        $res = Db::name('refractive')->where('refractive_id',$refracitive_id)
            ->where('user_id','in',$admin_info['user_id'])
            ->update(['is_delete'=>1]);
        if ($res){

            return json_encode($this->renderSuccess('删除成功'));
        }
        return json_encode($this->renderError('删除失败'));
    }
    public function del_color(){
        $data = $this->postData();
        $color_id = $data['color_id'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $db_type = $data['dbtype'];
        $db_name = $this->channelDb($db_type);
        $res = Db::name('color')->where('color_id',$color_id)
            ->where('user_id','in',$admin_info['user_id'])
            ->update(['is_delete'=>1]);
        if ($res){

            return json_encode($this->renderSuccess('删除成功'));
        }
        return json_encode($this->renderError('删除失败'));
    }
    public function del_spec(){
        $data = $this->postData();
        $specification_id = $data['specification_id'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $dbtype = $data['dbtype'];
        if ($dbtype == 0){
            $res =Db::name('specification')->where('specification_id',$specification_id)
                ->where('user_id','in',$admin_info['user_id'])
                ->update(['is_delete'=>1]);
        } elseif ($dbtype == 1){
            $res =Db::name('other_specification')->where('specification_id',$specification_id)
                ->where('user_id','in',$admin_info['user_id'])
                ->update(['is_delete'=>1]);
        }elseif ($dbtype == 2) {
            $res =Db::name('glasses_specification')->where('specification_id',$specification_id)
                ->where('user_id','in',$admin_info['user_id'])
                ->update(['is_delete'=>1]);
        }elseif ($dbtype == 3){
            $res =Db::name('contact_specification')->where('specification_id',$specification_id)
                ->where('user_id','in',$admin_info['user_id'])
                ->update(['is_delete'=>1]);
        }


        if ($res){

            return json_encode($this->renderSuccess('删除成功'));
        }
        return json_encode($this->renderError('删除失败'));
    }

    public function update_brand(){
        $date = $this->postData();
        $brand_id = $date['brand_id'];
        $brand_name = $date['brand_name'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $db_type = $date['dbtype'];
        $db_name = $this->channelDb($db_type);
        $res = Db::name(''.$db_name.'')
            ->where('brand_id',$brand_id)
            ->where('user_id','in',$admin_info['user_id'])
            ->update(['brand_name'=>$brand_name]);
        if ($res){

            return json_encode($this->renderSuccess('修改成功'));
        }
        return json_encode($this->renderError('修改失败'));
    }
    public function update_type(){
        $date = $this->postData();
        $type_id = $date['type_id'];
        $type = $date['type'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $res = Db::name('contact_type')
            ->where('type_id',$type_id)
            ->where('user_id','in',$admin_info['user_id'])
            ->update(['type'=>$type]);
        if ($res){

            return json_encode($this->renderSuccess('修改成功'));
        }
        return json_encode($this->renderError('修改失败'));
    }
    public function update_model(){
        $date = $this->postData();
        $model_id = $date['model_id'];
        $model = $date['model'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $db_type = $date['dbtype'];
        $db_name = $this->cDb($db_type);
        $res = Db::name(''.$db_name.'')
            ->where('model_id',$model_id)
            ->where('user_id','in',$admin_info['user_id'])
            ->update(['model'=>$model]);

        if ($res){

            return json_encode($this->renderSuccess('修改成功'));
        }
        return json_encode($this->renderError('修改失败'));
    }
    public function update_refracitive(){
        $date = $this->postData();
        $refracitive_id = $date['refractive_id'];
        $refractive_num = $date['refractive_num'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $res = Db::name('refractive')
            ->where('refractive_id',$refracitive_id)
            ->where('user_id','in',$admin_info['user_id'])
            ->update(['refractive_num'=>$refractive_num]);
        if ($res){

            return json_encode($this->renderSuccess('修改成功'));
        }
        return json_encode($this->renderError('修改失败'));
    }
    public function update_colorspec(){
        $data = $this->postData();
        $color_id = $data['color_id'];
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $color = $data['color'];
        $res = Db::name('contact_color')
            ->where('color_id',$color_id)
            ->where('user_id','in',$admin_info['user_id'])
            ->update(
                [
                    'color'=>$color
                ]
            );
        if ($res){
            return json_encode($this->renderSuccess('修改成功'));
        }
        return json_encode($this->renderError('修改失败'));
    }
    public function update_spec(){
        $data = $this->postData();
        $specification_id = $data['specification_id'];
        $dbtype = $data['dbtype'];
        
        $price = $data['price'];
        $now_inventory = $data['now_inventory'];
        $update_time = time();
        $admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        
        if ($dbtype == 0){
            $spherical_lens = $data['spherical_lens'];
            $cytdnder = $data['cytdnder'];
            $res = Db::name('specification')
                ->where('specification_id',$specification_id)
                ->where('user_id','in',$admin_info['user_id'])
                ->update(
                    [
                        'spherical_lens'=>$spherical_lens,
                        'cytdnder'=>$cytdnder,
                        'price'=>$price,
                        'standard_inventory'=>$now_inventory,
                        'now_inventory'=>$now_inventory,
                        'update_time'=>$update_time
                    ]
                );
        } elseif ($dbtype == 1){
            $res = Db::name('other_specification')
                ->where('specification_id',$specification_id)
                ->where('user_id','in',$admin_info['user_id'])
                ->update(
                    [
                        'price'=>$price,
                        'standard_inventory'=>$now_inventory,
                        'now_inventory'=>$now_inventory,
                        'update_time'=>$update_time
                    ]
                );
        }elseif ($dbtype == 2) {
                $color = $data['color'];
            $res = Db::name('glasses_specification')
                ->where('specification_id', $specification_id)
                ->where('user_id', 'in', $admin_info['user_id'])
                ->update(
                    [
                        'color' => $color,
                        'price' => $price,
                        'standard_inventory'=>$now_inventory,
                        'now_inventory' => $now_inventory,
                        'update_time' => $update_time
                    ]
                );
            }elseif ($dbtype == 3){
                $degree = $data['degree'];
                $res = Db::name('contact_specification')
                    ->where('specification_id',$specification_id)
                    ->where('user_id','in',$admin_info['user_id'])
                    ->update(
                        [
                            'price'=>$price,
                            'degree'=>$degree,
                            'standard_inventory'=>$now_inventory,
                            'now_inventory'=>$now_inventory,
                            'update_time'=>$update_time
                        ]
                    );
        }


        if ($res){

            return json_encode($this->renderSuccess('修改成功'));
        }
        return json_encode($this->renderError('修改失败'));
    }


    public function add_brand()
    {
        $admin_info = Session::get('yoshop_store')['user'];
        $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
        $date = $this->postData();
        $data['user_id'] = $user_info['user_id'];
        $data['brand_name'] = $date['brand'];



        $data['create_time'] = time();
        $db_type = $date['dbtype'];
        $db_name = $this->channelDb($db_type);

        $res = Db::name(''.$db_name.'')
            ->insert($data);
        $new_brand_id = Db::name(''.$db_name.'')
            ->where('user_id',$user_info['user_id'])
            ->where('brand_name',$date['brand'])
            ->order('create_time','desc')->find();
        $new_brand_id = $new_brand_id['brand_id'];
        if ($res){
            return json_encode($this->renderSuccess('添加成功',[],['brand_id'=>$new_brand_id]));
        }
        return json_encode($this->renderError('添加失败'));
    }
    public function add_refracitive()
    {
        $admin_info = Session::get('yoshop_store')['user'];
        $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
        $date = $this->postData();
        $data['user_id'] = $user_info['user_id'];
        $data['brand_id'] = $date['brand_id'];
        $data['type']= $date['type'];
        $data['refractive_num'] = $date['refractive_num'];
        $data['create_time'] = time();

        $res = Db::name('refractive')
            ->insert($data);
        $new_brand_id = Db::name('refractive')
            ->where('refractive_num',$date['refractive_num'])
            ->where('user_id',$user_info['user_id'])
            ->where('brand_id',$date['brand_id'])
            ->where('type',$date['type'])
            ->order('create_time','desc')->find();
        $new_brand_id = $new_brand_id['refractive_id'];
        if ($res){

            return json_encode($this->renderSuccess('添加成功',[],['refractive_id'=>$new_brand_id]));
        }
        return json_encode($this->renderError('添加失败'));
    }
    public function add_type()
    {
        $admin_info = Session::get('yoshop_store')['user'];
        $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
        $date = $this->postData();
        $data['user_id'] = $user_info['user_id'];
        $data['brand_id'] = $date['brand_id'];
        $data['type']= $date['type'];
        $data['create_time'] = time();

        $res = Db::name('contact_type')
            ->insert($data);
        $new_brand_id = Db::name('contact_type')
            ->where('type',$date['type'])
            ->where('user_id',$user_info['user_id'])
            ->where('brand_id',$date['brand_id'])
            ->order('create_time','desc')->find();
        $new_brand_id = $new_brand_id['type_id'];
        if ($res){

            return json_encode($this->renderSuccess('添加成功',[],['type_id'=>$new_brand_id]));
        }
        return json_encode($this->renderError('添加失败'));
    }
    public function add_model()
    {
        $admin_info = Session::get('yoshop_store')['user'];
        $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
        $date = $this->postData();
        $data['user_id'] = $user_info['user_id'];
        $data['brand_id'] = $date['brand_id'];
        $data['create_time'] = time();
        $data['model'] = $date['model'];
        $dbtype = $date['dbtype'];

        if ($dbtype == 0 ){
            $data['refractive_id'] = $date['refractive_id'];
            $data['type'] = $date['type'];

            $res = Db::name('model')
                ->insert($data);
            $new_brand_id = Db::name('model')
                ->where('model',$date['model'])
                ->where('user_id',$user_info['user_id'])
                ->where('brand_id',$date['brand_id'])
                ->where('refractive_id',$date['refractive_id'])
                ->where('type',$date['type'])
                ->order('create_time','desc')->find();
            $new_brand_id = $new_brand_id['model_id'];
        }elseif ($dbtype == 3){
            $data['type_id'] = $date['type_id'];

            $res = Db::name('contact_model')
                ->insert($data);
            $new_brand_id = Db::name('contact_model')
                ->where('model',$date['model'])
                ->where('user_id',$user_info['user_id'])
                ->where('brand_id',$date['brand_id'])
                ->where('type_id',$date['type_id'])
                ->order('create_time','desc')->find();
            $new_brand_id = $new_brand_id['model_id'];
        }else{

            $db_type = $date['dbtype'];

            $db_name = $this->cDb($db_type);

            $res = Db::name(''.$db_name.'')
                ->insert($data);
            $new_brand_id = Db::name(''.$db_name.'')
                ->where('model',$date['model'])
                ->where('user_id',$user_info['user_id'])
                ->where('brand_id',$date['brand_id'])
                ->order('create_time','desc')->find();
            $new_brand_id = $new_brand_id['model_id'];
        }
        if ($res){

            return json_encode($this->renderSuccess('添加成功',[],['model_id'=>$new_brand_id]));
        }
        return json_encode($this->renderError('添加失败'));
    }
    public function add_colorspec()
    {
        $admin_info = Session::get('yoshop_store')['user'];
        $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
        $date = $this->postData();
        $data['user_id'] = $user_info['user_id'];
        $data['brand_id'] = $date['brand_id'];
        $data['model_id'] = $date['model_id'];
        $data['create_time'] = time();
        $data['type_id'] = $date['type_id'];
        $data['color'] = $date['color'];
        $res = Db::name('contact_color')
            ->insert($data);
        $new_brand_id = Db::name('contact_color')
            ->where('user_id',$user_info['user_id'])
            ->where('brand_id',$date['brand_id'])
            ->where('model_id',$date['model_id'])
            ->where('type_id',$date['type_id'])
            ->where('color',$date['color'])
            ->order('create_time','desc')->find();

        $new_brand_id = $new_brand_id['color_id'];

        if ($res){

            return json_encode($this->renderSuccess('添加成功',[],['color_id'=>$new_brand_id]));
        }
        return json_encode($this->renderError('添加失败'));
    }
    public function add_spec()
    {
        $admin_info = Session::get('yoshop_store')['user'];
        $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
        $date = $this->postData();
        $data['user_id'] = $user_info['user_id'];
        $data['brand_id'] = $date['brand_id'];
        $data['model_id'] = $date['model_id'];
        $data['price'] = $date['price'];
        $data['standard_inventory'] = $date['now_inventory'];
        $data['now_inventory'] = $date['now_inventory'];
        $data['total_price'] = 0;
        $data['create_time'] = time();
        $dbtype = $date['dbtype'];
        if ($dbtype == 0){
            $data['type'] = $date['type'];
            $data['refractive_id'] = $date['refractive_id'];
            $data['spherical_lens'] = $date['spherical_lens'];
            $data['cytdnder'] = $date['cytdnder'];

            $res = Db::name('specification')
                ->insert($data);
            $new_brand_id = Db::name('specification')
                ->where('refractive_id',$date['refractive_id'])
                ->where('spherical_lens',$date['spherical_lens'])
                ->where('cytdnder',$date['cytdnder'])
                ->where('user_id',$user_info['user_id'])
                ->where('brand_id',$date['brand_id'])
                ->where('type',$date['type'])
                ->where('model_id',$date['model_id'])
                ->order('create_time','desc')->find();
            $new_brand_id = $new_brand_id['specification_id'];
        } elseif ($dbtype == 1){

            $res = Db::name('other_specification')
                ->insert($data);
            $new_brand_id = Db::name('other_specification')
                ->where('user_id',$user_info['user_id'])
                ->where('brand_id',$date['brand_id'])
                ->where('model_id',$date['model_id'])
                ->order('create_time','desc')->find();
            $new_brand_id = $new_brand_id['specification_id'];
        }elseif ($dbtype == 2) {
            $data['color'] = $date['color'];
            $res = Db::name('glasses_specification')
                ->insert($data);
            $new_brand_id = Db::name('glasses_specification')
                ->where('user_id',$user_info['user_id'])
                ->where('brand_id',$date['brand_id'])
                ->where('model_id',$date['model_id'])
                ->where('color',$date['color'])
                ->order('create_time','desc')->find();

            $new_brand_id = $new_brand_id['specification_id'];
        }elseif ($dbtype == 3){
            $data['type_id'] = $date['type_id'];
            $data['degree'] = $date['degree'];
            $data['color_id'] = $date['color_id'];
            $res = Db::name('contact_specification')
                ->insert($data);
            $new_brand_id = Db::name('contact_specification')
                ->where('user_id',$user_info['user_id'])
                ->where('brand_id',$date['brand_id'])
                ->where('type_id',$date['type_id'])
                ->where('model_id',$date['model_id'])
                ->where('color_id',$date['color_id'])
                ->where('degree',$date['degree'])
                ->order('create_time','desc')->find();
            $new_brand_id = $new_brand_id['specification_id'];

        }
        if ($res){

            return json_encode($this->renderSuccess('添加成功',[],['specification_id'=>$new_brand_id]));
        }
        return json_encode($this->renderError('添加失败'));
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

        $model = new IndexModel;
        $this_user = Db::name('user')->where(['pid'=>$admin_info['user_id']])->column('user_id');
        $list = $model->getLists($this->request->param(),$admin_info['user_id']);
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
            return $this->renderSuccess('添加成功', url('inventory.index/index'));
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


