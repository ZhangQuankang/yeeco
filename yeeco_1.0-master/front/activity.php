<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');
$sId=$_GET['sId'];
//获取用户身份
$isManage=mysql_fetch_assoc(mysql_query("select isManage,depBelong from user_society_relation where societyId='$sId' and userId='$uId'"));
if($isManage['isManage']==0){
	$user_limit='成员';
}else if($isManage['isManage']==1){
	$user_limit='管理员';
}else if($isManage['isManage']==2){
	$user_limit='创建人';
}
$societyRes=mysql_fetch_array(mysql_query("select *  from society where sId='$sId'"));
//提取活动信息
$actRes=mysql_query("select * from society_act_open where sId='$sId'");
if($actRes && mysql_num_rows($actRes)){
	    while($row = mysql_fetch_assoc($actRes)){
			$act_info[]=$row;
		}			
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
<title>我的社团-活动</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/activity.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="top_back transparency"></div>
  <div class="top">
      <ul>
        <li class="a">logo</li>
        <li class="b"><?php echo $societyRes['sName']?></li>
        <li class="c"><a href="javascript:change_society()">[切换]</a></li>
        <li class="d">返回&nbsp&nbsp;<a href="square.php">易可广场>></a></li>
      </ul>
      <div style="clear:both;"></div>
      <div class="change_society" style="display:none;">
<?php 
if($sName){
	for($i=0;$i<=sizeof($sName)-1;$i++){
?>
          <a href="activity.php?sId=<?php echo  $societyId[$i]?>"><?php echo $sName[$i]?></a>
<?php
	}
}
?>
      </div>
  </div>
  
<!--社团封面部分-->
<div class="head">
    <div class="head_in">
    	<div class="cover_pic"><img src="<?php echo substr($societyRes['sImg'],3)?>"/></div>
        <div class="name"><strong><?php echo $societyRes['sName']?></strong></div>
        <div class="description"><p><?php echo $societyRes['sDesc']?></p></div>
        <div class="identity">我是：<a href="" ><?php echo $user_limit?></a></div>
    </div>
</div>

<div class="body">
    <!--左侧导航按钮-->
    <div class="left">
<?php
if($user_limit!='成员'){
	if($societyRes['isFresh']!=1){
		
?>
    	<a href="fresh_open.php?sId=<?php echo $sId?>&sName=<?php echo $societyRes['sName']?>"><div class="fresh_button">开启纳新</div></a>
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
		<!--用户信息存储-->
        <input type="hidden" id="sId" value="<?php echo $sId?>"/>
    		<div class="buttons" id="fixedSide">
      		<a href="society_home.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_1.png"/>社团动态</li></div></a>
       		<a href="address_book.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_2.png"/>通讯录</li></div></a>
       	    <a href="activity.php?sId=<?php echo $sId?>"><div class="nav_on"><li><img src="../image/web_image/homeIcon_3.png"/>活动</li></div></a>
      	    <a href="society_info.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_4.png"/>社团资料</li></div></a>
         	<a href="change_term.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_5.png"/>换届</li></div></a>
       	    <a href="temp_page.html"><div><li><img src="../image/web_image/homeIcon_6.png"/>找赞助</li></div></a>
    	</div>
    </div>
    <!--中间主体内容-->
    <div class="main">
<?php 
if($user_limit!='成员'){
?>
        <!--发起一个活动-->
        <div class="page">
        	<div class="title"><strong>创建新的活动</strong><div style="clear:both;"></div></div>
			<div class="creat_new">
            	<img src="<?php echo substr($societyRes['sImg'],3)?>"/>
            	<p>活动越多，就能获取越高的社团热度哦！<a href="activity_open.php?sId=<?php echo $sId?>" class="button">立即创建活动</a></p>           
                <div style="clear:both;"></div>
            </div>
        </div>
<?php 
}
?>
        <!--正在进行的活动-->
        <div class="page">
        	<div class="title"><strong>正在进行的活动</strong><a href="javascript:unfold_1()" style="display:none">展开<i></i></a><a href="javascript:fold_1()">收起<i></i></a><div style="clear:both;"></div></div>
            <div class="all_act_ing">
<?php 
if($act_info){
		foreach($act_info as $value){
			if($user_limit!='成员'){
?>
               <a href="activity_detail.php?actId=<?php echo $value['actId']?>&sId=<?php echo $sId?>" style="color:#333;">
 <?php
			}else{
 ?>   
 			 <a href="activity_visitor.php?actId=<?php echo $value['actId']?>&sId=<?php echo $sId?>" style="color:#333;">
 <?php 
			}
 ?>
               <div class="act">
                    <div class="act_ad">
                        <img src="<?php echo substr($value['actImg'],3)?>"/>
                    </div>
                    <ul class="act_tips">
                      <li><strong><?php echo $value['actName']?></strong><span class="number"><strong><?php echo $value['actNum']?></strong>人报名&nbsp;<strong><?php echo $value['actFocusNum']?></strong>人关注</span></li>
                      <li><label>类型：</label><span><?php echo $value['actType']?>/<?php echo $value['isApply']?>/<?php echo $value['actRange']?></span></li>		
                      <li><label>时间：</label><span><?php echo $value['actBeginDate']?>&nbsp;<?php echo $value['actBeginTime']?>&nbsp;&nbsp;~&nbsp;&nbsp;<?php echo $value['actEndDate']?>&nbsp;<?php echo $value['actEndTime']?></span></li>
                      <li><label>地点：</label><span><?php echo $value['actPlace']?></span></li>
                      <li><label>简介：</label><span><?php echo $value['actDesc']?></span></li>
                    </ul>       
                    <div style="clear:both;"></div>
                </div>
               </a>					
<?php
		}
}
?>
            </div>
        </div>
        <!--已经关闭的活动-->
        <div class="page">
        	<div class="title"><strong>已经关闭的活动</strong><a href="javascript:unfold_2()" class="unfold_2">展开<i></i></a><a href="javascript:fold_2()" style="display:none">收起<i></i></a><div style="clear:both;"></div></div>
			<div class="all_act_ed" style="display:none">
            					
            </div>
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
<script src="js/activity.js" type="text/javascript"></script>
</body>