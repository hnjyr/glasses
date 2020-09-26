<?php

namespace app\api\controller;

use app\api\model\Goods as GoodsModel;
use app\api\model\Cart as CartModel;
use app\common\service\qrcode\Goods as GoodsPoster;

use think\Db;

/**
 * 商品控制器
 * Class Goods
 * @package app\api\controller
 */
class Goods extends Controller
{
    /**
     * 商品列表
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        // 整理请求的参数
        $user = $this->getUser(false);

        $type = 1;
        $op['status'] =  10;

       if(in_array($type,[1,2] )){
           $op['goods_type'] =  $type;
       }

        $param = array_merge($this->request->param(), $op);
        // 获取列表数据
        $model = new GoodsModel;
        $list = $model->getList($param, $this->getUser(false));
        return $this->renderSuccess(compact('list'));
    }

    /**
     * 商品列表
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function sharelst()
    {
        // 整理请求的参数
        $op['status'] =  10;
        $op['share'] =  1;
        $param = array_merge($this->request->param(), $op);
        $model = new GoodsModel;
        $goodsList = $model->getList($param, $this->getUser(false));

        $data = [];
        foreach ($goodsList as $goods) {
                $data[] = [
                    'goods_name' => $goods['goods_name'],
                    'selling_point' => $goods['selling_point'],
                    'share' => 'http://'.$_SERVER['SERVER_NAME'].'/uploads/'.$goods['share'],
                    'goods_id' => $goods['goods_id'],
                ];
            
        }
        return $this->renderSuccess(compact('data'));
    }

    private function getGoodsList($user)
    {
        // 获取商品数据
        $model = new GoodsModel;
            // 数据来源：自动
            $gop = [
                'status' => 10,
            ];
            $goodsList = $model->getList($gop, $user);
        if ($goodsList->isEmpty()) return [];
        // 格式化商品列表
        $data = [];
        foreach ($goodsList as $goods) {
            if($goods['share']){
                $data[] = [
                    'selling_point' => $goods['selling_point'],
                    'share' => 'http://'.$_SERVER['SERVER_NAME'].'/uploads/'.$goods['share'],
                    'goods_id' => $goods['goods_id'],
                ];
            }
            
        }
        return $data;
    }

    /**
     * 获取商品详情
     * @param $goods_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function detail($goods_id)
    {
        // 用户信息
        $user = $this->getUser(false);
        // 商品详情
        $model = new GoodsModel;
        $goods = $model->getDetails($goods_id, $this->getUser(false));
        if ($goods === false) {
            return $this->renderError($model->getError() ?: '商品信息不存在');
        }
        // 多规格商品sku信息, todo: 已废弃 v1.1.25
        $specData = $goods['spec_type'] == 20 ? $model->getManySpecData($goods['spec_rel'], $goods['sku']) : null;
        $goods['share'] = 'http://'.$_SERVER['SERVER_NAME'].'/uploads/'.$goods['share'];
        $goods_id = $goods['goods_id'];
        $goods['is_show'] = Db::name('goods_show')->where(['goods_id'=>$goods_id,'user_id'=>$user['user_id']])->value('status');
            $sinfo =Db::name('goods_show')->field('status,note')->where(['goods_id'=>$goods_id,'user_id'=>$user['user_id']])->order('id desc')->find();
        return $this->renderSuccess([
            // 商品详情
            'detail' => $goods,
            'show' => $sinfo ? $sinfo : [],
            // 购物车商品总数量
            'cart_total_num' => $user ? (new CartModel($user))->getGoodsNum() : 0,
            // 多规格商品sku信息
            'specData' => $specData,
        ]);
    }

    /**
     * 申请查看价格
     * @param $goods_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function apply_goods()
    {
        // 商品详情
        $goods_id = $this->request->post('goods_id');
        $user = $this->getUser(false);
        if(!$user){
            return $this->renderError('登录后重试');
        }
        $op = [
            'goods_id'=>$goods_id,
            'user_id'=>$user['user_id'],
        ];
        $info = Db::name('goods_show')->where($op)->find();
        if($info['status'] == 1){
            return $this->renderError('可查看请刷新后重试');
        }
        if($info['status'] === 0){
            return $this->renderError('正在审核中 请稍后');
        }
        if($info['status'] === 2){
            $info = Db::name('goods_show')->where($op)->update(['status'=>0]);
            return $this->renderError('申请成功, 请稍后');
        }
        $op['create_time'] = time();
        $op['salesman_id'] = $user['salesman_id'];
        $info = Db::name('goods_show')->insert($op);
        if($info){
            return $this->renderSuccess([
                'msg' => '申请成功 请稍后',
            ]);
        }else{
            return $this->renderError('申请失败'
            );
        }
        
    }


     /**
     * 申请查看价格
     * @param $goods_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function poster($goods_id)
    {
        // 商品详情
        $detail = GoodsModel::detail($goods_id);
        $Qrcode = new GoodsPoster($detail, $this->getUser(false));
        return $this->renderSuccess([
            'qrcode' => $Qrcode->getImage(),
        ]);
    }

}
