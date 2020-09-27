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
                                                    <?php if (checkPrivilege('order.index/export')): ?>
                                                        <!-- <a class="j-export am-btn am-btn-danger am-radius"
                                                           href="javascript:void(0);">
                                                            <i class="iconfont icon-daochu am-margin-right-xs"></i>订单导出
                                                        </a> -->
                                                    <?php endif; ?>
                                                    <div class="am-u-sm-12 am-u-md-3" style="display: none">
                                                        <div class="am-form-group">
                                                            <?php if($admin_info['is_super'] != 1): ?>
                                                                <div class="am-btn-group am-btn-group-xs">
                                                                    <a class="am-btn am-btn-default am-btn-success"
                                                                       href="<?= url('order.index/add') ?>">
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
                                            <div class="am-form-group tpl-form-border-form am-fl">
                                                <input type="text" name="start_time"
                                                       class="am-form-field"
                                                       value="<?= $request->get('start_time') ?>" placeholder="请选择起始日期"
                                                       data-am-datepicker>
                                            </div>
                                            <div class="am-form-group tpl-form-border-form am-fl">
                                                <input type="text" name="end_time"
                                                       class="am-form-field"
                                                       value="<?= $request->get('end_time') ?>" placeholder="请选择截止日期"
                                                       data-am-datepicker>
                                            </div>
                                            <!--<div class="am-form-group am-fl">
                                                <div class="am-input-group am-input-group-sm tpl-form-border-form">
                                                    <input type="text" class="am-form-field" name="shopName"
                                                           placeholder="请输入店铺名" value="<?/*= $request->get('shopName') */?>">
                                                    <div class="am-input-group-btn">
                                                        <button class="am-btn am-btn-default am-icon-search"
                                                                type="submit"></button>
                                                    </div>
                                                </div>
                                            </div>-->
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
                            <div class="order-list am-scrollable-horizontal am-u-sm-12 am-margin-top-xs" >
                                <table width="100%" border="1" cellspacing="0" class="am-table am-table-centered
                        am-text-nowrap am-margin-bottom-xs">
                                    <thead>
                                    <tr>
                                        <th><input id="checkAll" type="checkbox"></th>
                                        <!--<th width="12%">订单号</th>-->
<!--                                        <th>店铺名</th>-->
                                        <th>客户姓名</th>
                                        <th>手机号</th>
                                        <th colspan="3">商品信息</th>
<!--                                        <th>折扣金额</th>-->
<!--                                        <th>合计金额</th>-->
                                        <th>实收金额</th>
                                        <th>积分</th>
                                        <th width="15%">说明</th>
                                        <th>订单时间</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $colspan = 12; ?>
                                    <?php if (!$glassesList->isEmpty()): foreach ($glassesList as $order): ?>
                                        <tr>
                                            <td class="am-text-middle am-text-left" rowspan="2">
                                                <input type="checkbox" name="checkitem" value="">
                                            </td>
                                            <!--<td class="am-text-middle am-text-left" rowspan="2">
                                                <span class="am-margin-right-lg"><?/*= $order['shop_name'] */?></span>
                                            </td>-->
                                            <td class="am-text-middle" rowspan="2">
                                                <span > <?= $order['user_name'] ?></span>
                                            </td>
                                            <td class="am-text-middle" rowspan="2">
                                                <span > <?= $order['mobile'] ?></span>
                                            </td>
                                            <td>
                                                <span>右眼：</span>
                                            </td>
                                            <td class="am-text-middle"  style="text-align: left" >
                                                <?php if ($order['right_frame_num'] != 0): ?>
                                                    <span >镜片:(<?= $order['right_frame'] ?>)*<?= $order['right_frame_num'] ?> </span>
                                                <?php  endif;?>
                                                <?php if ($order['right_frame_num'] == 0): ?>
                                                    暂无数据
                                                <?php  endif;?>

                                            </td>
                                            <td rowspan="2">
                                                <?php if ($order['right_glasses_cloth_num'] != 0): ?>
                                                    <br><span >镜框:(<?= $order['right_glasses'] ?>)*<?= $order['right_glasses_cloth_num'] ?> </span>
                                                <?php  endif;?>
                                                <?php if ($order['glasses_les_num'] != 0): ?>
                                                    <br><span >镜盒:(<?= $order['glasses_les'] ?>)*<?= $order['glasses_les_num'] ?> </span>
                                                <?php  endif;?>
                                                <?php if ($order['glasses_case_num'] != 0): ?>
                                                    <br><span >镜布:(<?= $order['case'] ?>)*<?= $order['glasses_case_num'] ?> </span>
                                                <?php  endif;?>
                                                <?php if ($order['glasses_other_num'] != 0): ?>
                                                    <br><span >镜布:(<?= $order['other'] ?>)*<?= $order['glasses_other_num'] ?> </span>
                                                <?php  endif;?>
                                                <?php if ($order['right_glasses_cloth_num'] == 0 && $order['glasses_les_num'] == 0
                                                    && $order['glasses_case_num'] == 0 && $order['glasses_other_num'] == 0): ?>
                                                    暂无数据
                                                <?php  endif;?>
                                            </td>
                                           <!-- <td class="am-text-middle" rowspan="2">
                                                <span > <?/*= $order['discount'] */?></span>
                                            </td>
                                            <td class="am-text-middle" rowspan="2">
                                                <span > <?/*= $order['total'] */?></span>
                                            </td>-->
                                            <td class="am-text-middle" rowspan="2">
                                                <span > <?= $order['pay_total'] ?></span>
                                            </td>
                                            <td class="am-text-middle" rowspan="2">
                                                <span > <?= $order['point'] ?></span>
                                            </td>
                                            <td class="am-text-middle" rowspan="2">
                                                <span > <?= $order['notes'] ?></span>
                                            </td>
                                            <td class="am-text-middle" rowspan="2">
                                                <span > <?= $order['create_time'] ?></span>
                                            </td>
                                            <td class="am-text-middle" rowspan="2">
                                                <div class="tpl-table-black-operation">
                                                    <a class="tpl-table-black-operation-green"
                                                       href="<?= url('order.glasses/detail', ['order_id' => $order['glasses_id']]) ?>">
                                                        订单详情</a>
                                                    <a class="tpl-table-black-operation-del" target="_blank"
                                                       href="<?= url('order.glasses/print_order', ['order_id' => $order['glasses_id']]) ?>">
                                                        打印订单</a>
                                                    <a class="tpl-table-black-operation-del iteam-del iteam-del2"
                                                       href="javascript:void(0);" data-id="<?= $order['glasses_id'] ?>">
                                                        删除订单</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span>左眼：</span>
                                            </td>
                                            <td class="am-text-middle"  style="text-align: left">
                                                <?php if ($order['left_frame_num'] != 0): ?>
                                                    <span >镜片:(<?= $order['left_frame'] ?>)*<?= $order['left_frame_num'] ?> </span>
                                                <?php  endif;?>
                                                <?php if ($order['left_frame_num'] == 0): ?>
                                                    暂无数据
                                                <?php  endif;?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if (!$contactList->isEmpty()): foreach ($contactList as $order): ?>
                                        <tr>
                                            <td class="am-text-middle am-text-left" rowspan="2">
                                                <input type="checkbox" name="checkitem" >
                                            </td>
                                           <!-- <td class="am-text-middle am-text-left" rowspan="2">
                                                <span class="am-margin-right-lg"><?/*= $order['shop_name'] */?></span>
                                            </td>-->
                                            <td class="am-text-middle" rowspan="2">
                                                <span > <?= $order['user_name'] ?></span>
                                            </td>
                                            <td class="am-text-middle" rowspan="2">
                                                <span > <?= $order['mobile'] ?></span>
                                            </td>
                                            <td>
                                                <span>右眼：</span>
                                            </td>
                                            <td class="am-text-middle" style="text-align: left" >
                                                <?php if ($order['contact_num'] != 0): ?>
                                                    <span >隐形眼镜:(<?= $order['contact'] ?>)*<?= $order['contact_num'] ?> </span>
                                                <?php  endif;?>
                                                <?php if ($order['contact_num'] == 0): ?>
                                                    暂无数据
                                                <?php  endif;?>

                                            </td>
                                            <td rowspan="2">
                                                <?php if ($order['solution_num'] != 0): ?>
                                                    <br><span >护理液:(<?= $order['contact_solution'] ?>)*<?= $order['solution_num'] ?> </span>
                                                <?php  endif;?>
                                                <?php if ($order['contact_les_num'] != 0): ?>
                                                    <br><span >隐形镜盒:(<?= $order['contact_les'] ?>)*<?= $order['contact_les_num'] ?> </span>
                                                <?php  endif;?>
                                                <?php if ($order['solution_num'] == 0 && $order['contact_les_num'] == 0): ?>
                                                    暂无数据
                                                <?php  endif;?>
                                            </td>
                                           <!-- <td class="am-text-middle" rowspan="2">
                                                <span > <?/*= $order['discount'] */?></span>
                                            </td>
                                            <td class="am-text-middle" rowspan="2">
                                                <span > <?/*= $order['total'] */?></span>
                                            </td>-->
                                            <td class="am-text-middle" rowspan="2">
                                                <span > <?= $order['pay_total'] ?></span>
                                            </td>
                                            <td class="am-text-middle" rowspan="2">
                                                <span > <?= $order['point'] ?></span>
                                            </td>
                                            <td class="am-text-middle" rowspan="2">
                                                <span > <?= $order['notes'] ?></span>
                                            </td>
                                            <td class="am-text-middle" rowspan="2">
                                                <span > <?= $order['create_time'] ?></span>
                                            </td>
                                            <td class="am-text-middle" rowspan="2">
                                                <div class="tpl-table-black-operation">
                                                    <a class="tpl-table-black-operation-green"
                                                       href="<?= url('order.contact/detail', ['order_id' => $order['contact_id']]) ?>">
                                                        订单详情</a>
                                                    <a class="tpl-table-black-operation-del" target="_blank"
                                                       href="<?= url('order.contact/print_order', ['order_id' => $order['contact_id']]) ?>">
                                                        打印订单</a>
                                                    <a class="tpl-table-black-operation-del iteam-del iteam-del1"
                                                       href="javascript:void(0);" data-id="<?= $order['contact_id'] ?>">
                                                        删除订单</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span>左眼：</span>
                                            </td>
                                            <td class="am-text-middle" style="text-align: left" >
                                                <?php if ($order['left_contact_num'] != 0): ?>
                                                    <span >隐形眼镜:(<?= $order['left_contact'] ?>)*<?= $order['left_contact_num'] ?> </span>
                                                <?php  endif;?>
                                                <?php if ($order['left_contact_num'] == 0): ?>
                                                    暂无数据
                                                <?php  endif;?>
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

                                <div class="am-fr pagination-total am-margin-right">
                                    <div class="am-vertical-align-middle">总记录：<?= $glassesList->total()+ $contactList->total()?></div>
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
                        window.location = "<?= url('order.index/export') ?>" + '&' + $.urlEncode(data);
                    } else{
                        var formData = $('tbody').find('input:checked').serializeArray();
                        $.each(formData, function (i) {
                            this.name !== 's' && (data[i] = this.value);//设定数组下标为递增数字，避免因获取的复选框name值一致导致数组内重写
                        });
                        // console.log( $.urlEncode(data));return;
                        window.location = "<?= url('order.index/exports') ?>" + '&' + $.urlEncode(data);

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
        var url = "<?= url('order.glasses/del_order') ?>";

        $('.iteam-del2').delete('glasses_id', url, '删除后不可恢复，确定要删除吗？');



    });

</script>
<script>
    $(function () {
        // 删除元素
        var url = "<?= url('order.contact/del_order') ?>";

        $('.iteam-del1').delete('contact_id', url, '删除后不可恢复，确定要删除吗？');



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



