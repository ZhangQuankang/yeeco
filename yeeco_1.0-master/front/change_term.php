<?php 
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');
$sId=$_GET['sId'];
//获取用户身份
$isManage=mysql_fetch_assoc(mysql_query("select isManage from user_society_relation where societyId='$sId' and userId='$uId'"));
if($isManage['isManage']==0){
	$user_limit='成员';
}else if($isManage['isManage']==1){
	$user_limit='管理员';
}else if($isManage['isManage']==2){
	$user_limit='创建人';
}
//查询社团信息
$query=mysql_query("select * from society where sId=$sId");
$sInfo=mysql_fetch_assoc($query);
if($sInfo['sImg']==NULL){
	$sInfo['sImg']="../../image/web_image/社团封面.png";
}
//查找用户相关社团ID
$user_society_Id=mysql_query("SELECT societyId FROM user_society_relation WHERE userId='$uId' and isManage<>4");
if($user_society_Id && mysql_num_rows($user_society_Id)){
	    while($row = mysql_fetch_assoc($user_society_Id)){
			if($row['societyId']!=$sId){
				$societyId[]=$row['societyId'];
			}
		}			
}

//获取社团名称
if($societyId){
	foreach($societyId as $value){
		$res=mysql_fetch_array(mysql_query("select sName from society where sId='$value' "));
		$sName[]=$res['sName'];
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的社团-换届</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/change_term.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="top_back transparency"></div>
  <div class="top">
      <ul>
        <li class="a">logo</li>
        <li class="b"><?php echo $sInfo['sName']?></li>
        <li class="c"><a href="javascript:change_society()">[切换]</a></li>
        <li class="d">返回&nbsp&nbsp;<a href="square.php">易可广场>></a></li>
      </ul>
      <div style="clear:both;"></div><div class="change_society" style="display:none;">
<?php 
if($sName){
	for($i=0;$i<=sizeof($sName)-1;$i++){
?>
          <a href="society_info.php?sId=<?php echo  $societyId[$i]?>"><?php echo $sName[$i]?></a>
<?php
	}
}
?>
      </div>
  </div>
  
<!--社团封面部分-->
<div class="head">
    <div class="head_in">
    	<div class="cover_pic"><img src="<?php echo substr($sInfo['sImg'],3)?>"/></div>
        <div class="name"><strong><?php echo $sInfo['sName']?></strong></div>
        <div class="description"><p><?php echo $sInfo['sDesc']?></p></div>
        <div class="identity">我是：<a href="" ><?php echo $user_limit?></a></div>
    </div>
</div>

<div class="body">
    <!--左侧导航按钮-->
    <div class="left">
    	<?php
if($user_limit!='成员'){
	if($sInfo['isFresh']!=1){
		
?>
    	<a href="fresh_open.php?sId=<?php echo $sId?>&sName=<?php echo $sInfo['sName']?>"><div class="fresh_button">开启纳新</div></a>
<?php
	}else{
?>
        <a href="fresh_detail.php?sId=<?php echo $sId?>"><div class="fresh_button">查看纳新</div></a>
<?php
	}
}else{
?>
	<a href="society_visitor.php?sId=<?php echo $sId?>"><div class="fresh_button">查看纳新</div></a>
<?php
}
?>
  		<div class="buttons" id="fixedSide">
      		<a href="society_home.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_1.png"/>社团动态</li></div></a>
       		<a href="address_book.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_2.png"/>通讯录</li></div></a>
       	    <a href="activity.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_3.png"/>活动</li></div></a>
      	    <a href="society_info.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_4.png"/>社团资料</li></div></a>
         	<a href="change_term.php?sId=<?php echo $sId?>"><div class="nav_on"><li><img src="../image/web_image/homeIcon_5.png"/>换届</li></div></a>
       	    <a href="temp_page.html"><div><li><img src="../image/web_image/homeIcon_6.png"/>找赞助</li></div></a>
    	</div>
    </div>
    <!--中间主体内容-->
    <div class="main">
        <div class="temp">不好意思啊！！这里还在装修，过些时候再来吧!<br/><a href="javascript:history.go(-1);">点此返回</a></div>
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
<script src="js/change_term.js" type="text/javascript"></script>
</body>