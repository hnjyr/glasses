<!DOCTYPE html>
<html lang="en">
<?php //dump($list);die();?>
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
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">

                        <div class="widget-body am-fr">
                            <!-- 工具栏 -->
                            <div class="page_toolbar am-margin-bottom-xs am-cf">
                                <form id="form-search" class="toolbar-form" action="">
                                    <div class="am-u-sm-12 am-u-md-3">
                                        <div class="am-form-group">
                                            <div class="am-btn-toolbar">
                                                <div class="am-btn-group am-btn-group-xs">
                                                    <a class="j-export am-btn am-btn-danger am-radius"
                                                       href="<?= url('setting.sales/add') ?>">
                                                        <i class="iconfont icon-add am-margin-right-xs"></i>新增
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="order-list am-scrollable-horizontal am-u-sm-12 am-margin-top-xs">
                                <table width="100%" class="am-table am-table-centered
                        am-text-nowrap am-margin-bottom-xs">
                                    <thead>
                                    <tr>
                                        <th width="12%">姓名</th>
                                        <th >电话</th>
                                        <th>职位</th>
                                        <th>入职时间</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $colspan = 12; ?>
                                    <?php if (!$list->isEmpty()): foreach ($list as  $order):?>
                                        <tr>

                                            <td class="am-text-middle " >
                                                <span class="am-margin-right-lg">
                                                    <?= $order['sales_name'] ?>
                                                </span>
                                            </td>
                                            <td class="am-text-middle" >
                                                <span > <?= $order['mobile'] ?></span>
                                            </td>
                                            <td class="am-text-middle" >
                                                <?php if ($order['type'] == 0): ?>
                                                <span >销售 </span>
                                                <?php elseif ($order['type'] == 1): ?>
                                                <span >验光师 </span>
                                                <?php elseif ($order['type'] == 2): ?>
                                                <span >加工师 </span>
                                                <?php elseif ($order['type'] == 3): ?>
                                                <span >收银员 </span>
                                                <?php /*elseif ($order['type'] == 4): */?><!--
                                                <span >客服 </span>-->
                                                <?php endif; ?>
                                            </td>
                                            <td class="am-text-middle" >
                                                <span > <?= date("Y-m-d",$order['created_time']) ?></span>
                                            </td>
                                            <td class="am-text-middle" width="300px">
                                                <div class="tpl-table-black-operation">
                                                    <a class="tpl-table-black-operation-green"
                                                       href="<?= url('setting.sales/edit', ['sales_id' => $order['sales_id']]) ?>" style="display: inline-block">
                                                        编辑</a>
                                                    <a class="tpl-table-black-operation-del iteam-del"
                                                       href="javascript:void(0);" data-id="<?= $order['sales_id'] ?>" style="display: inline-block">
                                                        删除</a>

                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                        <tr>
                                            <td colspan="<?= $colspan ?>" class="am-text-center">暂无记录</td>
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
        <script>

            $(function () {

                /**
                 * 订单导出
                 */
                $('.j-export').click(function () {
                    var data = {};
                    var formData = $('#form-search').serializeArray();
                    $.each(formData, function () {
                        this.name !== 's' && (data[this.name] = this.value);
                    });
                    window.location = "<?= url('new_order/export') ?>" + '&' + $.urlEncode(data);
                });

            });

        </script>
    </div>
    <!-- 内容区域 end -->

</div>
<script>
    $(function () {
        // 删除元素
        var url = "<?= url('setting.sales/del_sales') ?>";

        $('.iteam-del').delete('sales_id', url, '删除后不可恢复，确定要删除吗？');



    });

</script>
<script src="assets/common/plugins/layer/layer.js"></script>
<script src="assets/common/js/jquery.form.min.js"></script>
<script src="assets/common/js/amazeui.min.js"></script>
<script src="assets/common/js/webuploader.html5only.js"></script>
<script src="assets/common/js/art-template.js"></script>
<script src="assets/store/js/app.js?v=<?= $version ?>"></script>
<script src="assets/store/js/file.library.js?v=<?= $version ?>"></script>
</body>

</html>
