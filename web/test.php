<?php
$appid = "wxe41c3cc1a7acedfd";
$secret = "eaa0dac0d5b33ad3eff73aa218c75b38";
$code = $_GET["code"];

$oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
$oauth2 = getJson($oauth2Url);

// 获得 access_token 和openid
$access_token = $oauth2["access_token"];
$openid = $oauth2['openid'];

function getJson($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, true);
}

$get_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
$userinfo = getJson($get_user_info_url);

//打印用户信息
print_r($userinfo);die;
//array('openid' => 'oiuH-xxxxxxxxxxxxx',

