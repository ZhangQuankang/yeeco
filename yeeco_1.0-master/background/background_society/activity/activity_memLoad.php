<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../conf/connect.php');
$actId=$_POST['actId'];
$i=$_POST['i'];
//查询活动的成员
$query=mysql_query("select uId from act_user_relation where actId='$actId' limit ".$i.",5");
if($query && mysql_num_rows($query)){
	    while($row = mysql_fetch_assoc($query)){
			$aUid[]=$row;
		}			
}
if($aUid){
	foreach($aUid as $value){
		$uFace=mysql_fetch_assoc(mysql_query("select userFace from user where uId='$value[uId]'"));
		$uInfo=mysql_fetch_assoc(mysql_query("select userName,userTel,userSex,userClass from userextrainfo where uId='$value[uId]'"));
	
	echo "<li><span><input type='checkbox' value='".$value['uId']."' id='key' name='member[]'/></span><span><a href='javascript:void(0)' id='table_a'><img src='../".$uFace['userFace']."'/>".$uInfo['userName']."<i>".$uInfo['userSex']."</i></a></span><span>".$uInfo['userClass']."</span><span>".$uInfo['userTel']."</span></li>";
	$i++;	
	}
	echo '@'.$i;
}
?>