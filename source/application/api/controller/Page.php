<?php

namespace app\api\controller;

use app\common\exception\BaseException;

use app\api\service\order\PaySuccess;
use app\api\model\WxappPage;
use app\api\model\Wxapp;
use app\api\model\Setting as SettingModel;
use think\Db;
use app\api\model\User as UserModel;

/**
 * 页面控制器
 * Class Index
 * @package app\api\controller
 */
class Page extends Controller
{
    /**
     * 页面数据
     * @param null $page_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index($page_id = null)
    {
        // 页面元素
        $data = WxappPage::getPageData($this->getUser(false), $page_id);
        $config = SettingModel::getItem('store');
        // dump($config);die;
        $data['phone'] = $config['phone'];
        return $this->renderSuccess($data);
    }

    public function ajson(){
        $arr = [
            // 'access_token'=>'34_RJbo3FWyAsaw2q9z5bzsE6dUawpe4BjF6jaYBpWI_nRYdxgsPybekKSGypqTVYzcCBz4pbtIPCqmyFkWBgxixZ8LnVlbLGRq8jk-SKmp5IfZ0EM22tKeYHzVhz8mIW1yWXYhsudZUoNz4hCqIVSbACATGD',
            'scene'=>'i=395fb5f51cdfb854_100023',
            'page'=>'/pages/detail/detail',
        ];

        dump(json_encode($arr));die;
    }


    public function pay()
    {

        
        // $amount = Db::name('order')->where('order_no',$order_no)->value('pay_price');
        $url = 'http://'.$_SERVER['HTTP_HOST'].'/index.php?s=/api/page/notifyurl';
        $op = [
            'channelid'=>config('channelid'),
            'merid'=>config('merid'),
            'termid'=>config('termid'),
            'tradetrace'=>time(),
            'tradeamt'=>1000,
            'body'=>'大家好',
            'notifyurl'=>'http://baidu.com',
            'tradetype'=>'APP',
            'opt'=>'dirBankPay',
            'returnurl'=>'dirBankPay',
        ];
            $op['opt'] = 'dirBankPay';
            $op['tradetype'] = 'APP';
            $op['returnurl'] = 'dirBankPay';

           
        $aa = getPayData($op);
        dump($aa);die;
    }


    public  function narr(){
        $arr = [5,4,3,2,1];
        $oarr = [
           ['id'=>3,'val'=>'33'],
           ['id'=>4,'val'=>'44'],
           ['id'=>5,'val'=>'55'],
           ['id'=>2,'val'=>'22'],
           ['id'=>1,'val'=>'11'],
        ];
        foreach($arr as $v){
                foreach($oarr as $ov){
                    if($ov['id'] == $v){
                        $narr[] = $ov;
                    }
                }
        }
        dump($oarr);
        dump($narr);die;
    }

    public function notifyurl()
    {
        $post = input('post.');
        foreach($post as $k=> $v){
            $a = $k;
        }
        $postd= json_decode($a,true);
        $order_no = $postd['tradetrace'];

        $order_nos = explode('_',$order_no);
        if($order_nos[1] == 1){
            DB::name('recharge_order')->where('order_no',$order_nos[0])->update(['pay_status'=>20]);
            $rinfo = DB::name('recharge_order')->where('order_no',$order_nos[0])->find();
            DB::name('user')->where('user_id',$rinfo['user_id'])->setInc('balance',$rinfo['actual_money']);
        }else{
            // DB::name('order')->where('order_no',$order_nos[0])->update(['pay_status'=>20]);
            $rinfo = DB::name('order')->where('order_no',$order_nos[0])->find();
            if($rinfo){
                $PaySuccess = new PaySuccess($order_nos[0]);
                // 发起支付
                $status = $PaySuccess->onPaySuccess($rinfo['pay_type']);
            }

        //     $rinfo = DB::name('order')->where('order_no',$order_nos[0])->find();
        //    DB::name('user')->where('user_id',$rinfo['user_id'])->setInc('expend_money',$rinfo['pay_price']);
        //    DB::name('user')->where('user_id',$rinfo['user_id'])->setInc('pay_money',$rinfo['pay_price']);
           
        }
        // $dd =  DB::name('user')->getlastsql();
        // DB::name('aa')->insert(['aa'=>$dd,'time'=>time()]);
        // DB::name('aa')->insert(['aa'=>$order_no,'time'=>time()]);
        die;

    }

    public function notify_url()
    {
        $post = input('post.');
        foreach($post as $k=> $v){
            $a = $k;
        }
        $postd= json_decode($a,true);
        $order_no = $postd['tradetrace'];

        $order_nos = explode('_',$order_no);
        if($order_nos[1] == 1){
            DB::name('recharge_order')->where('order_no',$order_nos[0])->update(['pay_status'=>20]);
        }else{
            DB::name('salesman_order')->where('order_no',$order_nos[0])->update(['pay_status'=>20,'pay_time'=>time()]);

        }


//        DB::name('salesman_order')->where('order_no',$order_no)->update(['pay_status'=>20]);
        $dd =  DB::name('salesman_order')->getlastsql();
        DB::name('aa')->insert(['aa'=>$dd,'time'=>time()]);

        die;

    }

    public function getopenid1(){
        $openid = input('openid');
        $user = $this->getUser();
        model('user')->where('user_id',$user['user_id'])->update(['open_id'=>$openid]);
        return  $this->renderSuccess([],'操作成功');
    }
    public function getopenid(){
       
        $code = input('code');
        $type = input('type',0);
        $token = input('token');
        if($code){
            $model = new UserModel();
            $ret = $model->wxlogin($code);
            $openid = $ret['openid'];
            if($type){
               $user =  DB::name('user_token')->where([
                    'token' => $token,
                    'type' => 3,
                ])->find();
                if(!$user){
                    return  $this->renderError('用户信息不存在');
                }
                model('salesman')->where('salesman_id',$user['user_id'])->update(['open_id'=>$openid]);
            }else{
                $user = $this->getUser();
                model('user')->where('user_id',$user['user_id'])->update(['open_id'=>$openid]);
            }
            return  $this->renderSuccess([],'操作成功');
        }else{
            $openid = input('openid');
            if($type){
                $user =  DB::name('user_token')->where([
                     'token' => $token,
                     'type' => 3,
                 ])->find();
                 if(!$user){
                     return  $this->renderError('用户信息不存在');
                 }
                 model('salesman')->where('salesman_id',$user['user_id'])->update(['open_id'=>$openid]);
             }else{
                 $user = $this->getUser();
                 model('user')->where('user_id',$user['user_id'])->update(['open_id'=>$openid]);
             }

            model('user')->where('user_id',$user['user_id'])->update(['open_id'=>$openid]);
            return  $this->renderSuccess([],'操作成功'); 
        }
        
    }

    public function getcode(){
        $code = input('code');
        $model = new UserModel();
        $ret = $model->wxlogin($code);
        
        return  $this->renderSuccess($ret);
    }
    
    public function getPaySign(){
        $order_no = input('order_no');
        $ret = Db::name('paysign')->where('order_no',$order_no)->value('sign');
        return  $this->renderSuccess($ret);
    }


    public function unshort()
{

    $url = 'https://u.jd.com/mNKCNH'; 
    $res = curl($url); //get请求 获取到 内容
    // print_r($res);die;
    // 正则获取 跳转的 url1
        $url1 = 'https://u.jd.com/jda?e=&p=AyIGZRhaFwYRDlASXxYyEgZUGloQBhAOVxNSJUZNXwtEa0xHV0YXEEULWldTCQQHCllHGAdFBwtEQkQBBRxNVlQYBUkeTVxNCRNLGEF6RwtVGloUAxcDVxJZHQsiTgJPJE9eWQA2UA9ick5XA2lYUHxSd1kXaxQyEgZUGlsTAhoCUStrFQUiUTsbWhQDEwZWE1IdMhM3VR9TFQsSAFcdWhECETdSG1IlARMHUBxfEAIVG1MfXBMBGjdlK1glMiIHZRhrV2xBUwUcC0dVRQJcT1oQABMABU8IFVcXA1AeUhUHEAQGH2sXAxMDXA%3D%3D&a=fCg9UgoiAwwHO1BcXkQYFFlgf3t3eVZcRVgzVRBSUll%2bAQAPDSwjLw%3d%3d&refer=norefer&d=mNKCNH';

        $res = get_headers($url1,1); // 由于是 302 重定向 获取header 头信息 获取 location 信息

        var_dump($res);
        die;

 
 
}

}
