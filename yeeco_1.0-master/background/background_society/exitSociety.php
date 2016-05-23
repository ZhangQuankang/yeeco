<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
$sId=$_POST['sId'];
$uId=$_POST['uId'];
$depName=$_POST['depName'];
$authority=$_POST['authority'];
if($authority=='创建人'){
	echo "<script>alert('您是社团创建人，无法退出社团！');history.go(-1);</script>";
}else if($authority=='管理员'){
	if($depName!=='0'){
		//如果被删除用户是某部门的部长，则更新相应的部门表信息
		$res_1=mysql_fetch_assoc(mysql_query("select userTel from user where uId='$uId'"));
		$userTel=$res_1['userTel'];
		$res_2=mysql_fetch_assoc(mysql_query("select * from department where societyId='$sId' and (tel_1='$userTel' or tel_2='$userTel'  or tel_3='$userTel')"));
		foreach ($res_2 as $name => $value_1) { 
			if($value_1 == $userTel){
				$temp=substr($name,4,1);
				break;
			}
		}
		mysql_query("update department set position_$temp='',depManager_$temp='',tel_$temp='' where depName='$res_2[depName]' and societyId='$sId'");	
	}
	mysql_query("delete from user_society_relation where societyId='$sId' and userId='$uId'");
	echo "<script>alert('退出成功');window.location.href='../../front/square.php';</script>";
}else{
	
	mysql_query("delete from user_society_relation where userId='$uId' and societyId='$sId'");
	echo "<script>alert('退出成功');window.location.href='../../front/square.php';</script>";
}

?>