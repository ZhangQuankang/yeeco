<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
$sId=$_GET['sId'];
require_once('../background/conf/session.php');
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
/*
*查询部门信息
*/
$dep=mysql_query("select * from department where societyId='$sId'");
if($dep && mysql_num_rows($dep)){
	    while($row = mysql_fetch_assoc($dep)){
			$dep_info[]=$row;
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
<title>我的社团-社团资料</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/society_info.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="top_back transparency"></div>
<!--顶部-->
  <div class="top">
      <ul>
        <li class="a">logo</li>
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
     <!--用户信息存储-->
        <input type="hidden" id="sId" value="<?php echo $sId?>"/>
        <input type="hidden" id="authority" value="<?php echo $user_limit?>"/>
        <input type="hidden" id="uId" value="<?php echo $uId?>"/>
        <input type="hidden" id="user_dep" value="<?php echo $isManage['depBelong']?>"/>
        <div class="buttons" id="fixedSide">
      		<a href="society_home.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_1.png"/>社团动态</li></div></a>
       		<a href="address_book.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_2.png"/>通讯录</li></div></a>
       	    <a href="activity.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_3.png"/>活动</li></div></a>
      	    <a href="society_info.php?sId=<?php echo $sId?>"><div class="nav_on"><li><img src="../image/web_image/homeIcon_4.png"/>社团资料</li></div></a>
         	<a href="change_term.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_5.png"/>换届</li></div></a>
       	    <a href="temp_page.html"><div><li><img src="../image/web_image/homeIcon_6.png"/>找赞助</li></div></a>
    	</div>
    </div>
    <!--中间主体内容-->
    <div class="main">
    	<!--基本资料-->
        <div class="page">
        	<div class="title"><strong>基本资料</strong><a href="javascript:change_info()" class="mod">修改<i></i></a><a href="javascript:back_info()" style="display:none">返回<i></i></a><div style="clear:both;"></div></div>
			<div class="base_info">
                    	<div class="course-list-img">
                        	<img src="<?php echo substr($sInfo['sImg'],3)?>"/>
                        </div>
                        <h5>
                        	<span><?php echo $sInfo['sName']?></span>
                        </h5>
                        <div class="tips">
                            <p class="des"><?php echo $sInfo['sDesc']?></p>
                            <span class="type"><?php echo $sInfo['sCate']?></span>      <span class="member_num">现有成员<strong><?php echo $sInfo['sNum']?></strong>人</span>
                        </div>
                </div>
            <div style="clear:both;"></div>
            <div class="contact" style="display:none;">
				<form class="contact_form" action="../background/background_society/society_modify_form.php?action=modify_info&sId=<?php echo $sId?>"
 method="post" name="contact_form" enctype="multipart/form-data">
    <ul>
        <li>
            <label for="society_name"><span>*</span>社团名称：</label>
            <input name="society_name" type="text"  placeholder="6~20个字符" value="<?php echo $sInfo['sName']?>"/>
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
            <textarea name="describe" placeholder="不超过400个字符"><?php echo $sInfo['sDesc']?></textarea>
        </li>
        <li>
            <label for="pic">&nbsp;&nbsp;社团封面：</label>
            <div class="pic" id="dd"><img id="pre_img" src="<?php echo substr($sInfo['sImg'],3)?>"/></div>
            <input id="pic" type="file" name="pic" accept="image/gif/png/jpeg/jpg" onchange="setImagePreviews();"/>
            <p>请选择不超过1M的 .gif, .jpg, .jpeg 或 .png文件</p>
            <a href="javascript:delete_pic()">移除图片</a><span style="color:#999">（如果未上传将使用默认图片）</span>
            <div style="clear:both;"></div>
        </li>
        <li>
            <input type="button" class="button" value="保存" onclick="save_info()">
        </li>
    </ul>    
<!--表单信息未填写完整-->
<div id="notice" style="display:none;"></div>

</form>    
    		</div>
        </div>
        <!--部门-->
        <div class="page">
        	<div class="title"><strong>组织架构</strong><a href="javascript:change_dep()" class="mod">修改<i></i></a><a href="javascript:back_dep()" style="display:none">返回<i></i></a><div style="clear:both;"><div style="clear:both;"></div></div>
			  <div class="dep_info">
                <ul>
            		<li><label>名称：</label><strong><?php echo $sInfo['team_name']?></strong></li>
                	<li><label><?php echo $sInfo['position']?>：</label><span><?php echo $sInfo['sPrincipal']?></span></li>
<?php
if($dep_info){
	foreach($dep_info as $value_1){
?>
                	<li><label><?php echo $value_1['depName']?>：</label><span>
<?php 
	if($value_1['position_1']!=NULL){
?>
                    <div><p><?php echo $value_1['position_1']?>：</p><p><?php echo $value_1['depManager_1']?></p><p><?php echo $value_1['tel_1']?></p></div>
<?php 
	}
	if($value_1['position_2']!=NULL){
?>
                    <div><p><?php echo $value_1['position_2']?>：</p><p><?php echo $value_1['depManager_2']?></p><p><?php echo $value_1['tel_2']?></p></div>
<?php 
	}
	if($value_1['position_3']!=NULL){
?>
                    <div><p><?php echo $value_1['position_3']?>：</p><p><?php echo $value_1['depManager_3']?></p><p><?php echo $value_1['tel_3']?></p></div>
<?php 
	}
?>
                    </span></li>
<?php
	}
}
?>                
                </ul>
              </div>
      		  <form class="framwork" id="form_1" action="../background/background_society/society_modify_form.php?action=modify_dep&sId=<?php echo $sId?>&sName=<?php echo $sInfo['sName']?>&userName=<?php echo $userName?>" method="post" style="display:none;">
      <div class="leader_team">
          <label>架构名称：</label><input type="text" name="leader_team" value="<?php echo $sInfo['team_name']?>"/>
      </div>
      <div class="left_2"> 
          <input type="text" name="position" placeholder="职位" value="<?php echo $sInfo['position']?>"/>
          <input type="text" name="me" value="我" disabled="disabled"/>
          <div class="chestnut"><img src="../image/web_image/举例说明.png"></div>
      </div>
      <div class="right">
        <div class="example">
            <input type="text" name="dep_name" value="组织部" readonly="readonly"/>
            <input type="text" name="position_1" value="部长" readonly="readonly"/>
            <input type="text" name="position_2" value="副部长" readonly="readonly"/>
            <input type="text" name="position_3" placeholder="无" readonly="readonly"/>
            <input type="text" name="manager_1" value="张三" readonly="readonly"/>
            <input type="text" name="manager_2" value="李四" readonly="readonly"/>
            <input type="text" name="manager_3" placeholder="无" readonly="readonly"/>
            <input type="text" name="tel_1" value="136****6666" readonly="readonly"/>
            <input type="text" name="tel_2" value="138****8888" readonly="readonly"/>
            <input type="text" name="tel_3" placeholder="无" readonly="readonly"/>
        </div>
        <div id="all_dep">
<?php 
$i=1;
if($dep_info){
	foreach($dep_info as $value_2){
?>
            <input type="hidden" id="i" value="<?php echo $i?>">
          <div id="dep_<?php echo $i?>" class="new_dep"> 
            <input type="text" name="dep_name[]" value="<?php echo $value_2['depName']?>" required="required"/>
            <input type="text" name="position_1[]" value="<?php echo $value_2['position_1']?>" required="required"/>
            <input type="text" name="position_2[]" value="<?php echo $value_2['position_2']?>"/>
            <input type="text" name="position_3[]" value="<?php echo $value_2['position_3']?>"/>
            <input type="text" name="manager_1[]" value="<?php echo $value_2['depManager_1']?>" required="required"/>
            <input type="text" name="manager_2[]" value="<?php echo $value_2['depManager_2']?>"/>
            <input type="text" name="manager_3[]" value="<?php echo $value_2['depManager_3']?>"/>
            <input type="text" name="tel_1[]" value="<?php echo $value_2['tel_1']?>" required="required"/>
            <input type="text" name="tel_2[]" value="<?php echo $value_2['tel_2']?>"/>
            <input type="text" name="tel_3[]" value="<?php echo $value_2['tel_3']?>"/>
            <a href="javascript:deleteDep('dep_<?php echo $i?>');">-</a>
          </div>
<?php
	$i++;
	}
}else{
?>
			<input type="hidden" id="i" value="<?php echo $i?>">
          <div id="dep_<?php echo $i?>" class="new_dep"> 
            <input type="text" name="dep_name[]" placeholder="部门名称" required="required"/>
            <input type="text" name="position_1[]" placeholder="职位" required="required"/>
            <input type="text" name="position_2[]" placeholder="职位"/>
            <input type="text" name="position_3[]" placeholder="职位"/>
            <input type="text" name="manager_1[]" placeholder="姓名" required="required"/>
            <input type="text" name="manager_2[]" placeholder="姓名"/>
            <input type="text" name="manager_3[]" placeholder="姓名"/>
            <input type="text" name="tel_1[]" placeholder="联系方式" required="required"/>
            <input type="text" name="tel_2[]" placeholder="联系方式"/>
            <input type="text" name="tel_3[]" placeholder="联系方式"/>
          </div>
<?php
	}
?>          
        </div>    
        <div class="add_new"> 
        <a href="javascript:insert();">+</a>
        </div>
      </div>
      <div style="clear:both;"></div>
      <div class="actions">
          <input type="submit" value="保存" class="button"/>
      </div>   
      </form>
            <div style="clear:both;"></div> 
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
<script src="js/jquery.form.js" type="text/javascript"></script>
<script src="js/main.js"></script>
<script src="js/pic_preview.js"></script>
<script src="js/society_info.js" type="text/javascript"></script>
</body>