<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:101:"C:\Users\Administrator\Desktop\glasses\web/../source/application/store\view\new_order\contact\add.php";i:1601120328;s:104:"C:\Users\Administrator\Desktop\glasses\source\application\store\view\layouts\_template\tpl_file_item.php";i:1601114968;s:103:"C:\Users\Administrator\Desktop\glasses\source\application\store\view\layouts\_template\file_library.php";i:1601114968;s:112:"C:\Users\Administrator\Desktop\glasses\source\application\store\view\layouts\_template\contact\glasses_modal.php";i:1601114968;s:117:"C:\Users\Administrator\Desktop\glasses\source\application\store\view\layouts\_template\contact\left_glasses_modal.php";i:1601114968;}*/ ?>
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
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
        BASE_URL = '<?= isset($base_url) ? $base_url : '' ?>';
        STORE_URL = '<?= isset($store_url) ? $store_url : '' ?>';
    </script>

     <!-- import Vue before Element -->
     <script src="https://unpkg.com/vue/dist/vue.js"></script>
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
        <?php  $second = isset($menus[$group]['submenu']) ? $menus[$group]['submenu'] : []; if (!empty($second)) : ?>
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
        <link rel="stylesheet" href="assets/common/plugins/umeditor/themes/default/css/umeditor.css">
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">
                        <form  onsubmit="return false;" id="my-form" class="am-form tpl-form-line-form" method="post">
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">客户信息</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_left">姓名 </label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input   type="text" class="tpl-form-input" name="user_name"
                                                     value="" required>
                                        </div>
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_right" >性别 </label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <label class="am-radio-inline">
                                                <input type="radio" name="sex" value="1" data-am-ucheck checked>
                                                男
                                            </label>
                                            <label class="am-radio-inline" style="float: right">
                                                <input type="radio" name="sex" value="2" data-am-ucheck
                                                >
                                                女
                                            </label>
                                        </div>
                                    </div>
                                    <!--<div class="am-form-group">

                                    </div>-->
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_left">年龄</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input   type="text" class="tpl-form-input" name="years"
                                                     value="" required>
                                        </div>

                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_right">生日</label>
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
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_left">电话</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input id='phone' type="text" class="tpl-form-input" name="mobile"
                                                   value="" required>
                                        </div>

                                    </div>





                                    <!-- 商品信息 -->
                                    <div id='app'>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">商品信息</div>
                                    </div>
                                    <div class="am-scrollable-horizontal goodsinfo" >
                                        <table class="regional-table am-table am-table-bordered am-table-centered
                            am-text-nowrap am-margin-bottom-xs" style="table-layout: fixed">
                                            <tbody class="info">
                                            <tr>
                                                <th>商品名称</th>
                                                <th colspan="6" style="width: 35%">品牌</th>
                                                <!-- <th>到期时间</th> -->
                                                <th>数量</th>
                                                <th>价格</th>
                                            </tr>

                                            <tr>
                                                <td rowspan="2"><div class="am-u-sm-9 am-u-end">隐形眼镜</div></td>
                                                <td>
                                                    右眼：
                                                </td>
                                                <td colspan="5" width="35%"><div class="am-u-sm-9 am-u-end">
                                                        <!--<input type="text" style="float: left;width: 70%" class="tpl-form-input" name="frame"
                                                               value="" required>-->
                                                        <input id="contactBrandInfo" style="float: left;width: 70%;display: none" readonly type="text" class="tpl-form-input" name="contact"
                                                               value="">
                                                        <input id="right_contact_specification_id" name="right_contact_specification_id" type="text" style="display: none">
                                                        <button id="contactBtn"  type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myContactModal">选规格</button>
                                                    </div></td>

                                                <!-- <td width="15%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="text" id="contact_end_time" class="tpl-form-input" name="contact_end_time"
                                                               value="">
                                                    </div></td> -->
                                                <td width="15%"><div class="am-u-sm-9 am-u-end">
                                                        <input  id="contact_num" min="0" type="number" class="tpl-form-input" name="contact_num"
                                                                value="" @change='change' v-model='contact_num'>
                                                    </div></td>
                                                <td><div class="am-u-sm-9 am-u-end">
                                                        <input id="contactPriceMax" type="number" min="0" class="tpl-form-input" name="contact_price"
                                                               value="" v-model='contactPriceMax' @change='change'>
                                                    </div></td>


                                            </tr>
                                            <tr>
                                                <td>
                                                    左眼：
                                                </td>
                                                <td colspan="5" width="35%"><div class="am-u-sm-9 am-u-end">
                                                        <!--<input type="text" style="float: left;width: 70%" class="tpl-form-input" name="frame"
                                                               value="" required>-->
                                                        <input id="left_contactBrandInfo" style="float: left;width: 70%;display: none" readonly type="text" class="tpl-form-input" name="left_contact"
                                                               value="">
                                                        <input id="left_contact_specification_id" name="left_contact_specification_id" type="text" style="display: none">
                                                        <button id="left_contactBtn"  type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myLeftContactModal">选规格</button>
                                                    </div></td>

                                                <!-- <td width="15%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="text" id="left_contact_end_time" class="tpl-form-input" name="left_contact_end_time"
                                                               value="">
                                                    </div></td> -->
                                                <td width="15%"><div class="am-u-sm-9 am-u-end">
                                                        <input  id="left_contact_num" min="0" type="number" class="tpl-form-input" name="left_contact_num"
                                                                value="" v-model='left_contact_num' @change='change'>
                                                    </div></td>
                                                <td><div class="am-u-sm-9 am-u-end">
                                                        <input id="left_contactPriceMax" type="number" min="0" class="tpl-form-input" name="left_contact_price"
                                                               value="" v-model='left_contactPriceMax' @change='change'>
                                                    </div></td>


                                            </tr>
                                            <tr>
                                                <td>护理液</td>
                                                <td colspan="6"><div class="am-u-sm-9 am-u-end">
                                                        <input type="text" class="tpl-form-input" name="contact_solution"
                                                               value="">
                                                    </div></td>

                                                <!-- <td ><div class="am-u-sm-9 am-u-end">
                                                        <input type="text" id="solution_end_time" class="tpl-form-input" name="solution_end_time"
                                                               value="">
                                                    </div></td> -->

                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input   min="0" type="number" class="tpl-form-input" name="solution_num"
                                                                value="" v-model='num' @change='change'>
                                                    </div></td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input  type="number" min="0" class="tpl-form-input" name="solution_price"
                                                               value="" v-model='jiage' @change='change'>
                                                    </div></td>


                                            </tr>

                                            <tr>
                                                <td width="25%">隐形镜盒</td>
                                                <td colspan="6"><div class="am-u-sm-9 am-u-end">
                                                        <input type="text" class="tpl-form-input" name="contact_les"
                                                               value="">
                                                    </div></td>

                                                <!-- <td ><div class="am-u-sm-9 am-u-end">
                                                        <input type="text" id="contact_les_end_time" class="tpl-form-input" name="contact_les_end_time"
                                                               value="">
                                                    </div></td> -->
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input   min="0" type="number" class="tpl-form-input" name="contact_les_num"
                                                                value="" v-model='num2' @change='change'>
                                                    </div></td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input  type="number" min="0" class="tpl-form-input" name="contact_les_price"
                                                               value="" v-model='jiage2' @change='change'>
                                                    </div></td>


                                            </tr>

                                            <tr>
                                                <td>合计</td>
                                                <td colspan="6">
                                                    <div class="am-u-sm-9 am-u-end">
                                                        <input readonly type="text" class="tpl-form-input"
                                                               value="" v-model='add'>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    </div>


                                    <?php
                                    use app\store\model\setting\SalesModel as SalesListModel;
                                    use think\Session;
                                    use think\db;
                                    $salesModel = new SalesListModel;
                                    $admin_info = Session::get('yoshop_store')['user'];
                                    $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
                                    $salesList = $salesModel->getListByType($user_info['user_id'],0);
                                    //                                                    dump($salesList);die();
                                    $optometryList = $salesModel->getListByType($user_info['user_id'],1);
                                    $workingList = $salesModel->getListByType($user_info['user_id'],2);
                                    $cashList = $salesModel->getListByType($user_info['user_id'],3);

                                    ?>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">服务人员</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_left">销售员</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <select  name="sales" class="selectpicker1 show-tick form-control"  data-live-search="false">
                                                <?php
                                                if (!$salesList->isEmpty()): foreach ($salesList as $order):
                                                    ?>

                                                    <option value="<?=$order['sales_name'] ?>"><?=$order['sales_name'] ?></option>


                                                <?php endforeach; endif; ?>
                                            </select>
                                        </div>



                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_right">验光师</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <select  name="optometry" class="selectpicker1 show-tick form-control"  data-live-search="false">
                                                <?php
                                                if (!$optometryList->isEmpty()): foreach ($optometryList as $order):
                                                    ?>

                                                    <option value="<?=$order['sales_name'] ?>"><?=$order['sales_name'] ?></option>


                                                <?php endforeach; endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_left">加工师</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <select  name="working" class="selectpicker1 show-tick form-control"  data-live-search="false">
                                                <?php
                                                if (!$workingList->isEmpty()): foreach ($workingList as $order):
                                                    ?>

                                                    <option value="<?=$order['sales_name'] ?>"><?=$order['sales_name'] ?></option>


                                                <?php endforeach; endif; ?>
                                            </select>
                                        </div>
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_right">收银员</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <select  name="cash" class="selectpicker1 show-tick form-control"  data-live-search="false">
                                                <?php
                                                if (!$cashList->isEmpty()): foreach ($cashList as $order):
                                                    ?>

                                                    <option value="<?=$order['sales_name'] ?>"><?=$order['sales_name'] ?></option>


                                                <?php endforeach; endif; ?>
                                            </select>
                                        </div>
                                    </div>




                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">备注</div>
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-u-sm-8 am-u-end">
                                            <textarea style="width: 101%;text-align: unset;"   class="tpl-form-input" name="notes"></textarea>
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
        <script id="tpl-file-item" type="text/template">
    {{ each list }}
    <div class="file-item">
        <a href="{{ $value.file_path }}" title="点击查看大图" target="_blank">
            <img src="{{ $value.file_path }}">
        </a>
        <input type="hidden" name="{{ name }}" value="{{ $value.file_id }}">
        <i class="iconfont icon-shanchu file-item-delete"></i>
    </div>
    {{ /each }}
</script>




        <!-- 文件库弹窗 -->
        <!-- 文件库模板 -->
<script id="tpl-file-library" type="text/template">
    <div class="row">
        <div class="file-group">
            <ul class="nav-new">
                <li class="ng-scope {{ is_default ? 'active' : '' }}" data-group-id="-1">
                    <a class="group-name am-text-truncate" href="javascript:void(0);" title="全部">全部</a>
                </li>
                <li class="ng-scope" data-group-id="0">
                    <a class="group-name am-text-truncate" href="javascript:void(0);" title="未分组">未分组</a>
                </li>
                {{ each group_list }}
                <li class="ng-scope"
                    data-group-id="{{ $value.group_id }}" title="{{ $value.group_name }}">
                    <a class="group-edit" href="javascript:void(0);" title="编辑分组">
                        <i class="iconfont icon-bianji"></i>
                    </a>
                    <a class="group-name am-text-truncate" href="javascript:void(0);">
                        {{ $value.group_name }}
                    </a>
                    <a class="group-delete" href="javascript:void(0);" title="删除分组">
                        <i class="iconfont icon-shanchu1"></i>
                    </a>
                </li>
                {{ /each }}
            </ul>
            <a class="group-add" href="javascript:void(0);">新增分组</a>
        </div>
        <div class="file-list">
            <div class="v-box-header am-cf">
                <div class="h-left am-fl am-cf">
                    <div class="am-fl">
                        <div class="group-select am-dropdown">
                            <button type="button" class="am-btn am-btn-sm am-btn-secondary am-dropdown-toggle">
                                移动至 <span class="am-icon-caret-down"></span>
                            </button>
                            <ul class="group-list am-dropdown-content">
                                <li class="am-dropdown-header">请选择分组</li>
                                {{ each group_list }}
                                <li>
                                    <a class="move-file-group" data-group-id="{{ $value.group_id }}"
                                       href="javascript:void(0);">{{ $value.group_name }}</a>
                                </li>
                                {{ /each }}
                            </ul>
                        </div>
                    </div>
                    <div class="am-fl tpl-table-black-operation">
                        <a href="javascript:void(0);" class="file-delete tpl-table-black-operation-del"
                           data-group-id="2">
                            <i class="am-icon-trash"></i> 删除
                        </a>
                    </div>
                </div>
                <div class="h-rigth am-fr">
                    <div class="j-upload upload-image">
                        <i class="iconfont icon-add1"></i>
                        上传图片
                    </div>
                </div>
            </div>
            <div id="file-list-body" class="v-box-body">
                {{ include 'tpl-file-list' file_list }}
            </div>
            <div class="v-box-footer am-cf"></div>
        </div>
    </div>

</script>

<!-- 文件列表模板 -->
<script id="tpl-file-list" type="text/template">
    <ul class="file-list-item">
        {{ include 'tpl-file-list-item' data }}
    </ul>
    {{ if last_page > 1 }}
    <div class="file-page-box am-fr">
        <ul class="pagination">
            {{ if current_page > 1 }}
            <li>
                <a class="switch-page" href="javascript:void(0);" title="上一页" data-page="{{ current_page - 1 }}">«</a>
            </li>
            {{ /if }}
            {{ if current_page < last_page }}
            <li>
                <a class="switch-page" href="javascript:void(0);" title="下一页" data-page="{{ current_page + 1 }}">»</a>
            </li>
            {{ /if }}
        </ul>
    </div>
    {{ /if }}
</script>

<!-- 文件列表模板 -->
<script id="tpl-file-list-item" type="text/template">
    {{ each $data }}
    <li class="ng-scope" title="{{ $value.file_name }}" data-file-id="{{ $value.file_id }}"
        data-file-path="{{ $value.file_path }}">
        <div class="img-cover"
             style="background-image: url('{{ $value.file_path }}')">
        </div>
        <p class="file-name am-text-center am-text-truncate">{{ $value.file_name }}</p>
        <div class="select-mask">
            <img src="assets/store/img/chose.png">
        </div>
    </li>
    {{ /each }}
</script>

<!-- 分组元素-->
<script id="tpl-group-item" type="text/template">
    <li class="ng-scope" data-group-id="{{ group_id }}" title="{{ group_name }}">
        <a class="group-edit" href="javascript:void(0);" title="编辑分组">
            <i class="iconfont icon-bianji"></i>
        </a>
        <a class="group-name am-text-truncate" href="javascript:void(0);">
            {{ group_name }}
        </a>
        <a class="group-delete" href="javascript:void(0);" title="删除分组">
            <i class="iconfont icon-shanchu1"></i>
        </a>
    </li>
</script>

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
            
            const that=this
            function isPhone(str) {
                let reg = /^((0\d{2,3}-\d{7,8})|(1[3456789]\d{9}))$/;
                return reg.test(str);
            }
            $('#btn-submit').click(function() {
                var value=$("#phone").val()
                var flag=that.isPhone(value)
                if(flag&&value!=''){
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
                }else if(value!=''){
                    layer.msg('您输入的手机号格式不符合要求！', {time: 1500, anim: 6});
                }
            })
        </script>
    </div>
</div>

<?php


//use think\Session;

$admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
$contact_brand = Db::name('contact_brand')->where('is_delete',0)->where('user_id',$admin_info['user_id'])->select();
?>


<div class="modal fade" id="myContactModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">隐形眼镜规格选择</h4>
            </div>
            <div class="modal-body">

                <form>
                    <div class="form-group contact-form-group">
                        <label for="recipient-name" class="control-label">隐形眼镜品牌:</label>
                        <select onchange="contact_brandChange(1)" id="contact_brand" name="data[contact_brand]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择品牌</option>
                            <?php foreach ($contact_brand as $value): ?>
                                <option value="<?=$value['brand_id'] ?>"><?=$value['brand_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group contact-form-group">
                        <label for="recipient-name" class="control-label">隐形眼镜类型:</label>
                        <select onchange="contact_typeChange(2)" id="contact_type" name="data[contact_type]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="null">请选择类型</option>
                            <option value="0">球面</option>
                            <option value="1">非球面</option>
                        </select>
                    </div>

                    <div class="form-group contact-form-group">
                        <label for="recipient-name" class="control-label">隐形眼镜型号:</label>
                        <select onchange="contact_modelChange(3)"  id="contact_model" name="data[contact_model]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择型号</option>
                        </select>
                    </div>
                    <div class="form-group contact-form-group">
                        <label for="recipient-name" class="control-label">隐形眼镜颜色:</label>
                        <select onchange="contact_colorChange(4)"  id="contact_color" name="data[contact_color]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择颜色</option>
                        </select>
                    </div>
                    <div class="form-group contact-form-group">
                        <label for="recipient-name" class="control-label">隐形眼镜度数:</label>
                        <select onchange="contact_degreeChange()" id="contact_degree" name="data[contact_degree]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="">请选择度数</option>
                            <?php for ($i = 0 ;$i <= 1000 ;$i +=25) :?>
                                <option value="<?=$i ?>"><?=$i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <!--<div class="form-group">
                        <label class="col-sm-3 control-label">镜片标准库存：</label>
                        <input type="text" class="form-control" id="standard_inventory">
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">镜片现有库存：</label>
                        <input type="text" class="form-control" id="now_inventory">
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">镜片单价：</label>
                        <input type="text" class="form-control" id="price">
                    </div>-->

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button onclick="submit_contact()" id="contact_submit" type="button"  class="btn btn-primary ">选定</button>
            </div>
        </div>
    </div>
</div>
<script>

    var contact_brand = $('#contact_brand  option:selected').val();
    var contact_btn = $('#contact_submit');
    var contact_type = $('#contact_type  option:selected').val();
    var selectInfo = $('.contact-form-group').find('select');

    $('#contactBtn').click(function () {
        var contact_brand = $('#contact_brand  option:selected').val();
        var selectInfo = $('.contact-form-group').find('select');
        var contact_btn = $('#contact_submit');
        if (contact_brand==0){
            selectInfo.find('option:selected').attr('selected',false);
            selectInfo.disabled=true;
            for (var i = 1 ; i < selectInfo.length; i ++) {
                contact_btn.attr('disabled',true);
                contact_btn.css({'background-color' : 'gray'});
                selectInfo[i].disabled = true;

            }
        }
    })
    function contact_brandChange(i) {
        var selectInfo = $('.contact-form-group').find('select');
        var contact_brand = $('#contact_brand  option:selected').val();
        if (contact_brand != 0){
            selectInfo[i].disabled =false;
        }else {
            selectInfo[i].disabled =true;
        }
    }
    function contact_typeChange(i) {
        var selectInfo = $('.contact-form-group').find('select');
        var contact_brand = $('#contact_brand  option:selected').val();
        var contact_type = $('#contact_type  option:selected').val();
        var j = i;
        if (!isNaN(contact_type)){
            $('#contact_type').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.contact.model/getmodel',
                data:{contact_type:contact_type,contact_brand:contact_brand},
                success: function (result) {
                    // console.log(result);return;
                    $("#contact_model").empty();
                    $("#contact_model").append("<option value='0'>请选择型号</option>");
                    if (result.data.length != 0 ){
                        for (var i = 0 ;i < result.data.length;i++){
                            // console.log(result.data[i]['model_id']);return;
                            $("#contact_model").append("<option value='"+result.data[i]['model_id']+"'>"+result.data[i]['model']+"</option>");
                        }
                        selectInfo[j].disabled =false;
                    }else{
                        layer.msg('暂无数据', {time: 1500, anim: 6});
                        selectInfo[j].disabled =true;
                    }

                }
            });


        }else {
            selectInfo[i].disabled =true;
        }
    }
    function contact_modelChange(i) {
        var selectInfo = $('.contact-form-group').find('select');
        var contact_brand = $('#contact_brand  option:selected').val();
        var contact_type = $('#contact_type  option:selected').val();
        var contact_model = $('#contact_model  option:selected').val();
        var j = i;
        if (contact_model != 0){
            $('#contact_model').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.contact.color/getcolor',
                data:{contact_type:contact_type,contact_brand:contact_brand,contact_model:contact_model},
                success: function (result) {
                    $("#contact_color").empty();
                    $("#contact_color").append("<option value='0'>请选择颜色</option>");
                    if (result.data.length != 0 ){
                        for (var i = 0 ;i < result.data.length;i++){
                            $("#contact_color").append("<option value='"+result.data[i]['color_id']+"'>"+result.data[i]['color']+"</option>");
                        }
                        selectInfo[j].disabled =false;
                    }else{
                        layer.msg('暂无数据', {time: 1500, anim: 6});
                        selectInfo[j].disabled =true;
                    }

                }
            });


        }else {
            selectInfo[i].disabled =true;
        }
    }
    function contact_colorChange(i) {
        var selectInfo = $('.contact-form-group').find('select');
        var contact_brand = $('#contact_brand  option:selected').val();
        var contact_type = $('#contact_type  option:selected').val();
        var contact_color = $('#contact_color  option:selected').val();
        if (contact_color != 0){
            selectInfo[i].disabled =false;
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function contact_degreeChange() {
        var contact_btn = $('#contact_submit');
        var contact_degree = $('#contact_degree  option:selected').val();
        if (contact_degree != 0){

            contact_btn.attr('disabled',false);
            contact_btn.css({'background-color' : '#337ab7'});
        }
        else {
            contact_btn.attr('disabled',true);
            contact_btn.css({'background-color' : 'gray'});
        }
    }
    function submit_contact(){
        var contact_brand = $('#contact_brand  option:selected').val();
        var contact_btn = $('#contact_submit');
        var contact_type = $('#contact_type  option:selected').val();
        var selectInfo = $('.contact-form-group').find('select');
        var contact_degree = $('#contact_degree  option:selected').val();
        var contact_model = $('#contact_model  option:selected').val();
        var contact_color = $('#contact_color  option:selected').val();

        var l = '';
        if(contact_type == 0){
            l = '球面';
        }else {
            l = '非球面';
        }

        contact_btn.attr('disabled',true);
        contact_btn.css({'background-color' : 'gray'});
        $('#contact_submit').ajaxSubmit({
            type: "post",
            dataType: "json",
            url: 'index.php?s=/store/inventory.contact.specification/getspecification',
            data:{contact_type:contact_type,contact_brand:contact_brand,contact_model:contact_model,contact_degree:contact_degree,contact_color:contact_color},
            success: function (result) {
                if (result.data.length != 0 ){
                    for (var i = 0 ;i < result.data.length;i++){
                        var data = [
                            result.data[i].brand_name+'—'+
                            l+'—'+
                            result.data[i].model+'—'+
                            result.data[i].degree+'—'+
                            result.data[i].color

                        ];
                        var ids = result.data[i].specification_id;
                        // console.log(ids);return;
                        console.log(data);
                        $("#right_contact_specification_id").val(ids);
                        $("#contactBrandInfo").val(data);
                        $("#contactBrandInfo").attr('readonly',true);
                        $("#contactBrandInfo").css('display','block');
                        $("#contactBtn").css('float','right');
                        $('#contact_num').attr('max',result.data[i].now_inventory);

                        $('.close').click();
                        console.log(result.data[i]);

                    }
                }else{
                    layer.msg('暂无记录，请先添加！', {time: 1500, anim: 6});
                    contact_btn.attr('disabled',false);
                    contact_btn.css({'background-color' : '#337ab7'});
                }

            }
        });
    }


</script>


<?php


$admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
$contact_brand = Db::name('contact_brand')->where('is_delete',0)->where('user_id',$admin_info['user_id'])->select();
?>


<div class="modal fade" id="myLeftContactModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">隐形眼镜规格选择</h4>
            </div>
            <div class="modal-body">

                <form>
                    <div class="form-group left_contact-form-group">
                        <label for="recipient-name" class="control-label">隐形眼镜品牌:</label>
                        <select onchange="left_contact_brandChange(1)" id="left_contact_brand" name="data[contact_brand]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择品牌</option>
                            <?php foreach ($contact_brand as $value): ?>
                                <option value="<?=$value['brand_id'] ?>"><?=$value['brand_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group left_contact-form-group">
                        <label for="recipient-name" class="control-label">隐形眼镜类型:</label>
                        <select onchange="left_contact_typeChange(2)" id="left_contact_type" name="data[contact_type]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="null">请选择类型</option>
                            <option value="0">球面</option>
                            <option value="1">非球面</option>
                        </select>
                    </div>

                    <div class="form-group left_contact-form-group">
                        <label for="recipient-name" class="control-label">隐形眼镜型号:</label>
                        <select onchange="left_contact_modelChange(3)"  id="left_contact_model" name="data[contact_model]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择型号</option>
                        </select>
                    </div>
                    <div class="form-group left_contact-form-group">
                        <label for="recipient-name" class="control-label">隐形眼镜颜色:</label>
                        <select onchange="left_contact_colorChange(4)"  id="left_contact_color" name="data[contact_color]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择颜色</option>
                        </select>
                    </div>
                    <div class="form-group left_contact-form-group">
                        <label for="recipient-name" class="control-label">隐形眼镜度数:</label>
                        <select onchange="left_contact_degreeChange()" id="left_contact_degree" name="data[contact_degree]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="">请选择度数</option>
                            <?php for ($i = 0 ;$i <= 1000 ;$i +=25) :?>
                                <option value="<?=$i ?>"><?=$i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <!--<div class="form-group">
                        <label class="col-sm-3 control-label">镜片标准库存：</label>
                        <input type="text" class="form-control" id="standard_inventory">
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">镜片现有库存：</label>
                        <input type="text" class="form-control" id="now_inventory">
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">镜片单价：</label>
                        <input type="text" class="form-control" id="price">
                    </div>-->

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button onclick="left_submit_contact()" id="left_contact_submit" type="button"  class="btn btn-primary ">选定</button>
            </div>
        </div>
    </div>
</div>

<script>

    var contact_brand = $('#left_contact_brand  option:selected').val();
    var contact_btn = $('#left_contact_submit');
    var contact_type = $('#left_contact_type  option:selected').val();
    var selectInfo = $('.left_contact-form-group').find('select');

    $('#left_contactBtn').click(function () {
        var contact_brand = $('#left_contact_brand  option:selected').val();
        var selectInfo = $('.left_contact-form-group').find('select');
        var contact_btn = $('#left_contact_submit');
        if (contact_brand==0){
            selectInfo.find('option:selected').attr('selected',false);
            selectInfo.disabled=true;
            for (var i = 1 ; i < selectInfo.length; i ++) {
                contact_btn.attr('disabled',true);
                contact_btn.css({'background-color' : 'gray'});
                selectInfo[i].disabled = true;

            }
        }
    })
    function left_contact_brandChange(i) {
        var selectInfo = $('.left_contact-form-group').find('select');
        var contact_brand = $('#left_contact_brand  option:selected').val();
        if (contact_brand != 0){
            selectInfo[i].disabled =false;
        }else {
            selectInfo[i].disabled =true;
        }
    }

    function left_contact_typeChange(i) {
        var selectInfo = $('.left_contact-form-group').find('select');
        var contact_brand = $('#left_contact_brand  option:selected').val();
        var contact_type = $('#left_contact_type  option:selected').val();
        var j = i;
        if (!isNaN(contact_type)){
            $('#left_contact_type').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.contact.model/getmodel',
                data:{contact_type:contact_type,contact_brand:contact_brand},
                success: function (result) {
                    $("#left_contact_model").empty();
                    $("#left_contact_model").append("<option value='0'>请选择型号</option>");
                    if (result.data.length != 0 ){
                        for (var i = 0 ;i < result.data.length;i++){
                            $("#left_contact_model").append("<option value='"+result.data[i]['model_id']+"'>"+result.data[i]['model']+"</option>");
                        }
                        selectInfo[j].disabled =false;
                    }else{
                        layer.msg('暂无数据', {time: 1500, anim: 6});
                        selectInfo[j].disabled =true;
                    }

                }
            });


        }else {
            selectInfo[i].disabled =true;
        }
    }
    function left_contact_modelChange(i) {
        var selectInfo = $('.left_contact-form-group').find('select');
        var contact_brand = $('#left_contact_brand  option:selected').val();
        var contact_type = $('#left_contact_type  option:selected').val();
        var contact_model = $('#left_contact_model  option:selected').val();
        var j = i;
        if (contact_model != 0){
            $('#left_contact_model').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.contact.color/getcolor',
                data:{contact_type:contact_type,contact_brand:contact_brand,contact_model:contact_model},
                success: function (result) {
                    $("#left_contact_color").empty();
                    $("#left_contact_color").append("<option value='0'>请选择颜色</option>");
                    if (result.data.length != 0 ){
                        for (var i = 0 ;i < result.data.length;i++){
                            $("#left_contact_color").append("<option value='"+result.data[i]['color_id']+"'>"+result.data[i]['color']+"</option>");
                        }
                        selectInfo[j].disabled =false;
                    }else{
                        layer.msg('暂无数据', {time: 1500, anim: 6});
                        selectInfo[j].disabled =true;
                    }

                }
            });


        }else {
            selectInfo[i].disabled =true;
        }
    }
    function left_contact_colorChange(i) {
        var selectInfo = $('.left_contact-form-group').find('select');
        var contact_brand = $('#left_contact_brand  option:selected').val();
        var contact_type = $('#left_contact_type  option:selected').val();
        var contact_color = $('#left_contact_color  option:selected').val();
        if (contact_color != 0){
            selectInfo[i].disabled =false;
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function left_contact_degreeChange() {
        var contact_btn = $('#left_contact_submit');
        var contact_degree = $('#left_contact_degree  option:selected').val();
        if (contact_degree != 0){

            contact_btn.attr('disabled',false);
            contact_btn.css({'background-color' : '#337ab7'});
        }
        else {
            contact_btn.attr('disabled',true);
            contact_btn.css({'background-color' : 'gray'});
        }
    }
    function left_submit_contact(){
        var contact_brand = $('#left_contact_brand  option:selected').val();
        var contact_btn = $('#left_contact_submit');
        var contact_type = $('#left_contact_type  option:selected').val();
        var selectInfo = $('.left_contact-form-group').find('select');
        var contact_degree = $('#left_contact_degree  option:selected').val();
        var contact_model = $('#left_contact_model  option:selected').val();
        var contact_color = $('#left_contact_color  option:selected').val();

        var l = '';
        if(contact_type == 0){
            l = '球面';
        }else {
            l = '非球面';
        }

        contact_btn.attr('disabled',true);
        contact_btn.css({'background-color' : 'gray'});
        $('#left_contact_submit').ajaxSubmit({
            type: "post",
            dataType: "json",
            url: 'index.php?s=/store/inventory.contact.specification/getspecification',
            data:{contact_type:contact_type,contact_brand:contact_brand,contact_model:contact_model,contact_degree:contact_degree,contact_color:contact_color},
            success: function (result) {
                if (result.data.length != 0 ){
                    for (var i = 0 ;i < result.data.length;i++){
                        var data = [
                            result.data[i].brand_name+'—'+
                            l+'—'+
                            result.data[i].model+'—'+
                            result.data[i].degree+'—'+
                            result.data[i].color

                        ];
                        var ids = result.data[i].specification_id;
                        $("#left_contact_specification_id").val(ids);
                        // console.log(ids);return;
                        console.log(data);
                        $("#left_contactBrandInfo").val(data);
                        $("#left_contactBrandInfo").attr('readonly',true);
                        $("#left_contactBrandInfo").css('display','block');
                        $("#left_contactBtn").css('float','right');
                        $('#left_contact_num').attr('max',result.data[i].now_inventory);

                        $('.close').click();
                        console.log(result.data[i]);

                    }
                }else{
                    layer.msg('暂无记录，请先添加！', {time: 1500, anim: 6});
                    contact_btn.attr('disabled',false);
                    contact_btn.css({'background-color' : '#337ab7'});
                }

            }
        });
    }


</script>

<!-- 内容区域 end -->
<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;

        //常规用法contact_end_time
        laydate.render({
            elem: '#test1',
            trigger:'click'
        });
        laydate.render({
            elem: '#contact_end_time',
            trigger:'click'
        });
        laydate.render({
            elem: '#left_contact_end_time',
            trigger:'click'
        });
        laydate.render({
            elem: '#solution_end_time',
            trigger:'click'
        });
        laydate.render({
            elem: '#contact_les_end_time',
            trigger:'click'
        });



    });
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css" />

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js" ></script>
<script>
    $(function () {
        $('.selectpicker').select2({
            allowClear: true,
            dropdownAutoWidth : true,
            width: '568'
        });
    })
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

<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                contact_num:'',
                contactPriceMax:'',
                left_contact_num:'',
                left_contactPriceMax:'',
                num:'',
                jiage:'',
                num2:'',
                jiage2:'',
                add:''

            }
        },
        methods:{
            change(){
                this.add=Number(this.contact_num)*Number(this.contactPriceMax)+Number(this.left_contact_num)*Number(this.left_contactPriceMax)+Number(this.num)*Number(this.jiage)+Number(this.num2)*Number(this.jiage2)
                console.log(this.add)
            }
        }
    });
</script>

