<?php 
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
require_once('../background_comment/create_news.php');
$sId=$_GET['sId'];
$action=$_GET['action'];

//生成纳新关闭动态
$sName=$_GET['sName'];
$type = '纳新关闭';
$data = array(
		'sId' => $sId,
		'oId' => $sId,
		'oName' => $sName,
		'action' => $action,
);
create_news($type,$data);
//执行停止纳新操作
if($action=='pub'){
	mysql_query("update society set isFresh=2 where sId='$sId'");
}else{
	mysql_query("update society set isFresh=0 where sId='$sId'");
}
//查找旧图片
$oldImg=mysql_fetch_assoc(mysql_query("select fImg from society_fresh where sId='$sId'"));
//删除不用的活动二维码、图片
unlink($oldImg['fImg']);
mysql_query("delete from society_fresh where sId='$sId'");
mysql_query("delete from apply_information_unselected where sId='$sId'");
echo "<script>window.location.href='../../front/society_home.php?sId=$sId'</script>";
?>