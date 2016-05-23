<?php
/**
*登录页面，包括登录、自动登录、退出登录、登录并激活
*1.所需要的参数：用户手机号、密码、action（logout:退出登录）、remember（是否自动登录的标志）
*2.返回值：200成功登录或退出；201：下一步执行激活该账号；107：用户不存在而登录失败；108：密码错误而登录失败
*/
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/json_port.php');
require_once('../conf/isMobile.php');
$clientSign = isMobile();

//连接数据库文件
require_once('../conf/connect.php');
//导入加密解密文件
require_once('../conf/enc.php');

//删除cookie和session，执行退出操作
if($_GET['action'] == 'logout'){
   logout();
}

//获取用户电话和密码
$usertel = $_POST['usertel'];
$password = $_POST['password'];
$remember = $_POST['remember'];

//检测用户名是否正确
$check_user = mysql_query("select * from user where userTel='$usertel' limit 1");
$result_user = mysql_fetch_assoc($check_user);

//验证密码或加密后的密码是否正确，进行登录判断
if($result_user){
    if($_GET['action'] == 'auto'){
		//自动登录
		if($result_user['passwordno'] == $password){
		    login();
		}else{
	        error();
		}
	}else{
		if($result_user['password'] == $password){
		    login();
		}else{
	        error();
		}
	} 
}else{
	//user没有的话遍历pre_user
	$check_pre_user = mysql_query("select * from pre_user where userTel='$usertel' limit 1");
	$result_pre_user = mysql_fetch_array($check_pre_user);
	if($result_pre_user){
		if($password=='123456'){
			//执行登陆操作，修改密码，进行用户激活
			active_login();
		}else{
			error();
		}
	 }else{
		if($clientSign){
		    Response::json(107,'登录失败，该用户不存在！',NULL);
		}else{
			
			echo "<script>alert('登录失败，该用户不存在！');</script>";
	 		logout();
		}
	}
}

//执行登陆操作，修改密码，进行用户激活
function active_login(){
	global $clientSign;
	global $result_pre_user;
    global $usertel;
	//对电话进行加密操作
	$usertel=code($usertel);
	if($clientSign){
		Response::json(201,'该用户为待激活用户，为该用户跳转至修改密码界面',NULL);
	}else{
		echo "<script>alert('为保证您的账号安全，请修改密码！');
window.location.href='../../front/change_password.php?account=$usertel';</script>";
	}
}

//执行登录操作
function login(){ 
	global $clientSign;
 	global $result_user;
    global $usertel;
    global $password;
    global $remember;
    $_SESSION['userName'] = $result_user['userName'];
    $_SESSION['userId'] = $result_user['uId'];
	$_SESSION['sSchool']=$result_user['userSchool'];
	$_SESSION['userFace']=$result_user['userFace'];
	$uid=$result_user['uId'];
	//检测自动登录是否被选中
	if( !empty($remember)){		
		//对用户电话和密码进行加密
        $encryptuser=trim($usertel);
        $encryptpass=md5(trim($password));
		
		//更新cookie信息
		setcookie("usertelno", $encryptuser, time()+3600*24*365,"/");  
		setcookie("passwordno", $encryptpass, time()+3600*24*365,"/");
	    $updatetsql=mysql_query("update user set usertelno='$encryptuser',passwordno='$encryptpass' where uId='$uid'");					
	}
	if($clientSign){
		$data = array(
   			'userId' => $result_user['uId'],
			'userName'  => $result_user['userName'],
			'sSchool' => $result_user['userSchool'],
			'userFace' => $result_user['userFace']
		);
		Response::json(200,'登录成功,下一步跳转至主页',$data);
	}else{
		
		echo "<script>window.location.href='../../front/square.php';</script>";
	}
}

//登录失败报错
function error(){
	global $clientSign;
	if($clientSign){
		Response::json(108,'登录失败，密码错误！',NULL);
	}else{
		echo "<script>alert('登录失败，请检查密码是否输入错误！');</script>";
		logout();
	}
}

function logout(){
	global $clientSign;
    unset($_SESSION['userName']); 
	unset($_SESSION['userId']);
    if(!empty($_COOKIE['usertelno']) || !empty($_COOKIE['passwordno'])){  
    setcookie("usertelno", null, time()-3600*24*365,"/");  
    setcookie("passwordno", null, time()-3600*24*365,"/");  
	}
	if($clientSign){
		Response::json(202,'成功退出登录',NULL);
	}else{
		echo "<script>window.location.href='../../index.php';</script>";
	}
	exit;
}