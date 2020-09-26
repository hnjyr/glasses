<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>二郎神视力云管家</title>
    <link rel="stylesheet" href="assets/admin/css/common.css" type="text/css">
    <script src="assets/admin/js/flexible.js"></script>
    <style>
        .content {
            padding: 4.5rem .46875rem 3.125rem .46875rem;
        }

        .welcomes {
            font-size: .625rem;
            font-family: PingFangSC-Semibold, PingFang SC;
            font-weight: 600;
            color: rgba(51, 51, 51, 1);
            line-height: .625rem;
            margin-bottom: 1.6rem;
        }

        .telphone {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: .375rem 0;
            border-bottom: 2px solid #EEEEEE;
            margin-bottom: .125rem;
        }

        .img {
            width: .4375rem;
            height: .5625rem;
        }

        input {
            margin-left: .1875rem;
            color: #999999;
            font-weight: 400;
            font-size: .4375rem;
            line-height: .625rem;
        }

        .btnNext {
            width: 8.5rem;
            height: 1.4rem;
            background: rgba(13, 165, 111, 1);
            border-radius: .2rem;
            text-align: center;
            line-height: 1.4rem;
            font-size: .5rem;
            font-family: PingFangSC-Regular, PingFang SC;
            font-weight: 400;
            color: #FFFFFF;
            margin: 1.875rem auto;
        }

        .error {
            font-size: .1rem;
            color: red;
        }
    </style>
</head>

<body>
<div class="content">
    <div class="welcomes">
        您好，
        <span style="display: block;">欢迎来到二郎神视力云管家！</span>
    </div>
    <div class="telphone">
        <image src="assets/admin/img/phone.png" mode="" class="img"></image>
        <input id="text" type="text" placeholder="输入手机号" />
    </div>
    <div class="error"></div>
    <div class="btnNext" @click="next" id="next">下一步</view>
    </div>
</body>
<script src="assets/admin/js/jQuery.min.js"></script>
<script type="text/javascript">
    $('#next').click(() => {
        let value = $("#text").val();
        let reg = /^1[3|4|5|7|8][0-9]{9}$/;
        $('.error').html('')
        if (value.trim() == '') {
            $('.error').html('请输入您的手机号')
            return;
        } else if (!reg.test(value)) {
            $('.error').html('请输入正确的手机号码')
            return;
        }
        window.location = "<?= url('wxapp.index/login') ?>"+ '&' + 'mobile='+value

    })
</script>

</html>