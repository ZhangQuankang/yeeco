<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
$sId=$_POST['sId'];
$i=$_POST['i'];
//在申请成员表apply_information_unselected中查询信息
$members=mysql_query("SELECT aId,uId,aName,aSex,aClass,aTel,sDep,aRemark FROM apply_information_unselected WHERE sId='$sId' order by aSendTime desc limit ".$i.",5");
if($members && mysql_num_rows($members)){
	    while($row = mysql_fetch_assoc($members)){
			$member_info[]=$row;
		}			
}
if($member_info){
	foreach($member_info as $value){
		$qu=mysql_fetch_assoc(mysql_query("select userFace from user where uId='$value[uId]'"));
		$uImg=$qu['userFace'];
		if(empty($value['aRemark'])){
			$value['aRemark'] = '添加备注';
		}
		if($value['sDep']=='0'){
			$value['sDep']='任意部门';
		}
	  echo "<li id='".$value['aId']."'><span><input type='checkbox' value='".$value['aId']."' class='key' name='member[]'/></span><span><a href='javascript:void(0)'  class='check_form'><img src='../".$uImg."'/>".$value['aName']."<i>".$value['aSex']."</i></a></span><span>".$value['aClass']."</span><span>".$value['aTel']."</span><span>".$value['sDep']."</span><span><a href='javascript:void(0)' class='add_remark'>".$value['aRemark']."</a></span><div class='edit_box' style='display:none'><input type='text' id='remark'/></div></li>
<script>
	aIds['".$i."'] = parseInt(".$value['aId'].");i=".++$i.";
</script>";
	}
}
?>