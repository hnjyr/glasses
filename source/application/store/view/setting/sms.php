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
                        <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">短信通知（阿里云短信）</div>
                                    </div>
                                    <input type="hidden" name="sms[default]" value="aliyun">
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label form-require"> AccessKeyId </label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" name="sms[engine][aliyun][AccessKeyId]"
                                                   value="<?= $values['engine']['aliyun']['AccessKeyId'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label form-require"> AccessKeySecret </label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="sms[engine][aliyun][AccessKeySecret]"
                                                   value="<?= $values['engine']['aliyun']['AccessKeySecret'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label form-require"> 短信签名 </label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" name="sms[engine][aliyun][sign]"
                                                   value="<?= $values['engine']['aliyun']['sign'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="widget-head am-cf" style="display: none">
                                        <div class="widget-title am-fl">新付款订单提醒</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label form-require">
                                            是否开启短信提醒
                                        </label>
                                        <div class="am-u-sm-9">
                                            <label class="am-radio-inline">
                                                <input type="radio" name="sms[engine][aliyun][order_pay][is_enable]" value="1"
                                                       data-am-ucheck
                                                    <?= $values['engine']['aliyun']['order_pay']['is_enable'] == '1' ? 'checked' : '' ?>
                                                       required>
                                                开启
                                            </label>
                                            <label class="am-radio-inline">
                                                <input type="radio" name="sms[engine][aliyun][order_pay][is_enable]" value="0"
                                                       data-am-ucheck
                                                    <?= $values['engine']['aliyun']['order_pay']['is_enable'] == '0' ? 'checked' : '' ?>>
                                                关闭
                                            </label>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label form-require">
                                            模板ID <span class="tpl-form-line-small-title">Template Code</span>
                                        </label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="sms[engine][aliyun][order_pay][template_code]"
                                                   value="<?= $values['engine']['aliyun']['order_pay']['template_code'] ?>">
                                            <small>例如：SMS_139800030</small>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-3">
                                            <small>模板内容：您有一条新订单，订单号为：${order_no}，请注意查看。</small>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label form-require"> 接收手机号 </label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="sms[engine][aliyun][order_pay][accept_phone]"
                                                   value="<?= $values['engine']['aliyun']['order_pay']['accept_phone'] ?>">
                                            <div class="help-block">
                                                <small>注：如需填写多个手机号，可用英文逗号 <code>,</code> 隔开</small>
                                            </div>
                                            <div class="help-block">
                                                <small>接收测试： <a class="j-sendTestMsg" data-msg-type="order_pay"
                                                                href="javascript:void(0);">点击发送</a>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-head am-cf" style="display: none">
                                        <div class="widget-title am-fl">短信注册</div>
                                    </div>

                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label form-require">
                                            模板ID <span class="tpl-form-line-small-title">Template Code</span>
                                        </label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="sms[engine][aliyun][register][template_code]"
                                                   value="<?= $values['engine']['aliyun']['register']['template_code'] ?>">
                                            <small>例如：SMS_139800030</small>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-3">
                                            <small>模板内容：您的验证码：${code}，请勿泄漏。</small>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-form-label form-require"> 接收手机号 </label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="sms[engine][aliyun][register][accept_phone]"
                                                   value="<?= $values['engine']['aliyun']['register']['accept_phone'] ?>">
                                            <div class="help-block">
                                                <small>注：如需填写多个手机号，可用英文逗号 <code>,</code> 隔开</small>
                                            </div>
                                        </div>
                                    </div>










                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                            <button type="submit" class="j-submit am-btn am-btn-secondary">提交
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
            $(function () {

                /**
                 * 表单验证提交
                 * @type {*}
                 */
                $('#my-form').superForm();

                /**
                 * 发送测试短信
                 */
                $('.j-sendTestMsg').click(function () {
                    var msgType = $(this).data('msg-type')
                        , formData = {
                        AccessKeyId: $('input[name="sms[engine][aliyun][AccessKeyId]"]').val()
                        , AccessKeySecret: $('input[name="sms[engine][aliyun][AccessKeySecret]"]').val()
                        , sign: $('input[name="sms[engine][aliyun][sign]"]').val()
                        , msg_type: msgType
                        , template_code: $('input[name="sms[engine][aliyun][' + msgType + '][template_code]"]').val()
                        , accept_phone: $('input[name="sms[engine][aliyun][' + msgType + '][accept_phone]"]').val()
                    };
                    if (!formData.AccessKeyId.length) {
                        layer.msg('请填写 AccessKeyId');
                        return false;
                    }
                    if (!formData.AccessKeySecret.length) {
                        layer.msg('请填写 AccessKeySecret');
                        return false;
                    }
                    if (!formData.sign.length) {
                        layer.msg('请填写 短信签名');
                        return false;
                    }
                    if (!formData.template_code.length) {
                        layer.msg('请填写 模板ID');
                        return false;
                    }
                    if (!formData.accept_phone.length) {
                        layer.msg('请填写 接收手机号');
                        return false;
                    }
                    layer.confirm('确定要发送测试短信吗', function (index) {
                        var load = layer.load();
                        var url = "<?= url('setting/smsTest') ?>";
                        $.post(url, formData, function (result) {
                            layer.msg(result.msg);
                            layer.close(load);
                        });
                        layer.close(index);
                    });
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

