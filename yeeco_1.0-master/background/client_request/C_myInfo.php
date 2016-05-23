<?php
/**个人资料页面
*请求我的个人资料；
*1.所需要的参数：用户Id
*2.返回值：200，个人资料，返回个人资料；
*/


	error_reporting(E_ALL & ~E_NOTICE);
	require_once('../conf/connect.php');
	require_once('../conf/json_port.php');
	
	$uId = $_POST['userId'];
	//根据uId查找用户的个人资料
	$infoResult=mysql_fetch_array(mysql_query("select u.userName,u.userSchool,u.userTel,u.userFace,e.userEmail,e.userSex,e.userBirth,e.userPlace,e.userClass,e.userQQ FROM user as u inner join userextrainfo as e
on u.uId=e.uId  where e.uId='$uId' limit 1"));
	
	$data = array(
	    'userFace' => $infoResult['userFace'],
		'userName' => $infoResult['userName'],
		'userSex' => $infoResult['userSex'],
		'userBirth' => $infoResult['userBirth'],
		'userPlace' => $infoResult['userPlace'],
		'userSchool' => $infoResult['userSchool'],
		'userClass' => $infoResult['userClass'],
		'userTel' => $infoResult['userTel'],
		'userEmail' => $infoResult['userEmail'],
		'userQQ' => $infoResult['userQQ'],
	);
	
	Response::json(214,'该用户的个人资料如下',$data);	

?>