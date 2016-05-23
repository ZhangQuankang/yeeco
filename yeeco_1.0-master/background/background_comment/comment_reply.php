<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
$action=$_GET['action'];
//插入评论
if($action=='insert'){
	$uId=$_POST['userId'];
	$uName=$_POST['userName'];
	$uFace=$_POST['userFace'];
	$cBody=$_POST['comment'];
	$cTime=$_POST['date'];
	$nId=$_POST['nId'];
	$ccId=$_POST['ccId'];
	$ccName=$_POST['ccName'];
	mysql_query("insert into comment_form(uId,uName,uFace,cBody,cTime,nId,ccId,ccName) values('$uId','$uName','$uFace','$cBody','$cTime','$nId','$ccId','$ccName')");
	$cId = mysql_insert_id();
	echo $cId;
	exit;
}
//删除评论
if($action=='delete'){
	$cId=$_POST['cId'];
	//删除评论下的所有回复
	$ccId=mysql_fetch_assoc(mysql_query("select ccId from comment_form  where cId='$cId'"));
	if($ccId['ccId']==0){
		mysql_query("delete from comment_form where cId='$cId'");
		mysql_query("delete from comment_form where ccId='$cId'");
	}else{
		mysql_query("delete from comment_form where cId='$cId'");
	}
	exit;
}
//删除动态
if($action=='del_news'){
	$nId=$_POST['nId'];
	//删除动态
	mysql_query("delete from dynamic_state where nId='$nId'");
	//删除动态下的回复
	mysql_query("delete from comment_form where nId='$nId'");
}
?>