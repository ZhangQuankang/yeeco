<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require_once('../conf/connect.php');
require_once('get_picture.php');
require_once('../conf/adjust_Img.php');
require_once('../background_comment/create_news.php');
require_once('../message/create_sysMsg.php');
require_once('invite_code.php');
//载入ucpass类
require_once('../ucpass-demo/lib/Ucpaas.class.php');
$action=$_GET['action'];
$sSchool=$_SESSION['sSchool'];
$uId=$_SESSION['userId'];
$sId=$_GET['sId'];
//社团基本资料修改
if($action=='modify_info'){
	//获取表单属性
	$sName = $_POST['society_name'];
	$sSchool = $_POST['school'];
	foreach($_POST['type'] as $n){
		$str = $n.'/'.$str;
	}
	$sCate = substr($str,0,strlen($str)-1);
	$sDesc = $_POST['describe'];
	$folder = "../../image/user_image/society";
	$sImg = getImg($folder);
	if($sImg){
		$oldImg=mysql_fetch_assoc(mysql_query("select sImg  from society where sId='$sId'"));
		unlink($oldImg['sImg']);
		mysql_query("update society set sImg='$sImg' where sId='$sId'");
		//更新状态表里边的动态
		mysql_query("update dynamic_state set nImg='$sImg' where oId='$sId' and nWho='society'");
	}
	mysql_query("update society set sName='$sName',sSchool='$sSchool',sDesc='$sDesc',sCate='$sCate' where sId='$sId'");
	//设置动态内容
	$content="社团基本资料有所更新！";
}
//社团部门信息修改
if($action=='modify_dep'){
	$userName=$_GET['userName'];
	$sName=$_GET['sName'];
	$param=$userName.','.$sName;
	//获取表单数据
	$leader_team=$_POST['leader_team'];
	$position=$_POST['position'];
	$dep_name=$_POST['dep_name'];
	$position_1=$_POST['position_1'];
	$position_2=$_POST['position_2'];
	$position_3=$_POST['position_3'];
	$manager_1=$_POST['manager_1'];
	$manager_2=$_POST['manager_2'];
	$manager_3=$_POST['manager_3'];
	$tel_1=$_POST['tel_1'];
	$tel_2=$_POST['tel_2'];
	$tel_3=$_POST['tel_3'];
	//将队名和领导人的职位名称存入数据库
	$updatetsql=mysql_query("update society set team_name='$leader_team',position='$position' where sId='$sId'");
	//删除以前部门信息
	mysql_query("delete from department where societyId='$sId'");
	//更新用户社团关联关系表
	mysql_query("update user_society_relation set isManage='0',position='成员',depBelong='0' where societyId='$sId' and isManage='1'");
		//录入部门信息
		for($i=0;$i<=sizeof($dep_name)-1;$i++){
			//将第一条部门、职位、负责人，电话插入数据库
			mysql_query("insert into department(depName,depManager_1,tel_1,position_1,societyId) values('$dep_name[$i]','$manager_1[$i]','$tel_1[$i]','$position_1[$i]','$sId')");
			//$depid = mysql_insert_id();
			//将邀请信息存入pre_user表中
			$res1=mysql_fetch_array(mysql_query("select uId from user where userTel='$tel_1[$i]'"));
				if(!$res1){
					//print_r("insert into pre_user(userName,userTel,userSchool) values('$manager_1[$i]','$tel_1[$i]','$sSchool')");
					mysql_query("delete from pre_user where userTel='$tel_1[$i]'");
					mysql_query("insert into pre_user(userName,userTel,userSchool) values('$manager_1[$i]','$tel_1[$i]','$sSchool')");
					$pid1 = mysql_insert_id();
					mysql_query("insert into preuser_society_relation(pid,sid,isDepManager,position) values('$pid1','$sId','$dep_name[$i]','$position_1[$i]')");
					//给未激活用户发短信
					send_msg($tel_1[$i],$param);
				}else{
					$uId1=$res1['uId'];
					mysql_query("delete from user_society_relation where societyId='$sId' and userId='$uId1'");
					mysql_query("insert into user_society_relation(userId,societyId,isManage,depBelong,position) values('$uId1','$sId','1','$dep_name[$i]','$position_1[$i]')");
					$data=array();
					$data['sId']=$sId;
					$data['depName']=$dep_name[$i];
					$data['position']=$position_1[$i];
					send_sysMsg($uId1,$data,'joinSociety');
				}
			if($position_2[$i]){
				
				$res2=mysql_fetch_array(mysql_query("select uId from user where userTel='$tel_2[$i]'"));
				if(!$res2){
							mysql_query("delete from pre_user where userTel='$tel_2[$i]'");
							mysql_query("insert into pre_user(userName,userTel,userSchool) values('$manager_2[$i]','$tel_2[$i]','$sSchool')");
							$pid2 = mysql_insert_id();
							mysql_query("insert into preuser_society_relation(pid,sid,isDepManager,position) values('$pid2','$sId','$dep_name[$i]','$position_2[$i]')");
							//给未激活用户发短信
							send_msg($tel_2[$i],$param);
				}else{
					$uId2=$res2['uId'];
					mysql_query("delete from user_society_relation where societyId='$sId' and userId='$uId2'");
					mysql_query("insert into user_society_relation(userId,societyId,isManage,depBelong,position) values('$uId2','$sId','1','$dep_name[$i]','$position_2[$i]')");
					$data=array();
					$data['sId']=$sId;
					$data['depName']=$dep_name[$i];
					$data['position']=$position_2[$i];
					send_sysMsg($uId2,$data,'joinSociety');
				}
					//第二条职位、负责人、电话信息插入数据库
					mysql_query("update department set depManager_2='$manager_2[$i]',tel_2='$tel_2[$i]',position_2='$position_2[$i]' where depName='$dep_name[$i]' and societyId='$sId'");
			}
			if($position_3[$i]){
				$res3=mysql_fetch_array(mysql_query("select uId from user where userTel='$tel_3[$i]'"));	
				if(!$res3){
							mysql_query("delete from pre_user where userTel='$tel_3[$i]'");
							mysql_query("insert into pre_user(userName,userTel,userSchool) values('$manager_3[$i]','$tel_3[$i]','$sSchool')");
							$pid3 = mysql_insert_id();
							mysql_query("insert into preuser_society_relation(pid,sid,isDepManager,position) values('$pid3','$sId','$dep_name[$i]','$position_3[$i]')");
							//给未激活用户发短信
							send_msg($tel_3[$i],$param);
				}else{
					$uId3=$res3['uId'];
					mysql_query("delete from user_society_relation where societyId='$sId' and userId='$uId3'");
					mysql_query("insert into user_society_relation(userId,societyId,isManage,depBelong,position) values('$uId3','$sId','1','$dep_name[$i]','$position_3[$i]')");
					$data=array();
					$data['sId']=$sId;
					$data['depName']=$dep_name[$i];
					$data['position']=$position_3[$i];
					send_sysMsg($uId3,$data,'joinSociety');
				}
					//第三条职位、负责人、电话信息插入数据库
					mysql_query("update department set depManager_3='$manager_3[$i]',tel_3='$tel_3[$i]',position_3='$position_3[$i]' where depName='$dep_name[$i]' and societyId='$sId'");
				}	
		}
		//重置关联关系表
		$q=mysql_query("select depName from  department where societyId='$sId'");
		$p=mysql_query("SELECT depBelong FROM user_society_relation WHERE societyId='$sId' group by depBelong");
		if($p && mysql_num_rows($p)){
			while($row = mysql_fetch_assoc($p)){
				 $depBelong[]=$row['depBelong'];
			}			
		}
		if($q && mysql_num_rows($q)){
			while($row = mysql_fetch_assoc($q)){
				 $depName[]=$row['depName'];
			}			
		}
	
		//找出关联关系表多的部分，就是用户删除的部门
		$remain=array_diff($depBelong,$depName);
		foreach($remain as $value){
			if($value!='0'){
				mysql_query("update user_society_relation set depBelong='0' where societyId='$sId' and depBelong='$value'");
			}
		}
		//设置动态内容
		$content="社团部门信息有所更新！";
		echo "<script>window.location.href='../../front/society_info.php?sId=$sId'</script>";
}




//批量删除选中用户信息
if($action=='del_societyMembers'){
	$membersId=$_POST['uId'];
	$depName=($_GET['depName']=='未分配'?0:$_GET['depName']);
	if($depName=='0'){
		foreach($membersId as $value){
			mysql_query("delete from user_society_relation where societyId='$sId' and userId='$value'");
			//生成成员剔出社团的系统消息
			$data=array();
			$data['sId']=$sId;
			send_sysMsg($value,$data,'exitSociety');
		}
	}else{
		foreach($membersId as $value){
			$isManage=mysql_fetch_assoc(mysql_query("select isManage from user_society_relation where societyId='$sId' and userId='$value'"));
			if($isManage['isManage']!=0){
				//如果被删除用户是某部门的部长，则更新相应的部门表信息
				$res_1=mysql_fetch_assoc(mysql_query("select userTel from user where uId='$value'"));
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
			mysql_query("delete from user_society_relation where societyId='$sId' and userId='$value'");	
			//生成成员剔出社团的系统消息
			$data=array();
			$data['sId']=$sId;
			send_sysMsg($value,$data,'exitSociety');
		}	
	}
	//设置动态内容
	$content="社团通讯录有所更新!";
}

//调换部门
if($action=='ex_societyMemberDep'){
	$membersId=$_POST['aim_member'];
	//要调换到的部门
	$depName=($_POST['aim_dep']=='未分配'?0:$_POST['aim_dep']);
	foreach($membersId as $value){
		mysql_query("update user_society_relation set depBelong='$depName' where societyId='$sId' and userId='$value'");	
		$data=array();
		$data['sId']=$sId;
		$data['depName']=$depName;
		send_sysMsg($value,$data,'ex_SocietyDep');
	}
	//设置动态内容
	$content="社团通讯录有所更新!";
	echo "<script>window.location.href='../../front/address_book.php?sId=$sId'</script>";
}
//删除未激活用户
if($action=='del_preMember'){
	$pre_uId=$_POST['uId'];
	mysql_query("delete from preuser_society_relation where pid='$pre_uId' and sid='$sId'");
	//发短信告诉用户，您长时间未激活已被该社团请出
	exit;
}
//提醒用户激活
if($action=='warn_active'){
	$pre_uId=$_POST['uId'];
	$param=$_POST['sName'];
	//查找用户电话
	$query=mysql_fetch_assoc(mysql_query("select userTel from pre_user where pId='$pre_uId'"));
	$userTel=$query['userTel'];
	//调用短信模板发送短信
	warn_active($userTel,$param);
	echo  1;
	exit;
}
//生成新的社团动态
$sName=mysql_fetch_assoc(mysql_query("select sName from society where sId='$sId'"));
$type = '修改社团资料';
$data = array(
		'sId' => $sId,
		'oId' => $sId,
		'oName' => $sName['sName'],
		'content' => $content,
);
create_news($type,$data);
?>