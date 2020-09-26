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
                        <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">日常消费订单</div>
                                    </div>
                                    <div class="am-form-group sales">
                                        <label class="am-u-sm-3 am-form-label form-require"> 采购人 </label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" name="data[buy_sales_name]"
                                                   value="<?= $data['buy_sales_name'] ?>" required>
                                            <!--<select  name="data[buy_sales_name]" class="selectpicker1 show-tick form-control"  data-live-search="false">
                                                <?php
/*                                                if (!$list->isEmpty()): foreach ($list as $order):
                                                    */?>

                                                    <option value="<?/*=$order['buy_sales_name'] */?>"><?/*=$order['buy_sales_name'] */?></option>


                                                <?php /*endforeach; */?>
                                                <?php /*endif; */?>
                                            </select>-->
                                        </div>
                                    </div>
                                    <div class="am-form-group sales">
                                        <label class="am-u-sm-3 am-form-label form-require"> 消费类型 </label>
                                        <div class="am-u-sm-9">
                                            <input type="text"  class="tpl-form-input" name="data[buy_name]"
                                                   value="<?= $data['buy_name'] ?>" required>
                                        </div>
                                    </div>

                                    <div class="am-form-group sales">
                                        <label class="am-u-sm-3 am-form-label form-require"> 金额 </label>
                                        <div class="am-u-sm-9">
                                            <!--<select name="data[shop_name]" id="">
                                                <?php /*foreach ($list as $order):*/?>

                                                    <option value="<?/*= $order['user_id'] */?>"><?/*= $order['shop_name'] */?></option>
                                                <?php /*endforeach; */?>
                                            </select>-->
                                            <input type="text"  class="tpl-form-input" name="data[price]"
                                                   value="<?= $data['price'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="am-form-group sales">
                                        <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                            <button id="btn-submit" type="submit" class="j-submit am-btn am-btn-secondary">提交
                                            </button>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            /*$(function () {

                /!**
                 * 表单验证提交
                 * @type {*}
                 *!/

                $('#my-form').superForm();


            });*/
            $(function () {
                // 表单提交
                var $form = $('#my-form');
                $form.submit(function () {
                    var buy_sales_name  = $('input[name="data[buy_sales_name]').val();
                    var buy_name  = $('input[name="data[buy_name]').val();
                    var price  = $('input[name="data[price]').val();
                    var $btn_submit = $('#btn-submit');
                    $btn_submit.attr("disabled", true);
                    $form.ajaxSubmit({
                        type: "post",
                        dataType: "json",
                        data:{buy_sales_name:buy_sales_name,buy_name:buy_name,price:price},
                        url: "<?= url('setting.sales_order/add') ?>",
                        success: function (result) {
                            $btn_submit.attr('disabled', false);
                            if (result.code === 1) {
                                layer.msg(result.msg, {time: 1500, anim: 1}, function () {
                                    window.location = result.url;
                                });
                                return true;
                            }
                            layer.msg(result.msg, {time: 1500, anim: 6});
                        }
                    });
                    return false;
                });
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
