<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');
//将数据库所有发给该用户的数据置为未读
mysql_query("update message set notice=0 where msgToId='$uId'");

$sId = $_GET['sId'];
$chooseToId = $_POST['chooseToId'];

if($_GET['action'] == "applyNotice"){
	$aId = $_GET['aId'];
	foreach($aId as $value){
		$query=mysql_fetch_assoc(mysql_query("select uId from apply_information_unselected where aId='$value'"));
		$chooseToId[]=$query['uId'];
	}
}

if(empty($chooseToId)){
	$chooseToId = "noBody";
}
//print_r($chooseToId);
if($chooseToId){
	if(is_array($chooseToId)){
		//准备群发消息
		 
		foreach($chooseToId as $value){
			$i++;
			$massRes = mysql_fetch_assoc(mysql_query("select userName from user where uId='$value' limit 1"));
			$massUserNameArray[] = $massRes['userName'];
		}
		$massUserName = implode(',',$massUserNameArray);
		$massTarget = implode(',',$chooseToId);
		
		echo "<script>
			targetSid = '$sId';
			newTarget = '$massTarget';
			newTargetName = '$massUserName';
			newTargetFace = '/image/user_image/defaultImg/massFace.png';
		</script>";
	}else{
		//准备单发消息
		$toUserInfo = mysql_fetch_assoc(mysql_query("select userFace,userName from user where uId='$chooseToId' limit 1"));
		echo "<script>
			targetSid = 0;
			newTarget = '$chooseToId';
			newTargetName = '$toUserInfo[userName]';
			newTargetFace = '$toUserInfo[userFace]';
		</script>";
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="height: 100%;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>消息盒子</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/massageBox.css" type="text/css" rel="stylesheet">
</head>

<body style="height: 100%;">

<div class="top_back">
  <div class="top">
      <ul>
        <li class="a">消息盒子</li>
        <li class="b"><a href="javascript:history.go(-1)">返回&nbsp&nbsp;上一页>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>

<div class="body">
<div class="nav">
   	  <a href="#" id="msgBtn"></a>
      <a href="#" id="linkBtn"></a>
    </div>
    
    <div class="msg_list">
      <ul>
<!--
        <a href="javascript:openSingleChat(1)"><li>
        <div class="userFace"><img src="../image/user_image/user_face/default_face/default_face_5.jpg" /><span></span></div>
        <strong>傻逼屈煜晖</strong>
        <p>Hi小伙伴们，期待已久的林永坚大神的动画案例新作已经新鲜出炉了</p><i class="delete_msg">删除</i>
        </li></a>
-->
      </ul>
      <div class="ui-scrollbar-bar" style="top:0;display:none;"></div>
    </div>
    
    <div class="linkman_list" style="display:none">

  	</div>
    
    <div class="chat_window state_1">
    
    </div>
    
    <div class="chat_window state_2" style="display:none">
    	<div class="massages">
            <ul>
            	<div id="oldMsg"></div>
				<div id="currentMsg"></div>
            </ul>       
        </div>
        <div class="sendBox">
            <input type="hidden" name="toUserFace" value="" />
            <input type="hidden" name="toUserName" value="" />
        	<input type="hidden" name="userName" value="<?php echo $userName?>" />
            <input type="hidden" name="userFace" value="<?php echo '../'.$userFace?>" />
        
          <form action="../background/message/create_msg.php" method="post" id="massage_form" name="massage_form">
            <input type="hidden" name="userId" value="<?php echo $uId?>" />
            <input type="hidden" name="toId" value="" />
        	<textarea name="message" id="msgBody"></textarea>
            <input type="submit" value="发送" onclick="send_massage()"/>
          </form>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>
<!--
<div id="result1" style="height:200px">result1:</div>
<br/>*****************************************************************************<br/>
<div id="result2" style="height:200px">result2:</div>
-->
<!--短信发送窗口-->
<div class="mobile_msg" id="mobile_msg" style="display:none">
<p>网站推广期间，手机短信发送次数不限~~</p><a href="javascript:quit()">&times;</a>
<form action="../background/message/mobile_msg.php" method="post" id="mobileMsg_form">
    <input type="hidden" name="toId" value="" />
    <input type="hidden" name="userName" value="<?php echo $userName?>" />
    <textarea name="m_message" placeholder="在这里编辑短信的内容"></textarea>
    <input type="submit" value="发送" onclick="send_mobileMsg()"/>
</form>
</div>
<!--侧边快捷操作面板-->
<div class="icon_box">
     <a href="massageBox.php"><div id="icon_1"></div>
     </a>
     <a href="myconcern.php"><div id="icon_2"></div></a>
     <a href="../background/background_person/login.php?action=logout"><div id="icon_3"></div></a>
</div>

<script src="js/jquery-1.11.1.js"></script>
<script src="js/main.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script src="js/massageBox.js" type="text/javascript"></script>
<script src="js/messageSystem.js" type="text/javascript"></script>



</body>
</html>


