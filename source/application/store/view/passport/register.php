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

    <link href="/assets/layui/css/layui.css" rel="stylesheet" />
    <script src="/assets/layui/layui.js" type="text/javascript"></script>

    <style type="text/css">

        body{ background:#EEEEEE;margin:0; padding:0; font-family:"微软雅黑", Arial, Helvetica, sans-serif; }

        a{ color:#006600; text-decoration:none;}

        a:hover{color:#990000;}

        .top{ margin:5px auto; color:#990000; text-align:center;}

        .info select{ border:1px #651BCF solid; background:#FFFFFF;border-bottom:0px!important;font-size: 16px;}

        .info{ margin:5px; text-align:center;}

        .info #show{ color:#3399FF; }

        .bottom{ text-align:right; font-size:12px; color:#CCCCCC; width:1000px;}
        .address{
            display: inline-block;
            border: 0;
            border-radius: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
            width: 356px;
            border-bottom: 1px solid #651BCF;
            background: #F2F2F2;
            font-size: 20px;
            height: 40px;
            line-height: 1.5;
            margin-left: 10px;
            outline: none;
            padding: 0 4px;
            color: #000;
            font: 18px/1.5 "Segoe UI", "Lucida Grande", Helvetica, Arial, "Microsoft YaHei", FreeSans, Arimo, "Droid Sans", "wenquanyi micro hei", "Hiragino Sans GB", "Hiragino Sans GB W3", Roboto, Arial, sans-serif;
            transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -webkit-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s ease-in-out;
            text-align: left;
        }

        .div{
            display: inline-block;
            border: 0;
            border-radius: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
            width: 356px;
            border-bottom: 1px solid #651BCF;
            background: #F2F2F2;
            font-size: 20px;
            height: 40px;
            line-height: 1.5;
            margin-left: 10px;
            outline: none;
            padding: 0 4px;
            color: #a3afb7;
            font: 18px/1.5 "Segoe UI", "Lucida Grande", Helvetica, Arial, "Microsoft YaHei", FreeSans, Arimo, "Droid Sans", "wenquanyi micro hei", "Hiragino Sans GB", "Hiragino Sans GB W3", Roboto, Arial, sans-serif;
            transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -webkit-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s ease-in-out;
            text-align: left;
            color:#757575;
        }
        .select{
            width:200px;
            height:30px;
            appearance:none;
            -moz-appearance:none;
            -webkit-appearance:none;
            background-size:10%;
            font-size:16px;
            font-family:Microsoft YaHei;
            outline:none;
            display: inline-block;
            border: 0;
            border-radius: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
            width: 356px;
            border-bottom: 1px solid #651BCF;
            background: #F2F2F2;
            font-size: 20px;
            height: 40px;
            line-height: 1.5;
            margin-left: 10px;
            outline: none;
            padding: 0 4px;
            color: #000;
            font: 18px/1.5 "Segoe UI", "Lucida Grande", Helvetica, Arial, "Microsoft YaHei", FreeSans, Arimo, "Droid Sans", "wenquanyi micro hei", "Hiragino Sans GB", "Hiragino Sans GB W3", Roboto, Arial, sans-serif;
            transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -webkit-transition: all 0.3s ease-in-out;
        }
        input::-webkit-input-placeholder{
            color:#757575;
        }
        input:-webkit-autofill{
            -webkit-box-shadow: 0 0 0 1000px #F2F2F2 inset!important;
            -webkit-text-fill-color: #000!important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-transition-delay: 99999s;
            -webkit-transition: color 99999s ease-out, background-color 99999s ease-out;
        }
		.register-body {
			padding: 30px 60px 0;
			height: auto;
			width: auto;
		}
		.container {
			/* text-align: left; */
		}
		#btn-submit-register {
			margin-top: 20px;
		}

        .layui-layer {
            position: fixed!important;
            top: 50%!important;
            left: 50%!important;
            transform: translate(-50%,-50%)!important;
            background: rgba(0,0,0,0.7)!important;
            padding: 15px 30px!important;
            border-radius: 10px!important;
            color: #fff!important;
        }

    </style>
</head>
<body class="page-login-v3">
<div class="container">
    <div id="wrapper" class="register-body">
        <div class="register-content">
            <div class="brand brand_top">
                <img alt="logo" class="brand-img" src="assets/store/img/login/logo.png?v=<?/*= $version */?>" >
                <div class="brand_info">
					<p class="brand-text">欢迎注册</p>
					<p class="brand-login">已有账号？<a href="index.php?s=/store/passport/login">登录</a></p>
				</div>
            </div>
            <div class="form_box">
				<form id="register-form"  class="register-form" onsubmit="return false;">
					<div class="first_form">
						<div class="form-group group_img1">
							<img class="input_icon" src="assets/store/img/login/username.png" alt="" style="">
							<input  class="username" name="Register[linkman]" placeholder="请输入用户名" type="text" required >
						</div>
						<div class="form-group">
							<img class="input_icon" src="assets/store/img/login/password.png" alt="" style="">
							<input  class="password" name="Register[password]" placeholder="请输入密码" type="password" required >
						</div>
						<div class="form-group">
							<img class="input_icon" src="assets/store/img/login/password.png" alt="" style="">
							<input  class="password1" name="Register[password1]" placeholder="请再次输入密码" type="password" required >
						</div>
						<div class="form-group">
							<img class="input_icon" src="assets/store/img/login/phone.png" alt="" style="">
							<input id='phone' class="phone" name="Register[username]" maxlength='11' placeholder="请输入手机号" type="phone" required >
						</div>
						<div class="form-group form_code" >
							<img class="input_icon" src="assets/store/img/login/code.png" alt="" style="">
							<div class="code_form">
								<input id='code' class="code" name="Register[code]" maxlength='4' placeholder="请输入验证码" type="text" required >
								<div id="send_code" class="code_text">获取验证码</div>
							</div>
						</div>
						
						<div class="form-group">
							<button id="btn-submit-register-x">
								下一步
							</button>
						</div>
					</div>
					<div class="sec_form">
						<div class="form-group">
							<img class="input_icon" src="assets/store/img/login/shop.png" alt="" style="">
							<input class="phone" name="Register[shop_name]" placeholder="请输入店铺名称" type="text" required >
						</div>
						<div class="form-group">
							<img class="input_icon" src="assets/store/img/login/address.png" alt="" style="">
							<div class="info address">
								<div style='height:100%;'>
									<select style='height:100%;' id="s_province" name="Register[province_id]"></select>  
									<select style='height:100%;' id="s_city" name="Register[city_id]" ></select>  
									<select style='height:100%;' id="s_county" name="Register[region_id]"></select>
									<script  class="resources library" src="js/area.js" type="text/javascript"></script>
									<script type="text/javascript">_init_area();</script>
								</div>
								<div id='show' style='display:none;'></div>
							</div>
						</div>
				
				
						<div class="form-group">
							<img class="input_icon" src="assets/store/img/login/address.png" alt="" style="">
							<input class="address_detail" name="Register[address_detail]" placeholder="请输入详细地址" type="text" required>
						</div>
						<!-- <div class="form-group" id='one'>
							<img class="input_icon" src="assets/store/img/login/shop.png" alt="" style="">
							<select class='select type' id="type" name="Register[shop_type]">
								<option value ="请选择" style='color:#999;'>请选择</option>
								<option value ="1">是</option>
								<option value ="0">否</option>
							</select>
						</div> -->
						<div class="form-group" style='display:none' id='two'>
							<img class="input_icon" src="assets/store/img/login/shop.png" alt="" style="">
							<select class='select type' id="div1" name="Register[type]">
								<option value ="请选择" style='color:#999;'>请选择</option>
								<option value ="1">分店</option>
								<option value ="2">总店</option>
							</select>
						</div>
						<div class="form-group" style='display:none' id='three'>
							<img class="input_icon" src="assets/store/img/login/shop.png" alt="" style="">
							<select class='select type' id="div2" name="Register[pid]">
								<option value ="请选择">请选择</option>
								<?php  foreach ($fatherLsit as $item): ?>
									<option value="<?= $item['user_id'] ?>"><?= $item['shop_name'] ?></option>
								<?php endforeach;?>
							</select>
							<!-- <input class="pid" name="Register[pid]" placeholder="请选择总店" id='zhongdina'  type="text" list="pidList" required>
							<datalist id="pidList">
							<?php  foreach ($fatherLsit as $item): ?>
								<option><?= $item['shop_name'] ?></option>
							<?php endforeach;?>
							</datalist> -->
						</div>
						<!-- 店面照片 -->
						<div id='box1' style='position: relative;height: 50px;'>
							<!-- <div class="img_box1"></div> -->
							<img alt="点击上传" id="faceImg"  οnclick="toUpload()" class="upload_shop_img" src="assets/store/img/login/upload.png" alt="">
                            <input type="hidden" id="img" name="Register[shop_img]">
						</div>
						<div class="form-group">
                            <img class="shop_img_icon input_icon" src="assets/store/img/login/shop_img.png" alt="" style="">
							<div class='div' class="shop_img" disable name="Register[shop_img]" placeholder="" type="password" required>请上传店面图片</div>
						</div>
						<!-- 营业执照 -->
						<div id='box2' style='position: relative;height: 50px'>
                            <div class="img_box2"></div>
							<img alt="点击上传" id="faceImg2"  οnclick="toUpload()" class="upload_shop_img" src="assets/store/img/login/upload.png" alt="">
                            <input type="hidden" id="img1" name="Register[bussiness_img]">
						</div>
						<div class="form-group">
                            <img class="input_icon" src="assets/store/img/login/idcard.png" alt="" style="">
							<div class='div' class="bussiness_img" disable placeholder="请上传营业执照" type="password" required>请上传营业执照图片</div>
						</div>
						<div class="form-group">
							<button id="btn-submit-register" type="submit">
								确认提交
							</button>
						</div>
					</div>
				</form>
			</div>
        </div>
    </div>
</div>
<form id="formFile" method="post" enctype="multipart/form-data"  target="frameFile" style='z-index:-99;display:none;'>
    <input type="file" accept="image/*" onchange="gome(this)" id="fileUpload" name="Register[shop_img]" class="input-file" required>
    <input type="file" accept="image/*" onchange="gome2(this)" id="fileUpload2" name="Register[bussiness_img]" class="input-file" required>
    <input type="hidden" value="" id="oldFilePath" name="oldFilePath">
</form>
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

    $('#type').click(function (e) {
        var v= $('#type').val()
        if(v=='1'){
            $("#two").css("display","block");
        }else if(v==0){
            $("#two").css("display","none");
            $("#three").css("display","none");
            $('#two').find("option:selected").attr("selected", false);
            $('#three').find("option:selected").attr("selected", false);
        }
    })

    $('#div1').click(function (e) {
        var v= $('#div1').val()
        if(v=='1'){
            $("#three").css("display","block");
        }else if(v==2){
            $("#three").css("display","none");
            $('#three').find("option:selected").attr("selected", false);
        }
    })
	$('.brand-text').click(function() {
		// console.log(1)
		// $('.register-form').addClass('form_move')
    })
    function isPhone(str) {
        let reg = /^((0\d{2,3}-\d{7,8})|(1[3456789]\d{9}))$/;
        return reg.test(str);
    }
	$('#btn-submit-register-x').click(function() {
        var phone = $('#phone').val();
        var code = $('#code').val();
        var linkman = $('.username').val();
        var password = $('.password').val();
        var password1 = $('.password1').val();

        if (password != password1){
            layer.msg('两次密码不一致！');
            return false;
        }
        if(!(phone&&linkman&&password&&password1&&code)) {
            layer.msg('请填写完整！',{time: 1000, anim: 1});
            return false;
        }
        if(!isPhone(phone)) {
            layer.msg('请输入正确的手机号！');
            return false;
        }
        $.ajax({
            url:"index.php?s=/store/passport/is_user",
            type:"post",
            data: {phone:phone,code:code,linkman:linkman,password:password},
            success: function(data) {
                if(data.code == 1){
                    $('.register-form').addClass('form_move')
                    layer.msg(data.msg, {time: 1000, anim: 1}, function () {
                    });
                }else{
                    layer.msg(data.msg, {time: 1000, anim: 1}, function () {
                    });
                }
            },
            error:function(err) {
                alert("发送失败！")
            }
        });
        return false;
    })
    let timer;
    let sends = 60;
    let codeFlag = true;
    $('#send_code').click(function() {
        if(!codeFlag) {
            return false;
        }
        var phone = $('#phone').val();
        var code = $('#code').val();
        if(!isPhone(phone)) {
            layer.msg('请输入正确的手机号！');
            return false;
        }
        timer = setInterval(function() {
            sends--;
            $('#send_code').text(`${sends}s后再次获取`)
            if(sends == 1) {
                sends = 60;
                codeFlag = true;
                $('#send_code').text(`获取验证码`);
                clearInterval(timer);
            }
        },1000)
        codeFlag = false;
        if(phone.trim()!=''){
            $.ajax({
                url:"index.php?s=/api/salesman.index/smscode",
                type:"post",
                data: {phone:phone},
                success: function(data) {
                    if(data.code == 1){
                        layer.msg(data.msg, {time: 1000, anim: 1}, function () {
                        });
                    }else{
                        layer.msg(data.msg, {time: 1000, anim: 1}, function () {
                        });
                    }
                },
                error:function(err) {
                    layer.msg('网络错误')
                }
            });
        } else{
            layer.msg('请输入手机号', {time: 1000, anim: 1}, function () {
            });
        }
    })
    $('#btn-submit-register').click(function(){
		var show=$('#show').text()
		var img=$('#img').val();
        var img1=$('#img1').val();
        
        if(show!=''){
           if(img!=undefined&&img1!=undefined){
            var value=$("#phone").val()
            var flag=that.isPhone(value)
            if(value!=''){
                if(flag&&value!=''){
                    var $form = $('#register-form');
                    $form.submit(function () {
                        var $btn_submit = $('#btn-submit-register');
                        $btn_submit.attr("disabled", true);
                        $form.ajaxSubmit({
                            type: "post",
                            dataType: "json",
                            url: 'index.php?s=/store/passport/register',
                            success: function (result) {
                                $btn_submit.attr('disabled', false);
                                if (result.code === 1) {
                                    layer.msg(result.msg, {time: 1500, anim: 1}, function () {
                                        window.location.href = "index.php?s=/store/passport/login";
                                    });
                                    return true;
                                }
                                layer.msg(result.msg, {time: 1500, anim: 6});
                            }
                        });
                        return false;
                    });
                }else if(value!='') {
                    layer.msg('您输入的手机号格式不符合要求！', {time: 1500, anim: 6});
                }
            }else{
                layer.msg('手机号不能为空！', {time: 1500, anim: 6});
            }
           }else{
            layer.msg('请上传营业执照和门头照片', {time: 1500, anim: 6});
           }
        }else{
            layer.msg('请选择店铺地址', {time: 1500, anim: 6});
        }
    })

    $('#faceImg').click(function () {
        jQuery('#fileUpload').click();
    })

    $('#faceImg2').click(function () {
        jQuery('#fileUpload2').click();
    })

    function uploadFile(obj) {
        var form = jQuery("#formFile");
    }

    // 转化图片方法
    function getObjectURL(file) {
        var url = null;
        if (window.createObjectURL != undefined) { // basic
            url = window.createObjectURL(file);
        } else if (window.URL != undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file);
        } else if (window.webkitURL != undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file);
        }
        return url;
    }

    // 上传店面相片
    function gome(obj) {
        var formData = new FormData();
        formData.append('iFile',obj.files[0]);
        $.ajax({
            url:"index.php?s=/api/upload/image",
            type:"post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                const{ file_path } =data.data
                // console.log(file_path)
                var html=$("<img id='img' name='Register[shop_img]' src=" + file_path + " style=' width:80px;height:80px;'>" +
                    "<input name='Register[shop_img]' value='"+ file_path +"' type='text' style='display: none;z-index: -99;'>");
                // $('.img_box1').html(html);
                $('#faceImg').attr('src',file_path)
                $('#img').val(file_path)
            },
            error:function(err) {
                alert("上传失败")
            }
        });
        return
    }


    //  上传营业执照
    function gome2(obj) {
        var formData = new FormData();
        formData.append('iFile',obj.files[0]);
        $.ajax({
            url:"index.php?s=/api/upload/image",
            type:"post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                const{ file_path } =data.data
                // console.log(file_path)
                var html=$("<img id='img1' name='Register[bussiness_img]' src=" + file_path + " style=' width:80px;height:80px;'>" +
                    "<input name='Register[bussiness_img]' value='"+ file_path +"' type='text' style='display: none;z-index: -99;'>");
                // $('.img_box2').html(html);
				$('#faceImg2').attr('src',file_path)
				$('#img1').val(file_path)
            },
            error:function(err) {
                alert("上传失败")
            }
        });
        return
    }
    // var Gid  = document.getElementById ;
    $('#s_county').change(function () {
        var province=$('#s_province').val()
        var city=$('#s_city').val()
        var county=$('#s_county').val()
        html=province+','+city+','+county
        $('#show').html(html)
    })

</script>
</html>
