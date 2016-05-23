<?php
/**社团通讯录页面
*请求某个社团的成员列表；
*1.所需要的参数：用户Id
*2.返回值：200，有参加的社团，并且返回社团数据；
*        301，无参加的社团，无数据；
*/
	error_reporting(E_ALL & ~E_NOTICE);
	require_once('../conf/connect.php');
	require_once('../conf/json_port.php');
	
	$sId = $_POST['sId'];
	//获取部门信息
	$dep=mysql_query("select depName from department where societyId='$sId'");
	if($dep && mysql_num_rows($dep)){
		while($row = mysql_fetch_assoc($dep)){
			$dep_info[]=$row;
		}			
	}
	$undis['depName']='0';
	if($dep_info){
		array_push($dep_info,$undis);
	}else{
		$dep_info[0]=$undis;
	}
	//将每个部门的成员筛选出来
	foreach($dep_info as $value){
		$depName = $value['depName'];
		$user_society_r=mysql_query("select userId,isManage,depBelong,position from user_society_relation where societyId='$sId' and depBelong='$depName'");
		if($user_society_r && mysql_num_rows($user_society_r)){
			while($row = mysql_fetch_assoc($user_society_r)){	
				$uInfo=mysql_fetch_assoc(mysql_query("select userFace,userName from user where uId='$row[userId]'"));		
				$members[] = array(
					'userId' => $row['userId'],
					'userName' => $uInfo['userName'],
					'userFace' => $uInfo['userFace'],
					'isManage' => $row['isManage'],
					'depBelong' => $row['depBelong'],
					'position' => $row['position'],
				);
			}
		}
		$dep_members[] = array(
			'depName' => $depName,
			'members' => $members,
		);
		$members = array();
	}
	
	Response::json(218,'部门信息及各部门成员信息如下：',$dep_members);
?>