<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');

$fromId=$_POST['userId'];
$toId=$_POST['toId'];
$message=$_POST['message'];
$msgTime = time();
if(strpos($toId ,",")){
	//群发消息
	$massMsgTo = explode(",",$toId);
	foreach($massMsgTo as $value){
		mysql_query("insert into message(msgToId,msgFromId,msgBody,msgTime) values('$value','$fromId','$message','$msgTime')");
	}
}else{
	//单独消息
	mysql_query("insert into message(msgToId,msgFromId,msgBody,msgTime) values('$toId','$fromId','$message','$msgTime')");
}
?>