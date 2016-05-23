<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');
$sId=$_GET['sId'];
$sName=$_GET['sName'];
//查询社团二维码
$qrcode=mysql_fetch_assoc(mysql_query("select sQRCode from society where sId='$sId'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>开启纳新</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/fresh_open.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="top_back">
  <div class="top">
      <ul>
        <li class="a"><?php echo $sName?>&nbsp;·&nbsp;开启纳新</li>
        <li class="b">返回&nbsp&nbsp;<a href="society_home.php?sId=<?php echo $sId?>">我的社团>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>

<div class="body">   
  <div class="main">
    <div class="contact_title" id="contact_title">
        <li class="on">上传海报</li>
        <li>纳新详情</li>
        <li>创建报名表</li>
        <li>开启纳新</li>
    </div>
    
    <div class="contact">
    <form action="../background/background_society/society_fresh_form.php" method="post" id="fresh_form" enctype="multipart/form-data">
    <input type="hidden" name="sId" value="<?php echo $sId?>">
    <input type="hidden" name="sName" value="<?php echo $sName?>">
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
                      <img id="pre_img" src="../image/user_image/defaultImg/fresh_ad.png"/>
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
              <label for="notice"><span>*</span>纳新公告：</label>
              <textarea name="notice" placeholder="用一句话为你的社团吸引人气（10~40个字）" required></textarea>
            </li>
            <li>
              <label for="detail">&nbsp;详细说明：</label>
              <textarea name="detail" placeholder="输入纳新的详细说明，介绍社团详情或纳新规则等（0~500个字）"></textarea>
            </li>
            <li><div style="width:304px;margin:auto;"><input type="button" class="button" onclick="page_to('0','1');" value="上一步"/><input type="button" class="button" onclick="check_page()" value="下一步"/></div></li>
          </ul>
      <div style="clear:both;"></div> 
      </div>
      
      <div class="page_3" id="2" style="display:none;">
          <ul>
            <li>
                <label for="aa"><span>*</span>基本信息</label><input type="checkbox" id="aa" checked disabled/>
            </li>
            <li>
                <img src="../image/web_image/纳新报名表.png" width="550"  /> 
            </li>
            <li>
                您还可以设置最多三个开放式问题<span class="gray">（回答字数不超过400字）</span>： 
            </li>
            <li>
                <label for="ques_1">设置问题一：</label><input type="checkbox" id="set_1" checked onclick="judge_check('1');"/>
                <input type="text" name="que_1" placeholder="在这里输入问题（4~25字）" id="ques_1"/><br/>
                <label for="ques_2">设置问题二：</label><input type="checkbox" id="set_2"  onclick="judge_check('2');"/>
                <input type="text" name="que_2"  placeholder="在这里输入问题（4~25字）" id="ques_2" style="display:none;"/><br/>
                <label for="ques_3">设置问题三：</label><input type="checkbox" id="set_3"  onclick="judge_check('3');"/>
                <input type="text" name="que_3"  placeholder="在这里输入问题（4~25字）" id="ques_3" style="display:none;"/>
            </li>
            <li><div style="width:304px;margin:auto;"><input type="button" class="button" onclick="page_to('1','2');" value="上一步"/><input type="button" class="button" value="开启纳新"  onclick="asyncSubmit()"/></div></li>
          </ul>
      <div style="clear:both;"></div>
      </div>
      
      <div class="page_4" id="3" style="display:none;">
          <ul>
          <li>
            <table class="hello">
              <tr>
                <td><img src="<?php echo substr($qrcode['sQRCode'],3)?>" width=100% height=100% /></td>
                <td><span>恭喜您，现在已经成功开启纳新！</span><span>左边是此社团的专属二维码，快快扫码分享吧！</span></td>
              </tr>
            </table>
          </li>
          <li><a href="fresh_detail.php?sId=<?php echo $sId ?>"><div class="button_4 button">进入纳新详情页</div></a></li>
          <li>返回&nbsp&nbsp;<a href="#">我的社团>></a></li>
          </ul>
      <div style="clear:both;"></div> 
      </div>
    </form>  
     
    </div>
  </div>
<div class="right"> 
<!--  
  <div class="advertisement">
      <div class="ad_title">
        <li class="ad_title_li">推广链接</li>
      </div>
      <div class="ad_img"><img src="../image/web_image/测试图片/9.png"></div>
      <div class="ad_img"><img src="../image/web_image/测试图片/20.png"></div>
      <div class="ad_img"><img src="../image/web_image/测试图片/8.png"></div>
      <div class="ad_img"><img src="../image/web_image/测试图片/9.png"></div>
      <div style="clear:both;"></div>
  </div> -->
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
<script src="js/fresh_open.js" type="text/javascript"></script>
<script src="js/pic_preview.js" type="text/javascript"></script>
</body>
</html>
