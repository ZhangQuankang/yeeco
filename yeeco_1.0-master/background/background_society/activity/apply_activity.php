<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../conf/connect.php');
$actId=$_GET['actId'];
$uId=$_GET['uId'];
$action=$_GET['action'];
//如果未关注，进行关注
if($action=='concern'){
	mysql_query("insert into act_user_relation(uId,actId,isConcern) values('$uId','$actId','1')");
	exit;
}
if($action=='cancel_concern'){
	mysql_query("delete from act_user_relation where uId='$uId' and actId='$actId' and isConcern='1'");
	exit;
}
if($action=='join'){	
	//插入活动-用户关联关系表,其中isConcern=0，则是既关注又参加，等于1是只关注
	mysql_query("delete from act_user_relation where uId='$uId' and actId='$actId'");
	mysql_query("insert into act_user_relation(uId,actId,isConcern) values('$uId','$actId',0)");
}

?>