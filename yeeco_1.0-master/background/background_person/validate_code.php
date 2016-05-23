<?php
//载入ucpass类
require_once('../ucpass-demo/lib/Ucpaas.class.php');
//产生验证码并发送
function creatTestCode($userTel){
	$arr=array();
	while(count($arr)<6)
	{
	  $arr[]=rand(0,9);
	  $arr=array_unique($arr);
	}
	$testCode = implode("",$arr);
	//在这里将验证码发给运营商
	send_msg($userTel,$testCode);
	return $testCode;
}
//短信验证码（模板短信）,默认以65个汉字（同65个英文）为一条（可容纳字数受您应用名称占用字符影响），超过长度短信平台将会自动分割为多条发送。分割后的多条短信将按照具体占用条数计费。
function send_msg($to,$param){
//初始化必填
$options['accountsid']='00545cd93375717edd3d44e93df42c0f';
$options['token']='dde37532d26905ad2f3a6bf3141e21ad';

//初始化 $options必填
$ucpass = new Ucpaas($options);

//开发者账号信息查询默认为json或xml
$ucpass->getDevinfo('xml');
$appId = "ee23bbaaa47b412f8138ad62cc1e879d";
//$to = "13649240941";
$templateId = "10833";
//$param="0227";
return $ucpass->templateSMS($appId,$to,$templateId,$param);
}

?>