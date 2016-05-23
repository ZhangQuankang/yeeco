<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');
//查找用户相关社团ID
$user_society_Id=mysql_query("SELECT societyId FROM user_society_relation WHERE userId='$uId' and isManage=4");
if($user_society_Id && mysql_num_rows($user_society_Id)){
	while($row = mysql_fetch_assoc($user_society_Id)){
		$societyId[]=$row['societyId'];
	}			
}
//获取社团资料
if($societyId){
	foreach($societyId as $value){
		$res=mysql_fetch_assoc(mysql_query("select sId,sName,sImg,sPrincipal,isFresh,(select count(actId) from society_act_open where sId='$value') as actNum from society where sId='$value'"));
		$societys[]=$res;
	}
}
//查找用户关注的活动ID
$user_act_Id=mysql_query("SELECT actId FROM act_user_relation WHERE uId='$uId' and isConcern=1");
if($user_act_Id && mysql_num_rows($user_act_Id)){
	while($row = mysql_fetch_assoc($user_act_Id)){
		$actId[]=$row['actId'];
	}			
}
//获取活动资料
if($actId){
	foreach($actId as $value){
		$res=mysql_fetch_assoc(mysql_query("select actId,actName,actBeginDate,actEndDate,actPlace,sId from society_act_open where actId='$value'"));
		$acts[]=$res;
	}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>个人中心</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/myconcern.css" type="text/css" rel="stylesheet">
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


<!--我的动态页面-->   
<div class="main" id="main_1">
    <div class="page_title">
        <li class="title_left">我关注的&nbsp;·&nbsp;社团</li>
    </div>
    <div class="contact">
	<table class="myconcern_society">
    	<tr class="society_name">
        	<td>社团名称</td>
            <td>创建人</td>
            <td>是否开启纳新</td>
            <td>正在进行的活动(个)</td>
        </tr>  
 <?php
 if($societys){
	 foreach($societys as $value){
 ?>
        <tr>
        	<td><a href="society_visitor.php?sId=<?php echo $value['sId']?>"><?php echo $value['sName']?></a></td>
            <td><?php echo $value['sPrincipal']?></td>
            <td><?php echo $value['isFresh']==1?'是':'否'?></td>
            <td><?php echo $value['actNum']?></td>  
        </tr>
 <?php
	 }
 }
 ?>        
    </table>
    </div>  
</div>

<div class="main" id="main_2">
    <div class="page_title">
        <li class="title_left">我关注的&nbsp;·&nbsp;活动</li>
    </div>
    <div class="contact">
    <table class="myconcern_act">
    	<tr class="act_name">
        	<td>活动名称</td>
            <td>主办社团</td>
            <td>活动持续时间</td>
            <td>活动地点</td>
         </tr>  
 <?php 
 if($acts){
	 foreach($acts as $value){
		 $sName=mysql_fetch_assoc(mysql_query("select sName from society where sId='$value[sId]'"));
		 $sName=$sName['sName'];
 ?>
        <tr> 
        	<td><a href="activity_visitor.php?actId=<?php echo $value['actId']?>"><?php echo $value['actName']?></a></td>
            <td><?php echo $sName?></td>
            <td><?php echo $value['actBeginDate']?>~<?php echo $value['actEndDate']?></td>
            <td><?php echo $value['actPlace']?></td>
        </tr> 
<?php
	 }
 }
?>
     </table>
     </div>
   <!-- <div class="contact">
			<a href="#" style="color:#333;">
                <div class="act">
                    <div class="act_ad">
                        <img src="#"/>
                    </div>
                    <ul class="act_tips">
                      <li><strong>活动名称</strong><span class="number"><strong>34</strong>人报名&nbsp;<strong>43</strong>人关注</span></li>
                      <li><label>类型：</label><span>比赛/面向全校/无需报名</span></li>		
                      <li><label>时间：</label><span>2015-07-25 16:01 ~ 2015-07-25 16:01</span></li>
                      <li><label>地点：</label><span>这里是活动地点</span></li>
                      <li><label>简介：</label><span>这里是活动简介</span></li>
                    </ul>       
                    <div style="clear:both;"></div>
                </div>
             </a>	
    </div>  -->
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
<script src="js/myconcern.js" type="text/javascript"></script>

</body>
</html>


