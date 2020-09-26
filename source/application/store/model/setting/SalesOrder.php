<?php

namespace app\store\model\setting;

use think\Db;
use think\Session;
use app\common\model\BaseModel;
use app\common\model\User as User;
use app\store\model\setting\SalesModel as SalesModel;

class SalesOrder extends BaseModel
{
    protected $name = 'sales_order';


    /**
     * 获取用户列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getLists($query = [])
    {
        // 检索查询条件
//        dump($query);
        !empty($query) && $this->setWheres($query);
        // 获取数据列表
        return $this
            ->alias('sales_order')
            ->field('sales_order.*,sales.sales_name')
            ->join('sales', 'sales.sales_id = sales_order.sales_id')
//            ->where('sales_order.sales_id','in',$arr)
            ->where('sales_order.is_delete', '=', 0)
            ->order(['sales_order.create_time' => 'desc'])
            ->paginate(10, false, [
                'query' => \request()->request()
            ]);

    }
    public function getList($dataType,$query = [],$user_id=null)
    {
// 检索查询条件
        !empty($query) && $this->setWheres($query);
        // 获取数据列表
        return $this
            ->alias('sales_order')
            ->field('sales_order.*,sales.sales_name')
            ->join('sales', 'sales.sales_id = sales_order.sales_id')
            ->where($this->transferDataType($dataType))
            ->where('sales_order.is_delete', '=', 0)
            ->order(['sales_order.create_time' => 'desc'])
            ->paginate(10, false, [
                'query' => \request()->request()
            ]);

    }
    public function getAll()
    {
//        $model = new User();
        return Db::name('user')->paginate(15);

    }
    /*    public function getType()
        {
    //        $model = new User();
            return $this->where()

        }*/

    /**
     * 新增记录
     * @param $data
     * @return bool|false|int
     * @throws \think\exception\DbException
     */
   /* public function add($data)
    {
        if (empty($data['sales_name'])) {
            $this->error = '请输入人员名称';
            return false;
        }
        if (empty($data['mobile'])) {
            $this->error = '请输入店面人员手机号';
            return false;
        }
        $data['created_time'] = date("Y-m-d",time());
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
    }*/
    public function add($data)
    {
        $this->startTrans();
        try {
            // 新增管理员记录
            $data['create_time'] = date('Y-m-d',time());
            $data['update_time'] = date('Y-m-d',time());
            $this->allowField(true)->save($data);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }

    /**
     * 更新记录
     * @param array $data
     * @return bool
     * @throws \think\exception\DbException
     */
    /* public function edit($data)
     {
         if ($this['user_name'] !== $data['user_name']
             && self::checkExist($data['user_name'])) {
             $this->error = '用户名已存在';
             return false;
         }
         if (!empty($data['password']) && ($data['password'] !== $data['password_confirm'])) {
             $this->error = '确认密码不正确';
             return false;
         }
         if (empty($data['role_id'])) {
             $this->error = '请选择所属角色';
             return false;
         }
         if (!empty($data['password'])) {
             $data['password'] = yoshop_hash($data['password']);
         } else {
             unset($data['password']);
         }
         $this->startTrans();
         try {
             // 更新管理员记录
             $this->allowField(true)->save($data);
             // 更新角色关系记录
             (new UserRole)->edit($this['store_user_id'], $data['role_id']);
             $this->commit();
             return true;
         } catch (\Exception $e) {
             $this->error = $e->getMessage();
             $this->rollback();
             return false;
         }
     }*/

    /**
     * 软删除
     * @return false|int
     */
    /* public function setDelete()
     {
         if ($this['is_super']) {
             $this->error = '超级管理员不允许删除';
             return false;
         }
         // 删除对应的角色关系
         UserRole::deleteAll(['store_user_id' => $this['store_user_id']]);
         return $this->save(['is_delete' => 1]);
     }*/

    /**
     * 更新当前管理员信息
     * @param $data
     * @return bool
     */
    /*public function renew($data)
    {
        if ($data['password'] !== $data['password_confirm']) {
            $this->error = '确认密码不正确';
            return false;
        }
        if ($this['user_name'] !== $data['user_name']
            && self::checkExist($data['user_name'])) {
            $this->error = '用户名已存在';
            return false;
        }
        // 更新管理员信息
        if ($this->save([
                'user_name' => $data['user_name'],
                'password' => yoshop_hash($data['password']),
            ]) === false) {
            return false;
        }
        // 更新session
        Session::set('yoshop_store.user', [
            'store_user_id' => $this['store_user_id'],
            'user_name' => $data['user_name'],
        ]);
        return true;
    }*/


    public function createOrderNo()
    {
        return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }
    private function setWheres($query)
    {
        if (isset($query['search']) && !empty($query['search'])) {
            $this->where('buy_sales_name', 'like', '%' . trim($query['search']) . '%');
        }

        // 用户id
//        if (isset($query['user_arr']) && !empty($query['user_arr'])) {
//            $this->where('user.user_id', 'in', (int)$query['user_arr']);
//        }
    }
    private function transferDataType($dataType)
    {
        // 数据类型
        $filter = [];
        switch ($dataType) {
            case 'delivery':
                $filter = [
                    'pay_status' => 20,
                    'delivery_status' => 10,
                    'order_status' => ['in', [10, 21]]
                ];
                break;
            case 'receipt':
                $filter = [
                    'pay_status' => 20,
                    'delivery_status' => 20,
                    'receipt_status' => 10
                ];
                break;
            case 'pay':
                $filter = ['pay_status' => 10, 'order_status' => 10];
                break;
            case 'complete':
                $filter = ['order_status' => 30];
                break;
            case 'cancel':
                $filter = ['order_status' => 20];
                break;
            case 'all':
                $filter = [];
                break;
        }
        return $filter;
    }
    public function getSalesList($query)
    {
        !empty($query) && $this->setWheres($query);
        return Db::name('sales_order')
            ->where('is_delete',0)
            ->order('create_time asc')
            ->paginate(10, false, [
                'query' => \request()->request()
            ]);

    }
    public function getSalesLists($query,$arr)
    {
        !empty($query) && $this->setWheres($query);
        return Db::name('sales_order')
            ->where('is_delete',0)
            ->where('user_id','in',$arr)
            ->order('create_time asc')
//            ->group('buy_sales_name')
            ->paginate(10, false, [
                'query' => \request()->request()
            ]);


    }
}