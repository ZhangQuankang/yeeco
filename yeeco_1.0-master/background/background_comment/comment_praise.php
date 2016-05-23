<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
$action=$_GET['action'];
//对评论的赞操作
if($action=='c'){
	$uId=$_POST['uId'];
	$cId=$_POST['cId'];
	mysql_query("insert into praise(cId,uId) values('$cId','$uId')");
	mysql_query("update comment_form set pNum=pNum+1 where cId='$cId'");
	//查询现有赞数
	$query=mysql_fetch_assoc(mysql_query("select pNum from comment_form where cId='$cId'"));
	$pNum=$query['pNum'];
	echo $pNum;
	exit;
}
//取消对评论的赞
if($action=='cancel_c'){
	$uId=$_POST['uId'];
	$cId=$_POST['cId'];
	mysql_query("delete from praise where cId='$cId' and uId='$uId'");
	mysql_query("update comment_form set pNum=pNum-1 where cId='$cId'");
	//查询现有赞数
	$query=mysql_fetch_assoc(mysql_query("select pNum from comment_form where cId='$cId'"));
	$pNum=$query['pNum'];
	echo $pNum;
	exit;
}
//对动态的赞
if($action=='n'){
	$uId=$_POST['uId'];
	$nId=$_POST['nId'];
	$row=mysql_num_rows(mysql_query("select * from praise where nId='$nId' and uId='$uId'"));
	if($row){
		echo "已赞过";
		exit;
	}else{
		mysql_query("insert into praise(nId,uId) values('$nId','$uId')");
		mysql_query("update dynamic_state set pNum=pNum+1 where nId='$nId'");
		//查询现有赞数
		$query=mysql_fetch_assoc(mysql_query("select pNum from dynamic_state where nId='$nId'"));
		$pNum=$query['pNum'];
		echo $pNum;
		exit;
	}
}
//取消对动态的赞
if($action=='cancel_n'){
	$uId=$_POST['uId'];
	$nId=$_POST['nId'];
	mysql_query("delete from praise where nId='$nId' and uId='$uId'");
	mysql_query("update dynamic_state set pNum=pNum-1 where nId='$nId'");
	//查询现有赞数
	$query=mysql_fetch_assoc(mysql_query("select pNum from dynamic_state where nId='$nId'"));
	$pNum=$query['pNum'];
	echo $pNum;
	exit;
}

?>