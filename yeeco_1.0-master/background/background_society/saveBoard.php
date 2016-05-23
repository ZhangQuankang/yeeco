<?php
/*
*存储公告栏
*/
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
$board=$_POST['board'];
$sId=$_POST['sId'];
mysql_query("update society set Board='$board' where sid='$sId'");
?>