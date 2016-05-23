<?php
/**我的社团页面
*请求我所参与的社团；
*1.所需要的参数：用户Id
*2.返回值：200，有参加的社团，并且返回社团数据；
*        301，无参加的社团，无数据；
*/
	error_reporting(E_ALL & ~E_NOTICE);
	require_once('../conf/connect.php');
	require_once('../conf/json_port.php');
	
	$uId = $_POST['userId'];
	
	//查找与用户相关联的社团ID
	$user_society_Id = mysql_query("SELECT societyId FROM user_society_relation WHERE userId='$uId' and isManage<>4");
	if($user_society_Id && mysql_num_rows($user_society_Id)){
	    while($row = mysql_fetch_assoc($user_society_Id)){
			$societyId[]=$row['societyId'];
		}			
	}

	//获取该社团的数据
	if($societyId){
		foreach($societyId as $value){
			$res = mysql_fetch_assoc(mysql_query("select sId,sName,sImg from society where sId='$value' "));
			if($res){	
				$data_1[]=$res;
			}else{
				$res = mysql_fetch_assoc(mysql_query("select sId,sName,sImg from pre_society where sId='$value' "));
				$data_2[]=$res;
			}
		}
		
		$data = array(
			'activated' => $data_1,
			'nonactivated' => $data_2,
		);

		Response::json(213,'该用户参加了以下社团(activated为已激活社团，nonactivated为未激活社团)',$data);		
	
	}else{
		
		Response::json(301,'该用户没有参加社团',NULL);
	
	}
?>