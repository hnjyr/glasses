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
    <link rel="stylesheet" href="assets/layui/css/layui.css"/>
    <script src="assets/layui/layui.all.js"></script>
    <script src="assets/common/plugins/laydate/laydate.js"></script>
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
        <?php  $second = isset($menus[$group]['submenu']) ? $menus[$group]['submenu'] : []; ?>
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
        <link rel="stylesheet" href="assets/common/plugins/umeditor/themes/default/css/umeditor.css">
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">
                        <form id="my-form" class="am-form tpl-form-line-form" method="post">
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">客户信息</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require">姓名 </label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input   type="text" class="tpl-form-input" name="user_name"
                                                     value="" required>
                                        </div>
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require">性别 </label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <label class="am-radio-inline">
                                                <input type="radio" name="sex" value="1" data-am-ucheck checked>
                                                男
                                            </label>
                                            <label class="am-radio-inline">
                                                <input type="radio" name="sex" value="2" data-am-ucheck
                                                >
                                                女
                                            </label>
                                        </div>
                                    </div>
                                    <!--<div class="am-form-group">

                                    </div>-->
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require">年龄</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input   type="text" class="tpl-form-input" name="years"
                                                     value="" required>
                                        </div>

                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require">生日</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input type="text" id="test1" class="am-form-field tpl-form-input" name="birthday"
                                                   value=""  placeholder="请选择日期，如2020-01-01">
                                        </div>
                                    </div>
                                    <!--<div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">电话</label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="text" class="tpl-form-input" name="mobile"
                                                   value="" required>
                                        </div>
                                    </div>-->

                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require">电话</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input type="text" class="tpl-form-input" name="mobile"
                                                   value="" required>
                                        </div>

                                    </div>


                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">眼镜信息</div>
                                    </div>
                                    <div class="am-form-group" style="margin-left: 80px;">
                                        <table  class="am-u-sm-8 am-u-lg-8"    style=" border-color:grey">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th style="text-align: center">球镜</th>
                                                <th  style="text-align: center">柱镜</th>
                                                <th style="text-align: center">轴线</th>
                                                <th style="text-align: center">ADD</th>
                                                <th style="text-align: center">瞳距</th>

                                            </tr>
                                            <tr>
                                                <th width="100" style="text-align: center">左眼</th>
                                                <th><input type="text" class="tpl-form-input" name="left_ball_mirror"
                                                           value="0" required></th>
                                                <th><input type="text" class="tpl-form-input" name="left_cylinder"
                                                           value="0" required></th>
                                                <th><input type="text" class="tpl-form-input" name="left_axis"
                                                           value="0" required></th>
                                                <th><input type="text" class="tpl-form-input" name="left_add"
                                                           value="0" required></th>
                                                <th><input type="text" class="tpl-form-input" name="distance"
                                                           value="0" required></th>

                                            </tr>
                                            <tr>
                                                <th style="text-align: center">右眼</th>
                                                <th><input type="text" class="tpl-form-input" name="right_ball_mirror"
                                                           value="0" required></th>
                                                <th><input type="text" class="tpl-form-input" name="right_cylinder"
                                                           value="0" required></th>
                                                <th><input type="text" class="tpl-form-input" name="right_axis"
                                                           value="0" required></th>
                                                <th><input type="text" class="tpl-form-input" name="right_add"
                                                           value="0" required></th>
                                                <th><input type="text" class="tpl-form-input" name="distance"
                                                           value="0" required></th>
                                            </tr>
                                            </thead>
                                            <!--<div class="am-u-sm-3 am-u-end" style="float: right;margin-right: 180px;">
                                               瞳距: <input type="text" class="tpl-form-input" name="distance"
                                                   value="" required>
                                            </div>-->
                                        </table>
                                    </div>

                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">服务员人员</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require">销售员</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input type="text" class="tpl-form-input" name="sales"
                                                   value="" required>
                                        </div>
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require">验光师</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input type="text" class="tpl-form-input" name="optometry"
                                                   value="" required>
                                        </div>
                                    </div>
                                    <!--<div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require">验光师</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input type="text" class="tpl-form-input" name="optometry"
                                                   value="" required>
                                        </div>
                                    </div>-->
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require">加工师</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input type="text" class="tpl-form-input" name="working"
                                                   value="" required>
                                        </div>
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require">收银员</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input type="text" class="tpl-form-input" name="cash"
                                                   value="" required>
                                        </div>
                                    </div>
                                    <!--<div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">收银员</label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="text" class="tpl-form-input" name="cash"
                                                   value="" required>
                                        </div>
                                    </div>-->
                                    <!--<div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">经手人</label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="text" class="tpl-form-input" name="handle"
                                                   value="" required>
                                        </div>
                                    </div>-->
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require">检验员</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input type="text" class="tpl-form-input" name="inspectors"
                                                   value="" required>
                                        </div>
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require">是否合格</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <label class="am-radio-inline">
                                                <input type="radio" name="test" value="0" data-am-ucheck checked>
                                                合格
                                            </label>
                                            <label class="am-radio-inline">
                                                <input type="radio" name="test" value="1" data-am-ucheck
                                                >
                                                不合格
                                            </label>
                                        </div>
                                    </div>
                                    <!--<div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">是否合格</label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <label class="am-radio-inline">
                                                <input type="radio" name="test" value="0" data-am-ucheck checked>
                                                合格
                                            </label>
                                            <label class="am-radio-inline">
                                                <input type="radio" name="test" value="1" data-am-ucheck
                                                >
                                                不合格
                                            </label>
                                        </div>
                                    </div>-->

                                    <!-- 商品信息 -->
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">商品信息</div>
                                    </div>
                                    <div class="am-scrollable-horizontal ">
                                        <table class="regional-table am-table am-table-bordered am-table-centered
                            am-text-nowrap am-margin-bottom-xs">
                                            <tbody class="info">
                                            <tr>
                                                <th>商品名称</th>
                                                <th>型号</th>
                                                <th>数量</th>
                                                <th>价格</th>
                                            </tr>


                                            <tr>
                                                <td>眼睛框</td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="text" class="tpl-form-input" name="frame"
                                                               value="" required>
                                                    </div></td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="number" class="tpl-form-input" name="frame_num"
                                                               value="0" required>
                                                    </div></td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="number" class="tpl-form-input" name="frame_price"
                                                               value="0" required>
                                                    </div></td>


                                            </tr>
                                            <tr>
                                                <td>眼睛布</td>
                                                <td width="25%">无</td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="number" class="tpl-form-input" name="glasses_cloth_num"
                                                               value="0" required>
                                                    </div></td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="number" class="tpl-form-input" name="glasses_cloth_price"
                                                               value="0" required>
                                                    </div></td>


                                            </tr>
                                            <tr>
                                                <td>眼睛片</td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="text" class="tpl-form-input" name="lens"
                                                               value="" required>
                                                    </div></td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="number" class="tpl-form-input" name="lens_num"
                                                               value="0" required>
                                                    </div></td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="number" class="tpl-form-input" name="lens_price"
                                                               value="0" required>
                                                    </div></td>

                                            </tr>
                                            <tr>
                                                <td width="25%">眼睛盒</td>
                                                <td width="25%">无</td>
                                                <td width="25%"> <div class="am-u-sm-9 am-u-end">
                                                        <input type="number" class="tpl-form-input" name="glasses_case_num"
                                                               value="0" required>
                                                    </div></td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="number" class="tpl-form-input" name="glasses_case_price"
                                                               value="0" required>
                                                    </div></td>


                                            </tr>
                                            <tr>
                                                <td>隐形</td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="text" class="tpl-form-input" name="contact_lens"
                                                               value="" >
                                                    </div></td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="number" class="tpl-form-input" name="contact_lens_num"
                                                               value="0" >
                                                    </div></td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="number" class="tpl-form-input" name="contact_lens_price"
                                                               value="0" >
                                                    </div><?php ;?></td>

                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>








                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">其他信息</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require">折扣金额</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input type="number" class="tpl-form-input" name="discount"
                                                   value="0" >
                                        </div>
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require">执行标准</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input type="text" class="tpl-form-input" name="standard"
                                                   value="" required>
                                        </div>
                                    </div>

                                    <!-- <div class="am-form-group">
                                         <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">执行标准</label>
                                         <div class="am-u-sm-9 am-u-end">
                                             <input type="text" class="tpl-form-input" name="standard"
                                                    value="" required>
                                         </div>
                                     </div>-->

                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require">说明</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input type="text" class="tpl-form-input" name="notes"
                                                   value="" required>
                                        </div>
                                    </div>

                                    <!-- 表单提交按钮 -->
                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                            <button type="submit" class="j-submit am-btn am-btn-secondary" id="btn-submit">提交
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

        <!-- 图片文件列表模板 -->
        {{include file="layouts/_template/tpl_file_item" /}}

        <!-- 文件库弹窗 -->
        {{include file="layouts/_template/file_library" /}}
        <script src="assets/common/js/jquery.min.js"></script>
        <script src="assets/common/plugins/layer/layer.js?v=<?= $version ?>"></script>
        <script src="assets/common/js/jquery.form.min.js"></script>
        <script src="assets/common/js/vue.min.js"></script>
        <script src="assets/common/js/ddsort.js"></script>
        <script>

            // $(function () {
            //     /**
            //      * 表单验证提交
            //      * @type {*}
            //      */
            //     $('#my-form').superForm();
            //
            // });
            $(function () {
                // 表单提交
                var $form = $('#my-form');
                $form.submit(function () {
                    var $btn_submit = $('#btn-submit');
                    $btn_submit.attr("disabled", true);
                    $form.ajaxSubmit({
                        type: "post",
                        dataType: "json",
                        // url: '',
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
</div>
<!-- 内容区域 end -->
<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;

        //常规用法
        laydate.render({
            elem: '#test1',
            trigger:'click'
        });



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

