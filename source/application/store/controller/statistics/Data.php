<?php

namespace app\store\controller\statistics;

use app\store\controller\Controller;
use app\store\service\statistics\Data as StatisticsDataService;
use think\Db;
/**
 * 数据概况
 * Class Data
 * @package app\store\controller\statistics
 */
class Data extends Controller
{
    /* @var $statisticsDataService StatisticsDataService 数据概况服务类 */
    private $statisticsDataService;

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->statisticsDataService = new StatisticsDataService;
    }

    /**
     * 数据统计主页
     * @return mixed
     * @throws \think\Exception
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $data = $this->postData();
        }
//        return $this->fetch('index', [
//            // 数据概况
//            'survey' => $this->statisticsDataService->getSurveyData(),
//            // 近七日交易走势
//            'echarts7days' => $this->statisticsDataService->getTransactionTrend(),
//            // 商品销售榜
//            'goodsRanking' => $this->statisticsDataService->getGoodsRanking(),
//            // 用户消费榜
//            'userExpendRanking' => $this->statisticsDataService->geUserExpendRanking(),
//        ]);
        $data = [
        'month'=> $this->monthBoard(1),
//                'month'=> $this->test(),
        'years'=> $this->monthBoard(2),
    ];
        $this->assign('data',$data);
        return $this->fetch('index', [
            // 数据概况
            'survey' => $this->statisticsDataService->getSurveyData(),
            // 近七日交易走势
            'echarts7days' => $this->statisticsDataService->getTransactionTrend(),
            'echarts30days' => $this->statisticsDataService->getTransactionTrends(),
            'echartsyears' => $this->statisticsDataService->getTransactionYearsTrends(),
            // 商品销售榜
            'goodsRanking' => $this->statisticsDataService->getGoodsRanking(),
            // 用户消费榜
            'userExpendRanking' => $this->statisticsDataService->geUserExpendRanking(),
        ]);
    }

    public function monthBoard($type)
    {
        if($type == 1){
            $list =   DB::name('new_order')->where('is_delete',0)->whereTime('create_time','m')->field('user_id,sum(pay_total) as sales')->group('user_id')->order('sales desc ')->paginate(4)
                ->each(function ($item,$key){
                    $shop = Db::name('user')->where('user_id',$item['user_id'])->field('shop_name,address_detail')->find();
                    $item['shop_name'] = $shop['shop_name'];
                    $item['province_id'] = Db::name('region')->where('id',$shop['province_id'])->value('name') ;
                    $item['address_detail'] = $shop['address_detail'];
                    return $item;
                });
        }

        if($type == 2){
            $list =   DB::name('new_order')->where('is_delete',0)->whereTime('create_time','y')->field('user_id,sum(pay_total) as sales')->group('user_id')->order('sales desc ')->paginate(5)
                ->each(function ($item,$key){
                    $shop = Db::name('user')->where('user_id',$item['user_id'])->field('shop_name,address_detail')->find();
                    $item['shop_name'] = $shop['shop_name'];
                    $item['address_detail'] = $shop['address_detail'];
                    return $item;
                });
        }


        return $list;
    }

    /**
     * 数据概况API
     * @param null $startDate
     * @param null $endDate
     * @return array
     * @throws \think\Exception
     */
    public function survey($startDate = null, $endDate = null)
    {
        return $this->renderSuccess('', '',
            $this->statisticsDataService->getSurveyData($startDate, $endDate));
    }

}