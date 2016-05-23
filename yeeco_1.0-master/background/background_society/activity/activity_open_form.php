<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../conf/connect.php');
require_once('../get_picture.php');
require_once('../../conf/adjust_Img.php');
require_once('../../conf/code.php');
require_once('../../background_comment/create_news.php');
$sId=$_POST['sId'];
$sName=$_POST['sName'];
$sSchool=$_POST['sSchool'];
/*
*获取表单数据
*
*/
//获取上传图片
$folder='../../../image/user_image/society/activity';
$actImg=substr(getImg($folder),3);
if($actImg==NULL){
	$actImg='../../image/user_image/defaultImg/activity_ad.png';	
}
//活动名称
$activity_name=$_POST['activity_name'];
//活动类型
$activity_type=$_POST['activity_type'];
//是否需报名
$apply=$_POST['apply'];
//面向范围
$range=$_POST['range'];
//报名开始结束时间
$begin_date_apply=$_POST['begin_date_apply'];
$end_date_apply=$_POST['end_date_apply'];
$begin_time_apply=$_POST['begin_time_apply'];
$end_time_apply=$_POST['end_time_apply'];
//活动开始结束时间
$begin_date=$_POST['begin_date'];
$end_date=$_POST['end_date'];
$begin_time=$_POST['begin_time'];
$end_time=$_POST['end_time'];
//活动地点
$activity_place=$_POST['activity_place'];
//活动简介
$describe=$_POST['describe'];
//活动详情
$detail=$_POST['detail'];
//设置时间
$setTime=time();
//print_r($begin_date_apply);exit;
/**
*将数据插入数据库
*/
mysql_query("insert into society_act_open(actName,actType,isApply,actRange,actBeginDate,actBeginTime,actEndDate,actEndTime,applyBeginDate,applyBeginTime,applyEndDate,applyEndTime,actSchool,actPlace,actDesc,actDetail,sId,setTime,actImg) values('$activity_name','$activity_type','$apply','$range','$begin_date','$begin_time','$end_date','$end_time','$begin_date_apply','$begin_time_apply','$end_date_apply','$end_time_apply','$sSchool','$activity_place','$describe','$detail','$sId','$setTime','$actImg')");
$actId=mysql_insert_id();

//生成专属二维码
$page='mobileFront/M_activityVisitor.php';
$QRCode=substr(QRCode($page,$actId,'../../../'),3);
//将二维码保存在数据库中
mysql_query("update society_act_open set actCode='$QRCode' where actId='$actId'");
echo $QRCode.'&'.$actId;
//生成新的活动动态
$type = '创建活动';
$data = array(
		'sId' => $sId,
		'oId' => $actId,
		'oName' => $sName,
		'describe' => $describe
);
create_news($type,$data);
?>