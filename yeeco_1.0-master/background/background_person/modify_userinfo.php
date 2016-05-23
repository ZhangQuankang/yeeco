<?php
/**
*修改密码
*1.判断用户是否激活
*2.如果未激活，修改密码进行激活
*3.如果已激活，直接修改密码
*4.需要的参数：用户手机号userTel，新密码password_1
*5.返回值：修改成功200，激活失败104或修改失败105
*/
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
require_once('../background_society/get_picture.php');
require_once('../conf/adjust_Img.php');
require_once('../conf/json_port.php');
require_once('../conf/isMobile.php');

$clientSign = isMobile();
if($clientSign){
	$uId=$_POST['userId'];
}else{
	$uId= $_SESSION['userId'];
}

$op = $_GET['op'];
/*
*个人资料模块
*
*/

if($op == 'info'){
	$username=$_POST['username'];
	$tel_number=$_POST['tel_number'];
	$face_pic=$_POST['pic'];
	$sex=$_POST['sex'];	
	$birthYear=$_POST['birthYear'];
	$birthMonth=$_POST['birthMonth'];
	$birthDay=$_POST['birthDay'];
	$native_por=$_POST['native_por'];
	$native_city=$_POST['native_city'];
	$major=$_POST['major'];
	$email=$_POST['email'];
	$qq	=$_POST['qq'];
	$userBirth=$birthYear.'-'.$birthMonth.'-'.$birthDay;
	$userPlace=$native_por.'-'.$native_city;
	//获取图片
	$folder = "../../image/user_image/user_face/defined_face";
	$userFace=substr(getImg($folder),6);
	//更新动态表信息
	$sql="update dynamic_state set nImg='../../".$userFace."' where oId='$uId' and nWho=person";
	mysql_query($sql);
	//更新评论表信息
	$sql="update comment_form set uFace='../".$userFace."' where uId='$uId'";
	mysql_query("update comment_form set uFace='../$userFace' where uId='$uId'");
	//更新信息
	$updatesql1=mysql_query("update userextrainfo set userName='$username',userTel='$tel_number', userSex='$sex',userBirth='$userBirth',userPlace='$userPlace',userClass='$major',userEmail='$email',userQQ='$qq' where uId='$uId'");
	mysql_query("update user set userName='$username' where uId='$uId'");
	//http://127.0.0.1/yeeco_1.0/image/user_image/user_face/defined_face/ae4b30dd860b68c256d0528bf3e0fa49.jpg
	$_SESSION['userName']=$username;
	if($userFace){
		$oldFace=mysql_fetch_assoc(mysql_query("select userFace  from user where uId='$uId'"));
		unlink('../../'.$oldFace['userFace']);
		$updatesql2=mysql_query("update user set userFace='$userFace' where uId='$uId'");
		$_SESSION['userFace']=$userFace;
	}
	if($updatesql1){
		if($clientSign){
			Response::json(210,'个人资料修改成功',NULL);
		}else{
			echo "<script>alert('修改成功！');window.location.href='../../front/personal_center.php?action=info';</script>";
		}
	}else{
		if($clientSign){
			Response::json(109,'修改失败',NULL);
		}else{
			echo "<script>alert('修改失败！');window.location.href='../../front/personal_center.php?action=info';</script>";
		}		
	}
	exit;
}
/**
*账号信息模块
*
*/
//利用异步提交判断旧密码是否正确
if($_GET['action'] == 'isright'){
	$password_old=$_POST['password_old'];
	$result=mysql_fetch_array(mysql_query("select password from user where uId='$uId' limit 1"));
	if($password_old == $result['password']){
		if($clientSign){
			Response::json(208,'密码验证正确',NULL);
		}else{
			exit;
		}
	}else{
		if($clientSign){
			Response::json(110,'密码输入错误',NULL);
		}else{
			echo "密码输入错误！";	
		}
		exit;
	}
}

//修改电话号码
if($op == 'tel'){
	//获取表单电话号码的值
	$userTel=$_POST['userTel'];
	if($userTel){
			$f=mysql_query("update user set userTel='$userTel' where uId='$uId'");
			if($f){
				if($clientSign){
					Response::json(209,'账号修改成功，需要用户重新登录',NULL);
				}else{
					logout();
					echo "<script>alert('修改成功，请重新登陆！');window.location.href='../../index.php';</script>";
				}	
			}else{
				if($clientSign){
					Response::json(111,'修改失败',NULL);
				}else{
					echo "<script>alert('修改失败！');window.location.href='../../front/personal_center.php?action=account';</script>";
				}
			}
		}
	exit;		
}
//修改密码
if($op == 'pwd'){
	//获取表单新密码的值
	$password_1=$_POST['password_1'];
		$f=mysql_query("update user set password='$password_1' where uId='$uId'");
		if($f){
			if($clientSign){
				Response::json(212,'密码修改成功',NULL);
			}else{
				echo "<script>alert('修改成功！');window.location.href='../../front/personal_center.php?action=account';</script>";
			}	
		}else{
			if($clientSign){
				Response::json(112,'修改失败',NULL);
			}else{
				echo "<script>alert('修改失败！');window.location.href='../../front/personal_center.php?action=account';</script>";
			}			
		}
	exit;
}

function logout(){
    unset($_SESSION['userName']); 
	unset($_SESSION['userId']);
    if(!empty($_COOKIE['usertelno']) || !empty($_COOKIE['passwordno'])){  
    setcookie("usertelno", null, time()-3600*24*365,"/yeeco_1.0/");  
    setcookie("passwordno", null, time()-3600*24*365,"/yeeco_1.0/");  
	}
}
?>