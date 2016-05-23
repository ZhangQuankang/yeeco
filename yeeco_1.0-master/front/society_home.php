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
$societyRes=mysql_fetch_array(mysql_query("select *  from society where sId='$sId'"));
//获取动态
$res=mysql_query("select * from dynamic_state where sId='$sId' order by nTime desc");
if($res && mysql_num_rows($res)){	
	while($row = mysql_fetch_assoc($res)){
			$news[] = $row;	
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
<title>我的社团-社团动态</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/society_home.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="top_back transparency"></div>
  <div class="top">
      <ul>
        <li class="a"><img src="../image/web_image/logolittle.png" width="120" height="40" /></li>
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
          <a href="society_home.php?sId=<?php echo  $societyId[$i]?>"><?php echo $sName[$i]?></a>
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
 <!--个人信息-->
<input type="hidden" name="userName" value="<?php echo $userName?>"/>
<input type="hidden" name="userId" value="<?php echo $uId?>"/>
<input type="hidden" name="userFace" value="../<?php echo $userFace?>"/>
	<div class="buttons" id="fixedSide">
      	<a href="society_home.php?sId=<?php echo $sId?>"><div class="nav_on"><li><img src="../image/web_image/homeIcon_1.png"/>社团动态</li></div></a>
        <a href="address_book.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_2.png"/>通讯录</li></div></a>
        <a href="activity.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_3.png"/>活动</li></div></a>
        <a href="society_info.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_4.png"/>社团资料</li></div></a>
        <a href="change_term.php?sId=<?php echo $sId?>"><div><li><img src="../image/web_image/homeIcon_5.png"/>换届</li></div></a>
        <a href="temp_page.html"><div><li><img src="../image/web_image/homeIcon_6.png"/>找赞助</li></div></a>
    </div>

    </div>
    <!--中间主体内容-->
    <div class="main">
        <div class="send_msg">
       		<form action="../background/background_comment/send_msg.php" method="post" name="news" class="news">
                <input type="hidden" name="userName" value="<?php echo $userName?>"/>
                <input type="hidden" name="userId" value="<?php echo $uId?>"/>
                <input type="hidden" name="uFace" value="../../<?php echo $userFace?>"/>
            	<input type="hidden" name="sId" value="<?php echo $sId?>"/>
                <textarea name="news_content" placeholder="在这里发布一则新的动态吧！"></textarea>
                <input type="button" class="submit_btn" value="发表" onclick="submit_btn()"/>
            </form>
            <div style="clear:both;"></div> 
        </div>
        <div id="list">        
<?php
if($news){
	foreach($news as $value){
		//查询该用户是否赞过该动态
		$isPraise=mysql_num_rows(mysql_query("select * from praise where nId='$value[nId]' and uId='$uId'"));
?>
            <div class="box clearfix">
            	<input type="hidden" name="nId" value="<?php echo $value['nId']?>"/>
<?php if(($user_limit!='成员' && $value['nWho']!='person') || ($uId==$value['oId'] && $value['nWho']=='person')){?>                
                <a class="close" href="javascript:void();" onclick="del_news(this);">×</a>
<?php }?>   
                <img class="user_face" src="<?php echo substr($value['nImg'],3)?>" alt=""/>
                <div class="content">
                    <div class="host">
                        <p class="txt">
                            <span class="user"><?php echo $value['oName']?>：</span><?php echo $value['nBody']?>
                        </p>
                    </div>
                    <div class="info clearfix">
                        <span class="time"><?php echo $value['nTime']?></span>
                        <a class="praise" href="javascript:void();" onclick="praise(this);"><?php echo $isPraise!=NULL?'取消赞':'赞'?></a>
                    </div>
                    <div class="praises-total" total="<?php echo $value['pNum']?>" style="display: none;"></div>
                    <div class="comment-list">
<?php
$comment_1=NULL;
$comment_2=NULL;
$query=mysql_query("select *  from comment_form where nId='$value[nId]'");
if($query && mysql_num_rows($query)){	
	while($row = mysql_fetch_assoc($query)){
		if($row['ccId'] == 0){
			$comment_1[] = $row;//对于事件的直接评论
		}else{
			$comment_2[] = $row;//对于事件的评论进行的回复
		}
	}			
}

if($comment_1){
	foreach($comment_1 as $c1){
		//查询用户是否赞过该评论
		$isPraise=mysql_num_rows(mysql_query("select * from praise where cId='$c1[cId]' and uId='$uId'"));
?>					
    					<div class="comment-box clearfix" user="other">
                          <input type="hidden"  name="cId" value="<?php echo $c1['cId']?>"/>
                          <img class="myhead" src="<?php echo $c1['uFace']?>" alt=""/>
                          <div class="comment-content">
                          <p class="comment-text">
                             <span class="user"><?php echo $c1['uName']?>：</span><?php echo $c1['cBody']?>
                          </p>
                           <p class="comment-time">
                                    <?php echo $c1['cTime']?>
                              	<a class="comment-praise" href="javascript:void();"  total="<?php echo $c1['pNum']?>" my="0" onclick="praise(this);"><?php echo $isPraise!=NULL?'取消赞':'赞'?></a>
<?php
	if($uId!=$c1['uId']){
?>
                              	<a href="javascript:;" class="comment-operate">回复</a>
<?php
	}else{
?>
								<a href="javascript:void();" class="comment-operate" onclick="del_comment(this);">删除</a>	
<?php
	}
?>
                              </p>
                            </div>
                        </div>


<?php
if($comment_2){
	foreach($comment_2 as $c2){
		if($c2['ccId']==$c1['cId']){
			//查询用户是否赞过该评论
			$isPraise=mysql_num_rows(mysql_query("select * from praise where cId='$c2[cId]' and uId='$uId'"));
?>
						<div class="comment-box clearfix" user="other">
                          <input type="hidden"  name="cId" value="<?php echo $c2['cId']?>"/>
                          <img class="myhead" src="<?php echo $c2['uFace']?>" alt=""/>
                          <div class="comment-content">
                             <p class="comment-text">
                             <span class="user"><?php echo $c2['uName']?>：</span>回复<?php echo $c2['ccName']?><?php echo $c2['cBody']?>
                             </p>
                              <p class="comment-time">
                                    <?php echo $c2['cTime']?>
                              	<a class="comment-praise" href="javascript:void();"  total="<?php echo $c2['pNum']?>" my="0" onclick="praise(this);"><?php echo $isPraise!=NULL?'取消赞':'赞'?></a>
<?php
	if($uId!=$c2['uId']){
?>
                              	<a href="javascript:;" class="comment-operate">回复</a>
<?php
	}else{
?>
								<a href="javascript:void();" class="comment-operate" onclick="del_comment(this);">删除</a>	
<?php
	}
?>
                              </p>
                            </div>
                        </div>                         
<?php
		
			foreach($comment_2 as $c3){
				if($c3['ccId']==$c2['cId']){
					//查询用户是否赞过该评论
					$isPraise=mysql_num_rows(mysql_query("select * from praise where cId='$c3[cId]' and uId='$uId'"));
?>
						<div class="comment-box clearfix" user="other">
                          <input type="hidden"  name="cId" value="<?php echo $c3['cId']?>"/>
                          <img class="myhead" src="<?php echo $c3['uFace']?>" alt=""/>
                          <div class="comment-content">
                             <p class="comment-text">
                             <span class="user"><?php echo $c3['uName']?>：</span>回复<?php echo $c3['ccName']?><?php echo $c3['cBody']?>
                             </p>
                              <p class="comment-time">
                                    <?php echo $c3['cTime']?>
                              	<a class="comment-praise" href="javascript:void();"  total="<?php echo $c3['pNum']?>" my="0" onclick="praise(this);"><?php echo $isPraise!=NULL?'取消赞':'赞'?></a>
<?php
	if($uId!=$c3['uId']){
?>
                              	<a href="javascript:;" class="comment-operate">回复</a>
<?php
	}else{
?>
								<a href="javascript:void();" class="comment-operate" onclick="del_comment(this);">删除</a>	
<?php
	}
?>
                              </p>
                            </div>
                        </div>
<?php
					
				}
			}
		}
	}	
}
?>                
<?php
	}
}
?>
					</div>
                    <div class="text-box">
                        <textarea class="comment" autocomplete="off">评论…</textarea>
                        <button class="btn">回 复</button>
                        <span class="word"><span class="length">0</span>/140</span>
                    </div>
                </div>
            </div>
<?php
	}
}
?>
        </div>
    </div>
    <!--右侧 广告 或者其他-->
    <div class="right">
    	<div class="board">
            <strong>公告栏</strong>
<?php 
if($user_limit!='成员'){
?>
            <a href="javascript:edit()" id="a1">编辑</a>
            <a href="javascript:save()" style="display:none" id="a2">保存</a>
<?php
}
?>
				<br/><input type="hidden" id="sId" value="<?php echo $societyRes['sId']?>"/><textarea name="board" id="board_text" placeholder="不超过140个字符" readonly="readonly"><?php echo $societyRes['Board']?></textarea>
            
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
<script src="js/society_home.js" type="text/javascript"></script>
<script src="js/comment.js"></script>
</body>