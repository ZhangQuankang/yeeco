<?php
/**申请加入社团
*请求报名表信息；
*1.所需要的参数：用户Id:uId,社团Id:sId;
*2.返回值：200（报名表信息）
*/
	error_reporting(E_ALL & ~E_NOTICE);
	require_once('../conf/connect.php');
	require_once('../conf/json_port.php');
	
	$uId = $_POST['userId'];
	$sId = $_POST['sId'];
	
	//查找用户信息
	$uInfo = mysql_fetch_assoc(mysql_query("select uId,userName,userTel,userSex,userBirth,userPlace,userClass,userEmail,userQQ from userextrainfo where uId='$uId'"));
	if(empty($uInfo)){
		$uInfo = array(
			'uId' => '',
			'userName' => '',
			'userTel' => '',
			'userSex' => '',
			'userBirth' => '',
			'userPlace' => '',
			'userClass' => '',
			'userEmail' => '',
			'userQQ' => '',
		);
	}
	
	
	
	//查找纳新信息
	$fInfo = mysql_fetch_assoc(mysql_query("select sName,fQue_1,fQue_2,fQue_3 from society_fresh where sId='$sId'"));
	if(empty($fInfo)){
		$fInfo = array(
			'sName' => '',
			'fQue_1' => '',
			'fQue_2' => '',
			'fQue_3' => '',
		);
	}
	
	
	//查找部门信息
	$dep=mysql_query("SELECT depName FROM department WHERE societyId='$sId'");
	if($dep && mysql_num_rows($dep)){
	    while($row = mysql_fetch_assoc($dep)){
			$depInfo[]=$row['depName'];
		}			
	}else{
		$depInfo[]='';
	}
	
	$data = array(
		'uInfo' => $uInfo,
		'fInfo' => $fInfo,
		'depInfo' => $depInfo
	);
	
	Response::json(216,'该用户的报名表信息如下',$data);	

?>