<?php
/**社团详情页-访客界面
*请求该社团的详情；
*1.所需要的参数：用户Id:uId,社团Id:sId;
*2.返回值：200（社团的基本信息、纳新信息、该用户与该社团的关系）
*/
	error_reporting(E_ALL & ~E_NOTICE);
	require_once('../conf/connect.php');
	require_once('../conf/json_port.php');
	
	$uId = $_POST['userId'];
	$sId = $_POST['sId'];
	
	//判断用户与该社团的关系
	$relationRes=mysql_fetch_assoc(mysql_query("select isManage from user_society_relation where societyId='$sId' and userId='$uId'"));
	if(empty($relationRes)){
		$relation = 0;//该用户未加入该社团也未关注该社团
	}else if($relationRes['isManage'] == '4'){
		$relation = 1;//该用户已经关注了该社团
	}else{
		$isApplied=mysql_num_rows(mysql_query("select aId from apply_information_unselected where uId='$uId' and sId='$sId'"));
		if($isApplied){
			$relation = 3;//该用户已经提交过报名表了
		}else{
			$relation = 2;//该用户已加入了该社团
		}
	}

	//查找社团信息
	$sInfo = mysql_fetch_assoc(mysql_query("select sId,sName,sPrincipal,uId,sCate,sDesc,sNum,Board,isFresh from society where sId='$sId'"));

	if($sInfo['isFresh']){
		//查找纳新信息
		$fInfo = mysql_fetch_assoc(mysql_query("select fImg,fAnn,fDetail,fNum from society_fresh where sId='$sId'"));
	}
	
	$data = array(
		'sInfo' => $sInfo,
		'fInfo' => $fInfo,
		'relation' => $relation
	);
	
	Response::json(215,'该社团信息、纳新信息如下',$data);	

?>