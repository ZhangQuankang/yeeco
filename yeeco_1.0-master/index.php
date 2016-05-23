<?php	
    if(@$_COOKIE["passwordno"]){
	
?>
	<form id="LoginForm" action="background/background_person/login.php?action=auto" method="post"><!--指向后台的登录模块.php-->
        <input type="hidden" name="usertel" value="<?php echo $_COOKIE["usertelno"]?>"/>
        <input type="hidden"name="password" value="<?php echo $_COOKIE["passwordno"]?>"/>
    </form>
	<script type="text/javascript">
    	document.getElementById('LoginForm').submit();
	</script>
<?php	      
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>易可社团-登录</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<meta name="Keywords" content="易可社团,易可平台,易可高校社团,中国高校社团,高校社团管理平台,社团管理系统,线上社团,学生社团">
<meta name="Description" content="易可社团，作为一款适应于中国国内高校社团的线上管理系统，创建线上管理与线下活动相结合的新模式；构建围绕社团活动开展的网络社区，吸引高校生长期活跃的互联网社区。">
<link href="front/css/login.css" type="text/css" rel="stylesheet">
<link href="front/css/main.css" type="text/css" rel="stylesheet">
</head> 
<body> 
<div class="top_back">
  <div class="top">
      <div class="top_logo"><a href="../index.php"><img src="image/web_image/logo.png" width=100% height=100% /></a></div>
      <ul class="top_right">
        <a onMouseOver="newbox('code_2')" onMouseOut="movebox('code_2')"><li>Android下载</li></a>
        <a onMouseOver="newbox('code_1')" onMouseOut="movebox('code_1')"><li>iPhone下载</li></a>
        <a href="front/register.php"><li>注册易可账号</li></a>
      </ul>
      <div id="code_1">
           <img src="image/web_image/二维码.png"/>
      </div>
      <div id="code_2">
           <img src="image/web_image/二维码.png"/>
      </div>
  </div>
</div>

<div style="clear:both;"></div>

<div class="first_page">
      
    <div class="b"><img src="image/web_image/主题图片.png"></div>
    <!--<div class="a"><img src="image/web_image/背景图片1.png"></div>  -->
    <div class="c"><img src="image/web_image/气泡1.png"></div>
    <div class="d"><img src="image/web_image/气泡2.png"></div>
    <div class="e"><img src="image/web_image/气泡3.png"></div>
    
    <div class="login_box">
        <div class="logon_header">
          登&nbsp;录
        </div>
    <form name="LoginForm" action="background/background_person/login.php" method="post"><!--指向后台的登录模块.php-->
        <div class="lnusername">
            <div class="icon icon_1"></div>
            <input type="text" id="username" name="usertel" class="text-input" onFocus="register_text_in(this)" onBlur="register_text_out(this)" placeholder="请输入手机号码" required/>
        </div>
        <div class="lnpassword">
            <div class="icon icon_2"></div>
            <input type="password" id="password" name="password" class="text-input" onFocus="register_text_in(this)" onBlur="register_text_out(this)" placeholder="请输人密码" required oncopy="return false" onpaste="return false"/>
        </div>
        <label class="checkbox"><input type="checkbox" name="remember" checked="checked">自动登录</label>
        <label class="forget"><a href="front/change_password.php">忘记密码</a></label>
        <input type="submit" name="submit" class="logon" value="登录">
    </form>
    </div>

    
</div>

<div style="clear:both;"></div>
<div class="footer">
	<p><a href="front/temp_page.html">招才纳士</a><a href="front/temp_page.html">联系我们</a><a href="front/temp_page.html">意见反馈</a><a href="front/temp_page.html">网站地图</a><a href="front/temp_page.html">新手学堂</a></p>
    <hr color="#ccc" size="1"/>
    <p>中国·陕西·西安市·长安区·西安邮电大学 710100 | *</p>
    <p>好点子，新生活</p>
</div>
<script src="front/js/jquery-1.11.1.js"></script>
<script src="front/js/index.js"></script>
</body>
</html>
