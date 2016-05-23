<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
require_once('../conf/HttpClient.class.php');
require_once('../conf/enc.php');
$data[0] = "";
$url = "http://localhost/yeeco_1.0/test/untitled.php";
$result = HttpClient::quickPost($url,$data);
if($result){
	echo $result;
}else{
	echo "B";
}




?>