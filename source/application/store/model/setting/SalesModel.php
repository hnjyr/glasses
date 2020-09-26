<?php

namespace app\store\model\setting;

use think\Db;
use think\Session;
use app\common\model\BaseModel;
use app\common\model\User as User;


class SalesModel extends BaseModel
{
    protected $name = 'sales';


    /**
     * 获取用户列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getLists($arr = [])
    {
//        $model = new User();
        return Db::name('sales')->where('user_id', 'in',$arr)
            ->where('is_delete',0)
            ->order('type','asc')
            ->paginate(15);

    }
    public function getList($user_id)
    {
//        $model = new User();
        return Db::name('sales')->where('user_id', '=',$user_id)
            ->where('is_delete',0)
            ->order('type','asc')
            ->paginate(15);

    }
    public function getAll()
    {
//        $model = new User();
        return Db::name('sales')
            ->where('is_delete',0)
            ->order('type','asc')
            ->paginate(15);

    }
/*    public function getType()
    {
//        $model = new User();
        return $this->where()

    }*/

    public function getListByType($user_id,$type)
    {
        return Db::name('sales')->where('user_id', '=',$user_id)
            ->where('is_delete',0)
            ->where('type',$type)
            ->paginate(15);

    }

    /**
     * 新增记录
     * @param $data
     * @return bool|false|int
     * @throws \think\exception\DbException
     */
    public function add($data,$user_id)
    {
        if (empty($data['sales_name'])) {
            $this->error = '请输入人员名称';
            return false;
        }
        if (empty($data['mobile'])) {
            $this->error = '请输入店面人员手机号';
            return false;
        }
        $data['user_id'] = $user_id;
        $data['created_time'] = time();
        $this->startTrans();
        try {

            $this->allowField(true)->save($data);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }
    public function edit($data,$user_id)
    {
        if (empty($data['sales_name'])) {
            $this->error = '请输入人员名称';
            return false;
        }
        if (empty($data['mobile'])) {
            $this->error = '请输入店面人员手机号';
            return false;
        }
        $data['user_id'] = $user_id;
        $data['created_time'] = time();
        /*$this->startTrans();
        try {

            $this->allowField(true)->save($data);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }*/
//        dump($data);die();
        $res = Db::name('sales')->where('is_delete',0)->where('sales_id',$data['sales_id'])
            ->update(
                [
                    'sales_name'=>$data['sales_name'],
                    'mobile'=>$data['mobile'],
                    'type'=>$data['type']
                ]
            );
//        dump($res);die();
        if ($res){
            return true;
        }
        return false;
    }

    public function detail($sales_id,$user_id){
        return Db::name('sales')->where('user_id', '=',$user_id)
            ->where('is_delete',0)
            ->where('sales_id',$sales_id)
            ->find();
    }

}
