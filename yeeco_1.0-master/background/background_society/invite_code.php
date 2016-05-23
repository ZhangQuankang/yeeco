<?php

//短信验证码（模板短信）,默认以65个汉字（同65个英文）为一条（可容纳字数受您应用名称占用字符影响），超过长度短信平台将会自动分割为多条发送。分割后的多条短信将按照具体占用条数计费。
//给未激活用户发短信
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
	$templateId = "11565";
	//$param="0227";
	return $ucpass->templateSMS($appId,$to,$templateId,$param);
}
function send_msg_res($to,$param){
	//初始化必填
	$options['accountsid']='00545cd93375717edd3d44e93df42c0f';
	$options['token']='dde37532d26905ad2f3a6bf3141e21ad';
	
	//初始化 $options必填
	$ucpass = new Ucpaas($options);
	
	//开发者账号信息查询默认为json或xml
	$ucpass->getDevinfo('xml');
	$appId = "ee23bbaaa47b412f8138ad62cc1e879d";
	//$to = "13649240941";
	$templateId = "11636";
	//$param="0227";
	return $ucpass->templateSMS($appId,$to,$templateId,$param);
}
function send_msg_employ($to,$param){
	//初始化必填
	$options['accountsid']='00545cd93375717edd3d44e93df42c0f';
	$options['token']='dde37532d26905ad2f3a6bf3141e21ad';
	
	//初始化 $options必填
	$ucpass = new Ucpaas($options);
	
	//开发者账号信息查询默认为json或xml
	$ucpass->getDevinfo('xml');
	$appId = "ee23bbaaa47b412f8138ad62cc1e879d";
	//$to = "13649240941";
	$templateId = "11780";
	//$param="0227";
	return $ucpass->templateSMS($appId,$to,$templateId,$param);
}
function send_msg_unemploy($to,$param){
	//初始化必填
	$options['accountsid']='00545cd93375717edd3d44e93df42c0f';
	$options['token']='dde37532d26905ad2f3a6bf3141e21ad';
	
	//初始化 $options必填
	$ucpass = new Ucpaas($options);
	
	//开发者账号信息查询默认为json或xml
	$ucpass->getDevinfo('xml');
	$appId = "ee23bbaaa47b412f8138ad62cc1e879d";
	//$to = "13649240941";
	$templateId = "11779";
	//$param="0227";
	return $ucpass->templateSMS($appId,$to,$templateId,$param);
}
function warn_active($to,$param){
	//初始化必填
	$options['accountsid']='00545cd93375717edd3d44e93df42c0f';
	$options['token']='dde37532d26905ad2f3a6bf3141e21ad';
	
	//初始化 $options必填
	$ucpass = new Ucpaas($options);
	
	//开发者账号信息查询默认为json或xml
	$ucpass->getDevinfo('xml');
	$appId = "ee23bbaaa47b412f8138ad62cc1e879d";
	//$to = "13649240941";
	$templateId = "12049";
	//$param="0227";
	return $ucpass->templateSMS($appId,$to,$templateId,$param);
}


?>