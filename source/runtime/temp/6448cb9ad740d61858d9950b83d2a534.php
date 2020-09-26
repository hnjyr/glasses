<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:105:"C:\Users\Administrator\Desktop\glasses\web/../source/application/store\view\setting\sales_order\index.php";i:1601114968;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<?php //dump($data);die(); ?>
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
        <?php $menus = $menus ?: []; $group = $group ?: 0; ?>
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
        <?php $second = isset($menus[$group]['submenu']) ? $menus[$group]['submenu'] : []; if (!empty($second)) : ?>
            <ul class="left-sidebar-second">
                <li class="sidebar-second-title"><?= $menus[$group]['name'] ?></li>
                <li class="sidebar-second-item">
                    <?php foreach ($second as $item) : if (!isset($item['submenu'])): ?>
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
                        <?php endif; endforeach; ?>
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
                        <div class="widget-head am-cf">
                            <div class="widget-title am-cf"><?= $title ?></div>
                        </div>
                        <div class="widget-body am-fr">
                            <!-- 工具栏 -->
                            <div class="page_toolbar am-margin-bottom-xs am-cf">
                                <form id="form-search" class="toolbar-form" action="">
                                    <input type="hidden" name="s" value="/<?= $request->pathinfo() ?>">
                                    <input type="hidden" name="dataType" value="<?= $dataType ?>">
                                    <div class="am-u-sm-12 am-u-md-3">
                                        <div class="am-form-group">
                                            <div class="am-btn-toolbar">
                                                <div class="am-btn-group am-btn-group-xs">
                                                    <?php if (checkPrivilege('setting.sales_order/add')): ?>
                                                        <a class="j-export am-btn am-btn-danger am-radius"
                                                           href="<?= url('setting.sales_order/add') ?>">
                                                            新增
                                                        </a>
                                                    <?php endif; ?>
                                                    <div class="am-u-sm-12 am-u-md-3" style="display: none">
                                                        <div class="am-form-group">
                                                            <?php if($admin_info['is_super'] != 1): ?>
                                                                <div class="am-btn-group am-btn-group-xs">
                                                                    <a class="am-btn am-btn-default am-btn-success"
                                                                       href="<?= url('new_order/add') ?>">
                                                                        <span class="am-icon-plus"></span> 开单啦
                                                                    </a>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
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
<!--                                        <th><input id="checkAll" type="checkbox"></th>-->
<!--                                        <th width="12%">订单号</th>-->
                                        <th>消费类型</th>
                                        <th>采购人</th>
                                        <th>金额</th>
                                        <!--<th>月消费</th>
                                        <th>年消费</th>-->
                                        <th>总消费</th>
                                        <th>消费时间</th>
<!--                                        <th>操作</th>-->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $colspan = 7; /*dump($data[0]['zjtotal']);die();*/  if (!$list->isEmpty()):   foreach ($data as $order):if ($order!=null) {?>
                                        <tr>
                                            <!--<td class="am-text-middle" >
                                                <input type="checkbox" name="checkitem" value="<?php echo '<?'; ?>
/*= $order['sales_num'] */?>">
                                            </td>-->
                                           <!-- <td class="am-text-middle" >
                                                <span class="am-margin-right-lg"><?php echo '<?'; ?>
/*= $order['sales_num'] */?></span>
                                            </td>-->
                                            <td class="am-text-middle" >
                                                <span class="am-margin-right-lg"><?= $order['buy_name'] ?></span>
                                            </td>
                                            <td class="am-text-middle" >
                                                <span > <?= $order['buy_sales_name'] ?></span>
                                            </td>
                                            <td class="am-text-middle" >
                                                <span > <?= $order['price'] ?></span>
                                            </td>
                                           <!-- <td class="am-text-middle" >
                                                <span ><?php echo '<?'; ?>
/*= $data[$key]['month_total'] */?> </span>
                                            </td>
                                            <td class="am-text-middle" >
                                                <span > <?php echo '<?'; ?>
/*= $data[$key]['years_total'] */?></span>
                                            </td>-->
                                            <td class="am-text-middle" >
                                                <span > <?= $order['total'] ?></span>
                                            </td>
                                            <td class="am-text-middle" >
                                                <span > <?= $order['create_time'] ?></span>
                                            </td>
                                            <!--<td class="am-text-middle" >
                                                <div class="tpl-table-black-operation">
                                                    <a class="tpl-table-black-operation-green"
                                                       href="<?php echo '<?'; ?>
/*= url('setting.sales_order/add') */?>">
                                                        新增</a>
                                                    <a class="tpl-table-black-operation-del" target="_blank"
                                                       href="<?php echo '<?'; ?>
/*= url('setting.sales_order/detail', ['sales_id' => $order['sales_id']]) */?>">
                                                        编辑</a>
                                                </div>
                                            </td>-->
                                        </tr>
                                    <?php }else{break;} endforeach;?>
                                        <tr>
                                            <td  class="am-text-center">总计</td>
                                            <td colspan="<?= $colspan -1 ?>"  class="am-text-center"><?= $data[0]['zjtotal'] ?></td>
                                            <!--因新增加的复选框，导致底部样式改变，所以colspan多加一位-->
                                        </tr>
                                        <tr>
                                            <td colspan="<?= $colspan ?>" class="am-text-center">暂无记录</td>
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



