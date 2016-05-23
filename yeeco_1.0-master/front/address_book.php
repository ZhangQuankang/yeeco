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

//获取社团信息
$sInfo=mysql_fetch_assoc(mysql_query("select *  from society where sId='$sId'"));
//获取部门信息
$dep=mysql_query("select depName from department where societyId='$sId'");
if($dep && mysql_num_rows($dep)){
	    while($row = mysql_fetch_assoc($dep)){
			$dep_info[]=$row;
		}			
}
$undis['depName']='0';
if($dep_info){
	array_push($dep_info,$undis);
}else{
	$dep_info[0]=$undis;
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
<title>我的社团-通讯录</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/address_book.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="top_back transparency"></div>
  <div class="top">
      <ul>
        <li class="a"><img src="../image/web_image/logolittle.png" width="120" height="40" /></li>
        <li class="b"><?php echo $sInfo['sName']?></li>
        <li class="c"><a href="javascript:change_society()">[切换]</a></li>
        <li class="d">返回&nbsp&nbsp;<a href="square.php">易可广场>></a></li>
      </ul>
      <div style="clear:both;"></div>
      <div class="change_society" style="display:none;">
<?php 
if($sName){
	for($i=0;$i<=sizeof($sName)-1;$i++){
?>
          <a href="address_book.php?sId=<?php echo  $societyId[$i]?>"><?php echo $sName[$i]?></a>
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
       
        <!--用户信息存储-->
        <input type="hidden" id="sName" value="<?php echo $sInfo['sName']?>"/>
        <input type="hidden" id="authority" value="<?php echo $user_limit?>"/>
        <input type="hidden" id="uId" value="<?php echo $uId?>"/>
        <input type="hidden" id="user_dep" value="<?php echo $isManage['depBelong']?>"/>
  		<div class="buttons" id="fixedSide">
      		<a href="society_home.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_1.png"/>社团动态</li></div></a>
       		<a href="address_book.php?sId=<?php echo $sId?>"><div class="nav_on"><li><img src="../image/web_image/homeIcon_2.png"/>通讯录</li></div></a>
       	    <a href="activity.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_3.png"/>活动</li></div></a>
      	    <a href="society_info.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_4.png"/>社团资料</li></div></a>
         	<a href="change_term.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_5.png"/>换届</li></div></a>
       	    <a href="temp_page.html"><div><li><img src="../image/web_image/homeIcon_6.png"/>找赞助</li></div></a>
    	</div>
    </div>
    <!--中间主体内容-->
    <div class="main">
    	<div class="action">
            <a href="javascript:exit_society()" class="action_1">退出社团</a>
            <a href="javascript:add_newMember()" class="action_2">添加新成员</a>
        	<a href="javascript:export_members()" class="action_3">导出通讯录</a>
        </div>
        <div style="clear:both;"></div>
<?php
	if($dep_info){
		foreach($dep_info as $value_1){
?> 
    	<div class="page">
        	<div class="title"><strong class="dep_name"><?php echo $value_1['depName']=='0'?'未分配':$value_1['depName'];?></strong><a href="javascript:void(0)" class="unfold" <?php if($value_1['depName'] == $isManage['depBelong']){echo "id='open_target'";}?>>展开<i></i></a><div style="clear:both;"></div></div>         
			<div id="content_<?php echo $value_1['depName']?>" style="display:none;">  
				<p style="text-align:center;line-height:60px;">正在加载……</p>
			</div>
        </div>
<?php
		}
	}
?>
    </div>    
</div>


<div style="clear:both;"></div>
<!--调换部门!-->
<div class="change_dep" style="display:none;" onclick="noDisappear()">
	<p>把他（她）调换到:</p>
    <form action="../background/background_society/society_modify_form.php?action=ex_societyMemberDep&sId=<?php echo $sId?>" method="post" name="change_dep">
        <select name="aim_dep">
            <option value="">选择部门</option>
<?php 
if($dep_info){
		foreach($dep_info as $value_1){
?>
            <option value="<?php echo $value_1['depName']=='0'?'未分配':$value_1['depName'];?>"><?php echo $value_1['depName']=='0'?'未分配':$value_1['depName'];?></option>
<?php
		}
}
?>
        </select>
        <input type="submit" value="确定" class="change_submit"/>
    </form>
</div>    

<!--***************************************************************************************************************-->

<!--导出成员通讯录-->
<div class="export_members" id="export_members" style="display:none">
	<p>请选择您要导出的分组：</p><a href="javascript:quit()" class="quit">&times;</a>
<form id="export_form" method="post" action="../background/excel/export_DepMembers.php">
<input type="hidden" id="sId" name="sId" value="<?php echo $sId?>"/>
    <ul>
<?php
if($dep_info){
		foreach($dep_info as $value_1){
?>
    	<li><input type="checkbox" name="dep[]"  value="<?php echo $value_1['depName']=='0'?'未分配':$value_1['depName'];?>"/><label ><?php echo $value_1['depName']=='0'?'未分配':$value_1['depName'];?></label></li>
       <!-- <li><input type="checkbox" name="dep[]" id="dep_1" value="纪律部"/><label for="dep_1">纪律部</label></li>
        <li><input type="checkbox" name="dep[]" id="dep_2" value="安全部"/><label for="dep_2">安全部</label></li>
        <li><input type="checkbox" name="dep[]" id="dep_3" value="教育部"/><label for="dep_3">教育部</label></li>-->
<?php
		}
}
?>
	</ul>
    <input type="button" class="button" value="导出" onclick="export_depMenbers()">
</form>
</div>
<!--添加新成员-->
<div class="add_newMember" id="add_newMember" style="display:none">
	<div class="invite_1" onclick="add_1()"><img style="display:none" src="../image/web_image/逐一添加.png"></div>
    <div class="invite_2" onclick="add_2()"><img style="display:none" src="../image/web_image/批量导入.png"></div>
    <div style="clear:both;"></div>
<form class="new_member" id="form_2" action="../background/background_society/dep_structure/dep_members_form.php?sName=<?php echo $sInfo['sName']?>&userName=<?php echo $userName?>" method="post" enctype="multipart/form-data">
 <input type="hidden" name="sId" value="<?php echo $sId?>"/>
 <input type="hidden" name="sSchool" value="<?php echo $sSchool?>"/>
    <div class="way_1" style="display:none">
        <strong>逐一添加：</strong>
        <ul id="member_all">
          <li id="mem_1">
            <input type="text" name="name[]" placeholder="姓名"/>
            <input type="text" name="telnumber[]" placeholder="联系方式"/>
            <a href="javascript:deleteMem('mem_1');">-</a><div style="clear:both;"></div>
          </li>         
        </ul>
        <a href="javascript:insert_mem();" class="go_on">继续添加</a>
    </div>
    <div class="way_2" style="display:none">
        <strong>批量导入：</strong>
        <p>·第一步：点此<a href="../background/excel/downloadExcel.php">下载Excel模板</a>；</p>
        <p>·第二部：严格按模板格式填写对应内容，每个成员为一行；</p>
        <p>·第三步：上传填写好的Excel模板</p>
        <input type="file" name="members" accept="xlsx"/>
    </div>
  
  <div class="direction">
      <strong>说明：</strong>
      <p>·请填写有效的成员联系方式，易可平台将给该号码发送注册邀请短信；</p>
      <p>·您可以点击成员列表下方的加载更多，获取当前已经邀请了的成员；</p>
      <p>·接收到注册邀请短信的用户在注册后，将会收到“成为**社团成员”的通知，成为此社团的成员。</p>
  </div> 
  <div class="actions">
      <input type="button" value="邀请" class="button" onclick="asyncSubmit()"/>
      <input type="button" value="取消" class="button" onclick="quit()"/>
  </div> 
</form>  

</div>

<!--退出社团-->
<div class="exit_society" id="exit_society" style="display:none;">
	<p>您确定要退出当前社团吗？</p>
    <form action="../background/background_society/exitSociety.php" method="post">
        <input type="hidden" name="sId" value="<?php echo $sId?>"/>
        <input type="hidden" name="uId" value="<?php echo $uId?>"/>
        <input type="hidden" name="depName" value="<?php echo $isManage['depBelong']?>"/>
        <input type="hidden" name="authority" value="<?php echo $user_limit?>"/>
        <input class="button" type="submit" value="确定"/><a href="javascript:quit()" class="button">取消</a>
	</form>
</div>

<!--***************************************************************************************************************-->

<!--查看成员报名表-->
<div class="app_form" id="form_box" style="display:none;">

</div>
<!--发送通知-->
<form method='post' action='massageBox.php?sId=<?php echo $sId?>' id="testForm">

</form>

<!--删除提醒框--> 
<div class="notice_box" id="del_notice" style="display:none;">
	<strong>您确定要删除以上勾选的成员吗？</strong>
    <p>一旦删除该成员将无法恢复！</p>
    <div class="choose"><a href="javascript:closeWindow()" class="button">取消</a><a class="button" id="sureDelete">删除</a></div>
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
<script src="js/address_book.js" type="text/javascript"></script>
</body>