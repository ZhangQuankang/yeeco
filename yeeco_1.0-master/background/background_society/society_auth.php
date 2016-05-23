<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require_once('../conf/connect.php');
require_once('get_picture.php');
require_once('../conf/adjust_Img.php');
require_once('../conf/code.php');
//获取参数值
$sid=$_GET['sid'];
$uid=$_GET['uid'];
$sName=$_GET['sName']; 
$e=mb_detect_encoding($sName, array('UTF-8', 'GBK'));
if($e=='GBK'){
$sName= iconv("gbk","utf-8",$sName);
}
$flag=$_GET['flag'];
$page='mobileFront/M_societyVisitor.php';
$QRCode=QRCode($page,$sid,'../../');
$isActivition=mysql_query("select * from pre_society where sId='$sid'");
$result = mysql_fetch_assoc($isActivition);
if(!$result){
		echo "<script>window.location.href='../../front/actived.php';</script>";
	}else{
			$check_query = mysql_fetch_assoc(mysql_query("select * from pre_society where sId='$sid' && flag='$flag' limit 1"));
			if($check_query){
				$insertsql = mysql_query("insert into society(sId,sName,sSchool,sPrincipal,uId,sCate,sDesc,sImg) select 					     				sId,sName,sSchool,sPrincipal,uId,sCate,sDesc,sImg from pre_society where sId='$sid'");
				$newId = $check_query['sId'];
				$createNews = mysql_query("insert into dynamic_state(nImg) values('$newId')");
				$regTime=time();
				$updatesql=mysql_query("update society set regTime='$regTime',sQRCode='$QRCode',team_name='{$sName}2015届领导班子',position='社长' where sId='$sid'");
				$delete_old = mysql_query("delete from pre_society where sId='$sid'");	
			if( $insertsql && $updatesql && $delete_old ){
				echo "<script>window.location.href='../../front/new_society.php?uId=$uid&sId=$sid&sName=$sName';</script>";
				}else{
				echo "<script>alert('激活失败');</script>";
				}
			}else{
				echo "<script>alert('激活失败');</script>";
				}
	}
?>
