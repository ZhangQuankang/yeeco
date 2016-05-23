<?php 
error_reporting(E_ALL & ~E_NOTICE);
header('Cache-Control: no-cache');
require_once('../conf/connect.php');
header('Content-Type: text/event-stream');
////查询消息
$msgToId = $_GET['msgToId'];//与该用户通话者的ID67
$msgFromId = $_GET['msgFromId'];//请求者的ID9

$data = array(
	'notice' => array(),
	'message' => array()
);

$msg=mysql_query("select msgId,msgBody,msgTime,msgFromId,notice from message where msgToId='$msgFromId' order by msgTime");

if($msg && mysql_num_rows($msg)){
	while($rows = mysql_fetch_assoc($msg)){
		if($rows['notice'] == 0 && $msgToId != $rows['msgFromId']){
			$data['notice'][] = $rows['msgFromId'];
			mysql_query("update message set notice = 1 where msgId = '$rows[msgId]'");
		}
		if($msgToId == $rows['msgFromId']){
			$data['message'][] = array(
				'msgTime' => $rows['msgTime'],
				'msgBody' => $rows['msgBody']
			);
			mysql_query("delete from message where msgId = '$rows[msgId]'");
		}	
	}	
}
if($data['notice'] || $data['message']){
	$data=json_encode($data);
	echo "data: {$data}\n\n";	
}
flush();
//sleep(2);
?>