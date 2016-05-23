<?php
	session_start();
	error_reporting(E_ALL & ~E_NOTICE);
	require_once('../background/conf/enc.php');
	//接受从login.php获得的account值
	if($_GET['account']){
		$account = $_GET['account'];
	}
	//接受从本页面中获得的account值
	if($_POST['usertel']){
		$account=code($_POST['usertel']);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改密码</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/change_password.css" type="text/css" rel="stylesheet">
</head>

<body>

<div class="top_back">
  <div class="top">
      <ul>
        <li class="a">个人中心</li>
        <li class="b">已有账号？马上&nbsp;<a href="../index.php">登录</a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>

<div class="body">
<?php
	if($account){
?>
<!--修改密码页面-->   
<div class="page">
        <form class="password_form" action="../background/background_person/activate_user.php" method="post">
        <ul>
          <li>
          	<input name="userTel" type="hidden" value="<?php echo $account?>"/>
            <label>设置密码：</label>
            <input name="password_1" type="password" placeholder="密码不得少于六位" onblur="checking_2(this)"  onkeydown="disappear('span_2');" required="required"/>
          </li>
          <li><span id="span_2" style="display:none">密码长度至少6位！</span></li>
          <li>
            <label>确认密码：</label>
            <input name="password_2" type="password" onblur="checking_3(this)" onkeydown="disappear('span_3');"/>
          </li>
          <li><span id="span_3" style="display:none">两次密码不一致!</span></li>
          <input type="submit" class="button" value="修改密码"/>
        </ul>
        </form>
</div>
<?php
	}else{
?>
<!--发送验证码，找回密码页面-->   
<div class="page">
        <form class="test_code" id="tel_form" action="change_password.php" method="post">
        <ul>
          <li>
            <label>手机号码：</label>
            <input name="usertel" type="text" placeholder="请输入手机号码" required="required" onkeydown="disappear('span_4');disappear('otel')"/>
            <input type="button" class="button" id="onsend" value="发送验证码" onclick="checking_find()"/>
          </li>
          <li><span id="span_4" style="display:none">请输入合法的手机号码！</span></li>
          <li><span id="otel" style="display:none"></span></li>
          <li>
            <label>验证码：</label>
            <input name="user_tel" id="test" type="text" placeholder="请输入验证码" required="required"/>
          </li>
          <li><span id="span_5" style="display:none">验证码输入错误！</span></li>
          <input type="button" style="margin:0 170px" class="button" id="onsubmit" onclick="verify_Code()" value="提交" />
        </ul>
        </form>
</div>
<?php
	}
?>
</div>
<script src="js/jquery-1.11.1.js"></script>
<script src="js/main.js"></script>
<script src="js/change_password.js" type="text/javascript"></script>
</body>
</html>


