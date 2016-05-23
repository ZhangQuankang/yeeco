<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
require_once('get_emailbody.php');
require_once('../conf/mail_parameter.php');
$sId=$_GET['sId'];
$check=mysql_query("select * from pre_society where sId='$sId'");
$result=mysql_fetch_array($check);
$email=$result['sEmail'];
$flag=$result['flag'];
$uId=$result['uId'];
$sName=$result['sName'];
$smtpemailto=$email;
$mailbody = getEmailBody($sId,$flag,$uId,$sName);
$success=$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
if($success){
		echo "<script>alert('邮件已重新发送！');window.location.href='../../front/emailed.php?sId=$sId'</script>";
	}else{
		echo "<script>alert('邮件发送失败，请重新发送！');window.location.href='../../front/emailed.php?sId=$sId'</script>";
		}
?>