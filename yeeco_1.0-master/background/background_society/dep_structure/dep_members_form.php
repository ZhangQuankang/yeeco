<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../excel/UpLoad_Excel.php');
require_once('../../message/create_sysMsg.php');
require_once('../invite_code.php');
//载入ucpass类
require_once('../../ucpass-demo/lib/Ucpaas.class.php');
session_start();
$sId=$_POST['sId'];
$userName=$_GET['userName'];
$sName=$_GET['sName'];
$sSchool=$_POST['sSchool'];
$param=$userName.','.$sName;
//上传excel文件到服务器模块
$file = $_FILES['members']['name'];
if($file){
	$msg = uploadFile($sId,$file,$sSchool,$sName,$userName);
}
//手动添加模块
//获取表单值
$username=$_POST['name'];
$telnumber=$_POST['telnumber'];
//echo $sName.$userName.$telnumber[0];
if($username[0]){
for($i=0;$i<count($username);$i++){
	//判断该用户是否已经注册
	$res=mysql_fetch_array(mysql_query("select uId from user where userTel='$telnumber[$i]'"));
	if(!$res){
		//避免重复插入数据到pre_user表
		mysql_query("delete from pre_user where userTel='$telnumber[$i]'");
		//若未注册则将他插入pre_user、preuser_society_relation表
		mysql_query("insert into pre_user(userName,userTel,userSchool) values('$username[$i]','$telnumber[$i]','$sSchool')");
		$pid = mysql_insert_id();
		mysql_query("insert into preuser_society_relation(pid,sid,isDepManager,position) values('$pid','$sId','0','成员')");	
		//短信发给未激活用户		
		send_msg($telnumber[$i],$param);
	}else{
		$uId=$res['uId'];
		//若已注册，继续判断是否是该社团成员，若不是则进行邀请
		if(!mysql_num_rows(mysql_query("select id from user_society_relation where userId='$uId' and societyId='$sId'"))){
			$data=array();
			$data['sId']=$sId;
			$data['depName']='（未分配部门）';
			$data['position']='成员';
			send_sysMsg($uId,$data,'joinSociety');
			//发给已注册用户		
  			send_msg_res($telnumber[$i],$param);
			mysql_query("insert into user_society_relation(userId,societyId,isManage,position) values('$uId','$sId','0','成员')");
		}
	}
}
}
if(!($file || $username[0])){
		echo "<script>alert('请添加社团成员！');</script>";
}
?>
