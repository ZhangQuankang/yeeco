<?php 
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
require_once('get_picture.php');
require_once('../conf/adjust_Img.php');
require_once('../background_comment/create_news.php');
//上传纳新海报
$folder = "../../image/user_image/society/fresh";
$fImg = getImg($folder);
if($fImg==NULL){
		$fImg='../../image/user_image/defaultImg/fresh_ad.png';
}
//获取表单信息
$notice=$_POST['notice'];
$detail=$_POST['detail'];
$que_1=$_POST['que_1'];
$que_2=$_POST['que_2'];
$que_3=$_POST['que_3'];
$sName=$_POST['sName'];
$sId = $_POST['sId'];
//执行插入语句
if(mysql_num_rows(mysql_query("select sId from society_fresh where sId='$sId'"))){
	echo $sId;
}else{
	
	$insertsql = mysql_query("insert into society_fresh(sName,sId,fImg,fAnn,fDetail,fQue_1,fQue_2,fQue_3) values('$sName','$sId','$fImg','$notice','$detail','$que_1','$que_2','$que_3')");
	$fId=mysql_insert_id();
	
	$type = '开启纳新';
	$data = array(
		'sId' => $sId,
		'oId' => $fId,
		'oName' => $sName,
		'fAnn' => $notice
	);
	create_news($type,$data);
    mysql_query("update society set isFresh=1 where sId='$sId'");
}

?>