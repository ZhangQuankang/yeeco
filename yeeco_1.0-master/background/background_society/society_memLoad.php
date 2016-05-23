<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
$sId=$_GET['sId'];
$depName=$_GET['depName'];
$i=$_POST['i'];
$j=$_POST['j'];
$user_r=array();
$uInfo=array();
$ueInfo=array();
//获取用户社团关系信息
$user_society_r=mysql_query("select userId,isManage,depBelong,position from user_society_relation where societyId='$sId' and depBelong='$depName' limit ".$i.",8");
if($user_society_r && mysql_num_rows($user_society_r)){
	    while($row = mysql_fetch_assoc($user_society_r)){			
			$user_r[]=$row;
			$uInfo[]=mysql_fetch_assoc(mysql_query("select userFace from user where uId='$row[userId]'"));
			$ueInfo[]=mysql_fetch_assoc(mysql_query("select userName,userTel,userSex,userClass from userextrainfo where uId='$row[userId]'"));
		}
}
//判断是否取完，如果取完了则开始取未激活的
if(sizeof($user_r)!=8){//如果不等于8，则说明已经激活的取完了
	//计算未激活的条数
	$preSize=8-sizeof($user_r);
	//获取未激活用户社团关系信息
	$user_society_r=mysql_query("select pid,isDepManager,position from preuser_society_relation where sid='$sId' and 		isDepManager='$depName' limit ".$j.",{$preSize}");
	if($user_society_r && mysql_num_rows($user_society_r)){
	    while($row = mysql_fetch_assoc($user_society_r)){			
			$pre_user_r[]=$row;
			$pre_uInfo[]=array('userFace' => '?');
			$pre_ueInfo[]=mysql_fetch_assoc(mysql_query("select userName,userTel from pre_user where pId='$row[pid]'"));
		}
	}
	//合并数组
	$user_r=array_merge($user_r,$pre_user_r);
	$uInfo=array_merge($uInfo,$pre_uInfo);
	$ueInfo=array_merge($ueInfo,$pre_ueInfo);
}
$k=0;
if($user_r){
	foreach($user_r as $value_2){
		if($depName=='0'){
			$depName='未分配';
		}
		if($value_2!=NULL){
			if($uInfo[$k]['userFace']!='?'){
				echo "<li>
					<span><input type='checkbox' id='".$value_2['userId']."' value='".$value_2['userId']."' name='member_".$depName."[]'/></span><span><img src='../".$uInfo[$k]['userFace']."'/>".$ueInfo[$k]['userName']."".$ueInfo[$k]['userSex']."</span><span>".$ueInfo[$k]['userClass']."</span><span>".$ueInfo[$k]['userTel']."</span><span>".$depName."</span><span class='limit'>".$value_2['position']."</span><span class='cap'><a href='javascript:void(0)' class='table_b' onclick='delete_one(this)'>删除</a><a href='javascript:void(0)' class='table_c' onclick='change_oneDep(this)'>调换部门</a><a href='javascript:void(0)' class='table_d' onclick='send_oneMsg(this)'>发送通知</a></span>                            
					</li>
				";
				$i++;
			}else{
				echo "<li style='color:#999;'>
					<span><input type='checkbox' value='".$value_2['pid']."' name='member_".$depName."[]' disabled='disabled' /></span><span><img src=''/>".$ueInfo[$k]['userName']."</span><span> </span><span>".$ueInfo[$k]['userTel']."</span><span>".$depName."</span><span class='limit'>".$value_2['position']."</span><span class='cap'><a href='javascript:void(0)' class='table_e' onclick='del_preuser(this)'>删除</a><a href='javascript:void(0)' class='table_f' onclick='warn_active(this)'>提醒激活</a></span>                            
					</li>
				";	
				$j++;
			}
		}
		$k++;
		
	}
	echo '@'.$i.'+'.$j;
}
?>