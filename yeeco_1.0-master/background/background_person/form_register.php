<?php
/**
*注册页面
*1.判断用户是否已经注册，如果已经注册，返回注册失败或待激活，如果未注册，进行注册
*2.如果是注册待激活，则提示已经注册，请用123456密码登录
*3.所需要的参数：用户手机号、密码、学校
*4.返回值：200注册成功；101已被注册；102待激活
*/
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require_once('../conf/connect.php');
require_once('../conf/json_port.php');
require_once('../conf/isMobile.php');
require_once('validate_code.php');

$clientSign = isMobile();
//if($clientSign){
//	print_r("你是用手机登陆的！");
//}else{
//	print_r("你是用电脑登陆的！");
//}exit;
$action=$_GET['action'];
if($action=='testcode'){
	$tel=$_POST['usertel'];
	if($clientSign){
		$code = creatTestCode($tel);
		Response::json(221,'该账号可以注册！',$code);
	}else{
		$code = creatTestCode($tel);
		echo $code;
	}
	exit;	
}
//获取表单数据
$userTel = $_POST['usertel'];
$password = $_POST['password1'];
$userName=$_POST['realname'];
$userSchool=$_POST['school'];
$regTime = time();
//为用户添加默认头像
$t=$regTime%16;
$userFace = "image/user_image/user_face/default_face/default_face_".$t.".jpg";

if($_POST['ousertel']){
	$ousertel=$_POST['ousertel'];
	$query_1=mysql_query("select uId from user where userTel='$ousertel'");
	if($query_1 && mysql_num_rows($query_1)){
		if($clientSign){
			Response::json(101,'该用户已被注册！',NULL);
		}else{
			echo "该用户已被注册！";
		}
	}else{
		$query_2=mysql_query("select pId from pre_user where userTel='$ousertel'");	
		if($query_2 && mysql_num_rows($query_2)){
			if($clientSign){
				Response::json(102,'待激活用户，请以默认密码“123456”直接登录',NULL);
			}else{
				echo "您已被邀请，请以默认密码“123456”直接登录";
			}
		}else{
			//允许注册提示成功，返回200
			if($clientSign){
				//$code = creatTestCode($ousertel);
				Response::json(203,'该账号可以注册！',NULL);
			}
		}
	}
	exit;
}


//向数据库中插入新注册用户数据；
$insertsql=mysql_query("insert into user(userTel,password,userSchool,userName,regTime,userFace) values('$userTel','$password','$userSchool','$userName',$regTime,'$userFace')");
$uid = mysql_insert_id();


//插入成功，执行登录操作
 if($insertsql){
	if($_POST['flag'] == 'M_request'){
		echo $uid;
		exit;
	}else{ 	
		$_SESSION['userName'] = $userName;
		$_SESSION['userId'] = $uid;
		$_SESSION['sSchool'] = $userSchool;
		$_SESSION['userFace'] = $userFace;
		if($clientSign){
			$data = array(
				'userId' => $uid,
				'userName'  => $userName,
				'sSchool' => $userSchool,
				'userFace' => $userFace
			);
			Response::json(204,'注册成功，自动执行登录操作！',$data);
		}else{
			echo "<script>window.location.href='../../front/square.php'</script>";
		}
	}
}else{
	if($clientSign){
		Response::json(103,'注册失败，未知错误！',NULL);
	}else{
		echo "<script>alert('注册失败！');window.location.href='../../index.php'</script>";
	}
}

?>