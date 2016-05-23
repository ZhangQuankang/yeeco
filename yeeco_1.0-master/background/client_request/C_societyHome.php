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
	
	//获取用户身份
	$isManage=mysql_fetch_assoc(mysql_query("select isManage from user_society_relation where societyId='$sId' and userId='$uId'"));
	if($isManage['isManage']==0){
		$user_limit='成员';
	}else if($isManage['isManage']==1){
		$user_limit='管理员';
	}else if($isManage['isManage']==2){
		$user_limit='创建人';
	}
	
	//获取社团的基本信息
	$societyRes=mysql_fetch_array(mysql_query("select sName,sImg,sDesc,isFresh,Board from society where sId='$sId'"));
	$basicInfo = array(
		'sName' => $societyRes['sName'],				//社团名称
		'sImg' => $societyRes['sImg'],					//社团头像
		'sDesc' => $societyRes['sDesc'],				//社团简介
		'isFresh' => $societyRes['isFresh'],			//纳新状态
	);
	
	$societyRes=mysql_fetch_array(mysql_query("select * from society where sId='$sId'"));
	//获取动态
	$res=mysql_query("select * from dynamic_state where sId='$sId' order by nTime desc limit 10");//一次只加载出十条动态
	if($res && mysql_num_rows($res)){	
		while($row_1 = mysql_fetch_assoc($res)){
			//对于每一则动态
			$dynamic = array(
				'nId' => $row_1['nId'],  			//本则动态的ID
				'oId' => $row_1['oId'],  			//发此动态的对象
				'nWho' => $row_1['nWho'],  			//对象类型：社团、活动、个人
				'nImg' => $row_1['nImg'],  			//发布人头像
				'oName' => $row_1['oName'],  		//发布人姓名
				'nBody' => $row_1['nBody'],  		//发布的内容
				'nTime' => $row_1['nTime'],  		//发布的时间
				'pNum' => $row_1['pNum'],  			//赞的个数
			);
			//将每个动态的回复列出来
			$reply = array();
			$comments=mysql_query("select * from comment_form where nId='$row_1[nId]'");
			if($comments && mysql_num_rows($comments)){
				while($row_2 = mysql_fetch_assoc($comments)){
					$reply[] = array(
						'nId' => $row_2['nId'],
						'cId' => $row_2['cId'],  			//本则回复的ID
						'uId' => $row_2['uId'],  			//发布本则回复的用户ID
						'uName' => $row_2['uName'],  		//发布本则回复的用户名字
						'cBody' => $row_2['cBody'],  		//回复的内容
						'ccId' => $row_2['ccId'],  			//所回复的对象，如果是0表示回复动态，否则为回复其他的回复
						'ccName' => $row_2['ccName']		//所回复的对象的名称
					);
				}
			}
			$news[] = array(
				'dynamic' => $dynamic,
				'comment' => $reply, 
			);
		}			
	}
	$data = array(
		'basicInfo' => $basicInfo,
		'news' => $news
	);
	
	Response::json(222,'社团主页内容',$data);	

?>