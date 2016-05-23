<?php
/**活动详情页-访客界面
*请求该活动的详情；
*1.所需要的参数：用户Id:uId,活动actId:actId;
*2.返回值：200（活动的详细信息、该用户与该活动的关系）、
*/
	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	require_once('../conf/connect.php');
	require_once('../conf/json_port.php');
	
	$uId = $_POST['userId'];
	$actId = $_POST['actId'];

	
	//判断用户与该活动的关系
	$query=mysql_fetch_assoc(mysql_query("select isConcern from act_user_relation where uId='$uId' and actId='$actId'"));
	
	if(empty($relationRes)){
		$relation = 0;//该用户未加入该活动也未关注该活动
	}else if($relationRes['isConcern'] == 0){
		$relation = 1;//该用户已经参加了该活动，默认关注
	}else{
		$relation = 2;//该用户仅关注了该活动
	}

	//查找进行活动信息
	$actInfo = mysql_fetch_assoc(mysql_query("select * from society_act_open where actId='$actId'"));
	//查找活动的主办社团
	$society = mysql_fetch_assoc(mysql_query("select sName from society where sId='$actInfo[sId]'"));
	if($actInfo){
		$data = array(
			'actName' => $actInfo['actName'],
			'actImg' => $actInfo['actImg'],
			'actTime' => substr($actInfo['actBeginDate'],5).' '.$actInfo['actBeginTime'].'～'.substr($actInfo['actEndDate'],5).' '.$actInfo['actEndTime'],
			'actApplyTime' => $actInfo['applyBeginDate']!=NULL?substr($actInfo['applyBeginDate'],5).' '.$actInfo['applyBeginTime'].'～'.substr($actInfo['applyEndDate'],5).' '.$actInfo['applyEndTime']:'',
			'actPlace' => $actInfo['actPlace'],
			'actType' => $actInfo['actType'].'/'.$actInfo['isApply'].'/'.$actInfo['actRange'],
			'society' => $society['sName'],
			'actNum' => $actInfo['actNum'],
			'actFocusNum' => $actInfo['actFocusNum'],
			'actDesc' => $actInfo['actDesc'],
			'actDetail' => $actInfo['actDetail'],
			'actBoard' => $actInfo['actBoard'],
			'relation' => $relation,
		);	
	}else{
		$data = array(
			'actName' => '',
			'actImg' => '',
			'actTime' => '',
			'actApplyTime' => '',
			'actPlace' => '',
			'actType' => '',
			'society' => '',
			'actNum' => '',
			'actFocusNum' => '',
			'actDesc' => '',
			'actDetail' => '',
			'actBoard' => '',
			'relation' => ''
		);
	}
	Response::json(220,'该社团活动信息如下',$data);	

?>