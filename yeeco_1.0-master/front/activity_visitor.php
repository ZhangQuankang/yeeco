<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');
$actId=$_GET['actId'];
//查询活动用户关系
$aInfo=mysql_fetch_assoc(mysql_query("select * from society_act_open where actId='$actId'"));
if(!$aInfo){
	$aInfo=mysql_fetch_assoc(mysql_query("select * from society_act_closed where actId='$actId'"));
}
//查询活动主办社团
$society=mysql_fetch_assoc(mysql_query("select sName,sImg from society where sId='$aInfo[sId]'"));
//查询是否已经参加活动
$isJoin=mysql_fetch_assoc(mysql_query("select id,isConcern from act_user_relation where uId='$uId' and actId='$actId'"));
//查询用户是否是活动所属社团的人
$isSociety=mysql_num_rows(mysql_query("select id from user_society_relation where userId='$uId' and societyId='$aInfo[sId]'"));
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>活动详情</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/activity_visitor.css" type="text/css" rel="stylesheet">
<script src="js/jquery-1.11.1.js"></script>
</head>
<body>
<!--顶部--> 
<div class="top_back">
  <div class="top">
      <ul>

        <li class="a"><?php echo $aInfo['actName']?></li>
        <li class="b"><a href="javascript:history.go(-1)">返回&nbsp&nbsp;上一页>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>
<!--个人信息-->
<input type="hidden" id="actId" value="<?php echo $actId?>"/>
<input type="hidden" id="uId" value="<?php echo $uId?>"/>
<input type="hidden" id="actRange" value="<?php echo $aInfo['actRange']?>"/>
<input type="hidden" id="isSociety" value="<?php echo $isSociety?>"/>
<input type="hidden" id="isJoin" value="<?php echo $isJoin['isConcern']?>"/>
<!--封面--> 
<div class="head">
	<div class="cover"><img src="<?php echo substr($aInfo['actImg'],3)?>"/></div>
    <div class="summary">
    	<ul>
          <li>
            <span>当前状态</span>
        		<em>正在进行</em>
          </li>
          <li>
            <span>关注人数</span>
            <em><?php echo $aInfo['actFocusNum']?></em>
          </li>
          <li class="course_hour">
            <span>报名人数</span>
<?php
	if($aInfo['isApply']=='无需报名'){
?>
            <em>无需报名</em>
<?php
	}else{
?>
            <em><?php echo $aInfo['actNum']?></em>
<?php
	}
?>
          </li>
        </ul>
    </div>
    <div class="head_handle">
        <div class="concern" id="concern">
        	<a href="javascript:concern();" class="handle_1">
            	<i></i>
            	<em class="concerned-icon">关注此活动</em>
            </a>
        </div>
        
        <div class="join">
<?php
if($isJoin['isConcern']==='0'){
?>
        <a class="handle_2">报名成功</a>
<?php
}else{
?> 
		<a href="javascript:apply_activity();" id="apply_act" class="handle_2">报名参加</a>  
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
            	<p id="detail" style="display:nne;"><?php echo $aInfo['actDetail']?></p>
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
                    <form action="../background/background_comment/comment_reply.php?action=insert" method="post" name="commentForm" class="first_comment">
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
            <strong>活动公告</strong>
				<br/><input type="hidden" id="sId" value="<?php echo $sId?>"/><textarea name="board" id="board_text" placeholder="暂时没有公告！" readonly="readonly"><?php echo $aInfo['actBoard'] ?></textarea>
        </div>
        <!--社团二维码-->
    	<div class="activity_code">
            <strong>活动二维码</strong>
			<div><img src="<?php echo substr($aInfo['actCode'],3)?>" /></div>
        </div>
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
      </div>--> 
    </div>
</div>


<div style="clear:both;"></div>





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

<script src="js/jquery.form.js" type="text/javascript"></script>
<script src="js/main.js"></script>
<script src="js/activity_visitor.js" type="text/javascript"></script>
<?php
	if($isJoin['isConcern']==='0' || $isJoin['isConcern']==='1'){	
		//已关注
		echo "<script>change_concern(1);</script>";
	}
?>

</body>
</html>