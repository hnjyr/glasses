<?php
$appid = 'wxe41c3cc1a7acedfd';
$redirect_uri = urlencode('http://www.glasses.com/test.php');//重定向地址

$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
header("Location:" . $url);
