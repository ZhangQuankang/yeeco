<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../background/conf/connect.php');
$actId=$_GET['actId'];
$sSchool=$_GET['sSchool'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=2.0,initial-scale=1.0,user-scalable=no">
<title>报名表</title>
<link href="M_css/M_activityApply.css" type="text/css" rel="stylesheet">
</head>

<body>

<div class="isSubmitting" style="display:none">
    <div class="back"></div>
    <div class="back_in">
    	<img src="mum.gif" width="50" height="50" />
    	<p>正在提交~</p>
    </div>
</div>

<form action="../../background/web_app/M_activityApplyB.php" method="post" name="pre_applyForm" id="pre_applyForm">
<div id="index_1">
<div class="top">
	<a href="M_activityVisitor.php">&lt;返回</a>
	<p>活动报名表</p>
</div>

<div style="height:40px;"></div>
<input type="hidden" name="actId" value="<?php echo $actId?>"/>
<input type="hidden" name="state"/>
<div class="block page_1">
  <ul>
    <li><span>姓名</span><input type="text" placeholder="输入姓名" name="aName" required="required" /></li>
    <li><span>性别</span>
    	<select name="aSex" tabindex="6" class="sexSelect" >
            <option value="">选择性别</option>
            <option value="男">男</option>
            <option value="女">女</option>
        </select>
    </li>
  </ul>
</div>

<div class="block page_2">
  <ul>
    <li><span>所在学校</span><input type="text" value="<?php echo $sSchool?>" readonly="readonly" name="aSchool"/></li>
    <li><span>专业班级</span><input type="text" placeholder="输入专业班级" name="aClass" required="required" /></li>
  </ul>
</div>

<div class="block page_3">
  <ul>
    <li><span>电话</span><input type="text" placeholder="输入手机号码" name="aTel" required="required" /></li>
  </ul>
</div>

<input type="button" value="提交" class="subBtn" id="pre_applyForm" onclick="findUser();"/>

</div>

<div id="index_2" style="display:none">
<div class="top">
	<a href="javascript:history.back();">&lt;返回</a>
	<p>申请确认</p>
</div>
<div style="height:40px;"></div>
  <ul>
    <li><p>尊敬的<span id="userName_1"></span>同学：</p></li>
    <li><p>您的登录账号是：<span id="userTel_1"></span></p></li>
  </ul>
    <input type="password" placeholder="&nbsp;&nbsp;&nbsp;请在这里输入密码" name="password_1" required="required"/>
    <input type="submit" value="提交" class="subBtn"/>
  <div class="forget"><a href="#">忘记密码</a></div>
</div>

<div id="index_3" style="display:none">
<div class="top">
	<a href="javascript:history.back();">&lt;返回</a>
	<p>申请确认</p>
</div>
<div style="height:40px;"></div>
  <ul>
    <li><p>尊敬的<span id="userName_2"></span>同学：</p></li>
    <li><p>您的登录账号是：<span id="userTel_2"></span></p></li>
    <li><p>为及时给您反馈申请结果，我们需要保证您的联系方式真实有效！</p></li>
    <li><p>请在下面输入您收到的验证码</p></li>
  </ul>
  	<div class="line">
    	<input type="text" placeholder="&nbsp;&nbsp;&nbsp;在这里输入验证码" name="testCode"/>
        <div class="reSend" onclick="request_code()">重新发送</div>
    </div>
    <input type="password" placeholder="&nbsp;&nbsp;&nbsp;在这里设置密码，方便查询申请结果" name="password_2"/>
    <input type="button" value="提交" class="subBtn" onclick="form_submit()"/>
</div>
</form>


<script src="../js/jquery-1.11.1.js"></script>
<script src="../js/jquery.form.js" type="text/javascript"></script>
<script src="M_js/M_activityApply.js" type="text/javascript"></script>
</body>
</html>