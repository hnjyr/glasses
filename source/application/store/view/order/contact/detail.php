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
        <?php

        use app\common\enum\DeliveryType as DeliveryTypeEnum;

        // 订单详情
        $detail = isset($detail) ? $detail : null;

        ?>
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">
                        <div class="widget__order-detail widget-body am-margin-bottom-lg">


                            <!-- 基本信息 -->
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">基本信息</div>
                            </div>
                            <div class="am-scrollable-horizontal">
                                <table class="regional-table am-table am-table-bordered am-table-centered
                            am-text-nowrap am-margin-bottom-xs">
                                    <tbody>
                                    <tr>
                                        <th>订单号</th>
                                        <th>订单日期</th>
                                        <th>姓名</th>
                                        <th>性别</th>
                                        <th>手机号</th>
                                        <th>生日</th>
                                        <th>订单金额</th>
                                        <th>订单积分</th>
                                    </tr>
                                    <tr>
                                        <td><?= $detail['contact_no'] ?></td>
                                        <td><?= $detail['create_time'] ?></td>
                                        <td>
                                            <p><?= $detail['user_name'] ?></p>
                                        </td>
                                        <?php if($detail['sex'] == 1) :?>
                                            <td>
                                                <span >男</span>
                                            </td>
                                        <?php endif;?>
                                        <?php if($detail['sex'] == 2) :?>
                                            <td>
                                                <span >女</span>
                                            </td>
                                        <?php endif;?>
                                        <td>
                                            <span ><?= $detail['mobile']?></span>
                                        </td>
                                        <td>
                                            <span ><?= $detail['birthday']?></span>
                                        </td>
                                        <td class="">
                                            <div class="td__order-price am-text-left">
                                                <ul class="am-avg-sm-2">
                                                    <li class="am-text-right">订单总额：</li>
                                                    <li class="am-text-right">￥<?= $detail['total'] ?> </li>
                                                </ul>

                                                <div class="td__order-price am-text-left">
                                                    <ul class="am-avg-sm-2">
                                                        <li class="am-text-right">折扣金额：</li>
                                                        <li class="am-text-right">￥<?= $detail['discount'] ?> </li>
                                                    </ul>

                                                    <ul class="am-avg-sm-2">
                                                        <li class="am-text-right">实付款金额：</li>
                                                        <li class="x-color-red am-text-right">
                                                            ￥<?= $detail['pay_total'] ?></li>
                                                    </ul>
                                                </div>
                                        <td>
                                            <span ><?= $detail['point']?></span>
                                        </td>
                                        </td>


                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- 商品信息 -->
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">商品信息</div>
                            </div>
                            <div class="am-scrollable-horizontal">
                                <table class="regional-table am-table am-table-bordered am-table-centered
                            am-text-nowrap am-margin-bottom-xs">
                                    <tbody>
                                    <tr>
                                        <th>商品名称</th>
                                        <th colspan="2">型号</th>
                                        <th>单位</th>
                                        <th>数量</th>
                                        <th>价格</th>
                                    </tr>



                                    <tr>
                                        <td rowspan="2">隐形眼镜</td>
                                        <td>右眼：</td>
                                        <td><span class="goods-title"><?= $detail['contact'] ?></td>
                                        <td>副</td>
                                        <td><span class="goods-title"><?= $detail['contact_num'] ?></td>
                                        <td><span class="goods-title"><?= $detail['contact_price'] ?></td>

                                    </tr>
                                    <tr>
                                        <td>左眼：</td>
                                        <td><span class="goods-title"><?= $detail['left_contact'] ?></td>
                                        <td>副</td>
                                        <td><span class="goods-title"><?= $detail['left_contact_num'] ?></td>
                                        <td><span class="goods-title"><?= $detail['left_contact_price'] ?></td>

                                    </tr>
                                    <tr>
                                        <td>眼镜盒</td>
                                        <td colspan="2"><span><?= $detail['contact_les']?></span></td>
                                        <td>个</td>
                                        <td><span class="goods-title"><?= $detail['contact_les_num']?></td>
                                        <td><span class="goods-title"><?= $detail['contact_les_price'] ?></td>


                                    </tr>
                                    <tr>
                                        <td>护理液</td>
                                        <td colspan="2"><span class="goods-title"><?= $detail['contact_solution'] ?></span></td>
                                        <td>瓶</td>
                                        <td><span class="goods-title"><?= $detail['solution_num'] ?></span></td>
                                        <td><span class="goods-title"><?= $detail['solution_price'] ?></span><?php ;?></td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- 其他信息 -->
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">其他信息</div>
                            </div>
                            <div class="am-scrollable-horizontal">
                                <table class="regional-table am-table am-table-bordered am-table-centered
                            am-text-nowrap am-margin-bottom-xs">
                                    <tbody>
                                    <tr>
                                        <th>销售员</th>
                                        <th>验光师</th>
                                        <th>加工师</th>
                                        <th>收银员</th>
                                        <th>说明</th>

                                    </tr>
                                    <tr>
                                        <td><?= $detail['sales'] ?></td>
                                        <td><?= $detail['optometry'] ?></td>
                                        <td><?= $detail['working'] ?> </td>
                                        <td> <?= $detail['cash'] ?> </td>
                                        <td><?= $detail['notes'] ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script>
            $(function () {

                /**
                 * 修改价格
                 */
                $('.j-update-price').click(function () {
                    var data = $(this).data();
                    $.showModal({
                        title: '订单价格修改'
                        , content: template('tpl-update-price', data)
                        , yes: function () {
                            // 表单提交
                            $('.form-update-price').ajaxSubmit({
                                type: "post",
                                dataType: "json",
                                success: function (result) {
                                    result.code === 1 ? $.show_success(result.msg, result.url)
                                        : $.show_error(result.msg);
                                }
                            });
                        }
                    });
                });

                /**
                 * 表单验证提交
                 * @type {*}
                 */
                $('.my-form').superForm();

            });
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

