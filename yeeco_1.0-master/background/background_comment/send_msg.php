<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
require_once('create_news.php');
//获取表单数据
$sId=$_POST['sId'];
$oId=$_POST['userId'];
$oName=$_POST['userName'];
$nImg=$_POST['uFace'];
$nBody=$_POST['news_content'];
$type = '自定义动态';
$data = array(
		'sId' => $sId,
		'oId' => $oId,
		'oName' => $oName,
		'nImg' => $nImg,
		'nBody' => $nBody
);
create_news($type,$data);
?>