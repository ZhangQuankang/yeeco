<?php
/**
*忘记密码时，判断用户是否存在
*
*1.所需要的参数：用户手机号
*2.返回值：200成功，允许修改；106用户不存在
*/
	error_reporting(E_ALL & ~E_NOTICE);
	require_once('../conf/connect.php');
	require_once('../conf/isMobile.php');
	require_once('../conf/json_port.php');
	require_once('validate_code.php');
	
	$clientSign = isMobile();
	$ousertel=$_POST['ousertel'];

		$query_1=mysql_query("select uId from user where userTel='$ousertel'");
		if(!($query_1 && mysql_num_rows($query_1))){
			$query_2=mysql_query("select pId from pre_user where userTel='$ousertel'");	
			if(!($query_2 && mysql_num_rows($query_2))){
				if($clientSign){
					Response::json(106,'该用户不存在！',NULL);
				}else{
					echo "该用户不存在";
				}
			}else{
				if($clientSign){
					$code = creatTestCode($ousertel);
					Response::json(205,'该用户存在，允许其修改密码！',$code);
				}
			}	
		}else{
			if($clientSign){
				$code = creatTestCode($ousertel);
				Response::json(205,'该用户存在，允许其修改密码！',$code);
			}
		}
		
?>