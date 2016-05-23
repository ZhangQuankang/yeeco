<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>创建社团</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/society_establish.css" type="text/css" rel="stylesheet">
</head>

<body>

<div class="top_back">
  <div class="top">
      <ul>
        <li class="a">创建社团</li>
        <li class="b">返回&nbsp&nbsp;<a href="square.php">易可广场>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>

<div class="body">
  <div class="left">
      <div class="picture"></div>
      <div class="but">不太了解易可网的高校社团中心<br/>进入&nbsp;&nbsp;<a href="">新手学堂</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>></div>
  </div>
  <div class="main" id="main_1">
    <div class="page_title">
        <li class="title_left">填写基本信息</li>
    </div>
    <div class="contact">
<form class="contact_form" action="../background/background_society/society_establish_form.php"
 method="post" name="contact_form" enctype="multipart/form-data">
    <ul>
        <li>
            <input type="hidden" name="principalId" value="<?php echo $_SESSION['userId']?>"/>
            <input type="hidden" name="principal" value="<?php echo $_SESSION['userName']?>"/>
            <label for="society_name"><span>*</span>社团名称：</label>
            <input name="society_name" type="text"  placeholder="6~20个字符"/>
        </li>
        <li>
            <label for="school"><span>*</span>所在学校：</label>
            <input name="school" type="text" value="<?php echo $_SESSION['sSchool']?>" readonly="readonly"/>
        </li>
        <li>
            <label for="type"><span>*</span>社团性质：</label>
            <ul>
            <li><input type="checkbox" name="type[]" id="type_1" value="学生会（或其所属部门）" onclick="judge_check(this)" /><label for="type_1">学生会（或其所属部门）</label></li>
            <li><input type="checkbox" name="type[]" id="type_2" value="志愿者协会（或其所属部门）" onclick="judge_check(this)"/><label for="type_2">志愿者协会（或其所属部门）</label></li><br/>
            <li><input type="checkbox" name="type[]" id="type_3" value="学术类"/><label for="type_3">学术类</label></li>
            <li><input type="checkbox" name="type[]" id="type_4" value="艺术类"/><label for="type_4">艺术类</label></li>
            <li><input type="checkbox" name="type[]" id="type_5" value="文化类"/><label for="type_5">文化类</label></li>
            <li><input type="checkbox" name="type[]" id="type_6" value="体育类"/><label for="type_6">体育类</label></li>
            <li><input type="checkbox" name="type[]" id="type_7" value="兴趣类"/><label for="type_7">兴趣类</label></li>
            <li><input type="checkbox" name="type[]" id="type_8" value="其他"/><label for="type_8">其他</label></li>
            </ul>
            <div style="clear:both;"></div>
        </li>
        <li>
            <label for="describe"><span>*</span>社团简介：</label>
            <textarea name="describe" placeholder="不超过400个字符"></textarea>
        </li>
        <li>
            <label for="pic">&nbsp;&nbsp;社团封面：</label>
            <div class="pic" id="dd"><img id="pre_img" src="../image/user_image/defaultImg/society_logo.png"/></div>
            <input id="pic" type="file" name="pic" accept="image/gif/png/jpeg/jpg" onchange="setImagePreviews();"/>
            <p>请选择不超过1M的 .gif, .jpg, .jpeg 或 .png文件</p>
            <a href="javascript:delete_pic()">移除图片</a><span style="color:#999">（如果未上传将使用默认图片）</span>
            <div style="clear:both;"></div>
        </li>
        <li>
            <input type="button" class="button" value="提交" onclick="activate()">
        </li>
    </ul>    
<!--表单信息未填写完整-->
<div id="notice" style="display:none;"></div>

<!--弹出激活邮件对话框-->
<div class="email" id="email_box" style="display:none;">
    <p>您马上就成功创建了一个属于自己的社团啦！<a href="javascript:return_reg()">&times;</a></p>
    <p>~~~~只差最后一步了呢！</p>
    <input name="email" type="email"  placeholder="请在此输入您的邮箱"/>
    <p>我们将会给您发送一封激活邮件，您需要通过邮件亲自激活此社团！</p>
    <input type="submit" class="submit" value="确定">
</div>
</form>    
    </div>
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
<script src="js/pic_preview.js"></script>
<script src="js/society_establish.js" type="text/javascript"></script>
</body>
</html>


