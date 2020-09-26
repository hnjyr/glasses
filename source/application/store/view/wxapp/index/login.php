<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        .countDown {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: .4rem;
            font-family: PingFangSC-Regular, PingFang SC;
            font-weight: 550;
            line-height: 1rem;
        }

        .Tips {
            flex: 1;
            color: #333333;
        }

        .phone {
            color: #E05151;
        }

        .times {
            color: #999999;
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

        .telphone {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: .3rem 0;
            border-bottom: 2px solid #EEEEEE;
            margin-bottom: 1.875rem;

        }

        .telphone input {
            color: #999999;
            font-weight: 400;
            font-size: .4rem;
            line-height: .5rem;
        }

        .sendOut {
            font-size: .2rem;
            line-height: .5rem;
            background-color: #F6B70F;
            border-radius: .1rem;
            padding: .15rem .3rem;
            color: #fff;
        }
    </style>
</head>

<body>
<div class="content">
    <div class="welcomes">
        验证码
    </div>
    <div class="countDown">
        <div class="Tips">手机号
            <span class="phone" ><?= $mobile ?></span>，请查收</div>
        <input type="hidden" name="phone" value="<?= $mobile ?>" id="phone">
        <div class="times" id='times'></div>
        <div class="sendOut" @click="sendOut" id="sendOut"></div>
        <!-- {{yzmtext=='重新获取验证码'?yzmtext:yzmtext+'s'}} -->
    </div>
    <div class="telphone">
        <input type="number"  name="code" value="" id="text" placeholder="输入验证码" maxlength="4" placeholder-style='color:#999;' />
    </div>
    <div class="btnNext" id="btnNext">确认</div>
</div>
</body>

<script src="assets/admin/js/jQuery.min.js"></script>
<script type="text/javascript">
    window.onload = function () {
        var times = document.getElementById('times')
        var sendOut = document.getElementById('sendOut')
        var btnNext = document.getElementById('btnNext')
        var text = document.getElementById('text')
        var a = true;
        var len = 60;
        $("#sendOut").hide();
        $("#times").show();
        var phone = $("#phone").val();
        if (a) {
            times.innerHTML = len + 's';
            var time = setInterval(function () {
                times.innerHTML = parseFloat(times.innerHTML) - 1 + 's'
                if (times.innerHTML == '1s') {
                    $("#sendOut").show();
                    $("#times").hide();
                    $("#sendOut").html('重新获取验证码');
                    clearInterval(time);
                    a = true;
                }
            }, 1000);
            a = false;
        } else {
            return false;
        }
        $.post({
            url:"<?= url('wxapp.Index/smscode') ?>",
            data:{phone:phone},
            dataType:'json',

        })
        // 重新获取验证码
        $('#sendOut').click(function () {
            var a = true;
            var len = 60;
            $("#sendOut").hide();
            $("#times").show();
            if (a) {
                // 发送验证码
                $.post({
                    url:"<?= url('wxapp.Index/smscode') ?>",
                    data:{phone:phone},
                    dataType:'json',
                    success:function (res) {
                        console.log(res)
                        if(res.code == 1){
                            alert(res.msg)
                        }else{
                            alert(res.msg)
                        }
                    }

                })

                times.innerHTML = len + 's';
                var time = setInterval(function () {
                    times.innerHTML = parseFloat(times.innerHTML) - 1 + 's'
                    if (times.innerHTML == '1s') {
                        $("#sendOut").show();
                        $("#times").hide();
                        $("#sendOut").html('重新获取验证码');
                        clearInterval(time);
                        a = true;
                    }
                }, 1000);
                a = false;
            } else {
                return false;
            }
        })


        // 点击确定的事件  发送手机号及验证码验证是否通过，通过跳转页面
        $('#btnNext').click(function(){
            let code = $("#text").val();
            if(!code){
                alert('验证码不能为空!')
                return false;
            }
            let mobile =  $("#phone").val();
            $.post({
                url:"<?= url('wxapp.index/orderList') ?>",
                data:{code:code,mobile:mobile},
                dataTpe:'json',
                success:function (res) {
                    if(res.code == 1){
                        window.location = "<?= url('wxapp.index/userlist') ?>"
                    }else{
                        alert(res.msg);
                    }
                }
            })
        })


    }
</script>

</html>