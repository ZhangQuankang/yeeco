<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');
$sId=$_GET['sId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>邮件已发送</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/new_society.css" type="text/css" rel="stylesheet">
</head>

<body>
<div class="top_back">
  <div class="top">
      <ul>
        <li class="a">易可社团</li>
        <li class="b">返回&nbsp&nbsp;<a href="square.php">易可广场>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>


<div class="page_pre" id="page_pre">
    <div class="hello_pic"><img src=""></div>
    <div class="welcome">
       <p>激活邮件已发送至您的邮箱！</p>
       <p>请注意查收并及时激活您的社团！</p>
       <p>如果长时间未收到，点此<a href="../background/background_society/email_resend.php?sId=<?php echo $sId?>" class="gray">重新发送</a></p>
    </div>
</div>

<!--侧边快捷操作面板--> 
<div class="icon_box">
     <a href="massageBox.php"><div id="icon_1"></div>
<?php
	if(mysql_num_rows(mysql_query("select  msgId  from message where msgToId='$uId'"))){
?>     
     <span></span>
<?php
	}
?> 
     </a>
     <a href="myconcern.php"><div id="icon_2"></div></a>
     <a href="../background/background_person/login.php?action=logout"><div id="icon_3"></div></a>
</div>

<script src="js/jquery-1.11.1.js"></script>
<script src="js/main.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
</body>
</html>


