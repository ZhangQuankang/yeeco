<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../conf/connect.php');
$actId=$_GET['actId'];
$sId=$_GET['sId'];
//查询旧图片
$oldImg=mysql_fetch_assoc(mysql_query("select actImg,actCode from society_act_closed where sId='$sId'"));
//删除不用的活动二维码、图片
unlink('../'.$oldImg['actImg']);
unlink('../'.$oldImg['actCode']);
mysql_query("delete from society_act_closed where actId='$actId'");
mysql_query("delete from act_user_relation where actId='$actId'");
echo "<script>window.location.href='../../../front/activity.php?sId=$sId'</script>";
?>