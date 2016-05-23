<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');
$sId=$_GET['sId'];
$actId=$_GET['actId'];

//获取用户身份
$isManage=mysql_fetch_assoc(mysql_query("select isManage from user_society_relation where societyId='$sId' and userId='$uId'"));
if($isManage['isManage']==0){
	$user_limit='成员';
}else if($isManage['isManage']==1){
	$user_limit='管理员';
}else if($isManage['isManage']==2){
	$user_limit='创建人';
}
//判断活动是否关闭
$flag=false;
$aInfo=mysql_fetch_assoc(mysql_query("select * from society_act_open where actId='$actId'"));
if(!$aInfo){
	$aInfo=mysql_fetch_assoc(mysql_query("select * from society_act_closed where actId='$actId'"));
	$flag=true;
}
//查询活动的成员
$query=mysql_query("select uId from act_user_relation where actId='$actId' limit 0,10");
if($query && mysql_num_rows($query)){
	    while($row = mysql_fetch_assoc($query)){
			$aUid[]=$row;
		}			
}
//查询评论信息
$nId = mysql_fetch_assoc(mysql_query("select nId from dynamic_state where oId='$actId' and nWho='activity'"));
if($nId['nId']!==NULL){
	$query=mysql_query("select *  from comment_form where nId='$nId[nId]' order by cId desc");
}
if($query && mysql_num_rows($query)){	
	while($row = mysql_fetch_assoc($query)){
		if($row['ccId'] == 0){
			$comment_1[] = $row;//对于事件的直接评论
		}else{
			$comment_2[] = $row;//对于事件的评论进行的回复
		}
	}			
}
if($comment_2){
	sort($comment_2);
}
//获取赞的相关信息
$query=mysql_query("select cId from praise where uId='$uId'");
if($query && mysql_num_rows($query)){	
	while($row = mysql_fetch_assoc($query)){
		$pcId[]=$row;
	}			
}	
//查询活动主办社团
$society=mysql_fetch_assoc(mysql_query("select sName,sImg from society where sId='$aInfo[sId]'"));
$i=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>活动详情</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/activity_detail.css" type="text/css" rel="stylesheet">
</head>

<body>
<!--顶部--> 
<div class="top_back">
  <div class="top">
      <ul>

        <li class="a"><?php echo $aInfo['actName']?></li>
        <li class="b">返回&nbsp&nbsp;<a href="society_home.php?sId=<?php echo $sId?>">我的社团>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>
<!--个人信息-->
<input type="hidden" id="user_limit" value="<?php echo $user_limit?>"/>
<input type="hidden" id="actId" value="<?php echo $actId?>"/>

<!--社团封面-->
<div class="head">
	<div class="cover"><img src="<?php echo substr($aInfo['actImg'],3)?>"/></div>
    <div class="summary">
    	<ul>
          <li>
            <span>当前状态</span>
 <?php
if($flag==false){
?>
            <em>正在进行</em>
<?php 
}else{
?>
			<em>活动关闭</em>	
<?php
}
?>        </li>
          <li>
            <span>关注人数</span>
            <em><?php echo $aInfo['actFocusNum']?></em>
          </li>
          <li class="course_hour">
            <span>报名人数</span>
            <em><?php echo $aInfo['actNum']?></em>
          </li>
        </ul>
    </div>
    <div class="head_handle">

        <div class="concern" id="concern">
        	<a href="javascript:alert('此功能尚未开放！');" class="handle_1">
            	<i></i>
            	<em class="concerned-icon">活动互动室</em>
            </a>
        </div>
        <div class="join">
<?php
if($flag==false){
?>
            <a href="javascript:close_act();" class="handle_2">关闭活动</a>                      
<?php 
}else{
?>	
			<a href="javascript:close_act();" class="handle_2">删除活动</a>
            
<?php
}
?>
     
        </div>
        
    </div>
</div>
<div style="clear:both;"></div>

<!--主体-->
<div class="body">
    <div class="main">
    
    	<div class="page">
        	<div class="cover_pic"><img src="<?php echo substr($society['sImg'],3)?>"/></div>
        	<div class="base_info">
              <ul>
                <li><label style="margin-top:7px;">主办社团：</label><strong><?php echo $society['sName']?></strong></li>
               <li><label>活动类型：</label><p><?php echo $aInfo['actType']?>/<?php echo $aInfo['isApply']?>/<?php echo $aInfo['actRange']?></p></li>
                <li><label>活动时间：</label><p><?php echo $aInfo['actBeginDate']?>&nbsp;<?php echo $aInfo['actBeginTime']?>&nbsp;~&nbsp;<?php echo $aInfo['actEndDate']?>&nbsp;<?php echo $aInfo['actEndTime']?></p></li>
                <li><label>活动地点：</label><p><?php echo $aInfo['actPlace']?></p></li>
                <li><label>报名时间：</label><p><?php echo $aInfo['applyBeginDate']?>&nbsp;<?php echo $aInfo['applyBeginTime']?>&nbsp;~&nbsp;<?php echo $aInfo['applyEndDate']?>&nbsp;<?php echo $aInfo['applyEndTime']?></p></li>
              </ul>
            </div>
           	<div style="clear:both;"></div>
        </div>
    	<div class="page page_1">
        	<strong>活动简介：</strong>
                <p><?php echo $aInfo['actDesc']?></p>
        	<strong>活动详情：</strong><a class="more" href="javascript:detail()"></a>
            	<p id="detail" style="display:none;"><?php echo $aInfo['actDetail']?></p>
        </div>
        <!--当前报名-->
    	<div class="page page_2">
        	<strong>当前报名：</strong>
<?php 
if($aUid){
?>
            <div class="table">
              <ul>
                <li><span>选择</span><span>姓名</span><span>专业班级</span><span>手机号码</span></li>
<?php
	foreach($aUid as $value){
		$uFace=mysql_fetch_assoc(mysql_query("select userFace from user where uId='$value[uId]'"));
		$uInfo=mysql_fetch_assoc(mysql_query("select userName,userTel,userSex,userClass from userextrainfo where uId='$value[uId]'"));
?>                
                <li><span><input type="checkbox" value="<?php echo $value['uId']?>" id="key" name='member[]'/></span><span><a href="javascript:void(0)" id="table_a"><img src="../<?php echo $uFace['userFace']?>"/><?php echo $uInfo['userName']?><i><?php echo $uInfo['userSex']?></i></a></span><span><?php echo $uInfo['userClass']?></span><span><?php echo $uInfo['userTel']?></span></li>
               
<?php
		$i++;
	}
?>                
<input type="hidden" id="i" value="<?php echo $i?>"/>             
                <li><span><input type="checkbox" id="all" value=""/></span><span style="border-right:0;"><label for="all">全选</label></span><a href="javascript:void();" id="load_more">加载更多<i></i></a></li>
              </ul>
            </div>
            <div style="clear:both;"></div>            
<?php
}else{
?>
    <div class="no_body">当前还没有报名成员！</div>
<?php
}
?>        
        </div>
       <!--评论-->
    	<div class="page">
        	<strong>评论：</strong>
            <div class="comment">
              <ul class="big_comment">
<?php
if($comment_1){
	$i = 0;
	foreach($comment_1 as $value){
		$i++;		
?>
				<li>
                	<div class="user_face"><img src="<?php echo $value['uFace']?>"/></div>
                    <div class="right_body">
                    	<input type="hidden" name="cId" value="<?php echo $value['cId']?>">
                        <strong class="user_name"><?php echo $value['uName']?></strong>
                        <pre><?php echo $value['cBody']?></pre>
                      
<?php
		if($uId != $value['uId']){		
?>
                        <a href="javascript:void(0)" onclick="reply(this)" class="reply" id="reply_<?php echo $i?>">回复</a>
<?php
		}else{
?>
                        <a href="javascript:void(0)" onclick="delete1(this)" class="delete">删除</a>
<?php
		}
?>                        
						<span class="send_time"><?php echo $value['cTime']?></span>
<?php
if($pcId){
	$flag=false;
	foreach($pcId as $p){
		if($p['cId']==$value['cId']){
			$flag=true;
?>
  						<a class="praise" href="javascript:void(0)" onclick="praise_cancel(this)">取消赞(<?php echo $value['pNum']?>)</a>
<?php
			break;
		}					
	}
	if(!$flag){
?>
						<a class="praise" href="javascript:void(0)" onclick="praise(this)">赞<?php echo $value['pNum']==0?'':"(".$value['pNum'].")"?></a> 
<?php
	}
}else{
?>
						<a class="praise" href="javascript:void(0)" onclick="praise(this)">赞<?php echo $value['pNum']==0?'':"(".$value['pNum'].")"?></a> 
<?php
}
?>
                        <div class="sec_replys" style="display:none" id="<?php echo $i?>">
                          <ul>
<?php
if($comment_2){
	foreach($comment_2 as $value_2){
		if($value_2['ccId']==$value['cId']){
			echo "<script>$('#".$i."').show();$('#reply_".$i."').text('收起回复');</script>";
?>

                            <li class="content">
                              <div class="user_face2"><img src="<?php echo $value_2['uFace']?>"/></div>
                              <div class="right_body">
                              	  <input type="hidden" name="cId" value="<?php echo $value_2['cId']?>">
                                  <span class="reply_content"><strong class="host"><?php echo $value_2['uName']?></strong>回复<strong><?php echo $value_2['ccName']?></strong>：<?php echo $value_2['cBody']?></span>
<?php
		if($uId != $value_2['uId']){		
?>
                                  <a class="reply2" href="javascript:void(0)" onclick="reply2(this)">回复</a>
<?php
		}else{
?>                                   
                                  <a class="delete2" href="javascript:void(0)" onclick="delete2(this)">删除</a>
<?php
		}
?>
                                  <span class="send_time2"><?php echo $value_2['cTime']?></span>  
                                   
<?php
if($pcId){
	$flag=false;
	foreach($pcId as $p){
		if($p['cId']==$value_2['cId']){
			$flag=true;
?>
  						<a class="praise" href="javascript:void(0)" onclick="praise_cancel(this)">取消赞(<?php echo $value_2['pNum']?>)</a>
<?php
			break;
		}					
	}
	if(!$flag){
?>
						<a class="praise" href="javascript:void(0)" onclick="praise(this)">赞<?php echo $value_2['pNum']==0?'':"(".$value['pNum'].")"?></a> 
<?php
	}
}else{
?>
						<a class="praise" href="javascript:void(0)" onclick="praise(this)">赞<?php echo $value_2['pNum']==0?'':"(".$value['pNum'].")"?></a> 
<?php
}
?>                                
                                  
                              </div>
                              <div style="clear:both;"></div>
                            </li>
<?php
		}
	}
}
?>
                            <!--回复评论--> 
                            <li class="replayBox" style="display:none">
                                <form action="../background/background_comment/comment_reply.php" method="post" name="commentForm" class="second_comment">
                                    <textarea name="comment"></textarea>
                                    <input type="hidden" name="ccId" value="<?php echo $value['cId']?>">
                                    <input type="button" class="submit_btn_2" value="回复" onclick="submit_btn_2(this)"/>
                                </form>
                                <div style="clear:both;"></div>
                            </li>
                            <li class="say_too">
                            	<a href="javascript:void(0)" class="I_say" onclick="I_say(this)">我也说一句</a>
                            	<div style="clear:both;"></div>
                            </li>
                          </ul>
                        </div>
                    </div>
                    <div style="clear:both;"></div>
                </li>
<?php
	}
}
?>              
                <li class="sendBox">
                    <form action="../background/background_comment/comment_reply.php?action=insert" method="post" name="commentForm" class="first_comment" class="first_comment">
                    	<input type="hidden" name="date" value="">
                        <input type="hidden" name="userName" value="<?php echo $userName?>"/>
                        <input type="hidden" name="userId" value="<?php echo $uId?>"/>
                        <input type="hidden" name="userFace" value="../<?php echo $userFace?>"/>
                        <input type="hidden" name="nId" value="<?php echo $nId['nId']?>"/>
                        <textarea name="comment"></textarea>
                        <input type="submit" class="submit_btn" value="评论" onclick="submit_btn(this)"/>
                    </form>
                    <div style="clear:both;"></div>
                </li>

                
              </ul>
            </div>
        </div>
    </div>
    
    <div class="right">
    	<div class="board">
            <strong>活动公告</strong><a href="javascript:edit()" id="a1">编辑</a><a href="javascript:save()" style="display:none" id="a2">保存</a>
				<br/><input type="hidden" id="actId" value="<?php echo $actId?>"/><textarea name="board" id="board_text" placeholder="不超过140个字符" readonly="readonly"><?php echo $aInfo['actBoard']?></textarea>
            
        </div>
        <!--社团二维码-->
    	<div class="activity_code">
            <strong>活动二维码</strong>
			<div><img src="<?php echo substr($aInfo['actCode'],3)?>" /></div>
        </div><!--
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
<div style="clear:both;"></div>
<!--关闭提醒框--> 
<div class="notice_box" id="notice_box" style="display:none;">
<?php
if($flag==false){
?>
	<strong>您确定要关闭此次活动？</strong>
    <div class="choose"><a class="button" href="../background/background_society/activity/activity_closed.php?actId=<?php echo $actId?>&sId=<?php echo $sId?>">确定</a><a class="button" href="javascript:cancel_close()">取消</a></div>
<?php
}else{
?>
	<strong>您确定要删除此次活动？</strong>
    <div class="choose"><a class="button" href="../background/background_society/activity/activity_del.php?actId=<?php echo $actId?>&sId=<?php echo $sId?>">确定</a><a class="button" href="javascript:cancel_close()">取消</a></div>
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
<script src="js/jquery.form.js" type="text/javascript"></script>
<script src="js/main.js"></script>
<script src="js/activity_detail.js" type="text/javascript"></script>

</body>
</html>