<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <title><?= $setting ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="assets/common/i/favicon.ico"/>
    <link rel="stylesheet" href="assets/store/css/login/style.css?v=<?= $version ?>"/>
    <script src="/js/flexible.js"></script>
    <style>
        @media screen and (min-width: 1366px) and (max-width: 1920px){
            html{font-size: 19px;}
        }
        /* ## */
        @media screen and (min-width: 1920px) {
            html {
                font-size: 13px;
            }
        }
    </style>
</head>
<body class="page-login-v3">
<div class="container">
    <div id="wrapper" class="login-body">
        <div class="login-content">
            <div class="brand">
                <img alt="logo" class="brand-img" src="assets/store/img/login/logo.png?v=<?= $version ?>" style="position: absolute;left: 25%">
                <h2 class="brand-text" style="margin-left: 18%"><?= $setting ?></h2>
            </div>
            <form id="login-form" class="login-form" onsubmit="return false;">
                <div class="form-group">
                    <input  class="username" name="User[user_name]" placeholder="请输入手机号" id='phone' type="text" required>
                    <img src="assets/store/img/login/username.png" alt="">
                </div>
                <div class="form-group">
                <img src="assets/store/img/login/password.png" alt="">
                    <input class="password" name="User[password]" placeholder="请输入密码" type="password" required>
                </div>
                <div class="form-group">
                    <button id="btn-submit" type="submit">
                        登录
                    </button>
                </div>
                <div class="form-group">
                    <a href="index.php?s=/store/passport/register" style="text-decoration: none">去注册</a>
                </div>
            </form>
        </div>
    </div>

</div>
</body>
<script src="assets/common/js/jquery.min.js"></script>
<script src="assets/common/plugins/layer/layer.js?v=<?= $version ?>"></script>
<script src="assets/common/js/jquery.form.min.js"></script>
<script>

    const that=this
    function isPhone(str) {
        let reg = /^((0\d{2,3}-\d{7,8})|(1[3456789]\d{9}))$/;
        return reg.test(str);
    }
    $('#btn-submit').click(function() {
        var value=$("#phone").val()
        var flag=that.isPhone(value)
        if(flag&&value!=''){
            var $form = $('#login-form');
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
</html>
