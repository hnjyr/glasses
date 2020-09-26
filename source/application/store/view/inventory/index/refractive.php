<!DOCTYPE html>
<html lang="en">
<?php //dump($list);die(); ?>
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

    <style>
        #step1{
            display:block;
        }
        #step2,#step3,#step4,#step5,#step6,#step7,#step8{
            display: none;
        }
        #step1,#step2,#step3{
            position: absolute;
            width: 100%;
            height: 40%;
            left: 2%;
            top:10%;
        }
    </style>
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
                                                   href="<?= url('inventory.index.refractive/add') ?>">
                                                    <i class="iconfont icon-add am-margin-right-xs"></i>新增折射率
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
                                    <th>店铺名称</th>
                                    <th>添加时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $colspan = 7; ?>
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
                                            <span > <?= $order['refractive'] ?></span>
                                        </td>
                                        <td class="am-text-middle" >
                                            <span > <?= $order['shop_name'] ?></span>
                                        </td>
                                        <td class="am-text-middle" >
                                            <span > <?= $order['create_time'] ?></span>
                                        </td>


                                        <td class="am-text-middle" >
                                            <div class="tpl-table-black-operation">
                                                <a class="tpl-table-black-operation-green"
                                                   href="<?= url('inventory.index/index', ['type' => 0,'brand_id'=>$order['brand_id']]) ?>">
                                                    型号</a>

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

                        <!--<div class="widget am-cf" id="step1">
                        <div class="widget-head am-cf">
                            <div class="widget-title am-cf">选择品牌</div>
                        </div>
                        <div class="panel-body  form-group">
                            <div class="am-form-group inventory">
                                <label class="am-u-sm-3 am-form-label form-require"> 品牌 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" placeholder="请输入品牌名" class="tpl-form-input" name="data[brand]"
                                                   value="<?/*= $data['brand'] */?>" required>
                                    <button type="button" class="btn btn-success" onclick="getnext('step2')" >下一步</button>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="widget am-cf" id="step2">
                        <div class="widget-head am-cf">
                            <div class="widget-title am-cf">选择类型</div>
                        </div>
                        <div class="panel-body  form-group">
                            <div class="am-form-group inventory">
                                <label class="am-u-sm-3 am-form-label form-require"> 类型 </label>
                                <div class="am-u-sm-9">
                                    <select  class="selectpicker show-tick" name="data[type]" id="">
                                        <option value="0">球面</option>
                                        <option value="1">非球面</option>
                                    </select>
                                    <button type="button" class="btn btn-primary" onclick="getnext('step1')">上一步</button>
                                    <button type="button" class="btn btn-success" onclick="getnext('step3')" >下一步</button>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="widget am-cf" id="step3">
                        <div class="widget-head am-cf">
                            <div class="widget-title am-cf">输入折射率</div>
                        </div>
                        <div class="panel-body  form-group">
                            <div class="am-form-group inventory">
                                <label class="am-u-sm-3 am-form-label form-require"> 折射率 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="data[refractive]"
                                           value="<?/*= $data['refractive'] */?>" required>
                                    <button type="button" class="btn btn-primary" onclick="getnext('step2')">上一步</button>
                                    <button type="button" class="btn btn-success" onclick="getnext('step4')" >下一步</button>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="widget am-cf" id="step4">
                        <div class="widget-head am-cf">
                            <div class="widget-title am-cf">输入型号</div>
                        </div>
                        <div class="panel-body  form-group">
                            <div class="am-form-group inventory">
                                <label class="am-u-sm-3 am-form-label form-require"> 型号 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="data[model]"
                                           value="<?/*= $data['model'] */?>" required>
                                    <button type="button" class="btn btn-primary" onclick="getnext('step3')">上一步</button>
                                    <button type="button" class="btn btn-success" onclick="getnext('step5')" >下一步</button>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="widget am-cf" id="step5">
                        <div class="widget-head am-cf">
                            <div class="widget-title am-cf">选择球镜度数</div>
                        </div>
                        <div class="panel-body  form-group">
                            <div class="am-form-group inventory">
                                <label class="am-u-sm-3 am-form-label form-require"> 球镜度数 </label>
                                <div class="am-u-sm-9">
                                    <select class="selectpicker show-tick" name="data[spherical_lens]" id="">
                                        <?php /*for ($i = 0; $i <= 1000; $i += 25):*/?>

                                            <option value="<?/*= $i */?>"><?/*= $i */?></option>
                                        <?php /*endfor; */?>
                                    </select>
                                    <button type="button" class="btn btn-primary" onclick="getnext('step4')">上一步</button>
                                    <button type="button" class="btn btn-success" onclick="getnext('step6')" >下一步</button>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="widget am-cf" id="step6">
                        <div class="widget-head am-cf">
                            <div class="widget-title am-cf">选择柱镜度数</div>
                        </div>
                        <div class="panel-body  form-group">
                            <div class="am-form-group inventory">
                                <label class="am-u-sm-3 am-form-label form-require"> 柱镜度数 </label>
                                <div class="am-u-sm-9">
                                    <select class="selectpicker show-tick" name="data[cytdnder]" id="">
                                        <?php /*for ($i = 0; $i <= 1000; $i += 25):*/?>

                                            <option value="<?/*= $i */?>"><?/*= $i */?></option>
                                        <?php /*endfor; */?>
                                    </select>
                                    <button type="button" class="btn btn-primary" onclick="getnext('step5')">上一步</button>
                                    <button type="button" class="btn btn-success" onclick="getnext('step7')" >下一步</button>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="widget am-cf" id="step7">
                        <div class="widget-head am-cf">
                            <div class="widget-title am-cf">输入库存信息</div>
                        </div>
                        <div class="panel-body  form-group">
                            <div class="am-form-group inventory">
                                <label class="am-u-sm-3 am-form-label form-require"> 库存信息 </label>
                                <div class="am-u-sm-9">
                                    <div class="am-form-group sales">
                                        <label class="am-u-sm-3 am-form-label form-require"> 颜色 </label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" name="data[color]"
                                                   value="<?/*= $data['color'] */?>" required>
                                        </div>
                                    </div>
                                    <div class="am-form-group sales">
                                        <label class="am-u-sm-3 am-form-label form-require"> 成本价 </label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" name="data[price]"
                                                   value="<?/*= $data['price'] */?>" required>
                                        </div>
                                    </div>
                                    <div class="am-form-group sales">
                                        <label class="am-u-sm-3 am-form-label form-require"> 标准库存 </label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" name="data[standard_inventory]"
                                                   value="<?/*= $data['standard_inventory'] */?>" required>
                                        </div>
                                    </div>
                                    <div class="am-form-group sales">
                                        <label class="am-u-sm-3 am-form-label form-require"> 现有库存 </label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" name="data[now_inventory]"
                                                   value="<?/*= $data['now_inventory'] */?>" required>
                                        </div>
                                    </div>
                                    <div class="am-form-group sales">
                                        <label class="am-u-sm-3 am-form-label form-require"> 需补数量 </label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" name="data[sum]"
                                                   value="<?/*= $data['standard_inventory'] - $data['now_inventory']*/?>" required>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="getnext('step6')">上一步</button>
                                    <button type="submit" class="j-submit am-btn am-btn-secondary">提交
                                    </button>
                                </div>

                            </div>

                        </div>

                    </div>-->
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



