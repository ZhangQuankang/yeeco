<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
require_once('../conf/HttpClient.class.php');
require_once('../conf/enc.php');
$sId = $_POST['sId'];
$fId = $_POST['fId'];

//根据用户提供的账号，验证当前用户的身份
	if($_POST['ousertel']){
		$ousertel=$_POST['ousertel'];
		$query_1=mysql_query("select uId from user where userTel='$ousertel'");
		if($query_1 && mysql_num_rows($query_1)){
			$uIdRes = mysql_fetch_assoc($query_1);
			$uId = $uIdRes['uId'];
			$isMember = mysql_num_rows(mysql_query("select id from user_society_relation where userId='$uId' and societyId='$sId' and isManage<>4"));
			if($isMember){
				echo "203";//该用户为已经是该社团的成员了
			}else{
				$isApplied = mysql_num_rows(mysql_query("select aId from apply_information_unselected where uId='$uId' and sId='$sId'"));
				if($isApplied){
					echo "204";//该用户已经报过名了
				}else{
					echo "200";//该用户为已注册用户
				}
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
$birthYear = $_POST['birthYear'];
$birthMonth = $_POST['birthMonth'];
$birthDay = $_POST['birthDay'];

$aBirthDay = $birthYear.'-'.$birthMonth.'-'.$birthDay;

$native_por = $_POST['native_por'];
$native_city = $_POST['native_city'];

$aNative = $native_por.'-'.$native_city;

$aSchool = $_POST['aSchool'];
$aClass = $_POST['aClass'];
$aTel = $_POST['aTel'];
$aEmail = $_POST['aEmail'];
$aQQ = $_POST['aQQ'];
$aAnser_1 = $_POST['aAnser_1'];
$aAnser_2 = $_POST['aAnser_2'];
$aAnser_3 = $_POST['aAnser_3'];
$department = $_POST['department'];

$password_1 = $_POST['password_1'];//已激活用户的密码
$password_2 = $_POST['password_2'];//待激活用户或未注册用户的新密码
$testCode = $_POST['testCode'];

//验证数据是否重复提交
$isApplied = mysql_num_rows(mysql_query("select aId from apply_information_unselected where aTel='$aTel' and sId='$sId'"));

if($isApplied){
	echo "<script>alert('您已经提交过报名表了！');history.go(-2)</script>";
	exit;
}else{
	
	//打包用户的报名表信息
	$userData = array (	
		'fId' => $fId,		
		'sId' => $sId,
		'aName' => $aName,
		'aSex' => $aSex,
		'aBirthday' => $aBirthDay,
		'aNative' => $aNative,
		'aClass' => $aClass,
		'aTel' => $aTel,
		'aEmail' => $aTel,
		'aQQ' => $aQQ,
		'aFavor' => '',
		'aStrong' => '',
		'aAnser_1' => $aAnser_1,
		'aAnser_2' => $aAnser_2,
		'aAnser_3' => $aAnser_3,
		'department' => $department
	);	
	

	//若为已注册用户，验证用户所输密码是否正确
	if($state == "200"){	
		$check_user = mysql_query("select password from user where userTel='$aTel' limit 1");
		$result_user = mysql_fetch_assoc($check_user);
		if($password_1 != $result_user['password']){
			echo "<script>alert('密码输入错误！');history.go(-1);</script>";
			exit;
		}else{
			applyInsert($userData);//执行插入报名表
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
		//如果是被邀请成员，则提醒他已被邀请成员该社团的成员了
		if($uId){
			$re=mysql_query("select id from user_society_relation where societyId='$sId' and userId='$uId'");
			if(mysql_num_rows($re)){
				mysql_query("update userextrainfo set userName='$aName',userTel='$aTel',userSex='$aSex',userBirth='$aBirthDay',userPlace='$aNative',userClass='$aClass',userEmail='$aEmail',userQQ='$aQQ' where uId='$uId'");
				echo "<script>alert('恭喜您，您已经成功加入该社团！');window.location.href='../../front/mobileFront/M_overPage.php'</script>";
				exit;
			}else{
				applyInsert($userData);//执行插入报名表
			}
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
			applyInsert($userData);//执行插入报名表	
		}
	}
	exit;	
}


function applyInsert($data){
	$aTel = $data['aTel'];
	//获取用户的uId
	$uIdRes = mysql_fetch_assoc(mysql_query("select uId from user where userTel='$aTel' limit 1"));
	if($uIdRes){
		//如果该用户存在，则为该用户插入报名数据
		$uId = $uIdRes['uId'];
		//打包数据<br />
		$data['uId'] = $uId;
		$url = 'http://localhost/background/background_society/society_apply_form.php';
		$result = HttpClient::quickPost($url,$data);//将用户的报名信息传递给society_apply_form.php
		if($result == "success"){
			echo "<script>alert('报名表提交成功！');window.location.href='../../front/mobileFront/M_overPage.php'</script>";
			exit;
		}else{
			echo "<script>alert('报名表提交失败！');history.go(-2)</script>";
			exit;
		}
	}else{
		echo "<script>alert('报名表提交失败！');history.go(-2)</script>";
	}
}

?>