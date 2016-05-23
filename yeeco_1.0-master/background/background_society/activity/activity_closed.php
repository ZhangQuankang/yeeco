<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../conf/connect.php');
$actId=$_GET['actId'];
$sId=$_GET['sId'];
mysql_query("insert into society_act_closed(actId,actName,actType,isApply,actRange,actBeginDate,actBeginTime,actEndDate,actEndTime,applyBeginDate,applyBeginTime,applyEndDate,applyEndTime,actNum,actFocusNum,actSchool,actPlace,actDesc,actDetail,sId,setTime,actImg,actBoard,actCode) select actId,actName,actType,isApply,actRange,actBeginDate,actBeginTime,actEndDate,actEndTime,applyBeginDate,applyBeginTime,applyEndDate,applyEndTime,actNum,actFocusNum,actSchool,actPlace,actDesc,actDetail,sId,setTime,actImg,actBoard,actCode from society_act_open where actId='$actId'");
mysql_query("delete from society_act_open where actId='$actId'");
echo "<script>window.location.href='../../../front/activity.php?sId=$sId'</script>";
?>