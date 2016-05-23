<?php
error_reporting(E_ALL & ~E_NOTICE);
//生成唯一字符串的文件名
function QRCode($page,$Id,$QRfolder){
	$f1=substr($QRfolder,3);
	include $f1.'phpqrcode/qrlib.php';
	include $f1.'phpqrcode/qrconfig.php';
	if($page=='mobileFront/M_societyVisitor.php'){
		$value = 'http://123.57.86.194/front/'.$page.'?sId='.$Id; //二维码内容 
	}
	if($page=='mobileFront/M_activityVisitor.php'){
		$value = 'http://123.57.86.194/front/'.$page.'?actId='.$Id;
	}
	$errorCorrectionLevel = 'L';//容错级别 
	$matrixPointSize = 6;//生成图片大小 
	//生成二维码图片 
	$imgname=getUniName();
	$qrpath= $QRfolder.'image/user_image/society/qrcode/'.$imgname.'.png';
	QRcode::png($value,$qrpath, $errorCorrectionLevel, $matrixPointSize, 2); 
	return $qrpath;
	//$QR = 'qrcode.png';//已经生成的原始二维码图 
}
?>