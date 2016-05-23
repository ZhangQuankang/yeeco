<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
require_once('massMsg.php');
//判断用户身份
if($_POST['action']=='getIdentity'){
	$sId=$_POST['sId'];
	$uId=$_POST['uId'];
	$isManage=mysql_fetch_assoc(mysql_query("select isManage from user_society_relation where societyId='$sId' and userId='$uId'"));
	if($isManage['isManage']==0){
		//禁止发送
		echo 0;
	}else {
		//允许发送
		echo 1;
	}
	exit;
} 	

//获取发送对象用户ID
$toId=$_POST['toId'];
$message=$_POST['m_message'];
$userName=$_POST['userName'];
//处理toId,字符串转换成数组
$massMsgTo = explode(",",$toId);
foreach($massMsgTo as $value){
	$res=mysql_fetch_assoc(mysql_query("select userTel from user where uId='$value' limit 1"));
	$userTel.=$res['userTel'].',';
}

$userTel=substr($userTel,0,strlen($userTel)-1);
//发送短信函数
$c="来自".$userName."的社团通知:".$message;
$m=$userTel;
sendSMS($url,$ac,$authkey,$cgid,$m,$c,$csid,$t);
?>