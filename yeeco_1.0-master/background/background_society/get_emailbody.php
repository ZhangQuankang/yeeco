<?php 
error_reporting(E_ALL & ~E_NOTICE);
function getEmailBody($id,$flag,$uId,$sName){
$emailbody="您好，请点击下面的链接来激活你的易可社团:<br/><a href=http://localhost/yeeco_1.0/background/background_society/society_auth.php?sid=".$id."&uid=".$uId."&sName=".$sName."&flag=".$flag.">http://".md5(rand())."/".md5(rand())."</a>";
return $emailbody;
}

?>