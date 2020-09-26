<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title><?= $setting['store']['values']['name'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="assets/common/i/favicon.ico"/>
    <meta name="apple-mobile-web-app-title" content="<?= $setting['store']['values']['name'] ?>"/>
    <link rel="stylesheet" href="assets/common/css/amazeui.min.css"/>
    <link rel="stylesheet" href="assets/store/css/app.css?v=<?= $version ?>"/>
    <link rel="stylesheet" href="//at.alicdn.com/t/font_783249_m68ye1gfnza.css">
    <script src="assets/common/js/jquery.min.js"></script>
    <script src="//at.alicdn.com/t/font_783249_e5yrsf08rap.js"></script>
    <script>
        BASE_URL = '<?= isset($base_url) ? $base_url : '' ?>';
        STORE_URL = '<?= isset($store_url) ? $store_url : '' ?>';
    </script>
</head>

<body data-type="">
<div class="am-g tpl-g">
    <!-- 头部 -->
    <header class="tpl-header">
        <!-- 右侧内容 -->
        <div class="tpl-header-fluid">
            <!-- 侧边切换 -->
            <link rel="stylesheet" href="//at.alicdn.com/t/font_2031663_yvv9n6lkwt.css">
            <script src="//at.alicdn.com/t/font_2031663_yvv9n6lkwt.js"></script>
            <div class="am-fl tpl-header-button">
                <a href="javascript:history.go(-1)"><i class="iconfont icon-jiantouarrowhead7"></i></a>
            </div>
            <div class="am-fl tpl-header-button switch-button">
                <i class="iconfont icon-menufold"></i>
            </div>
            <!-- 刷新页面 -->
            <div class="am-fl tpl-header-button refresh-button">
                <i class="iconfont icon-refresh"></i>
            </div>
            <!-- 其它功能-->
            <div class="am-fr tpl-header-navbar">
                <ul>
                    <!-- 欢迎语 -->
                    <li class="am-text-sm tpl-header-navbar-welcome">
                        <a href="<?= url('store.user/renew') ?>">欢迎你，<span><?= $store['user']['user_name'] ?>，<?= $store['user']['user_name']=='admin'?'超级管理员':$store['user']['shop_name']?></span>
                        </a>
                    </li>
                    <!-- 退出 -->
                    <li class="am-text-sm">
                        <a href="<?= url('passport/logout') ?>">
                            <i class="iconfont icon-tuichu"></i> 退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- 侧边导航栏 -->
    <div class="left-sidebar dis-flex">
        <?php $menus = $menus ?: []; ?>
        <?php $group = $group ?: 0; ?>
        <!-- 一级菜单 -->
        <ul class="sidebar-nav">
            <li class="sidebar-nav-heading"><?= $setting['store']['values']['name'] ?></li>
            <?php foreach ($menus as $key => $item): ?>
                <li class="sidebar-nav-link">
                    <a href="<?= isset($item['index']) ? url($item['index']) : 'javascript:void(0);' ?>"
                       class="<?= $item['active'] ? 'active' : '' ?>">
                        <?php if (isset($item['is_svg']) && $item['is_svg'] == true): ?>
                            <svg class="icon sidebar-nav-link-logo" aria-hidden="true">
                                <use xlink:href="#<?= $item['icon'] ?>"></use>
                            </svg>
                        <?php else: ?>
                            <i class="iconfont sidebar-nav-link-logo <?= $item['icon'] ?>"
                               style="<?= isset($item['color']) ? "color:{$item['color']};" : '' ?>"></i>
                        <?php endif; ?>
                        <?= $item['name'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <!-- 子级菜单-->
        <?php $second = isset($menus[$group]['submenu']) ? $menus[$group]['submenu'] : []; ?>
        <?php if (!empty($second)) : ?>
            <ul class="left-sidebar-second">
                <li class="sidebar-second-title"><?= $menus[$group]['name'] ?></li>
                <li class="sidebar-second-item">
                    <?php foreach ($second as $item) : ?>
                        <?php if (!isset($item['submenu'])): ?>
                            <!-- 二级菜单-->
                            <a href="<?= url($item['index']) ?>"
                               class="<?= (isset($item['active']) && $item['active']) ? 'active' : '' ?>">
                                <?= $item['name']; ?>
                            </a>
                        <?php else: ?>
                            <!-- 三级菜单-->
                            <div class="sidebar-third-item">
                                <a href="javascript:void(0);"
                                   class="sidebar-nav-sub-title <?= $item['active'] ? 'active' : '' ?>">
                                    <i class="iconfont icon-caret"></i>
                                    <?= $item['name']; ?>
                                </a>
                                <ul class="sidebar-third-nav-sub">
                                    <?php foreach ($item['submenu'] as $third) : ?>
                                        <li>
                                            <a class="<?= $third['active'] ? 'active' : '' ?>"
                                               href="<?= url($third['index']) ?>">
                                                <?= $third['name']; ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </li>
            </ul>
        <?php endif; ?>
    </div>

    <!-- 内容区域 start -->
    <div class="tpl-content-wrapper <?= empty($second) ? 'no-sidebar-second' : '' ?>">
        <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
        <div id="app" v-cloak class="page-statistics-data row-content am-cf">
            <!-- 数据概况 -->
            <div class="row">
                <div class="am-u-sm-12 am-margin-bottom">
                    <div class="widget widget-survey am-cf" v-loading="survey.loading">
                        <div class="widget-head am-cf">
                            <div class="widget-title">数据概况</div>
                            <div class="widget-screen am-cf" style="display: none">
                                <!-- 日期选择器 -->
                                <div class="yxs-date-editor am-fl">
                                    <el-date-picker
                                            v-model="survey.dateValue"
                                            type="daterange"
                                            size="small"
                                            @change="onChangeDate"
                                            value-format="yyyy-MM-dd"
                                            range-separator="至"
                                            start-placeholder="开始日期"
                                            end-placeholder="结束日期">
                                    </el-date-picker>
                                </div>
                                <!-- 快捷选项 -->
                                <div class="widget-screen_shortcut am-fl" style="display: none">
                                    <div class="shortcut-days am-cf">
                                        <div class="shortcut-days_item am-fl">
                                            <a href="javascript:void(0);" @click="onFastDate(7)">7天</a>
                                        </div>
                                        <div class="shortcut-days_item am-fl">
                                            <a href="javascript:void(0);" @click="onFastDate(30)">30天</a>
                                        </div>
                                        <div class="shortcut-days_item item-clear am-fl">
                                            <a href="javascript:void(0);" @click="onFastDate(0)">清空</a>
                                        </div>
                                    </div>
                                </div>
                            </div st>
                        </div>
                        <div class="widget-body">
                            <div class="widget-body-center am-cf">
                                <div class="am-u-sm-6 am-u-md-6 am-u-lg-4">
                                    <div class="widget-outline dis-flex flex-y-center">
                                        <div class="outline-left">
                                            <img src="assets/store/img/statistics/survey/03.png" alt="">
                                        </div>
                                        <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                            <div class="item-name">门店数量</div>
                                            <div class="item-value">{{ survey.values.user_total }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="am-u-sm-6 am-u-md-6 am-u-lg-4">
                                    <div class="widget-outline dis-flex flex-y-center">
                                        <div class="outline-left">
                                            <img src="assets/store/img/statistics/survey/04.png" alt="">
                                        </div>
                                        <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                            <div class="item-name">订单数</div>
                                            <div class="item-value">{{ survey.values.order_total }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="am-u-sm-6 am-u-md-6 am-u-lg-4" style="display: none">
                                    <div class="widget-outline dis-flex flex-y-center">
                                        <div class="outline-left">
                                            <img src="assets/store/img/statistics/survey/05.png" alt="">
                                        </div>
                                        <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                            <div class="item-name">商品数量</div>
                                            <div class="item-value">{{ survey.values.goods_total }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="am-u-sm-6 am-u-md-6 am-u-lg-4" style="display: none">
                                    <div class="widget-outline dis-flex flex-y-center">
                                        <div class="outline-left">
                                            <img src="assets/store/img/statistics/survey/03.png" alt="">
                                        </div>
                                        <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                            <div class="item-name">消费人数</div>
                                            <div class="item-value">{{ survey.values.consume_users }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="am-u-sm-6 am-u-md-6 am-u-lg-4" >
                                    <div class="widget-outline dis-flex flex-y-center">
                                        <div class="outline-left">
                                            <img src="assets/store/img/statistics/survey/02.png" alt="">
                                        </div>
                                        <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                            <div class="item-name">付款实收总额</div>
                                            <div class="item-value">{{ survey.values.order_total_money }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="am-u-sm-6 am-u-md-6 am-u-lg-4" style="display: none">
                                    <div class="widget-outline dis-flex flex-y-center">
                                        <div class="outline-left">
                                            <img src="assets/store/img/statistics/survey/02.png" alt="">
                                        </div>
                                        <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                            <div class="item-name">用户充值总额</div>
                                            <div class="item-value">{{ survey.values.recharge_total }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="widget-body am-cf">
                            <div class="am-u-sm-6 am-u-md-6 am-u-lg-4">
                                <div class="widget-outline dis-flex flex-y-center">
                                    <div class="outline-left">
                                        <img src="assets/store/img/statistics/survey/04.png" alt="">
                                    </div>
                                    <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                        <div class="item-name">本周订单数</div>
                                        <div class="item-value"><?= $echarts7days['week_order_total'] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-u-sm-6 am-u-md-6 am-u-lg-4">
                                <div class="widget-outline dis-flex flex-y-center">
                                    <div class="outline-left">
                                        <img src="assets/store/img/statistics/survey/04.png" alt="">
                                    </div>
                                    <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                        <div class="item-name">本月订单数</div>
                                        <div class="item-value"><?= $echarts30days['month_order_total'] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-u-sm-6 am-u-md-6 am-u-lg-4" >
                                <div class="widget-outline dis-flex flex-y-center">
                                    <div class="outline-left">
                                        <img src="assets/store/img/statistics/survey/04.png" alt="">
                                    </div>
                                    <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                        <div class="item-name">本年订单数</div>
                                        <div class="item-value"><?= $echartsyears['year_order_total'] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-body am-cf">
                            <div class="am-u-sm-1 am-u-md-1 am-u-lg-4">
                                <div class="widget-outline dis-flex flex-y-center">
                                    <div class="outline-left">
                                        <img src="assets/store/img/statistics/survey/02.png" alt="">
                                    </div>
                                    <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                        <div class="item-name">本周成交额</div>
                                        <div class="item-value"><?= $echarts7days['week_order_total_price'] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-u-sm-1 am-u-md-1 am-u-lg-4">
                                <div class="widget-outline dis-flex flex-y-center">
                                    <div class="outline-left">
                                        <img src="assets/store/img/statistics/survey/02.png" alt="">
                                    </div>
                                    <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                        <div class="item-name">本月成交额</div>
                                        <div class="item-value"><?= $echarts30days['month_order_total_price'] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-u-sm-1 am-u-md-1 am-u-lg-4" >
                                <div class="widget-outline dis-flex flex-y-center">
                                    <div class="outline-left">
                                        <img src="assets/store/img/statistics/survey/02.png" alt="">
                                    </div>
                                    <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                        <div class="item-name">本年成交额</div>
                                        <div class="item-value"><?= $echartsyears['year_order_total_price'] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 近七日交易走势 -->
            <div class="row">
                <div class="am-u-sm-12 am-margin-bottom">
                    <div class="widget am-cf">
                        <div class="widget-head">
                            <div class="widget-title">本周交易走势</div>
                        </div>
                        <div class="widget-body am-cf">
                            <div id="echarts-trade" class="widget-echarts"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 近一月交易走势 -->
            <div class="row">
                <div class="am-u-sm-12 am-margin-bottom">
                    <div class="widget am-cf">
                        <div class="widget-head">
                            <div class="widget-title">
                                本月交易走势

                                    <select class="sel_month" name="mm" id="sel_month" style="margin-top: -8px;margin-left: 10px;text-align: center;font-weight: normal;text-align-last: center;">
<!--                                        <option value=""></option>-->
                                    </select>


                            </div>
                        </div>
                        <div class="widget-body am-cf">
                            <div id="echarts-trades" class="widget-echarts"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 近一年交易走势 -->
            <div class="row">
                <div class="am-u-sm-12 am-margin-bottom">
                    <div class="widget am-cf">
                        <div class="widget-head">
                            <div class="widget-title">本年交易走势
                                <select class="sel_year" name="YYYY" id="sel_year" style="margin-top: -8px;margin-left: 10px;text-align: center;font-weight: normal;text-align-last: center;">
                                    <option value="2020">2020年</option>
                                </select>
                            </div>
                        </div>
                        <div class="widget-body am-cf">
                            <div id="echarts-trades-years" class="widget-echarts"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($store['user']['store_user_id'] == 10001){ ?>
            <div class="order-list am-scrollable-horizontal am-u-sm-12 am-margin-top-xs">
                <h3>月排行榜</h3>
                <table width="100%" class="am-table am-table-centered
                        am-text-nowrap am-margin-bottom-xs">
                    <thead>
                    <tr>
                        <th width="12%">排名</th>
                        <th>店铺名</th>
                        <th>店铺地址</th>
                        <th>销售额</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $colspan = 12; ?>
                    <?php  foreach ($data['month'] as $key => $value): ?>
                        <tr>
                            <td class="am-text-middle" >
                                <span class="am-margin-right-lg"><?= $key+1 ?></span>
                            </td>
                            <td class="am-text-middle" >
                                <span class="am-margin-right-lg"><?= $value['shop_name'] ?></span>
                            </td>
                            <td class="am-text-middle" >
                                <span class="am-margin-right-lg"><?= $value['address_detail'] ?></span>
                            </td>
                            <td class="am-text-middle" >
                                <span > <?= $value['sales'] ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="<?= $colspan ?>" class="am-text-center">暂无记录</td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div class="am-u-lg-12 am-cf">
                <div class="am-fr"><?= $data['month']->render() ?> </div>
            </div>

            <div class="order-list am-scrollable-horizontal am-u-sm-12 am-margin-top-xs">
                <h3>年排行榜</h3>
                <table width="100%" class="am-table am-table-centered
                        am-text-nowrap am-margin-bottom-xs">
                    <thead>
                    <tr>
                        <th width="12%">排名</th>
                        <th>店铺名</th>
                        <th>店铺地址</th>
                        <th>销售额</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $colspan = 12; ?>
                    <?php  foreach ($data['years'] as $key => $value): ?>
                        <tr>
                            <td class="am-text-middle " >
                                <span class="am-margin-right-lg"><?= $key+1 ?></span>
                            </td>
                            <td class="am-text-middle" >
                                <span class="am-margin-right-lg"><?= $value['shop_name'] ?></span>
                            </td>
                            <td class="am-text-middle" >
                                <span class="am-margin-right-lg"><?= $value['address_detail'] ?></span>
                            </td>
                            <td class="am-text-middle" >
                                <span > <?= $value['sales'] ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="<?= $colspan ?>" class="am-text-center">暂无记录</td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div class="am-u-lg-12 am-cf">
                <div class="am-fr"><?= $data['years']->render() ?> </div>
            </div>
            <!-- 排行榜 -->
            <div class="row">
                <div class="am-u-sm-6 am-margin-bottom" style="display: none">
                    <div class="widget-ranking widget am-cf">
                        <div class="widget-head">
                            <div class="widget-title">商品销售榜</div>
                        </div>
                        <div class="widget-body am-cf">
                            <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black">
                                <thead>
                                <tr>
                                    <th class="am-text-center" width="15%">排名</th>
                                    <th class="am-text-left" width="45%">商品</th>
                                    <th class="am-text-center" width="20%">销量</th>
                                    <th class="am-text-center" width="20%">销售额</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in goodsRanking">
                                    <td class="am-text-middle am-text-center">
                                        <div v-if="index < 3 && item.total_sales_num > 0" class="ranking-img">
                                            <img :src="'assets/store/img/statistics/ranking/0' + (index + 1) + '.png'" alt="">
                                        </div>
                                        <span v-else>{{ index + 1 }}</span>
                                    </td>
                                    <td class="am-text-middle">
                                        <p class="ranking-item-title am-text-truncate">{{ item.goods_name }}</p>
                                    </td>
                                    <td class="am-text-middle am-text-center">{{ item.total_sales_num }}</td>
                                    <td class="am-text-middle am-text-center">{{ item.sales_volume }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="am-u-sm-6 am-margin-bottom" style="display: none">
                    <div class="widget-ranking widget am-cf">
                        <div class="widget-head">
                            <div class="widget-title">用户消费榜</div>
                        </div>
                        <div class="widget-body am-cf">
                            <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black">
                                <thead>
                                <tr>
                                    <th class="am-text-center" width="20%">排名</th>
                                    <th class="am-text-left" width="50%">用户昵称</th>
                                    <th class="am-text-center" width="30%">实际消费金额</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in userExpendRanking">
                                    <td class="am-text-middle am-text-center">
                                        <div v-if="index < 3 && item.expend_money > 0" class="ranking-img">
                                            <img :src="'assets/store/img/statistics/ranking/0' + (index + 1) + '.png'" alt="">
                                        </div>
                                        <span v-else>{{ index + 1 }}</span>
                                    </td>
                                    <td class="am-text-middle">
                                        <p class="ranking-item-title am-text-truncate">{{ item.nickName }}</p>
                                    </td>
                                    <td class="am-text-middle am-text-center">{{ item.expend_money }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>

        <script src="assets/common/js/echarts.min.js"></script>
        <script src="assets/common/js/echarts-walden.js"></script>
        <script src="assets/common/js/vue.min.js?v=1.1.35"></script>
        <script src="https://unpkg.com/element-ui/lib/index.js"></script>

        <script type="text/javascript">

            new Vue({
                el: '#app',
                data: {
                    // 数据概况
                    survey: {
                        loading: false,
                        dateValue: [],
                        values: <?= \app\common\library\helper::jsonEncode($survey) ?>
                    },
                    // 商品销售榜
                    goodsRanking: <?= \app\common\library\helper::jsonEncode($goodsRanking) ?>,
                    // 用户消费榜
                    userExpendRanking: <?= \app\common\library\helper::jsonEncode($userExpendRanking) ?>
                },

                mounted() {
                    // 近七日交易走势
                    this.drawLine();
                    //近一个月交易走势
                    this.drawLines();
                    this.drawLineYear();

                },

                methods: {

                    // 监听事件：日期选择快捷导航
                    onFastDate: function (days) {
                        var startDate, endDate;
                        // 清空日期
                        if (days === 0) {
                            this.survey.dateValue = [];
                        } else {
                            startDate = $.getDay(-days);
                            endDate = $.getDay(0);
                            this.survey.dateValue = [startDate, endDate];
                        }
                        // api: 获取数据概况
                        this.__getApiData__survey(startDate, endDate);
                    },

                    // 监听事件：日期选择框改变
                    onChangeDate: function (e) {
                        // api: 获取数据概况
                        this.__getApiData__survey(e[0], e[1]);
                    },

                    // 获取数据概况
                    __getApiData__survey: function (startDate, endDate) {
                        var app = this;
                        // 请求api数据
                        app.survey.loading = true;
                        // api地址
                        var url = '<?= url('statistics.data/survey') ?>';
                        $.post(url, {
                            startDate: startDate,
                            endDate: endDate
                        }, function (result) {
                            app.survey.values = result.data;
                            app.survey.loading = false;
                        });
                    },

                    /**
                     * 近七日交易走势
                     * @type {HTMLElement}
                     */
                    drawLine() {
                        var dom = document.getElementById('echarts-trade');
                        echarts.init(dom, 'walden').setOption({
                            tooltip: {
                                trigger: 'axis'
                            },
                            legend: {
                                data: ['成交量', '成交额','净收入'],
                                selectedMode:'single'
                            },
                            toolbox: {
                                show: true,
                                showTitle: false,
                                feature: {
                                    mark: {show: true},
                                    magicType: {show: true, type: ['line', 'bar']}
                                }
                            },
                            calculable: true,
                            xAxis: {
                                type: 'category',
                                boundaryGap: false,
                                data: <?= $echarts7days['date'] ?>
                            },
                            yAxis: {
                                type: 'value'
                            },
                            series: [
                                {
                                    name: '成交额',
                                    type: 'line',
                                    data: <?= $echarts7days['order_total_price'] ?>
                                },
                                {
                                    name: '成交量',
                                    type: 'line',
                                    data: <?= $echarts7days['order_total'] ?>
                                },
                                {
                                    name: '净收入',
                                    type: 'line',
                                    data: <?= $echarts7days['order_total'] ?>
                                }
                            ]
                        }, true);
                    },

                    /**
                     * 近七日交易走势
                     * @type {HTMLElement}
                     */
                    drawLines() {
                        var doms = document.getElementById('echarts-trades');
                        echarts.init(doms, 'waldens').setOption({
                            tooltip: {
                                trigger: 'axis'
                            },
                            legend: {
                                data: ['成交量', '成交额','净收入'],
                                selectedMode:'single'
                            },
                            toolbox: {
                                show: true,
                                showTitle: false,
                                feature: {
                                    mark: {show: true},
                                    magicType: {show: true, type: ['line', 'bar']}
                                }
                            },
                            calculable: true,
                            xAxis: {
                                type: 'category',
                                boundaryGap: false,
                                data: <?= $echarts30days['date'] ?>
                            },
                            yAxis: {
                                type: 'value'
                            },
                            series: [
                                {
                                    name: '成交额',
                                    type: 'line',
                                    data: <?= $echarts30days['order_total_price'] ?>
                                },
                                {
                                    name: '成交量',
                                    type: 'line',
                                    data: <?= $echarts30days['order_total'] ?>
                                },
                                {
                                    name: '净收入',
                                    type: 'line',
                                    data: <?= $echarts30days['order_total'] ?>
                                }
                            ]
                        }, true);
                    },

                    drawLineYear() {
                        var doms = document.getElementById('echarts-trades-years');
                        echarts.init(doms, 'waldens').setOption({
                            tooltip: {
                                trigger: 'axis'
                            },
                            legend: {
                                data: ['成交量', '成交额','净收入'],
                                selectedMode:'single'
                            },
                            toolbox: {
                                show: true,
                                showTitle: false,
                                feature: {
                                    mark: {show: true},
                                    magicType: {show: true, type: ['line', 'bar']}
                                }
                            },
                            calculable: true,
                            xAxis: {
                                type: 'category',
                                boundaryGap: false,
                                data: <?= $echartsyears['date'] ?>
                            },
                            yAxis: {
                                type: 'value'
                            },
                            series: [
                                {
                                    name: '成交额',
                                    type: 'line',
                                    data: <?= $echartsyears['order_total_price'] ?>
                                },
                                {
                                    name: '成交量',
                                    type: 'line',
                                    data: <?= $echartsyears['order_total'] ?>
                                },
                                {
                                    name: '净收入',
                                    type: 'line',
                                    data: <?= $echartsyears['order_total'] ?>
                                }
                            ]
                        }, true);
                    }

                }

            });

        </script>

        <script>
            $(function () {
                $.ms_DatePicker({
                    YearSelector: ".sel_year",
                    MonthSelector: ".sel_month"
                });
            });
            (function($){
                $.extend({
                    ms_DatePicker: function (options) {
                        var defaults = {
                            YearSelector: "#sel_year",
                            MonthSelector: "#sel_month",
                            FirstText: "<?= intval(date('m',time())) ?><font>月</font>",
                            FirstText1: "<?= intval(date('yy',time())) ?><font>年</font>",
                            FirstValue: 0,
                            FirstValue1: 0
                        };
                        var opts = $.extend({}, defaults, options);
                        var $YearSelector = $(opts.YearSelector);
                        var $MonthSelector = $(opts.MonthSelector);
                        var FirstText = opts.FirstText;
                        var FirstText1 = opts.FirstText1;
                        var FirstValue = opts.FirstValue;
                        var FirstValue1 = opts.FirstValue1;

                        // 初始化
                        var str = "<option value=\"" + FirstValue + "\">"+FirstText+"</option>";
                        var str1 = "<option value=\"" + FirstValue1 + "\">"+FirstText1+"</option>";
                        $YearSelector.html(str1);
                        $MonthSelector.html(str);

                        // 年份列表
                        var yearNow = new Date().getFullYear();
                        var yearSel = $YearSelector.attr("rel");
                        for (var i = yearNow; i > 2020; i--) {
                            var sed = yearSel==i?"selected":"";
                            var yearStr = "<option value=\"" + i + "\" " + sed+">"+i+"</option>";
                            $YearSelector.append(yearStr);
                        }

                        // 月份列表
                        var monthSel = $MonthSelector.attr("rel");
                        for (var i = 1; i <= 12; i++) {
                            var sed = monthSel==i?"selected":"";
                            var monthStr = "<option value=\"" + i + "\" "+sed+">"+i+"<font>月</font></option>";
                            $MonthSelector.append(monthStr);
                        }

                        // 日列表(仅当选择了年月)
                        function BuildDay() {
                            var year = parseInt($YearSelector.val());
                            var month = parseInt($MonthSelector.val());
                            var dayCount = 0;
                            switch (month) {
                                case 1:
                                case 3:
                                case 5:
                                case 7:
                                case 8:
                                case 10:
                                case 12:
                                    dayCount = 31;
                                    break;
                                case 4:
                                case 6:
                                case 9:
                                case 11:
                                    dayCount = 30;
                                    break;
                                case 2:
                                    dayCount = 28;
                                    if ((year % 4 == 0) && (year % 100 != 0) || (year % 400 == 0)) {
                                        dayCount = 29;
                                    }
                                    break;
                                default:
                                    break;
                            }
                        }
                        $MonthSelector.change(function () {
                            BuildDay();

                        });
                        $YearSelector.change(function () {
                            BuildDay();
                        });

                    } // End ms_DatePicker
                });
            })(jQuery);
        </script>
    </div>
    <!-- 内容区域 end -->

</div>
<script src="assets/common/plugins/layer/layer.js"></script>
<script src="assets/common/js/jquery.form.min.js"></script>
<script src="assets/common/js/amazeui.min.js"></script>
<script src="assets/common/js/webuploader.html5only.js"></script>
<script src="assets/common/js/art-template.js"></script>
<script src="assets/store/js/app.js?v=<?= $version ?>"></script>
<script src="assets/store/js/file.library.js?v=<?= $version ?>"></script>
</body>

</html>
