<?php 
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
$userId = $_GET['userId'];
$targetId = $_GET['targetId'];

$target = mysql_fetch_assoc(mysql_query("select userName,userFace from user where uId = '$targetId'"));
if($target){
	$data = array(
		'userName' => $target['userName'],
		'userFace' => $target['userFace']
	);
}else{
	$data = array(
		'userName' => '易可助手',
		'userFace' => 'image/web_image/yeeco_assistant.png'
	);
}


echo json_encode($data);
?>