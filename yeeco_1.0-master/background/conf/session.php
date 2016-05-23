<?php 
$userName=$_SESSION['userName'];
$uId=$_SESSION['userId'];
$sSchool=$_SESSION['sSchool'];
$userFace=$_SESSION['userFace'];
if($userName==NULL || $uId==NULL || $sSchool==NULL || $userFace==NULL){
	 unset($_SESSION['userName']); 
	 unset($_SESSION['userId']);
	 unset($_SESSION['sSchool']); 
	 unset($_SESSION['userFace']);
	  setcookie("usertelno", null, time()-3600*24*365,"/yeeco_1.0/");  
    setcookie("passwordno", null, time()-3600*24*365,"/yeeco_1.0/");
	 echo "<script>alert('长时间未登录，请重新登录！');window.location.href='../index.php';</script>";	
}
?>