<?php 
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');
$sId=$_GET['sId'];
$sinfo=mysql_fetch_assoc(mysql_query("select sName,sImg from society where sId='$sId'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>创建活动</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/activity_open.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="res_package/jquery.datetimepicker.css"/>
</head>
<body>
<div class="top_back">
  <div class="top">
      <ul>
        <li class="a"><?php echo $sinfo['sName']?>&nbsp;·&nbsp;创建活动</li>
        <li class="b">返回&nbsp&nbsp;<a href="society_home.php?sId=<?php echo $sId?>">我的社团>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>

<div class="body">   
  <div class="main">
    <div class="contact_title" id="contact_title">
        <li class="on">上传海报</li>
        <li>基本信息</li>
        <li>详细说明</li>
        <li>创建完成</li>
    </div>
    <div class="contact">
    <form action="../background/background_society/activity/activity_open_form.php" method="post" id="activity_form" enctype="multipart/form-data">
    <input type="hidden" name="sId" value="<?php echo $sId?>">
    <input type="hidden" name="sName" value="<?php echo $sinfo['sName']?>">
    <input type="hidden" name="sSchool" value="<?php echo $sSchool?>">
      <div class="page_1" id="0">
          <ul>
            <li>
              <label>海报尺寸：</label>
              <input type="radio" checked/><label for="size_2">600*340px</label>
              <div style="clear:both;"></div>
            </li>
            <li>
              <label>选择文件：</label>
              <input type='text' name='fImg' id='textfield' readonly="readonly"/>
              <div class="photo">
                  <div class="ph">
                      <img id="pre_img" src="../image/user_image/defaultImg/activity_ad.png"/>
                      <input type="file" class="file" name="pic" id="pic" onchange="setImagePreviews();document.getElementById('textfield').value=this.value" />
                      <input type='button'/>
                  </div>
              </div>
            </li>
            <li>
              <label></label>
              <a href="javascript:delete_pic()">移除图片</a><span>（如果未上传将使用默认图片）</span>
            </li>
            <li><input type="button" class="button" onclick="page_to('1','0');" value="下一步"/></li>
          </ul>
      <div style="clear:both;"></div> 
      </div>
      
      <div class="page_2" id="1"  style="display:none;">
          <ul>
            <li>
              <label for="activity_name"><span>*</span>活动名称：</label>
              <input name="activity_name" type="text" class="long_text" placeholder="输入活动名称（4~25字）" required />
            </li>
            <li>
              <label for="activity_type"><span>*</span>活动类型：</label>
              <select name="activity_type">
                <option value="比赛">比赛</option>
                <option value="晚会">晚会</option>
                <option value="会议">会议</option>
                <option value="聚会">聚会</option>
                <option value="其他">其他</option>
              </select>
              <select name="apply" onchange="need_app()">
                <option value="无需报名">无需报名</option>
                <option value="需要报名">需要报名</option>
              </select>
              <select name="range">
                <option value="面向全校">面向全校</option>
                <option value="面向社团">面向社团</option>
              </select>
            </li>
            <li id="apply">
              <label for="apply_type"><span>*</span>报名时间：</label>
              <input type="text" class="datepicker" name="begin_date_apply"/><input type="text" class="timepicker" name="begin_time_apply"/>-&nbsp;
              <input type="text" class="datepicker" name="end_date_apply" /><input type="text" class="timepicker" name="end_time_apply"/>
              <div id="cover_app_time"></div>
            </li>
            <li>
              <label for="apply_type"><span>*</span>活动时间：</label>
              <input type="text" class="datepicker" name="begin_date" /><input type="text" class="timepicker" name="begin_time" />-&nbsp;
              <input type="text" class="datepicker" name="end_date" /><input type="text" class="timepicker" name="end_time" />
            </li>
            <li>
              <label for="activity_place"><span>*</span>活动地点：</label>
              <input name="activity_place" type="text" class="long_text" placeholder="输入活动地点（4~30个字）" required />
            </li>
            <li>
              <label for="describe"><span>*</span>活动简介：</label>
              <textarea name="describe" rows="2" placeholder="输入活动的简要介绍（10~40个字）" required ></textarea>
            </li>
            <li><div style="width:304px;margin:auto;"><input type="button" class="button" onclick="page_to('0','1');" value="上一步"/><input type="button" class="button" onclick="check_page()" value="下一步"/></div></li>
          </ul>
      <div style="clear:both;"></div> 
      </div>
      
      <div class="page_3" id="2" style="display:none;">
          <ul>
            <li>
              <label for="describe">&nbsp;详细说明：</label>
              <textarea name="detail" placeholder="介绍活动的赛制赛规、报名方式、费用、注意事项等（0~500个字）"></textarea>
            </li>
            <li><div style="width:304px;margin:auto;"><input type="button" class="button" onclick="page_to('1','2');" value="上一步"/><input type="button" class="button" value="确认创建" onclick="aSubmit()"/></div></li>
          </ul>
      <div style="clear:both;"></div>
      </div>
      
      <div class="page_4" id="3" style="display:none;">
          <ul>
          <li>
            <table class="hello">
              <tr>
                <td><img id="qrcode" src="" width=100% height=100% /></td>
                <td><span>恭喜您，现在已经成功创建了活动！</span><span>左边是此活动的专属二维码，快快扫码分享吧！</span></td>
              </tr>
            </table>
          </li>
          <li><a id="activity_detail" href=""><div class="button_4 button">进入活动详情页</div></a></li>
          <li>返回&nbsp&nbsp;<a href="society_home.php?sId=<?php echo $sId?>">我的社团>></a></li>
          </ul>
      <div style="clear:both;"></div> 
      </div>
    </form>  
     
    </div>
  </div>
<div class="right">   
  <div class="advertisement">
      <div class="ad_title">
        <li class="ad_title_li">推广链接</li>
      </div>
      <div class="ad_img"><img src="../image/web_image/测试图片/9.png"></div>
      <div class="ad_img"><img src="../image/web_image/测试图片/20.png"></div>
      <div class="ad_img"><img src="../image/web_image/测试图片/8.png"></div>
      <div class="ad_img"><img src="../image/web_image/测试图片/9.png"></div>
      <div style="clear:both;"></div>
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
<script src="js/jquery.form.js" type="text/javascript"></script>
<script src="js/main.js"></script>
<script src="js/pic_preview.js" type="text/javascript"></script>
<script src="js/activity_open.js" type="text/javascript"></script>
<script src="res_package/jquery.datetimepicker.js"></script>
<script>
$('.datepicker').datetimepicker({
	lang:'ch',
	timepicker:false,
	format:'Y-m-d',
	});
$('.timepicker').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:10,
});
</script>
</body>
</html>
