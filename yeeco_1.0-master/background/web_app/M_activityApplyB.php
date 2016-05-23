<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
require_once('../conf/HttpClient.class.php');
require_once('../conf/enc.php');
$actId = $_POST['actId'];

//根据用户提供的账号，验证当前用户的身份
	if($_POST['ousertel']){
		$ousertel=$_POST['ousertel'];
		$query_1=mysql_query("select uId from user where userTel='$ousertel'");
		if($query_1 && mysql_num_rows($query_1)){
			$uIdRes = mysql_fetch_assoc($query_1);
			$uId = $uIdRes['uId'];
			$isApplied = mysql_num_rows(mysql_query("select id from act_user_relation where uId='$uId' and actId='$actId' and isConcern=0"));
			if($isApplied){
				echo "203";//该用户已经报名参加该活动了
			}else{
				//***********************************************************************
				echo "200";//该用户为已注册用户，但未参加该活动
			}
		}else{
			$query_2=mysql_query("select pId from pre_user where userTel='$ousertel'");	
			if($query_2 && mysql_num_rows($query_2)){
				echo "201";//该用户为待激活用户
			}else{
				echo "202";//该用户为未注册用户
			}
		}
		exit;
	}
	
$state = $_POST['state'];

$aName = $_POST['aName'];
$aSex = $_POST['aSex'];

$aSchool = $_POST['aSchool'];
$aClass = $_POST['aClass'];
$aTel = $_POST['aTel'];

$password_1 = $_POST['password_1'];//已激活用户的密码
$password_2 = $_POST['password_2'];//待激活用户或未注册用户的新密码
$testCode = $_POST['testCode'];
	
//验证数据是否重复提交
$query_1=mysql_query("select uId from user where userTel='$aTel'");
$uIdRes = mysql_fetch_assoc($query_1);
$uId = $uIdRes['uId'];
$isApplied = mysql_num_rows(mysql_query("select id from act_user_relation where uId='$uId' and actId='$actId'"));

if($isApplied){
	echo "<script>alert('您已经提交过报名表了！');history.go(-2)</script>";
	exit;
}else{
		//若为已注册用户，验证用户所输密码是否正确
	if($state == "200"){	
		$check_user = mysql_query("select uId,password from user where userTel='$aTel' limit 1");
		$result_user = mysql_fetch_assoc($check_user);
		if($password_1 != $result_user['password']){
			echo "<script>alert('密码输入错误！');history.go(-1);</script>";
			exit;
		}else{
			applyInsert($uId,$actId);//执行插入报名表
		}
		
	//若为待激活用户，则为该用户执行激活操作
	}else if($state == "201"){
		$data = array (
			'userTel' => code($aTel),
			'password_1' => $password_2,
			'flag' => 'M_request'
		); 
		$url = 'http://localhost/background/background_person/activate_user.php';
		
		$uId = HttpClient::quickPost($url,$data);//将用户的激活信息传递给activate_user.php
		if($uId){
			applyInsert($uId,$actId);//执行插入报名表
		}
	//若为未注册用户，为用户注册账号		
	}else if($state == "202"){
		$data = array (
			'realname' => $aName,
			'usertel' => $aTel,
			'password1' => $password_2,
			'school' => $aSchool,
			'flag' => 'M_request'
		); 
		$url = 'http://localhost/background/background_person/form_register.php';
		$uId = HttpClient::quickPost($url,$data);//将用户的注册信息传递给form_register.php
		if($uId){
			applyInsert($uId,$actId);//执行插入报名表
		}
	}
	exit;
}


function applyInsert($uId,$actId){
	//获取用户的uId
	$uIdRes = mysql_fetch_assoc(mysql_query("select uId from user where uId='$uId' limit 1"));
	if($uIdRes){
		//如果该用户存在，则为该用户插入报名数据
		$result = mysql_query("insert into act_user_relation(uId,actId,isConcern) values('$uId','$actId',0)");
		if($result){
			echo "<script>alert('报名表提交成功！');window.location.href='../../front/mobileFront/M_overPage.php'</script>";
			exit;
		}else{
			echo "<script>alert('报名表提交失败2！');history.go(-2)</script>";
		}
	}else{
		echo "<script>alert('报名表提交失败1！');history.go(-2)</script>";
	}
}


?>