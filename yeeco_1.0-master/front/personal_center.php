<?php
	session_start();
	error_reporting(E_ALL & ~E_NOTICE);
	require_once('../background/conf/connect.php');
	require_once('../background/conf/session.php');
	//获取页面信息，action表示要去往的页面，“”表示去往“我的动态”，“info”表示去往“个人资料”，“account”表示去往“账号信息”；
	$action = $_GET['action'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>个人中心</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/personal_center.css" type="text/css" rel="stylesheet">
</head>

<body>

<div class="top_back">
  <div class="top">
      <ul>
        <li class="a">个人中心</li>
        <li class="b">返回&nbsp&nbsp;<a href="square.php">易可广场>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>

<div class="body">

<!--左侧导航按钮--> 
  <div class="left">
      <div class="picture"></div>
      <div class="buttons" id="fixedSide">
      	   <a href="myconcern.php"><div><li>我关注的</li></div></a>
      	  <a href="personal_center.php?action=info"><div><li>个人资料</li></div></a>
          <a href="personal_center.php?action=account"><div><li>账号信息</li></div></a>
      </div>
  </div>

<?php
    if($action == ""){
?>
<!--我的动态页面-->   
<div class="main" id="main_1">
    <div class="page_title">
        <li class="title_left">我的动态</li>
    </div>
    <div class="contact">

    </div>  
</div>

<?php
	}else if($action == "info"){
		$infoResult=mysql_fetch_array(mysql_query("select u.userName,u.userSchool,u.userTel,u.userFace,e.userEmail,e.userSex,e.userBirth,e.userPlace,e.userClass,e.userQQ FROM user as u inner join userextrainfo as e
on u.uId=e.uId  where e.uId='$uId' limit 1"));
		$userPlace=$infoResult['userPlace'];
		$userBirth=$infoResult['userBirth'];
		$userSex=$infoResult['userSex'];
		if($userBirth){
			$userBirth=preg_split('/-/',$userBirth, -1, PREG_SPLIT_NO_EMPTY);
			$birthYear=$userBirth[0];
			$birthMonth=$userBirth[1];
			$birthDay=$userBirth[2];
		}
		$native_city="城市";
		if($userPlace){
			$userPlace=preg_split('/-/',$userPlace, -1, PREG_SPLIT_NO_EMPTY);
			$native_por=$userPlace[0];
			$native_city=$userPlace[1];
		}
?>


<!--个人资料页面-->   

<div class="main" id="main_2">
	<div class="page_title">
        <li class="title_left">个人资料</li>
    </div>
    <div class="contact">
		<form class="persenal_info" action="../background/background_person/modify_userinfo.php?op=info" method="post" enctype="multipart/form-data">
          <ul>
            <li class="refer_a">
                <label for="name">姓名：</label>
                <input name="username" type="text" value="<?php echo $infoResult['userName']?>"/>
                <div class="preview_face"><img id="pre_img" src="../<?php echo $infoResult['userFace']?>"></div>
                <input id="pic" type="file" class="face_pic" name="pic" accept="image/gif/png/jpeg/jpg" onchange="setImagePreviews();"/>
            </li>
            <li>
                <label for="sex">性别：</label>
                <span><input  type="radio" name="sex" value="男" id="boy"><label for="boy" class="gray">男</label>
                <input  type="radio" name="sex" value="女" id="girl"><label for="girl" class="gray">女</label></span>
            </li>
            <li>
                <label for="birthday">生日：</label>
                <span id="birthDaySunSelect">
					<select name="birthYear" tabindex="6" id="birthyear" class="select">
                        <option value="">选择年份</option>
                        <option value="2015">2015</option>
                        <option value="2014">2014</option>
                        <option value="2013">2013</option>
                        <option value="2012">2012</option>
                        <option value="2011">2011</option>
                        <option value="2010">2010</option>
                        <option value="2009">2009</option>
                        <option value="2008">2008</option>
                        <option value="2007">2007</option>
                        <option value="2006">2006</option>
                        <option value="2005">2005</option>
                        <option value="2004">2004</option>
                        <option value="2003">2003</option>
                        <option value="2002">2002</option>
                        <option value="2001">2001</option>
                        <option value="2000">2000</option>
                        <option value="1999">1999</option>
                        <option value="1998">1998</option>
                        <option value="1997">1997</option>
                        <option value="1996">1996</option>
                        <option value="1995">1995</option>
                        <option value="1994">1994</option>
                        <option value="1993">1993</option>
                        <option value="1992">1992</option>
                        <option value="1991">1991</option>
                        <option value="1990">1990</option>
                        <option value="1989">1989</option>
                        <option value="1988">1988</option>
                        <option value="1987">1987</option>
                        <option value="1986">1986</option>
                        <option value="1985">1985</option>
                        <option value="1984">1984</option>
                        <option value="1983">1983</option>
                        <option value="1982">1982</option>
                        <option value="1981">1981</option>
                        <option value="1980">1980</option>
                        <option value="1979">1979</option>
                        <option value="1978">1978</option>
                        <option value="1977">1977</option>
                        <option value="1976">1976</option>
                        <option value="1975">1975</option>
                        <option value="1974">1974</option>
                        <option value="1973">1973</option>
                        <option value="1972">1972</option>
                        <option value="1971">1971</option>
                        <option value="1970">1970</option>
                        <option value="1969">1969</option>
                        <option value="1968">1968</option>
                        <option value="1967">1967</option>
                        <option value="1966">1966</option>
                        <option value="1965">1965</option>
                        <option value="1964">1964</option>
                        <option value="1963">1963</option>
                        <option value="1962">1962</option>
                        <option value="1961">1961</option>
                        <option value="1960">1960</option>
                    </select> 
                    <select name="birthMonth" id="birthmonth" class="select">
                        <option value="">选择月份</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <select name="birthDay" id="birthday" class="select">
                        <option value="">选择日期</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                    </select>
				</span>
            </li>
            <li class="refer_b">
                <label for="native_place">籍贯：</label>
                <span id="native_place">
					<select class="native_por" id="native_por" name="native_por">
                        <option value="" selected="selected">省份</option>
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
					<select class="native_city" id="native_city" name="native_city">
	<option id="city" selected="selected" value="<?php echo $native_city?>"><?php echo $native_city?></option>
</select>
				</span>              
            </li>
            <li>
                <label for="school">所在学校：</label>
                <input name="school" type="text" value="<?php echo $infoResult['userSchool']?>" readonly="readonly"/>
            </li>
            <li>
                <label for="major">专业班级：</label>
                <input name="major" type="text" value="<?php echo $infoResult['userClass']?>"/>

            </li>
            <li>
                <label for="tel_number">联系电话：</label>
                <input name="tel_number" type="text" value="<?php echo $infoResult['userTel']?>" readonly="readonly"/>
            </li>
            <li>
                <label for="email">邮箱：</label>
                <input name="email" type="text" value="<?php echo $infoResult['userEmail']?>"/>
            </li>
            <li>
                <label for="qq">QQ：</label>
                <input name="qq" type="text" value="<?php echo $infoResult['userQQ']?>"/>
            </li>
              	<input type="submit" class="button" value="保存" />
          </ul>   
        </form>
    </div>
</div>

<?php



	}else if($action == "account"){
		$accountResult=mysql_fetch_array(mysql_query("select userTel from user where uId='$uId' limit 1"));

?>
<!--账号信息页面-->   
<div class="main" id="main_3">
    <div class="page_title">
        <li class="title_left">账号信息</li>
    </div>
    <div class="contact">
    	<form class="tel_form" id="tel_form" action="../background/background_person/modify_userinfo.php?op=tel" method="post">
          <li>
            <label>当前账号：</label>
            <input name="userTel" type="text" value="<?php echo $accountResult['userTel']?>" readonly="readonly" onkeydown="disappear('otel');" />
          </li>
          <li><span id="otel" style="display:none"></span><span id="span_4" style="display:none">手机号码格式不正确</span></li>
          <li><a class="gray" href="javascript:change_tel()">绑定其他手机号</a></li>
          <input type="button" class="button" id="sendcode" value="发送验证码" style="display:none;" onclick="sendCode();"/>
          <li class="ver_code" style="display:none;">
            <p>我们给该号码发送了一条短信验证码</p>
            <p>若<strong class="time">60</strong>秒后您还未收到，请点击<a id="resend" class="gray">重新发送</a></p>
            <p><input type="text" id="test" placeholder="在这里输入验证码"/></p>
          </li>
          <input type="button" class="button" id="onsubmit" value="确认修改" onclick="verify_Code()" style="display:none;"/>
        </form>
        <div style="width:750px;border-bottom:1px solid #f2f2f2;margin:35px auto;"></div>
        <form class="password_form" action="../background/background_person/modify_userinfo.php?op=pwd" method="post">
        <ul>
          <li>
            <label>当前密码：</label>
            <input name="password_old" type="password" onfocus="outline_new(this)" onblur="password_test();outline_old(this)" onkeydown="disappear('span_1');" required="required"/>

          </li>
          <li><span id="span_1" style="display:none"></span></li>
          <li>
            <label>设置密码：</label>
            <input name="password_1" type="password"  placeholder="密码不得少于六位" onblur="checking_2(this)"  onkeydown="disappear('span_2');" required="required"/>
          </li>
          <li><span id="span_2" style="display:none">密码长度至少6位！</span></li>
          <li>
            <label>确认密码：</label>
            <input name="password_2" type="password" onblur="checking_3(this)" onkeydown="disappear('span_3');"/>
          </li>
          <li><span id="span_3" style="display:none">两次密码不一致!</span></li>
          <input type="submit" class="button" value="修改密码" />
        </ul>
        </form>
    </div> 
</div>
<?php
	}
?>

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
<script src="js/personal_center.js" type="text/javascript"></script>
<script src="js/pic_preview.js" type="text/javascript"></script>
<script src="res_package/birth&native.js" type="text/javascript"></script>
<?php
	if($userBirth){
		echo  "<script>$('#birthyear').val('$birthYear');$('#birthmonth').val('$birthMonth');$('#birthday').val('$birthDay')</script>";
	}
	if($userPlace){
		echo  "<script>$('#native_por').val('$native_por')</script>";
	}
	if($userSex=='男'){
		echo  "<script>$('#boy').attr('checked','checked');</script>";
	}else{
    	echo  "<script>$('#girl').attr('checked','checked'); </script>";
    }

?>



</body>
</html>


