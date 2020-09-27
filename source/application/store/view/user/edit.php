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
                        <form id="my-form" class="am-form tpl-form-line-form" method="post">
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">编辑门店</div>
                                    </div>

                                    <div class="am-form-group am-padding-top">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 姓名 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="text" class="tpl-form-input" name="user[linkman]"
                                                   placeholder="请输入门店联系人" value="<?= $model['linkman'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 电话 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="text" id="user_name" class="tpl-form-input" name="user[username]"
                                                   placeholder="请输入电话" οnkeyup="value=value.replace(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/,'')" maxlength="11" value="<?= $model['username'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 门店名称 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="text" class="tpl-form-input" name="user[shop_name]"
                                                   placeholder="请输入姓名" value="<?= $model['shop_name'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="am-form-group am-padding-top">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 门店地址 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <div class="x-region-select" data-region-selected>
                                                <select name="user[province_id]"
                                                        data-province
                                                        data-id="<?= $model['province_id'] ?>"
                                                        required>
                                                    <option value="">请选择省份</option>
                                                </select>
                                                <select name="user[city_id]"
                                                        data-city
                                                        data-id="<?= $model['city_id'] ?>"
                                                        required>
                                                    <option value="">请选择城市</option>
                                                </select>
                                                <select name="user[region_id]"
                                                        data-region
                                                        data-id="<?= $model['region_id'] ?>"
                                                        required>
                                                    <option value="">请选择地区</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 详细地址 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="text" class="tpl-form-input" name="user[address_detail]"
                                                   placeholder="请输入详细地址" value="<?= $model['address_detail'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 性别 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <label class="am-radio-inline">
                                                <input type="radio" name="user[gender]" value="0" data-am-ucheck
                                                    <?= $model['gender'] == 0 ? 'checked' : '' ?>>
                                                保密
                                            </label>
                                            <label class="am-radio-inline">
                                                <input type="radio" name="user[gender]" value="1" data-am-ucheck
                                                    <?= $model['gender'] == 1 ? 'checked' : '' ?>>
                                                男
                                            </label>
                                            <label class="am-radio-inline">
                                                <input type="radio" name="user[gender]" value="2" data-am-ucheck
                                                    <?= $model['gender'] == 2 ? 'checked' : '' ?>>
                                                女
                                            </label>
                                        </div>
                                    </div>
                                    <div class="am-form-group" style="display: none">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">门店类型</label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <select name="user[type]">
                                                <option value="" >请选择</option>
                                                <option value="1" <?= $model['type'] ==1 ? 'selected' : '' ?> >分店</option>
                                                <option value="2" <?= $model['type'] ==2 ? 'selected' : '' ?>>总店</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 到期时间 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="text" class="tpl-form-input" name="user[end_time]"
                                                   placeholder="请输入时间" value="<?= date('Y-m-d',$model['end_time']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 营业执照 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <img width="72" height="72" src="<?= $model['bussiness_img'] ?>" alt="">
                                            <!--<input type="text" class="tpl-form-input" name="user[username]"
                                                   placeholder="请输入时间" value="<?/*= $model['bussiness_img'] */?>" required>-->
                                        </div>
                                    </div>

                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 门面照片 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <img width="72" height="72" src="<?= $model['shop_img'] ?>" alt="">
                                           <!-- <input type="text" class="tpl-form-input" name="user[username]"
                                                   placeholder="请输入时间" value="<?/*= $model['shop_img'] */?>" required>-->
                                        </div>
                                    </div>


                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 门店状态 </label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <label class="am-radio-inline">
                                                <input type="radio" name="user[status]" value="0" data-am-ucheck
                                                    <?= $model['status'] == 0 ? 'checked' : '' ?>>
                                                待审核
                                            </label>
                                            <label class="am-radio-inline">
                                                <input type="radio" name="user[status]" value="1" data-am-ucheck
                                                    <?= $model['status'] == 1 ? 'checked' : '' ?>>
                                                启用
                                            </label>
                                            <label class="am-radio-inline">
                                                <input type="radio" name="user[status]" value="0" data-am-ucheck
                                                    <?= $model['status'] == 2 ? 'checked' : '' ?>>
                                                禁用
                                            </label>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                            <button type="submit" id="sub_mit" class="j-submit am-btn am-btn-secondary">提交
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
        {{include file="layouts/_template/file_library" /}}

        <script src="assets/store/js/select.region.js?v=1.2"></script>
        <script>
            /**
             * 设置坐标
             */
            function setCoordinate(value) {
                var $coordinate = $('#coordinate');
                $coordinate.val(value);
                // 触发验证
                $coordinate.trigger('change');
            }
        </script>
        <script>
            $(function () {

                // 选择图片
                $('.upload-file').selectImages({
                    name: 'shop[logo_image_id]'
                });

                /**
                 * 表单验证提交
                 * @type {*}
                 */
                function isPhone(str) {
                    let reg = /^((0\d{2,3}-\d{7,8})|(1[3456789]\d{9}))$/;
                    return reg.test(str);
                }
                $('#sub_mit').click(function() {
                    if(!isPhone($('#user_name').val())) {
                        layer.msg('手机号格式错误')
                        return false;
                    }
                    $('#my-form').superForm();
                })
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

