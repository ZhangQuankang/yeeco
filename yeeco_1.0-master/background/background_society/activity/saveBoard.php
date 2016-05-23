<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../conf/connect.php');
$actId=$_POST['actId'];
$board=$_POST['board'];
$status=$_POST['status'];
if($status=='删除活动'){
	mysql_query("update society_act_closed set actBoard='$board' where actId='$actId'");
}else{
	mysql_query("update society_act_open set actBoard='$board' where actId='$actId'");
}
?>