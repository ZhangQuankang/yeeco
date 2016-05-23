<?php
/**申请加入社团
*功能：加入社团、保存用户备注、删除申请的成员、录用成员；
*1.所需要的参数：
*2.返回值：
*/
	error_reporting(E_ALL & ~E_NOTICE);
	require_once('../conf/connect.php');
	require_once('get_picture.php');
	require_once('../conf/adjust_Img.php');
	require_once('../conf/isMobile.php');
	require_once('../conf/json_port.php');
	require_once('../message/create_sysMsg.php');
	require_once('invite_code.php');
	//载入ucpass类
	require_once('../ucpass-demo/lib/Ucpaas.class.php');
	$uId=$_POST['uId'];
	$sId=$_POST['sId'];
	//判断是否已经是该社团成员
	$action=$_POST['action'];
	if($action=='isMember'){
		if(mysql_num_rows(mysql_query("select id from user_society_relation where userId='$uId' and societyId='$sId' and isManage<>4"))){
			echo true;
			exit;
		}else{
			echo false;	
			exit;
		}
		exit;
	}
	//保存单一用户的备注信息
	if($action=='saveRemark'){
		$aId=$_POST['aId'];
		$remark=$_POST['remark'];
		mysql_query("update apply_information_unselected set aRemark='$remark' where aId='$aId'");
		exit;
	}
	//保存多个用户备注信息
	if($action=='saveRemark_selected'){
		$aId=$_POST['aId'];
		$remark=$_POST['remark'];
		foreach($aId as $value){
				mysql_query("update apply_information_unselected set aRemark='$remark' where aId='$value'");
		}
		exit;	
	}
	//删除申请成员信息
	if($action=='del_app'){
		$aId=$_POST['aId'];
		foreach($aId as $value){
			$res=mysql_fetch_assoc(mysql_query("select uId,sId,sDep,aTel from apply_information_unselected where aId='$value'"));
			$data=array();
			$data['sId']=$res['sId'];
			$data['sDep']=($res['sDep']==0?'未分配':$res['sDep']);
			send_sysMsg($res['uId'],$data,'unemploySociety');
			//获取社团名字
			$sName=mysql_fetch_assoc(mysql_query("select sName from society where sId='$res[sId]'"));
			$sName=$sName['sName'];
			$to=$res['aTel'];
			send_msg_unemploy($to,$sName);	
			mysql_query("delete from apply_information_unselected where aId='$value'");
		}
		exit;
	}
	//录用
	if($action=='employ'){
		$aId=$_POST['aId'];
		foreach($aId as $value){
				$f=mysql_query("insert into apply_information_member(aId,userId,aName,aSex,aBirthday,aNative,aClass,aTel,aEmail,aQQ,aFavor,aStrong,aPhoto,aAnser_1,aAnser_2,aAnser_3,sId,fId,sDep,aSendTime,aRemark) select aId,uId,aName,aSex,aBirthday,aNative,aClass,aTel,aEmail,aQQ,aFavor,aStrong,aPhoto,aAnser_1,aAnser_2,aAnser_3,sId,fId,sDep,aSendTime,aRemark from apply_information_unselected where aId='$value'");
				$res=mysql_fetch_assoc(mysql_query("select uId,sId,sDep,aTel from apply_information_unselected where aId='$value'"));
				$data=array();
				$data['sId']=$res['sId'];
				$data['sDep']=($res['sDep']==0?'未分配':$res['sDep']);
				send_sysMsg($res['uId'],$data,'employSociety');
				//获取社团名字
				$sName=mysql_fetch_assoc(mysql_query("select sName from society where sId='$res[sId]'"));
				$sName=$sName['sName'];
				$to=$res['aTel'];
				$param=$sName.','.$data['sDep'];
				send_msg_employ($to,$param);
				//mysql_query();
				if($f){
					mysql_query("delete from apply_information_unselected where aId='$value'");
				}
		}
		exit;
	}
	
	
	//获取表单元素
	$aName=$_POST['aName'];
	$aSex=$_POST['aSex'];
	$fId=$_POST['fId'];
	$aBirthday=$_POST['aBirthday'];
	$aNative=$_POST['aNative'];
	$aClass=$_POST['aClass'];
	$aTel=$_POST['aTel'];
	$aEmail=$_POST['aEmail'];
	$aQQ=$_POST['aQQ'];
	$aFavor=$_POST['aFavor'];
	$aStrong=$_POST['aStrong'];
	$aAnser_1=$_POST['aAnser_1'];
	$aAnser_2=$_POST['aAnser_2'];
	$aAnser_3=$_POST['aAnser_3'];
	$depName=$_POST['department'];
	$aSendTime=time();
	//上传图片
	$folder="../../image/user_image/user_photo";
	$aPhoto=getImg($folder);
	//插入数据到数据库
	$insertSql=mysql_query("insert into apply_information_unselected(uId,aName,aSex,aBirthday,aNative,aClass,aTel,aEmail,aQQ,aFavor,aStrong,aPhoto,aAnser_1,aAnser_2,aAnser_3,sId,fId,sDep,aSendTime) values('$uId','$aName','$aSex','$aBirthday','$aNative','$aClass','$aTel','$aEmail','$aQQ','$aFavor','$aStrong','$aPhoto','$aAnser_1','$aAnser_2','$aAnser_3','$sId','$fId','$depName','$aSendTime')");
	//echo "insert into apply_information_unselected(uId,aName,aSex,aBirthday,aNative,aClass,aTel,aEmail,aQQ,aFavor,aStrong,aPhoto,aAnser_1,aAnser_2,aAnser_3,sId,fId,sDep,aSendTime) values('$uId','$aName','$aSex','$aBirthday','$aNative','$aClass','$aTel','$aEmail','$aQQ','$aFavor','$aStrong','$aPhoto','$aAnser_1','$aAnser_2','$aAnser_3','$sId','$fId','$depName','$aSendTime')";exit;
	//同步个人信息
	mysql_query("update userextrainfo set userName='$aName',userTel='$aTel',userSex='$aSex',userBirth='$aBirthday',userPlace='$aNative',userClass='$aClass',userEmail='$aEmail',userQQ='$aQQ' where uId='$uId'");
	if($insertSql){
		if($clientSign){
			Response::json(217,'数据提交成功！',NULL);
		}else{
			echo "success";
		}		
	}else{
		if($clientSign){
			Response::json(301,'加入社团-数据提交失败',NULL);
		}else{
			echo NULL;
		}
	}	
?>