<?php
/**
*修改密码
*1.判断用户是否激活
*2.如果未激活，修改密码进行激活
*3.如果已激活，直接修改密码
*4.需要的参数：用户手机号userTel，新密码password_1
*5.返回值：修改成功200，激活失败104或修改失败105
*/	
	
	error_reporting(E_ALL & ~E_NOTICE);
	session_start();
	require_once('../conf/connect.php');
	require_once('../conf/enc.php');
	require_once('../conf/isMobile.php');
	require_once('../conf/json_port.php');
	require_once('../message/create_sysMsg.php');
	$clientSign = isMobile();
	//获取表单值
	$password=$_POST['password_1'];
	if($clientSign){
		$userTel=$_POST['userTel'];
	}else{
		$userTel=decode($_POST['userTel']);
	}

	//判断用户是否激活，如果是未激活用户，则进行激活，否则执行修改密码操作
	$query_1=mysql_query("select * from pre_user where userTel='$userTel'");

	if(mysql_num_rows($query_1)){
		//激活该用户
		//将pre_user信息移到user
		if($query_1 && mysql_num_rows($query_1)){
			while($row = mysql_fetch_assoc($query_1)){
				$pId[]=$row['pId'];
				$userName=$row['userName'];
				$userTel=$row['userTel'];
				$userSchool=$row['userSchool'];
			}			
		}
		$regTime=time();
		//为用户添加默认头像
		$t=$regTime%16;
		$userFace = "image/user_image/user_face/default_face/default_face_".$t.".jpg";
		$f=mysql_query("insert into user(userTel,password,userSchool,userName,userFace,regTime) values('$userTel','$password','$userSchool','$userName','$userFace','$regTime')");
		$newId=mysql_insert_id();
		//print_r($pId);exit;	
		//将preuser_society_relation移到user_society_relation
		foreach($pId as $value){		
			$res=mysql_fetch_assoc(mysql_query("select * from preuser_society_relation where pid='$value' "));
			$sid = $res['sid'];
			$isDepManager = $res['isDepManager'];
			$position = $res['position'];
			//为避免重复添加关联关系，先删除已有的关联关系，保证一个用户和一个社团之间只存在一条关系；
			mysql_query("delete from user_society_relation where societyId='$sid' and userId='$newId'");	
			//插入一条新的关联关系。
			if($isDepManager == '0'){
				$f1=mysql_query("insert into user_society_relation(userId,societyId,isManage,depBelong,position) values('$newId','$sid','0','0','$position')");	
				$data=array();
				$data['sId']=$sid;
				$data['depName']='（未分配部门）';
				$data['position']=$position;
				send_sysMsg($newId,$data,'joinSociety');		
			}else{
				$f1=mysql_query("insert into user_society_relation(userId,societyId,isManage,depBelong,position) values('$newId','$sid','1','$isDepManager','$position')");	
				$data=array();
				$data['sId']=$sid;
				$data['depName']=$isDepManager;
				$data['position']=$position;
				send_sysMsg($newId,$data,'joinSociety');	
			}
			$f3=mysql_query("delete from preuser_society_relation where pid='$value'");	
		}

		//删除pre_user和preuser_society_relation信息
		$f2=mysql_query("delete from pre_user where userTel='$userTel'");	
		if($f && $f1 && $f2 && $f3){
			$_SESSION['userName'] = $userName;
			$_SESSION['sSchool']  = $userSchool;
			$_SESSION['userId'] = $newId;
			$_SESSION['userFace']=$userFace;
			if($clientSign){
				$data = array(
					'userId' => $newId,
					'userName'  => $userName,
					'sSchool' => $userSchool,
					'userFace' => $userFace
				);
				Response::json(207,'用户已成功激活，并自动为其登录',$data);
			}else{
				if($_POST['flag'] == 'M_request'){
					echo $newId;
				}else{
					echo "<script>window.location.href='../../front/square.php';</script>";
				}
			}
			
		}else{
			if($clientSign){
				Response::json(104,'激活失败，未知错误',NULL);
			}else{
				echo "<script>window.location.href='../../index.php';</script>";
			}
		}
	}else{
		//修改密码
		$f=mysql_query("update user set password='$password' where userTel='$userTel'");
		if($f){
			if($clientSign){
				Response::json(206,'修改成功，请重新登录',NULL);
			}else{
				echo "<script>alert('修改成功，请重新登陆！');window.location.href='../../index.php';</script>";
			}
			
		}else{
			if($clientSign){
				Response::json(105,'密码修改失败，未知错误',NULL);
			}else{
				echo "<script>alert('修改失败，请重新修改！');window.location.href='../../front/personal_center.php?action=account';</script>";
			}
		   
		}
	}
?>