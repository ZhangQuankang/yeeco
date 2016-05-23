<?php
//	oId	nImg	nTime	nWho	nBody
error_reporting(E_ALL & ~E_NOTICE);
//require_once('../conf/connect.php');
function create_news($type,$data){
	$sId = $data['sId'];
	$oId = $data['oId'];
	$oName = $data['oName'];
	date_default_timezone_set('PRC');
	$nTime = date('Y-m-d H:i',time());//**********************************
	if($type=='开启纳新'){
		$nWho = 'society';
		$fAnn = $data['fAnn'];
		$fUrl = "society_visitor.php?sId=".$sId;
		//查询图片
		$img=mysql_fetch_assoc(mysql_query("select sImg from society where sId='$sId'"));
		$nImg = $img['sImg'];
		$nBody = $oName.'开启纳新啦！<br/>'.$fAnn.'<br/>…小伙伴们快来报名加入吧！……详情<a href='.$fUrl.' style="color:#97ddff">猛戳这里！！！</a>';
		
	}
	if($type=='纳新关闭'){
		$nWho = 'society';
		$action=$data['action'];
		$fUrl = "society_visitor.php?sId=".$oId;
		//查询图片
		$img=mysql_fetch_assoc(mysql_query("select sImg from society where sId='$oId'"));
		$nImg = $img['sImg'];
		if($action=='pri'){
			$nBody = $oName.'纳新已经关闭啦！';
		}else{
			$nBody=$oName.'纳新已经关闭啦！</br>查看纳新结果点击<a href='.$fUrl.' style="color:#97ddff">这里!!</a>';
		}
	}
	if($type=='创建活动'){
		$nWho = 'activity';
		$describe=$data['describe'];
		$aUrl="activity_visitor.php?actId=".$oId;
		//查询图片
		$img=mysql_fetch_assoc(mysql_query("select sImg from society where sId='$sId'"));
		$nImg = $img['sImg'];
		$nBody=$oName.'创建了一个新的活动啦！<br/>'.$describe.'<br/>更多活动详情请点击<a href='.$aUrl.' style="color:#97ddff">这里!!</a>';	
	}
	if($type=='修改社团资料'){
		$nWho = 'society';
		$content=$data['content'];
		//查询图片
		$img=mysql_fetch_assoc(mysql_query("select sImg from society where sId='$oId'"));
		$nImg = $img['sImg'];
		if($content=='社团通讯录有所更新!'){
			$mUrl="address_book.php?sId=".$oId;
		}else{
			$mUrl="society_info.php?sId=".$oId;
		}
		$nBody=$oName.$content.'<br/>修改详情请点击<a href='.$mUrl.' style="color:#97ddff">这里!!</a>';	
	}
	if($type=='自定义动态'){
		$nWho='person';
		$nImg =$data['nImg'];
		$nBody=$data['nBody'];		
	}
	if($type=='换届'){
	}
	mysql_query("insert into dynamic_state(sId,oId,oName,nImg,nTime,nWho,nBody) values('$sId','$oId','$oName','$nImg','$nTime','$nWho','$nBody')");
}
?>