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
    <link rel="stylesheet" href="//at.alicdn.com/t/font_2045680_te8l9k0l53g.css">
    <script src="assets/common/js/jquery.min.js"></script>
    <script src="//at.alicdn.com/t/font_783249_e5yrsf08rap.js"></script>
    <script src="//at.alicdn.com/t/font_2045680_te8l9k0l53g.js"></script>
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
                                                    <?php if (checkPrivilege('new_order/export')): ?>
                                                        <a class="j-export am-btn am-btn-danger am-radius"
                                                           href="javascript:void(0);">
                                                            <i class="iconfont icon-daochu am-margin-right-xs"></i>信息导出
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
                                    <div class="am-u-sm-12 am-u-md-9">
                                        <div class="am fr">
                                            <div class="am-form-group am-fl">
                                                <div class="am-input-group am-input-group-sm tpl-form-border-form">
                                                    <input type="text" class="am-form-field" name="sales"
                                                           placeholder="销售员姓名" value="<?= $request->get('sales') ?>">
                                                    <div class="am-input-group-btn">
                                                        <button class="am-btn am-btn-default am-icon-search"
                                                                type="submit"></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="am-form-group am-fl">
                                                <div class="am-input-group am-input-group-sm tpl-form-border-form">
                                                    <input type="text" class="am-form-field" name="search"
                                                           placeholder="客户名字/客户手机号" value="<?= $request->get('search') ?>">
                                                    <div class="am-input-group-btn">
                                                        <button class="am-btn am-btn-default am-icon-search"
                                                                type="submit"></button>
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
                                        <th><input id="checkAll" type="checkbox"></th>
                                        <th>姓名</th>
                                        <th>性别</th>
                                        <th>年龄</th>
                                        <th>生日</th>
                                        <th>电话</th>
                                        <th>积分</th>
                                        <th>销售人员</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $colspan = 12; ?>
                                    <?php if (!is_null($new_arr)): foreach ($new_arr as $order): ?>
                                        <tr>
                                            <td class="am-text-middle am-text-center" >
                                                <input type="checkbox" name="checkitem">
                                            </td>
                                            <td class="am-text-middle" >
                                                <span class="search"><a href='<?= url("customer.history/index&&search=".$order['user_name']) ?>' style='color: #333'><?= $order['user_name'] ?></a> </span>
                                            </td>
                                            <?php if($order['sex'] == 0):?>
                                                <td class="am-text-middle">保密</td>
                                            <?php  endif; ?>
                                            <?php if($order['sex'] == 1):?>
                                                <td class="am-text-middle">男</td>
                                            <?php  endif; ?>
                                            <?php if($order['sex'] == 2):?>
                                                <td class="am-text-middle">女</td>
                                            <?php  endif; ?>
                                            <td class="am-text-middle" >
                                                <span > <?= $order['years'] ?></span>
                                            </td>
                                            <td class="am-text-middle" >
                                                <span > <?= date('Y-m-d',strtotime($order['birthday'])) ?></span>
                                            </td>
                                            <td class="am-text-middle" >
                                                <span > <?= $order['mobile'] ?></span>
                                            </td>
                                            <td class="am-text-middle" >
                                                <span > <?= $order['glasses_total_point'] ?></span>
                                            </td>
                                            <td class="am-text-middle" >
                                                <span > <?= $order['sales'] ?></span>
                                            </td>
                                            <td class="am-text-middle" >
                                                <div class="tpl-table-black-operation">
                                                    <a class="tpl-table-black-operation-green"
                                                       href="<?= url("customer.history/index&&search=".$order['user_name']) ?>">
                                                        订单信息</a>

                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>


                                    <tr>
                                        <td colspan="<?= $colspan+1 ?>" class="am-text-center">暂无记录</td>
                                        <!--因新增加的复选框，导致底部样式改变，所以colspan多加一位-->
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="am-u-lg-12 am-cf">
                                <div class="am-fr pagination-total am-margin-right">
                                    <div class="am-vertical-align-middle">总记录：<?= isset($new_arr)?count($new_arr):0 ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>

            $(function () {
                //初始化
                function initTable() {
                    var checkAll = $('#checkAll');


                    //得到tbody中的所有选框.
                    var checks = $('input[name="checkitem"]');

                    //给全选框添加事件
                    checkAll.on('click',function(event){
                        if($(this).prop('checked') == false){ //全部取消
                            $('input[type="checkbox"]').prop('checked',false);
                        }else{
                            $('input[type="checkbox"]').prop('checked',true);
                        }
                    });

                    //给每个单独的选择框加事件
                    $('tbody').on('click',function(event){
                        checks = $('input[name="checkitem"]');
                        if (event.target.name == 'checkitem'){
                            if($(this).prop('checked') == false){
                                $(this).prop('checked',false);
                            }else{
                                $(this).prop('checked',true);
                            }
                            //判断是否选满了
                            if(checks.length == $('tbody').find('input:checked').length){
                                checkAll.prop('checked',true);
                            }else{
                                checkAll.prop('checked',false);
                            }
                        }
                    });
                }

                initTable();



                /**
                 * 订单导出
                 */
                $('.j-export').click(function () {
                    var data = {};
                    //当复选框全选或者全不选时，执行全部导出
                    if ($('tbody').find('input:checked').length <= 0 || $('tbody').find('input:checked').length == $('input[name="checkitem"]').length){
                        var formData = $('#form-search').serializeArray();
                        $.each(formData, function () {
                            this.name !== 's' && (data[this.name] = this.value);
                        });
                        window.location = "<?= url('new_order/export') ?>" + '&' + $.urlEncode(data);
                    } else{
                        var formData = $('tbody').find('input:checked').serializeArray();
                        $.each(formData, function (i) {
                            this.name !== 's' && (data[i] = this.value);//设定数组下标为递增数字，避免因获取的复选框name值一致导致数组内重写
                        });
                        // console.log( $.urlEncode(data));return;
                        window.location = "<?= url('new_order/exports') ?>" + '&' + $.urlEncode(data);

                    }

                });

            });

        </script>
    </div>
    <!-- 内容区域 end -->

</div>
<script>
    $(function () {
        // 删除元素
        var url = "<?= url('order.index/del_order') ?>";

        $('.iteam-del').delete('user_id', url, '删除后不可恢复，确定要删除吗？');


        // $('.search').each(function () {
        //     $(this).click(function () {
        //         var s = $(this).text();
        //         var val = $('input[name="search"]').val(s);
        //         // console.log(val);
        //         // $('button[type="submit"]').click();
        //     })
        // })


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



