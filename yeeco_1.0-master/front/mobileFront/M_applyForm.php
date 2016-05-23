<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../background/conf/connect.php');
$sId=$_GET['sId'];
$fId=$_GET['fId'];
$sSchool=$_GET['sSchool'];
$fInfo=mysql_fetch_assoc(mysql_query("select * from society_fresh where sId='$sId'"));

//查找部门信息
$dep=mysql_query("SELECT depName FROM department WHERE societyId='$sId'");
if($dep && mysql_num_rows($dep)){
	    while($row = mysql_fetch_assoc($dep)){
			//$dId[]=$row['dId'];
			$depName[]=$row['depName'];
		}			
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=2.0,initial-scale=1.0,user-scalable=no">
<title>报名表</title>
<link href="M_css/M_applyForm.css" type="text/css" rel="stylesheet">
</head>


<body>

<div class="isSubmitting" style="display:none">
    <div class="back"></div>
    <div class="back_in">
    	<img src="mum.gif" width="50" height="50" />
    	<p>正在提交~</p>
    </div>
</div>

<form action="../../background/web_app/M_applyFormB.php" method="post" name="pre_applyForm" id="pre_applyForm">
<div id="index_1">
<div class="top">
	<a href="M_societyVisitor.php?sId=<?php echo $sId?>">&lt;返回</a>
	<p><?php echo $fInfo['sName']?>&nbsp;·&nbsp;报名表</p>
</div>

<div style="height:40px;"></div>
<input type="hidden" name="sId" value="<?php echo $sId?>"/>
<input type="hidden" name="fId" value="<?php echo $fId?>"/>
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
    <li><span>生日</span>
    				<select name="birthYear" tabindex="6" id="birthyear" class="birthSelect" style="width:24%">
                        <option value="">年份</option>
                        <option value="2015">2015年</option>
                        <option value="2014">2014年</option>
                        <option value="2013">2013年</option>
                        <option value="2012">2012年</option>
                        <option value="2011">2011年</option>
                        <option value="2010">2010年</option>
                        <option value="2009">2009年</option>
                        <option value="2008">2008年</option>
                        <option value="2007">2007年</option>
                        <option value="2006">2006年</option>
                        <option value="2005">2005年</option>
                        <option value="2004">2004年</option>
                        <option value="2003">2003年</option>
                        <option value="2002">2002年</option>
                        <option value="2001">2001年</option>
                        <option value="2000">2000年</option>
                        <option value="1999">1999年</option>
                        <option value="1998">1998年</option>
                        <option value="1997">1997年</option>
                        <option value="1996">1996年</option>
                        <option value="1995">1995年</option>
                        <option value="1994">1994年</option>
                        <option value="1993">1993年</option>
                        <option value="1992">1992年</option>
                        <option value="1991">1991年</option>
                        <option value="1990">1990年</option>
                        <option value="1989">1989年</option>
                        <option value="1988">1988年</option>
                        <option value="1987">1987年</option>
                        <option value="1986">1986年</option>
                        <option value="1985">1985年</option>
                        <option value="1984">1984年</option>
                        <option value="1983">1983年</option>
                        <option value="1982">1982年</option>
                        <option value="1981">1981年</option>
                        <option value="1980">1980年</option>
                        <option value="1979">1979年</option>
                        <option value="1978">1978年</option>
                        <option value="1977">1977年</option>
                        <option value="1976">1976年</option>
                        <option value="1975">1975年</option>
                        <option value="1974">1974年</option>
                        <option value="1973">1973年</option>
                        <option value="1972">1972年</option>
                        <option value="1971">1971年</option>
                        <option value="1970">1970年</option>
                    </select>
                    <select name="birthMonth" id="birthmonth" class="birthSelect"  style="width:19%">
                        <option value="">月份</option>
                        <option value="1">1月</option>
                        <option value="2">2月</option>
                        <option value="3">3月</option>
                        <option value="4">4月</option>
                        <option value="5">5月</option>
                        <option value="6">6月</option>
                        <option value="7" style="margin-left:20px;">7月</option>
                        <option value="8">8月</option>
                        <option value="9">9月</option>
                        <option value="10">10月</option>
                        <option value="11">11月</option>
                        <option value="12">12月</option>
                    </select>
                    <select name="birthDay" id="birthday" class="birthSelect"  style="width:19%">
                        <option value="">日期</option>
                        <option value="1">1日</option>
                        <option value="2">2日</option>
                        <option value="3">3日</option>
                        <option value="4">4日</option>
                        <option value="5">5日</option>
                        <option value="6">6日</option>
                        <option value="7">7日</option>
                        <option value="8">8日</option>
                        <option value="9">9日</option>
                        <option value="10">10日</option>
                        <option value="11">11日</option>
                        <option value="12">12日</option>
                        <option value="13">13日</option>
                        <option value="14">14日</option>
                        <option value="15">15日</option>
                        <option value="16">16日</option>
                        <option value="17">17日</option>
                        <option value="18">18日</option>
                        <option value="19">19日</option>
                        <option value="20">20日</option>
                        <option value="21">21日</option>
                        <option value="22">22日</option>
                        <option value="23">23日</option>
                        <option value="24">24日</option>
                        <option value="25">25日</option>
                        <option value="26">26日</option>
                        <option value="27">27日</option>
                        <option value="28">28日</option>
                        <option value="29">29日</option>
                        <option value="30">30日</option>
                        <option value="31">31日</option>
                    </select>
    </li>
    <li><span>籍贯</span>
    				<select class="native_por" id="native_por" name="native_por" style="width:22%">
                        <option selected="selected" value="">省份</option>
                        <option value="北京" id="1">北京</option>
                        <option value="上海" id="2">上海</option>
                        <option value="天津" id="3">天津</option>
                        <option value="重庆" id="4">重庆</option>
                        <option value="黑龙江" id="5">黑龙江</option>
                        <option value="吉林" id="6">吉林</option>
                        <option value="辽宁" id="7">辽宁</option>
                        <option value="安徽" id="8">安徽</option>
                        <option value="江苏" id="9">江苏</option>
                        <option value="浙江" id="10">浙江</option>
                        <option value="陕西" id="11">陕西</option>
                        <option value="湖北" id="12">湖北</option>
                        <option value="广东" id="13">广东</option>
                        <option value="湖南" id="14">湖南</option>
                        <option value="甘肃" id="15">甘肃</option>
                        <option value="四川" id="16">四川</option>
                        <option value="山东" id="17">山东</option>
                        <option value="福建" id="18">福建</option>
                        <option value="河南" id="19">河南</option>   
                        <option value="云南" id="20">云南</option>
                        <option value="河北" id="21">河北</option>
                        <option value="江西" id="22">江西</option>
                        <option value="山西" id="23">山西</option>
                        <option value="贵州" id="24">贵州</option>
                        <option value="广西" id="25">广西</option>
                        <option value="内蒙古" id="26">内蒙古</option>
                        <option value="宁夏" id="27">宁夏</option>
                        <option value="青海" id="28">青海</option>
                        <option value="新疆" id="29">新疆</option>
                        <option value="海南" id="30">海南</option>
                        <option value="西藏" id="31">西藏</option>
                        <option value="香港" id="32">香港</option>
                        <option value="澳门" id="33">澳门</option>
                        <option value="台湾" id="34">台湾</option>
                    </select>
					<select class="native_city" id="native_city" name="native_city" style="width:40%">
	<option id="city" selected="selected" value="">城市</option>
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
    <li><span>邮箱</span><input type="text" placeholder="输入邮箱" name="aEmail" /></li>
    <li><span>Q&nbsp;Q</span><input type="text" placeholder="输入QQ" name="aQQ" /></li>
  </ul>
</div>

<div class="block page_4">
<?php
	if($fInfo['fQue_1']){
?>
  <p><?php echo $fInfo['fQue_1']?></p>
  <textarea name="aAnser_1"></textarea>
<?php
	}if($fInfo['fQue_2']){
?>
  <hr noshade="noshade" size="1px" color="#eee" width="90%" style="margin:0 auto"/>
  <p><?php echo $fInfo['fQue_2']?></p>
  <textarea name="aAnser_2"></textarea>
<?php
	}if($fInfo['fQue_3']){
?>
  <hr noshade="noshade" size="1px" color="#eee" width="90%" style="margin:0 auto"/>
  <p><?php echo $fInfo['fQue_3']?></p>
  <textarea name="aAnser_3"></textarea>
<?php
	}
?>
</div>

<div class="block page_5">
  <ul>
    <li><span>选择部门：</span><select name="department">
                <option value="0">任意部门</option>
<?php
	for($i=0;$i<=sizeof($depName)-1;$i++){
?>
                <option value="<?php echo $depName[$i]?>"><?php echo $depName[$i]?></option>
<?php
}
?>
            </select></li>
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
        <div class="reSend" onclick="request_code();">重新发送</div>
    </div>
    <input type="password" placeholder="&nbsp;&nbsp;&nbsp;在这里设置密码，方便查询申请结果" name="password_2"/>
    <input type="button" value="提交" class="subBtn" onclick="form_submit();"/>
</div>
</form>

<script src="../js/jquery-1.11.1.js"></script>
<script src="../js/jquery.form.js" type="text/javascript"></script>
<script src="M_js/M_applyForm.js" type="text/javascript"></script>
</body>
</html>