<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:90:"C:\Users\Administrator\Desktop\glasses\web/../source/application/store\view\user\index.php";i:1601114968;}*/ ?>

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
    <link rel="stylesheet" href="assets/layui/css/layui.css"/>
    <link rel="stylesheet" href="assets/store/css/app.css?v=<?= $version ?>"/>
    <link rel="stylesheet" href="http://dbushell.github.com/Pikaday/css/pikaday.css">

    <link rel="stylesheet" href="//at.alicdn.com/t/font_783249_m68ye1gfnza.css">
    <script src="assets/common/js/jquery.min.js"></script>
    <script src="//at.alicdn.com/t/font_783249_e5yrsf08rap.js"></script>
    <!--    <script src="assets/layui/layui.js"></script>-->
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
        <!--        <link rel="stylesheet" href="assets/layui/css/layui.css">-->
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">
                        <div class="widget-head am-cf">
                            <div class="widget-title a m-cf">门店列表</div>
                        </div>
                        <div class="widget-body am-fr">
                            <!-- 工具栏 -->
                            <div class="page_toolbar am-margin-bottom-xs am-cf">
                                <!--                        <div class="am-form-group">-->
                                <!--                            --><?php //if (checkPrivilege('shop/add')): ?>
                                <!--                                <div class="am-btn-group am-btn-group-xs">-->
                                <!--                                    <a class="am-btn am-btn-default am-btn-success"-->
                                <!--                                       href="--><?php echo '<?'; ?>
//= url('shop/add') ?><!--">-->
                                <!--                                        <span class="am-icon-plus"></span> 新增-->
                                <!--                                    </a>-->
                                <!--                                </div>-->
                                <!--                            --><?php //endif; ?>
                                <!--                        </div>-->
                            </div>
                            <div class="am-scrollable-horizontal am-u-sm-12">
                                <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                                    <thead>
                                    <tr>
                                        <!--<th>ID</th>-->
                                        <th>姓名</th>
                                        <th>手机号</th>
                                        <th>地址</th>
                                        <th>店铺名称</th>
                                        <th>店铺类型</th>
                                        <th>营业执照</th>
                                        <!--                                        <th>性别</th>-->
                                        <th>创建时间</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                        <tr>
                                            <!--<td class="am-text-middle"><?php echo '<?'; ?>
/*= $item['user_id'] */?></td>-->
                                            <td class="am-text-middle"><?= $item['linkman'] ?></td>
                                            <td class="am-text-middle"><?= $item['username'] ?></td>

                                            <td class="am-text-middle">
                                                <?= $item['region']['province'] ?>  <?= $item['region']['city'] ?>  <?= $item['region']['region'] ?>
                                                <?= $item['address_detail'] ?>
                                            </td>
                                            <td class="am-text-middle"><?= $item['shop_name'] ?></td>
                                            <?php if($item['type'] == 0):?>
                                                <td class="am-text-middle">个体</td>
                                            <?php  endif; if($item['type'] == 1):?>
                                                <td class="am-text-middle">分店</td>
                                            <?php  endif; if($item['type'] == 2):?>
                                                <td class="am-text-middle">总店</td>
                                            <?php  endif; ?>
                                            <td class="am-text-middle">
                                                <a href="<?= explode(',',$item['bussiness_img'])[0] ?>" title="点击查看大图" target="_blank">
                                                    <img src="<?= explode(',',$item['bussiness_img'])[0] ?>" width="72" height="72" alt="">
                                                </a>
                                            </td>

                                            <td class="am-text-middle"><?= $item['create_time'] ?></td>

                                            <td class="am-text-middle">
                                                <?php if($item['status'] == 0):?>
                                                    <span class="am-badge am-badge-warning">
                                              待审核
                                           </span>
                                                <?php  endif; if($item['status'] == 1):?>
                                                    <span class="am-badge am-badge-success">
                                              启用
                                           </span>
                                                <?php  endif; if($item['status'] == 2):?>
                                                    <span class="am-badge am-badge-danger">
                                              禁用
                                           </span>
                                                <?php  endif; ?>

                                            </td>

                                            <td class="am-text-middle">
                                                <div class="tpl-table-black-operation">
                                                    <?php if (checkPrivilege('user/edit')): ?>
                                                        <a href="<?= url('user/edit', ['user_id' => $item['user_id']]) ?>">
                                                            <i class="am-icon-pencil"></i> 编辑
                                                        </a>
                                                    <?php endif; if (checkPrivilege('user/delete')): ?>
                                                        <a href="javascript:void(0);"
                                                           class="item-delete tpl-table-black-operation-del"
                                                           data-id="<?= $item['user_id'] ?>">
                                                            <i class="am-icon-trash"></i> 删除
                                                        </a>
                                                    <?php endif; if (checkPrivilege('user/agree')): if ($item['status'] == 0): ?>
                                                            <a href="javascript:void(0);"
                                                               class="item-agree tpl-table-black-operation-success"
                                                               data-id="<?= $item['user_id'] ?>">
                                                                <i class="am-icon-digg"></i> 通过
                                                            </a>
                                                        <?php endif; endif; if (checkPrivilege('user/disagree')): if ($item['status'] == 0): ?>
                                                            <a href="javascript:void(0);"
                                                               class="item-disagree tpl-table-black-operation-del"
                                                               data-id="<?= $item['user_id'] ?>">
                                                                <i class="am-icon-dashboard"></i> 拒绝
                                                            </a>
                                                        <?php endif; endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; else: ?>
                                        <tr>
                                            <td colspan="9" class="am-text-center">暂无记录</td>
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

        <div id="add-main" style="display: none;">

            <form class="layui-form my-form" id="add-form"  action="">
                <!--<div class="layui-form-item center" >
                    <label class="layui-form-label">日期范围</label>
                    <div class="layui-input-inline">
                        <input type="text" class="layui-input" id="test6" placeholder=" - " class="laydate-datetime layui-input layui-layer-content" name="start_time">
                    </div>
                </div>-->


                <div class="layui-form-item center" >
                    <label class="layui-form-label" style="width: 100px" >开始时间</label>
                    <div class="layui-input-block">
                        <input type="text" name="start_time" id="start_time"  required value="" style="width: 240px"  lay-verify="required" placeholder="请输入开始时间,例如2020-1-1" autocomplete="off" class="layui-input layui-layer-content">
                    </div>
                </div>
                <div class="layui-form-item center" >
                    <label class="layui-form-label" style="width: 100px" >到期时间</label>
                    <div class="layui-input-block">
                        <input type="text" name="end_time" id="end_time"  required value="" style="width: 240px"  lay-verify="required" placeholder="请输入到期时间,例如2020-1-1" autocomplete="off" class="layui-input layui-layer-content">
                    </div>
                </div>
                <div class="layui-form-item center" style="display: none">
                    <label class="layui-form-label" style="width: 100px" >App账号</label>
                    <div class="layui-input-block">
                        <input type="text" name="username" id="username"  required value="" style="width: 240px"  lay-verify="required" placeholder="请输入App账号" autocomplete="off" class="layui-input layui-layer-content">
                    </div>
                </div>
                <div class="layui-form-item" style="display: none">
                    <label class="layui-form-label" style="width: 100px">账号密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="password"  id="pwd" required  value=""  style="width: 240px" lay-verify="required" placeholder="请输入账号密码" autocomplete="off" class="layui-input layui-layer-content">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 100px">网址&emsp;</label>
                    <div class="layui-input-block">
                        <span>http://www.glasses.com/index.php?s=/store/passport/login</span>
                    </div>
                </div>
            </form>

        </div>
        <link rel="stylesheet" href="assets/layui/css/layui.css"/>
        <script src="assets/common/plugins/laydate/laydate.js"></script>

        <div id="disagree-main" style="display: none;">
            <form class="layui-form my-form"  action="">
                <div class="layui-form-item center" >
                    <label class="layui-form-label" style="width: 100px" >拒绝原因</label>
                    <div class="layui-input-block">
                        <input type="text" name="text" id="text"  required value="" style="width: 240px"  lay-verify="required" placeholder="请输入拒绝原因" autocomplete="off" class="layui-input layui-layer-content">
                    </div>
                </div>
            </form>
        </div>

        <script>
            $(function () {
                // 删除元素
                var url = "<?= url('user/delete') ?>";
                $('.item-delete').delete('user_id', url, '删除后不可恢复，确定要删除吗？');
                $('.item-agree').click(function () {
                    var  data = $(this).data();

                    $.showModal({
                        title: '发送账号'
                        , content: template('add-main', data)
                        , area: '500px'
                        , success: function (layero) {
                            //重写时间插件，在弹出的模态框中
                            $(layero).find('#start_time').datepicker({
                                timePicker:true,
                                language:'zh-cn',
                                autoClose: true,
                                minview:1,
                                format:'yyyy-mm-dd'
                            });
                            $(layero).find('#end_time').datepicker({
                                timePicker:true,
                                language:'zh-cn',
                                autoClose: true,
                                minview:1,
                                format:'yyyy-mm-dd'
                            });
                            var zIndex = $('.layui-layer').css('z-index')+1;//设置比模态框层级大一级
                            $('.am-datepicker').css('z-index',zIndex);

                        }

                        , yes: function (layero) {
                            var username = layero[1].value
                            var password = layero[2].value
                            layero.find('form').myAjaxSubmit({
                                url: '<?= url('user/setAccount') ?>',
                                data:data,
                                success:function (res) {
                                    if(res.code == 0){
                                        layer.alert(res.msg)
                                    }

                                }
                            });
                        }
                    });
                });


                //拒绝
                $('.item-disagree').click(function () {
                    var  data = $(this).data();
                    $.showModal({
                        title: '拒绝原因'
                        , content: template('disagree-main', data)
                        , area: '500px'
                        // , success: function ($content) {
                        //
                        // }
                        , yes: function (layero) {
                            var text = layero[1].value
                            layero.find('form').myAjaxSubmit({
                                url: '<?= url('user/disagree') ?>',
                                data:data,
                                success:function (res) {
                                    if(res.code == 0){
                                        layer.alert(res.msg)
                                    }

                                }
                            });
                        }
                    });
                });



            });

        </script>

    </div>
    <!-- 内容区域 end -->

</div>
<script src="assets/common/plugins/layer/layer.js"></script>


<script src="assets/layui/layui.all.js"></script>

<script src="assets/common/js/jquery.form.min.js"></script>
<script src="assets/common/js/amazeui.min.js"></script>
<script src="assets/common/js/webuploader.html5only.js"></script>
<script src="assets/common/js/art-template.js"></script>
<script src="assets/store/js/app.js?v=<?= $version ?>"></script>
<script src="assets/store/js/file.library.js?v=<?= $version ?>"></script>
</body>

</html>

