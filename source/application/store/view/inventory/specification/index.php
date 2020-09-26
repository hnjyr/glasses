<!DOCTYPE html>
<html lang="en">
<?php //dump($this->request->param());die(); ?>
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
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link href="https://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/bootstrap-select/1.12.4/css/bootstrap-select.min.css" rel="stylesheet">

    <script src="https://cdn.bootcss.com/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

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
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget-head am-cf">
                        <div class="widget-title am-cf"><?= $title ?></div>
                    </div>
                    <div class="widget-body am-fr">
                        <div class="page_toolbar am-margin-bottom-xs am-cf">
                            <form id="form-search" class="toolbar-form" action="">
                                <div class="am-u-sm-12 am-u-md-3">
                                    <div class="am-form-group">
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a class="j-export am-btn am-btn-danger am-radius"
                                                   href="<?= url('inventory.specification/add&&type='.$_GET['type'].'&&brand_id='.$_GET['brand_id'].'&&refractive_id='.$_GET['refractive_id'].'&&model_id='.$_GET['model_id']) ?>">
                                                    <i class="iconfont icon-add am-margin-right-xs"></i>新增库存
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="order-list am-scrollable-horizontal am-u-sm-12 am-margin-top-xs" >
                            <table width="100%" class="am-table am-table-centered
                        am-text-nowrap am-margin-bottom-xs">
                                <thead>
                                <tr>
                                    <th><input id="checkAll" type="checkbox"></th>
                                    <th>品牌名称</th>
                                    <th>球面类型</th>
                                    <th>折射率</th>
                                    <th>型号</th>
                                    <th>球镜度数</th>
                                    <th>柱镜度数</th>
                                    <th>成本价</th>
                                    <!--<th>店铺名称</th>-->
                                    <th>标准库存</th>
                                    <th>现存库存</th>
                                    <th>需补数量</th>
                                   <!-- <th>添加时间</th>
                                    <th>更新时间</th>-->
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $colspan = 15; ?>
                                <?php if (!$list->isEmpty()): foreach ($list as $order): ?>
                                    <!--                                --><?php //dump($order); ?>
                                    <tr>
                                        <td class="am-text-middle" >
                                            <input type="checkbox" name="checkitem" >
                                        </td>

                                        <td class="am-text-middle" >
                                            <span class="am-margin-right-lg"><?= $order['brand_name'] ?></span>
                                        </td>
                                        <?php $type = $_GET["type"];if ($type == 0): ?>
                                        <td class="am-text-middle" >
                                            <span > 球面</span>
                                        </td>
                                        <?php else: ?>
                                        <td class="am-text-middle" >
                                            <span > 非球面</span>
                                        </td>
                                        <?php endif; ?>
                                        <td class="am-text-middle" >
                                            <span > <?= $order['refractive_num'] ?></span>
                                        </td>
                                        <td class="am-text-middle" >
                                            <span > <?= $order['model'] ?></span>
                                        </td>

                                        <td class="am-text-middle" >
                                            <span > <?= $order['spherical_lens'] ?></span>
                                        </td>
                                        <td class="am-text-middle" >
                                            <span > <?= $order['cytdnder'] ?></span>
                                        </td>
                                        <td class="am-text-middle" >
                                            <span > <?= $order['price'] ?></span>
                                        </td>
                                       <!-- <td class="am-text-middle" >
                                            <span > <?/*= $order['shop_name'] */?></span>
                                        </td>-->


                                        <td class="am-text-middle" >
                                            <span > <?= $order['standard_inventory'] ?></span>
                                        </td>
                                        <td class="am-text-middle" >
                                            <span > <?= $order['now_inventory'] ?></span>
                                        </td>
                                        <td class="am-text-middle" >
                                            <span > <?= $order['standard_inventory']-$order['now_inventory'] ?></span>
                                        </td>
                                        <!--<td class="am-text-middle" >
                                            <span > <?/*= $order['create_time'] */?></span>
                                        </td>
                                        <td class="am-text-middle" >
                                            <span > <?/*= $order['update_time'] */?></span>
                                        </td>-->

                                        <td class="am-text-middle" >
                                            <div class="tpl-table-black-operation">
                                                <a id="submit1"  class="tpl-table-black-operation"
                                                   href="<?= url('inventory.model/index&&type='.$_GET['type'].'&&brand_id='.$order['brand_id'].'&&refractive_id='.$order['refractive_id']) ?>">
                                                    补充库存</a>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                    <tr>
                                        <td colspan="<?= $colspan+1 ?>" class="am-text-center">暂无记录</td>
                                        <!--因新增加的复选框，导致底部样式改变，所以colspan多加一位-->
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="am-u-lg-12 am-cf">
                            <div class="am-fr"><?= $list->render() ?> </div>
                            <div class="am-fr pagination-total am-margin-right">
                                <div class="am-vertical-align-middle">总记录：<?= $list->total() ?></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
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



