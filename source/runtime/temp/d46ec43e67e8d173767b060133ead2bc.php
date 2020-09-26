<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:101:"C:\Users\Administrator\Desktop\glasses\web/../source/application/store\view\new_order\glasses\add.php";i:1601119706;s:104:"C:\Users\Administrator\Desktop\glasses\source\application\store\view\layouts\_template\tpl_file_item.php";i:1601114968;s:103:"C:\Users\Administrator\Desktop\glasses\source\application\store\view\layouts\_template\file_library.php";i:1601114968;s:110:"C:\Users\Administrator\Desktop\glasses\source\application\store\view\layouts\_template\modal\glasses_modal.php";i:1601114968;s:112:"C:\Users\Administrator\Desktop\glasses\source\application\store\view\layouts\_template\glasses\glasses_modal.php";i:1601114968;s:115:"C:\Users\Administrator\Desktop\glasses\source\application\store\view\layouts\_template\modal\left_glasses_modal.php";i:1601114968;s:117:"C:\Users\Administrator\Desktop\glasses\source\application\store\view\layouts\_template\glasses\left_glasses_modal.php";i:1601114968;s:110:"C:\Users\Administrator\Desktop\glasses\source\application\store\view\layouts\_template\other\glasses_modal.php";i:1601114968;}*/ ?>
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
                        <form onsubmit="return false;" id="my-form" class="am-form tpl-form-line-form" method="post">
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">客户信息</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_left">姓名 </label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input   type="text" class="tpl-form-input" name="user_name"
                                                     value="" required >
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
                                                     value="" required >
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


                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">眼镜信息</div>
                                    </div>
                                    <div class="am-form-group eyes">
                                        <table  class="am-u-sm-8 am-u-lg-8 new_add_table"    style=" border-color:grey">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th style="text-align: center">球镜</th>
                                                <th  style="text-align: center">柱镜</th>
                                                <th style="text-align: center">轴位</th>
                                                <th style="text-align: center">ADD</th>
                                                <th style="text-align: center">瞳高</th>
                                                <th style="text-align: center">棱镜</th>
                                                <th style="text-align: center">矫正视力</th>

                                                <th style="text-align: center">瞳距</th>

                                            </tr>
                                            <tr>
                                                <th style="text-align: center">右眼</th>
                                                <th><input type="text" class="tpl-form-input" name="right_ball_mirror"
                                                           value="" ></th>
                                                <th><input type="text" class="tpl-form-input" name="right_cylinder"
                                                           value="" ></th>
                                                <th><input type="text" class="tpl-form-input" name="right_axis"
                                                           value="" ></th>
                                                <th><input type="text" class="tpl-form-input" name="right_add"
                                                           value="" ></th>
                                                <th><input type="text" class="tpl-form-input" name="right_pupil"
                                                           value="" ></th>
                                                <th><input type="text" class="tpl-form-input" name="right_prism"
                                                           value="" ></th>
                                                <th><input type="text" class="tpl-form-input" name="right_cva"
                                                           value="" ></th>

                                                <th rowspan="2"><input type="text" class="tpl-form-input" name="distance"
                                                                       value="" ></th>
                                            </tr>
                                            <tr>
                                                <th width="100" style="text-align: center">左眼</th>
                                                <th><input type="text" class="tpl-form-input" name="left_ball_mirror"
                                                           value="" ></th>
                                                <th><input type="text" class="tpl-form-input" name="left_cylinder"
                                                           value="" ></th>
                                                <th><input type="text" class="tpl-form-input" name="left_axis"
                                                           value="" ></th>
                                                <th><input type="text" class="tpl-form-input" name="left_add"
                                                           value="" ></th>
                                                <th><input type="text" class="tpl-form-input" name="left_pupil"
                                                           value="" ></th>
                                                <th><input type="text" class="tpl-form-input" name="left_prism"
                                                           value="" ></th>
                                                <th><input type="text" class="tpl-form-input" name="left_cva"
                                                           value="" ></th>



                                            </tr>

                                            </thead>
                                            <!--<div class="am-u-sm-3 am-u-end" style="float: right;margin-right: 180px;">
                                            瞳距: <input type="text" class="tpl-form-input" name="distance"
                                                value="" required>
                                            </div>-->
                                        </table>
                                    </div>



                                    <!-- 商品信息 -->
                                    <div id="app">
                                        <div class="widget-head am-cf">
                                            <div class="widget-title am-fl">商品信息</div>
                                        </div>
                                        <div class="am-scrollable-horizontal goodsinfo">
                                            <table class="regional-table am-table am-table-bordered am-table-centered
                            am-text-nowrap am-margin-bottom-xs" style="table-layout: fixed">
                                                <tbody class="info">
                                                <tr>
                                                    <th>商品名称</th>
                                                    <th colspan="6" width="40%">型号</th>
                                                    <th >数量</th>
                                                    <th>价格</th>
                                                </tr>


                                                <tr>
                                                    <td rowspan="2">镜片</td>
                                                    <td>
                                                        右眼：
                                                    </td>
                                                    <td colspan="5">
                                                        <!-- v-model='brandInfo' -->
                                                        <div class="am-u-sm-9 am-u-end">

                                                            <input id="brandInfo" style="float: left;width: 70%;display: none" readonly type="text" class="tpl-form-input" name="right_frame"
                                                                   value="" >
                                                            <input id="right_specification_id" name="right_specification_id" type="text" style="display: none">
                                                            <button id="brandBtn"  type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">选镜片</button>
                                                        </div>

                                                    </td>
                                                    <td><div class="am-u-sm-9 am-u-end">
                                                            <input  id="now_inventory_num" min="0" type="number" class="tpl-form-input" name="right_frame_num"
                                                                    value="" v-model='now_inventory_num' @change='change'>
                                                        </div></td>
                                                    <td><div class="am-u-sm-9 am-u-end">
                                                            <input id="priceMax" type="number" min="0" class="tpl-form-input" name="right_frame_price"
                                                                   value=""  v-model='priceMax' @change='change'>
                                                        </div></td>


                                                </tr>
                                                <tr>
                                                    <td width="20px">
                                                        左眼：
                                                    </td>
                                                    <td colspan="5">
                                                        <div class="am-u-sm-9 am-u-end">
                                                            <input id="left_brandInfo" style="float: left;width: 70%;display: none" readonly type="text" class="tpl-form-input" name="left_frame"
                                                                   value=""  >
                                                            <input id="left_specification_id" name="left_specification_id" type="text" style="display: none">
                                                            <button id="left_brandBtn"  type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myLeftModal">选镜片</button>
                                                        </div></td>
                                                    <td><div class="am-u-sm-9 am-u-end">
                                                            <input  id="now_left_inventory_num" min="0" type="number" class="tpl-form-input" name="left_frame_num"
                                                                    value="" v-model='now_left_inventory_num' @change='change'>
                                                        </div></td>
                                                    <td><div class="am-u-sm-9 am-u-end">
                                                            <input id="left_priceMax" type="number" min="0" class="tpl-form-input" name="left_frame_price"
                                                                   value="" v-model='left_priceMax' @change='change'>
                                                        </div></td>

                                                </tr>
                                                <tr>
                                                    <td>镜框</td>
                                                    <td colspan="6" width="25%"><div class="am-u-sm-9 am-u-end">
                                                            <input id="glassesInfo" style="float: left;width: 70%;display: none" readonly type="text" class="tpl-form-input" name="right_glasses"
                                                                   value=""  >
                                                            <input id="glasses_specification_id" name="glasses_specification_id" type="text" style="display: none">
                                                            <button id="glassesBtn"  type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myGlassesModal">选镜框</button>
                                                        </div></td>
                                                    <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                            <input id="glasses_num" type="number" class="tpl-form-input" name="right_glasses_cloth_num"
                                                                   value="" @change='change' v-model='glasses_num'>
                                                        </div></td>
                                                    <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                            <input id="glasses_price" type="number" class="tpl-form-input" name="right_glasses_cloth_price"
                                                                   value="" @change='change' v-model='glasses_price'>
                                                        </div></td>


                                                </tr>
                                                <tr>
                                                    <td>镜盒</td>
                                                    <td colspan="6" width="25%"><div class="am-u-sm-9 am-u-end">
                                                            <input type="text" class="tpl-form-input" name="glasses_les"
                                                                   value="" >
                                                        </div></td>
                                                    <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                            <input type="number" class="tpl-form-input" name="glasses_les_num"
                                                                   value="" @change='change' v-model='nums'>
                                                        </div></td>
                                                    <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                            <input type="number" class="tpl-form-input" name="glasses_les_price"
                                                                   value="" @change='change' v-model='jiage'>
                                                        </div></td>

                                                </tr>
                                                <tr>
                                                    <td width="25%">镜布</td>
                                                    <td colspan="6" width="25%"><div class="am-u-sm-9 am-u-end">
                                                            <input type="text" class="tpl-form-input" name="case"
                                                                   value="" >
                                                        </div></td>
                                                    <td width="25%"> <div class="am-u-sm-9 am-u-end">
                                                            <input type="number" class="tpl-form-input" name="glasses_case_num"
                                                                   value="" @change='change' v-model='num1'>
                                                        </div></td>
                                                    <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                            <input type="number" class="tpl-form-input" name="glasses_case_price"
                                                                   value="" @change='change' v-model='jiage1'>
                                                        </div></td>


                                                </tr>
                                                <tr>
                                                    <td width="25%">其他</td>
                                                    <td colspan="6" width="25%">
                                                        <div class="am-u-sm-9 am-u-end">
                                                            <input id="otherInfo" style="float: left;width: 70%;display: none" readonly type="text" class="tpl-form-input" name="other"
                                                                   value="">
                                                            <input id="other_specification_id" name="other_specification_id" type="text" style="display: none">
                                                            <button id="otherBtn"  type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myOtherModal">选规格</button>
                                                        </div>
                                                    </td>
                                                    <td width="25%"> <div class="am-u-sm-9 am-u-end">
                                                            <input  id="other_num" min="0" type="number" class="tpl-form-input" name="glasses_other_num"
                                                                    value="" @change='change' v-model='num2'>
                                                        </div></td>
                                                    <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                            <input id="otherPriceMax" type="number" min="0" class="tpl-form-input" name="glasses_other_price"
                                                                   value="" @change='change' v-model='jiage2'>
                                                        </div></td>


                                                </tr>
                                                <tr>
                                                    <td>合计</td>
                                                    <td colspan="8">
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
                                        <!--<label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_left">折扣金额</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input type="number" class="tpl-form-input" name="discount"
                                                value="" >
                                        </div>
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_right">说明</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input type="text" class="tpl-form-input" name="notes"
                                                value="" >
                                        </div>-->
                                        <div class="am-u-sm-8 am-u-end">
                                            <textarea style="width: 100%;text-align: left;"class="tpl-form-input" name="notes"></textarea>
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

    </div>
</div>

<?php

//use think\db;
//use think\Session;

$admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
$brand = Db::name('brand')->where('is_delete',0)->where('user_id',$admin_info['user_id'])->select();
?>


<div class="modal fade" id="myModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">镜片规格选择</h4>
            </div>
            <div class="modal-body">

                <form>
                    <div class="form-group les-form-group">
                        <label for="recipient-name" class="control-label">镜片品牌:</label>
                        <select onchange="brandChange(1)" id="brand" name="data[brand]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择品牌</option>
                            <?php foreach ($brand as $brand): ?>
                            <option value="<?=$brand['brand_id'] ?>"><?=$brand['brand_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group les-form-group">
                        <label for="recipient-name" class="control-label">镜片类型:</label>
                        <select onchange="typeChange(2)" id="type" name="data[type]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="null">请选择类型</option>
                            <option value="0">球面</option>
                            <option value="1">非球面</option>
                        </select>
                    </div>
                    <div class="form-group les-form-group">
                        <label for="recipient-name" class="control-label">镜片折射率:</label>
                        <select onchange="refractiveChange(3)" id="refractive" name="data[refractive]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择折射率</option>

                        </select>
                    </div>

                    <div class="form-group les-form-group">
                        <label for="recipient-name" class="control-label">镜片型号:</label>
                        <select onchange="modelChange(4)"  id="model" name="data[model]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择型号</option>
                        </select>
                    </div>
                    <div class="form-group les-form-group">
                        <label for="recipient-name" class="control-label">镜片球镜度数:</label>
                        <select onchange="spherical_lensChange(5)" id="spherical_lens" name="data[spherical_lens]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="">请选择球镜度数</option>
                            <?php for ($i = 0 ;$i <= 1000 ;$i +=25) :?>
                                <option value="<?=$i ?>"><?=$i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group les-form-group">
                        <label for="recipient-name" class="control-label">镜片柱镜度数:</label>
                        <select onchange="cytdnderChange()"  id="cytdnder" name="data[cytdnder]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="">请选择柱镜度数</option>
                            <?php for ($j = 0 ;$j <= 1000 ;$j +=25) :?>
                                <option value="<?=$j ?>"><?=$j ?></option>
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
                <button onclick="submit_les()" id="submit_xz" type="button"  class="btn btn-primary ">选定</button>
            </div>
        </div>
    </div>
</div>
<script>

    var brand = $('#brand  option:selected').val();
    var btn = $('#submit_xz');
    var type = $('#type  option:selected').val();
    var refractive = $('#refractive  option:selected').val();
    var selectInfo = $('.les-form-group').find('select');

    $('#brandBtn').click(function () {
        var selectInfo = $('.les-form-group').find('select');
        if (brand==0){
            selectInfo.find('option:selected').attr('selected',false);
            selectInfo.disabled=true;
            for (var i = 1 ; i < selectInfo.length; i ++) {
                btn.attr('disabled',true);
                btn.css({'background-color' : 'gray'});
                selectInfo[i].disabled = true;

            }
        }
    })
    function brandChange(i) {
        var selectInfo = $('.les-form-group').find('select');
        var brand = $('#brand  option:selected').val();
        if (brand != 0){
            selectInfo[i].disabled =false;
        }else {
            selectInfo[i].disabled =true;
        }
    }
    function typeChange(i) {
        var selectInfo = $('.les-form-group').find('select');
        var brand = $('#brand  option:selected').val();
        var type = $('#type  option:selected').val();
        var j = i;
        if (!isNaN(type)){
            $('#type').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.refractive/getrefractive',
                data:{type:type,brand:brand},
                success: function (result) {
                    $("#refractive").empty();
                    $("#refractive").append("<option value='0'>请选择折射率</option>");
                    if (result.data.length != 0 ){
                        for (var i = 0 ;i < result.data.length;i++){
                            $("#refractive").append("<option value='"+result.data[i]['refractive_num']+"'>"+result.data[i]['refractive_num']+"</option>");
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
    function refractiveChange(i) {
        var selectInfo = $('.les-form-group').find('select');
        var brand = $('#brand  option:selected').val();
        var type = $('#type  option:selected').val();
        var refractive = $('#refractive  option:selected').val();
        var j = i;
        if (refractive != 0){
            $('#refractive').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.model/getmodel',
                data:{type:type,brand:brand,refractive:refractive},
                success: function (result) {
                    $("#model").empty();
                    $("#model").append("<option value='0'>请选择型号</option>");
                    if (result.data.length != 0 ){

                        for (var i = 0 ;i < result.data.length;i++){

                            $("#model").append("<option value='"+result.data[i]['model']+"'>"+result.data[i]['model']+"</option>");
                        }
                        selectInfo[j].disabled =false;
                    }else{
                        layer.msg('暂无数据', {time: 1500, anim: 6});
                        selectInfo[j].disabled =true;
                    }

                }
            });
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function modelChange(i) {
        var selectInfo = $('.les-form-group').find('select');
        var model = $('#model  option:selected').val();
        if (model != 0){
            selectInfo[i].disabled =false;
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function spherical_lensChange(i) {
        var selectInfo = $('.les-form-group').find('select');
        var brand = $('#brand  option:selected').val();
        var type = $('#type  option:selected').val();
        var refractive = $('#refractive  option:selected').val();
        var model = $('#model  option:selected').val();
        var spherical_lens = $('#spherical_lens  option:selected').val();
        var j = i;
        if (spherical_lens != 0){
            selectInfo[i].disabled =false;
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function cytdnderChange() {
        var cytdnder = $('#cytdnder  option:selected').val();
        var btn = $('#submit_xz');
        if (cytdnder != 0){

            btn.attr('disabled',false);
            btn.css({'background-color' : '#337ab7'});
        }
        else {
            btn.attr('disabled',true);
            btn.css({'background-color' : 'gray'});
        }
    }
    function submit_les(){
        var selectInfo = $('.les-form-group').find('select');
        var btn = $('#submit_xz');
        var brand = $('#brand  option:selected').val();
        var type = $('#type  option:selected').val();
        var l = '';
        if(type == 0){
            l = '球面';
        }else {
            l = '非球面';
        }
        var refractive = $('#refractive  option:selected').val();
        var model = $('#model  option:selected').val();
        var spherical_lens = $('#spherical_lens  option:selected').val();
        var cytdnder = $('#cytdnder  option:selected').val();
        btn.attr('disabled',true);
        btn.css({'background-color' : 'gray'});
        $('#submit_xz').ajaxSubmit({
            type: "post",
            dataType: "json",
            url: 'index.php?s=/store/inventory.specification/getrespecification',
            data:{type:type,brand:brand,refractive:refractive,model:model,spherical_lens:spherical_lens,cytdnder:cytdnder},
            success: function (result) {
                // console.log(result);return;
                if (result.data.length != 0 ){
                    for (var i = 0 ;i < result.data.length;i++){
                        var data = [
                            result.data[i].brand_name+'—'+
                            l+'—'+
                            result.data[i].refractive_num+'—'+
                            result.data[i].model+'—'+
                            result.data[i].spherical_lens+'—'+
                            result.data[i].cytdnder

                        ];
                        var ids = result.data[i].specification_id;
                        // console.log(ids);return;
                        console.log(data);
                        $("#brandInfo").val(data);
                        $("#right_specification_id").val(ids);
                        $("#brandInfo").attr('readonly',true);
                        $("#brandInfo").css('display','block');
                        $("#brandBtn").css('float','right');
                        $('#now_inventory_num').attr('max',result.data[i].now_inventory);

                        $('.close').click();
                        console.log(result.data[i]);

                    }
                }else{
                    layer.msg('暂无记录，请先添加！', {time: 1500, anim: 6});
                }

            }
        });
    }


</script>

<!-- Modal -->
<!--<script src="https://cdn.bootcss.com/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>-->
<?php
/*use think\db;
use think\Session;*/

$admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
$glasses_brand = Db::name('glasses_brand')->where('is_delete',0)->where('user_id',$admin_info['user_id'])->select();
?>


<div class="modal fade" id="myGlassesModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">镜框规格选择</h4>
            </div>
            <div class="modal-body">

                <form>
                    <div class="form-group glasses_form">
                        <label for="recipient-name" class="control-label">镜框品牌:</label>
                        <select onchange="glassesBrandChange(1)" id="glasses_brand" name="data[glasses_brand]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择品牌</option>
                            <?php foreach ($glasses_brand as $value): ?>
                            <option value="<?=$value['brand_id'] ?>"><?=$value['brand_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>



                    <div class="form-group glasses_form">
                        <label for="recipient-name" class="control-label">镜框型号:</label>
                        <select onchange="glassesModelChange(2)"  id="glasses_model" name="data[glasses_model]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择型号</option>
                        </select>
                    </div>
                    <div class="form-group glasses_form">
                        <label for="recipient-name" class="control-label">镜框颜色:</label>
                        <select onchange="glassesColorChange()"  id="glasses_color" name="data[glasses_color]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择颜色</option>
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
                <button onclick="submit()" id="glasses_submit" type="button"  class="btn btn-primary ">选定</button>
            </div>
        </div>
    </div>
</div>
<script>

    var glasses_brand = $('#glasses_brand  option:selected').val();
    var glasses_btn = $('#glasses_submit');
    var selectInfo = $('.glasses_form').find('select');
    $('#glassesBtn').click(function () {
        var selectInfo = $('.glasses_form').find('select');
        if (glasses_brand==0){
            selectInfo.find('option:selected').attr('selected',false);
            selectInfo.disabled=true;
            for (var i = 1 ; i < selectInfo.length; i ++) {
                glasses_btn.attr('disabled',true);
                glasses_btn.css({'background-color' : 'gray'});
                selectInfo[i].disabled = true;

            }
        }
    })
    function glassesBrandChange(i) {
        var selectInfo = $('.glasses_form').find('select');
        var glasses_brand = $('#glasses_brand  option:selected').val();
        var j = i;
        if (glasses_brand != 0){
            $('#glasses_brand').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.glasses.model/getmodel',
                data:{glasses_brand:glasses_brand},
                success: function (result) {
                    $("#glasses_model").empty();
                    $("#glasses_model").append("<option value='0'>请选择型号</option>");
                    if (result.data.length != 0 ){

                        for (var i = 0 ;i < result.data.length;i++){

                            $("#glasses_model").append("<option value='"+result.data[i]['model']+"'>"+result.data[i]['model']+"</option>");
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

    function glassesModelChange(i) {
        var selectInfo = $('.glasses_form').find('select');
        var glasses_model = $('#glasses_model  option:selected').val();
        var glasses_brand = $('#glasses_brand  option:selected').val();
        var j = i;
        if (glasses_model != 0){
            $('#glasses_model').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.glasses.specification/getcolor',
                data:{glasses_brand:glasses_brand,glasses_model:glasses_model},
                success: function (result) {
                    $("#glasses_color").empty();
                    $("#glasses_color").append("<option value='0'>请选择颜色</option>");
                    if (result.data.length != 0 ){

                        for (var i = 0 ;i < result.data.length;i++){

                            $("#glasses_color").append("<option value='"+result.data[i]['color']+"'>"+result.data[i]['color']+"</option>");
                        }
                        selectInfo[j].disabled =false;
                    }else{
                        layer.msg('暂无数据', {time: 1500, anim: 6});
                        selectInfo[j].disabled =true;
                    }
                }
            });
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function glassesColorChange() {
        var selectInfo = $('.glasses_form').find('select');
        var glasses_color = $('#glasses_color  option:selected').val();
        var glasses_btn = $('#glasses_submit');
        if (glasses_color != 0){
            glasses_btn.attr('disabled',false);
            glasses_btn.css({'background-color' : '#337ab7'});
        }
        else {
            glasses_btn.attr('disabled',true);
            glasses_btn.css({'background-color' : 'gray'});
        }
    }
    function submit(){
        var glasses_btn = $('#glasses_submit');
        var selectInfo = $('.glasses_form').find('select');
        var glasses_brand = $('#glasses_brand  option:selected').val();
        var glasses_model = $('#glasses_model  option:selected').val();
        var glasses_color = $('#glasses_color  option:selected').val();
        glasses_btn.attr('disabled',true);
        glasses_btn.css({'background-color' : 'gray'});
        $('#glasses_submit').ajaxSubmit({
            type: "post",
            dataType: "json",
            url: 'index.php?s=/store/inventory.glasses.specification/getspecification',
            data:{glasses_brand:glasses_brand,glasses_model:glasses_model,glasses_color:glasses_color},
            success: function (result) {
                // console.log(result);return;
                if (result.data.length != 0 ){
                    for (var i = 0 ;i < result.data.length;i++){
                        var data = [
                            result.data[i].brand_name+'—'+
                            result.data[i].model+'—'+
                            result.data[i].color

                        ];
                        var ids = result.data[i].specification_id;
                        // console.log(ids);return;
                        $("#glassesInfo").val(data);
                        $("#glasses_specification_id").val(ids);
                        $("#glassesInfo").attr('readonly',true);
                        $("#glassesInfo").css('display','block');
                        $("#glassesBtn").css('float','right');
                        $('#glasses_num').attr('max',result.data[i].now_inventory);

                        $('.close').click();
                        console.log(result.data[i]);

                    }
                }else{
                    layer.msg('暂无记录，请先添加！', {time: 1500, anim: 6});
                }

            }
        });
    }


</script>


<?php


$admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
$brand = Db::name('brand')->where('is_delete',0)->where('user_id',$admin_info['user_id'])->select();
?>


<div class="modal fade" id="myLeftModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">镜片规格选择</h4>
            </div>
            <div class="modal-body">

                <form>
                    <div class="form-group left_les-form-group">
                        <label for="recipient-name" class="control-label">镜片品牌:</label>
                        <select onchange="left_brandChange(1)" id="left_brand" name="data[brand]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择品牌</option>
                            <?php foreach ($brand as $brand): ?>
                            <option value="<?=$brand['brand_id'] ?>"><?=$brand['brand_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group left_les-form-group">
                        <label for="recipient-name" class="control-label">镜片类型:</label>
                        <select onchange="left_typeChange(2)" id="left_type" name="data[type]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="null">请选择类型</option>
                            <option value="0">球面</option>
                            <option value="1">非球面</option>
                        </select>
                    </div>
                    <div class="form-group left_les-form-group">
                        <label for="recipient-name" class="control-label">镜片折射率:</label>
                        <select onchange="left_refractiveChange(3)" id="left_refractive" name="data[refractive]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择折射率</option>

                        </select>
                    </div>

                    <div class="form-group left_les-form-group">
                        <label for="recipient-name" class="control-label">镜片型号:</label>
                        <select onchange="left_modelChange(4)"  id="left_model" name="data[model]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择型号</option>
                        </select>
                    </div>
                    <div class="form-group left_les-form-group">
                        <label for="recipient-name" class="control-label">镜片球镜度数:</label>
                        <select onchange="left_spherical_lensChange(5)" id="left_spherical_lens" name="data[spherical_lens]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="">请选择球镜度数</option>
                            <?php for ($i = 0 ;$i <= 1000 ;$i +=25) :?>
                                <option value="<?=$i ?>"><?=$i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group left_les-form-group">
                        <label for="recipient-name" class="control-label">镜片柱镜度数:</label>
                        <select onchange="left_cytdnderChange()"  id="left_cytdnder" name="data[cytdnder]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="">请选择柱镜度数</option>
                            <?php for ($j = 0 ;$j <= 1000 ;$j +=25) :?>
                                <option value="<?=$j ?>"><?=$j ?></option>
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
                <button onclick="left_submit_les()" id="left_submit_xz" type="button"  class="btn btn-primary ">选定</button>
            </div>
        </div>
    </div>
</div>
<script>

    var brand = $('#left_brand  option:selected').val();
    var btn = $('#left_submit_xz');
    var type = $('#left_type  option:selected').val();
    var refractive = $('#left_refractive  option:selected').val();
    var selectInfo = $('.left_les-form-group').find('select');

    $('#left_brandBtn').click(function () {
        var selectInfo = $('.left_les-form-group').find('select');
        if (brand==0){
            selectInfo.find('option:selected').attr('selected',false);
            selectInfo.disabled=true;
            for (var i = 1 ; i < selectInfo.length; i ++) {
                btn.attr('disabled',true);
                btn.css({'background-color' : 'gray'});
                selectInfo[i].disabled = true;

            }
        }
    })
    function left_brandChange(i) {
        var selectInfo = $('.left_les-form-group').find('select');
        var brand = $('#left_brand  option:selected').val();
        if (brand != 0){
            selectInfo[i].disabled =false;
        }else {
            selectInfo[i].disabled =true;
        }
    }
    function left_typeChange(i) {
        var selectInfo = $('.left_les-form-group').find('select');
        var brand = $('#left_brand  option:selected').val();
        var type = $('#left_type  option:selected').val();
        var j = i;
        if (!isNaN(type)){
            $('#left_type').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.refractive/getrefractive',
                data:{type:type,brand:brand},
                success: function (result) {
                    $("#left_refractive").empty();
                    $("#left_refractive").append("<option value='0'>请选择折射率</option>");
                    if (result.data.length != 0 ){
                        for (var i = 0 ;i < result.data.length;i++){
                            $("#left_refractive").append("<option value='"+result.data[i]['refractive_num']+"'>"+result.data[i]['refractive_num']+"</option>");
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
    function left_refractiveChange(i) {
        var selectInfo = $('.left_les-form-group').find('select');
        var brand = $('#left_brand  option:selected').val();
        var type = $('#left_type  option:selected').val();
        var refractive = $('#left_refractive  option:selected').val();
        var j = i;
        if (refractive != 0){
            $('#left_refractive').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.model/getmodel',
                data:{type:type,brand:brand,refractive:refractive},
                success: function (result) {
                    $("#left_model").empty();
                    $("#left_model").append("<option value='0'>请选择型号</option>");
                    if (result.data.length != 0 ){

                        for (var i = 0 ;i < result.data.length;i++){

                            $("#left_model").append("<option value='"+result.data[i]['model']+"'>"+result.data[i]['model']+"</option>");
                        }
                        selectInfo[j].disabled =false;
                    }else{
                        layer.msg('暂无数据', {time: 1500, anim: 6});
                        selectInfo[j].disabled =true;
                    }

                }
            });
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function left_modelChange(i) {
        var selectInfo = $('.left_les-form-group').find('select');
        var model = $('#left_model  option:selected').val();
        if (model != 0){
            selectInfo[i].disabled =false;
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function left_spherical_lensChange(i) {
        var selectInfo = $('.left_les-form-group').find('select');
        var brand = $('#left_brand  option:selected').val();
        var type = $('#left_type  option:selected').val();
        var refractive = $('#left_refractive  option:selected').val();
        var model = $('#left_model  option:selected').val();
        var spherical_lens = $('#left_spherical_lens  option:selected').val();
        var j = i;
        if (spherical_lens != 0){
            selectInfo[i].disabled =false;
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function left_cytdnderChange() {
        var cytdnder = $('#left_cytdnder  option:selected').val();
        var btn = $('#left_submit_xz');
        if (cytdnder != 0){

            btn.attr('disabled',false);
            btn.css({'background-color' : '#337ab7'});
        }
        else {
            btn.attr('disabled',true);
            btn.css({'background-color' : 'gray'});
        }
    }
    function left_submit_les(){
        var selectInfo = $('.left_les-form-group').find('select');
        var btn = $('#left_submit_xz');
        var brand = $('#left_brand  option:selected').val();
        var type = $('#left_type  option:selected').val();
        var l = '';
        if(type == 0){
            l = '球面';
        }else {
            l = '非球面';
        }
        var refractive = $('#left_refractive  option:selected').val();
        var model = $('#left_model  option:selected').val();
        var spherical_lens = $('#left_spherical_lens  option:selected').val();
        var cytdnder = $('#left_cytdnder  option:selected').val();
        btn.attr('disabled',true);
        btn.css({'background-color' : 'gray'});
        $('#left_submit_xz').ajaxSubmit({
            type: "post",
            dataType: "json",
            url: 'index.php?s=/store/inventory.specification/getrespecification',
            data:{type:type,brand:brand,refractive:refractive,model:model,spherical_lens:spherical_lens,cytdnder:cytdnder},
            success: function (result) {
                // console.log(result);return;
                if (result.data.length != 0 ){
                    for (var i = 0 ;i < result.data.length;i++){
                        var data = [
                            result.data[i].brand_name+'—'+
                            l+'—'+
                            result.data[i].refractive_num+'—'+
                            result.data[i].model+'—'+
                            result.data[i].spherical_lens+'—'+
                            result.data[i].cytdnder

                        ];
                        var ids = result.data[i].specification_id;
                        // console.log(ids);return;
                        console.log(data);
                        $("#left_specification_id").val(ids);
                        $("#left_brandInfo").val(data);
                        $("#left_brandInfo").attr('readonly',true);
                        $("#left_brandInfo").css('display','block');
                        $("#left_brandBtn").css('float','right');
                        $('#now_left_inventory_num').attr('max',result.data[i].now_inventory);

                        $('.close').click();
                        console.log(result.data[i]);

                    }
                }else{
                    layer.msg('暂无记录，请先添加！', {time: 1500, anim: 6});
                }

            }
        });
    }


</script>

<!-- Modal -->
<!--<script src="https://cdn.bootcss.com/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>-->
<?php
/*use think\db;
use think\Session;*/

$admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
$glasses_brand = Db::name('glasses_brand')->where('is_delete',0)->where('user_id',$admin_info['user_id'])->select();
?>


<div class="modal fade" id="myLeftGlassesModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">镜框规格选择</h4>
            </div>
            <div class="modal-body">

                <form>
                    <div class="form-group left_glasses_form">
                        <label for="recipient-name" class="control-label">镜框品牌:</label>
                        <select onchange="left_glassesBrandChange(1)" id="left_glasses_brand" name="data[glasses_brand]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择品牌</option>
                            <?php foreach ($glasses_brand as $value): ?>
                            <option value="<?=$value['brand_id'] ?>"><?=$value['brand_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>



                    <div class="form-group left_glasses_form">
                        <label for="recipient-name" class="control-label">镜框型号:</label>
                        <select onchange="left_glassesModelChange(2)"  id="left_glasses_model" name="data[glasses_model]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择型号</option>
                        </select>
                    </div>
                    <div class="form-group left_glasses_form">
                        <label for="recipient-name" class="control-label">镜框颜色:</label>
                        <select onchange="left_glassesColorChange()"  id="left_glasses_color" name="data[glasses_color]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择颜色</option>
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
                <button onclick="left_submit()" id="left_glasses_submit" type="button"  class="btn btn-primary ">选定</button>
            </div>
        </div>
    </div>
</div>
<script>

    var glasses_brand = $('#left_glasses_brand  option:selected').val();
    var glasses_btn = $('#left_glasses_submit');
    var selectInfo = $('.left_glasses_form').find('select');
    $('#left_glassesBtn').click(function () {
        var selectInfo = $('.left_glasses_form').find('select');
        if (glasses_brand==0){
            selectInfo.find('option:selected').attr('selected',false);
            selectInfo.disabled=true;
            for (var i = 1 ; i < selectInfo.length; i ++) {
                glasses_btn.attr('disabled',true);
                glasses_btn.css({'background-color' : 'gray'});
                selectInfo[i].disabled = true;

            }
        }
    })
    function left_glassesBrandChange(i) {
        var selectInfo = $('.left_glasses_form').find('select');
        var glasses_brand = $('#left_glasses_brand  option:selected').val();
        var j = i;
        if (glasses_brand != 0){
            $('#left_glasses_brand').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.glasses.model/getmodel',
                data:{glasses_brand:glasses_brand},
                success: function (result) {
                    $("#left_glasses_model").empty();
                    $("#left_glasses_model").append("<option value='0'>请选择型号</option>");
                    if (result.data.length != 0 ){

                        for (var i = 0 ;i < result.data.length;i++){

                            $("#left_glasses_model").append("<option value='"+result.data[i]['model']+"'>"+result.data[i]['model']+"</option>");
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

    function left_glassesModelChange(i) {
        var selectInfo = $('.left_glasses_form').find('select');
        var glasses_model = $('#left_glasses_model  option:selected').val();
        var glasses_brand = $('#left_glasses_brand  option:selected').val();
        var j = i;
        if (glasses_model != 0){
            $('#left_glasses_model').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.glasses.specification/getcolor',
                data:{glasses_brand:glasses_brand,glasses_model:glasses_model},
                success: function (result) {
                    $("#left_glasses_color").empty();
                    $("#left_glasses_color").append("<option value='0'>请选择颜色</option>");
                    if (result.data.length != 0 ){

                        for (var i = 0 ;i < result.data.length;i++){

                            $("#left_glasses_color").append("<option value='"+result.data[i]['color']+"'>"+result.data[i]['color']+"</option>");
                        }
                        selectInfo[j].disabled =false;
                    }else{
                        layer.msg('暂无数据', {time: 1500, anim: 6});
                        selectInfo[j].disabled =true;
                    }
                }
            });
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function left_glassesColorChange() {
        var selectInfo = $('.left_glasses_form').find('select');
        var glasses_color = $('#left_glasses_color  option:selected').val();
        var glasses_btn = $('#left_glasses_submit');
        if (glasses_color != 0){
            glasses_btn.attr('disabled',false);
            glasses_btn.css({'background-color' : '#337ab7'});
        }
        else {
            glasses_btn.attr('disabled',true);
            glasses_btn.css({'background-color' : 'gray'});
        }
    }
    function left_submit(){
        var glasses_btn = $('#left_glasses_submit');
        var selectInfo = $('.left_glasses_form').find('select');
        var glasses_brand = $('#left_glasses_brand  option:selected').val();
        var glasses_model = $('#left_glasses_model  option:selected').val();
        var glasses_color = $('#left_glasses_color  option:selected').val();
        glasses_btn.attr('disabled',true);
        glasses_btn.css({'background-color' : 'gray'});
        $('#left_glasses_submit').ajaxSubmit({
            type: "post",
            dataType: "json",
            url: 'index.php?s=/store/inventory.glasses.specification/getspecification',
            data:{glasses_brand:glasses_brand,glasses_model:glasses_model,glasses_color:glasses_color},
            success: function (result) {
                // console.log(result);return;
                if (result.data.length != 0 ){
                    for (var i = 0 ;i < result.data.length;i++){
                        var data = [
                            result.data[i].brand_name+'—'+
                            result.data[i].model+'—'+
                            result.data[i].color

                        ];
                        var ids = result.data[i].specification_id;
                        // console.log(ids);return;
                        console.log(data);
                        $("#left_glassesInfo").val(data);
                        $("#left_glassesInfo").attr('readonly',true);
                        $("#left_glassesInfo").css('display','block');
                        $("#left_glassesBtn").css('float','right');
                        $('#left_glasses_num').attr('max',result.data[i].now_inventory);

                        $('.close').click();
                        console.log(result.data[i]);

                    }
                }else{
                    layer.msg('暂无记录，请先添加！', {time: 1500, anim: 6});
                }

            }
        });
    }


</script>

<!-- Modal -->
<!--<script src="https://cdn.bootcss.com/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>-->
<?php

$admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
$other_brand = Db::name('other_brand')->where('is_delete',0)->where('user_id',$admin_info['user_id'])->select();
?>


<div class="modal fade" id="myOtherModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">其他规格选择</h4>
            </div>
            <div class="modal-body">

                <form>
                    <div class="form-group other_form">
                        <label for="recipient-name" class="control-label">其他品牌:</label>
                        <select onchange="otherBrandChange(1)" id="other_brand" name="data[other_brand]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择品牌</option>
                            <?php foreach ($other_brand as $value): ?>
                            <option value="<?=$value['brand_id'] ?>"><?=$value['brand_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>



                    <div class="form-group other_form">
                        <label for="recipient-name" class="control-label">其他型号:</label>
                        <select onchange="otherModelChange()"  id="other_model" name="data[other_model]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择型号</option>
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
                <button onclick="submit_other()" id="other_submit" type="button"  class="btn btn-primary ">选定</button>
            </div>
        </div>
    </div>
</div>
<script>

    var other_brand = $('#other_brand  option:selected').val();
    var other_model = $('#other_model  option:selected').val();
    var other_submit = $('#other_submit');
    var selectInfo = $('.other_form').find('select');
    $('#otherBtn').click(function () {
        var selectInfo = $('.other_form').find('select');
        var other_submit = $('#other_submit');
        var other_brand = $('#other_brand  option:selected').val();
        if (other_brand==0){
            selectInfo.find('option:selected').attr('selected',false);
            selectInfo.disabled=true;
            for (var i = 1 ; i < selectInfo.length; i ++) {
                other_submit.attr('disabled',true);
                other_submit.css({'background-color' : 'gray'});
                selectInfo[i].disabled = true;

            }
        }
    })
    function otherBrandChange(i) {
        var selectInfo = $('.other_form').find('select');
        var other_brand = $('#other_brand  option:selected').val();
        var j = i;
        if (other_brand != 0){
            $('#other_brand').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.other.model/getmodel',
                data:{other_brand:other_brand},
                success: function (result) {
                    $("#other_model").empty();
                    $("#other_model").append("<option value='0'>请选择型号</option>");
                    if (result.data.length != 0 ){

                        for (var i = 0 ;i < result.data.length;i++){

                            $("#other_model").append("<option value='"+result.data[i]['model']+"'>"+result.data[i]['model']+"</option>");
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

    function otherModelChange() {
        var selectInfo = $('.other_form').find('select');
        var other_submit = $('#other_submit');
        var other_model = $('#other_model  option:selected').val();
        var other_brand = $('#other_brand  option:selected').val();
        if (other_model != 0){
            other_submit.attr('disabled',false);
            other_submit.css({'background-color' : '#337ab7'});
        }
        else {
            other_submit.attr('disabled',true);
            other_submit.css({'background-color' : 'gray'});
        }
    }
    function submit_other(){
        var selectInfo = $('.other_form').find('select');
        var other_submit = $('#other_submit');
        var other_model = $('#other_model  option:selected').val();
        var other_brand = $('#other_brand  option:selected').val();
        other_submit.attr('disabled',true);
        other_submit.css({'background-color' : 'gray'});
        $('#other_submit').ajaxSubmit({
            type: "post",
            dataType: "json",
            url: 'index.php?s=/store/inventory.other.specification/getspecification',
            data:{other_brand:other_brand,other_model:other_model},
            success: function (result) {
                // console.log(result);return;
                if (result.data.length != 0 ){
                    for (var i = 0 ;i < result.data.length;i++){
                        var data = [
                            result.data[i].brand_name+'—'+
                            result.data[i].model

                        ];
                        console.log(data);
                        var ids = result.data[i].specification_id;
                        $("#other_specification_id").val(ids);
                        $("#otherInfo").val(data);
                        $("#otherInfo").attr('readonly',true);
                        $("#otherInfo").css('display','block');
                        $("#otherBtn").css('float','right');
                        $('#other_num').attr('max',result.data[i].now_inventory);

                        $('.close').click();
                        console.log(result.data[i]);

                    }
                }else{
                    layer.msg('暂无记录，请先添加！', {time: 1500, anim: 6});

                }

            }
        });
    }


</script>

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
    $('#btn-submit').click(function () {
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
                now_inventory_num:'',
                priceMax:'',
                now_left_inventory_num:'',
                left_priceMax:'',
                glasses_num:'',
                glasses_price:'',
                nums:'',
                jiage:'',
                num1:'',
                jiage1:'',
                num2:'',
                jiage2:'',
                add:''
            }
        },
        methods:{
            change(){
                this.add=Number(this.now_inventory_num)*Number(this.priceMax)+Number(this.now_left_inventory_num)*Number(this.left_priceMax)+Number(this.glasses_num)*Number(this.glasses_price)+Number(this.nums)*Number(this.jiage)+Number(this.num1)*Number(this.jiage1)+Number(this.num2)*Number(this.jiage2)
            }
        }
    });
</script>

