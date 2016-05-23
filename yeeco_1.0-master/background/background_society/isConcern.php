<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
/*
*判断是否关注社团
*/
$action=$_GET['action'];
$societyId=$_GET['sId'];
$userId=$_GET['uId'];
if($action=='concern'){
	mysql_query("insert into user_society_relation(userId,societyId,isManage) values('$userId','$societyId','4')");
	exit;
}
if($action=='cancelConcern'){
	mysql_query("delete from user_society_relation where societyId='$societyId' and userId='$userId' and isManage=4");
	exit;
}

?>