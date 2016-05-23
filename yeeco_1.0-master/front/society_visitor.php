<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
$sId=$_GET['sId'];
require_once('../background/conf/session.php');
//查找社团信息
$sInfo=mysql_fetch_assoc(mysql_query("select * from society where sId='$sId'"));
//查找纳新信息
$fInfo=mysql_fetch_assoc(mysql_query("select * from society_fresh where sId='$sId'"));
//查看是否关注此社团
$concern=mysql_fetch_assoc(mysql_query("select isManage from user_society_relation where societyId='$sId' and userId='$uId'"));
//查询评论信息
$nId = mysql_fetch_assoc(mysql_query("select nId from dynamic_state where nImg='$sId'"));
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
}//print_r($pcId);exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>社团详情</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/society_visitor.css" type="text/css" rel="stylesheet">
<script src="js/jquery-1.11.1.js"></script>
</head>

<body>
<!--顶部--> 
<div class="top_back">
  <div class="top">
      <ul>
        <li class="a"><?php echo $sInfo['sName']?></li>
        <li class="b"><a href="javascript:history.go(-1)">返回&nbsp&nbsp;上一页>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>

<!--封面--> 
<div class="head">
	<div class="cover"><img src="<?php echo substr($fInfo['fImg'],3)?>"/></div>
    <div class="summary">
    	<ul>
          <li>
            <span>当前状态</span>
        <?php 
			if($sInfo['isFresh']==1){		
		?>
            	<em>正在纳新</em>           
        <?php
			}else{
		?>
        		<em>纳新关闭</em>
        <?php 		
			}
		?>
          </li>
          <li>
            <span>申请人数</span>
            <em><?php echo $fInfo['fNum']?$fInfo['fNum']:0;?></em>
          </li>
          <li class="course_hour">
            <span>现有成员</span>
            <em><?php echo $sInfo['sNum']?></em>
          </li>
        </ul>
    </div>
    <div class="head_handle">

        <div class="concern" id="concern">
        	<a href="javascript:concern();" class="handle_1">
            	<i></i>
            	<em class="concerned-icon">关注此社团</em>
            </a>
        </div>
        <div class="join">
            	<a href="javascript:apply_form(<?php echo $sInfo['isFresh']?>);" class="handle_2">申请加入</a>
        </div>
        
    </div>
</div>
<div style="clear:both;"></div>

<!--主体-->
<div class="body">
	<div class="main">
    	<!--基本信息-->
    	<div class="page" id="page_1">
        	<div class="cover_pic"><img src="<?php echo substr($sInfo['sImg'],3)?>"/></div>
        	<div class="base_info">
              <ul>
                <li><label style="margin-top:7px;">社团名称：</label><strong><?php echo $sInfo['sName']?></strong></li>
                <li><label>创建人：</label><p><?php echo $sInfo['sPrincipal']?></p></li>
                <li><label>社团性质：</label><p><?php echo $sInfo['sCate']?></p></li>
                <li><label>社团简介：</label><p><?php echo $sInfo['sDesc']?></p></li>
              </ul>
            </div>
        </div>
<?php
	if($sInfo['isFresh']){
?>        
    	<!--纳新公告--纳新详情-->
    	<div class="page">
        	<strong>纳新公告：</strong>       
               <p><?php echo $fInfo['fAnn']?></p>
        	<strong>纳新详情：</strong><a class="more" href="javascript:detail()"></a>
            	<p><pre id="detail"><?php echo $fInfo['fDetail']?></pre></p>			
        </div>
<?php 
	}

//纳新结果公示**********************************************************************************************
if($sInfo['isFresh']==2){
	$mFid=mysql_fetch_assoc(mysql_query("select max(fId) from apply_information_member where sId='$sId'"));
	$fId=$mFid['max(fId)'];
	$memberRes=mysql_query("select aName,aSex,aClass,sDep from apply_information_member where fId='$fId'");
	if($memberRes && mysql_num_rows($memberRes)){	
	while($row = mysql_fetch_assoc($memberRes)){
			$members[] = $row;
	}			
}
	if($members){
?>   
    	<div class="page">
        	<strong>纳新结果：</strong>       
               <p>恭喜以下同学加入我社团</p>

            <div class="table">
              <ul>
                <li><span>姓名</span><span>专业班级</span><span>部门</span><span></span><span>姓名</span><span>专业班级</span><span>部门</span></li>
<?php
		foreach($members as $value_3){
?>
                <li><span><?php echo $value_3['aName']?><i><?php echo $value_3['aSex']?></i></span><span><?php echo $value_3['aClass']?></span><span><?php echo $value_3['sDep']?></span></li>
           
<?php
		}
?>               
                         
                <li><a href="" id="load_more">加载更多<i></i></a></li>
              </ul>
            </div>
            <div style="clear:both;"></div>            

        </div> 
<?php
	}
}
?>
		<!--*******************************************************************************************8-->     
<!--评论-*************************************************************************************************************-->
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
<!--评论-****************************************************************************************************************-->

    </div>
    
    <div class="right">
    <!--公告栏-->
    	<div class="board">
            <strong>公告栏</strong>
				<br/><textarea name="board" id="board_text" placeholder="当前暂无公告" readonly="readonly"><?php echo $sInfo['Board']?></textarea>
            
        </div>
    <!--社团二维码-->
    	<div class="society_code">
            <strong>社团二维码</strong>
				<div class="qrCode"><img src="<?php echo substr($sInfo['sQRCode'],3)?>" /></div>
        </div>
    </div>
</div>


<!----> 
    <input type="hidden" id="isManage" value="<?php echo $concern['isManage']?>">
    <input type="hidden" id="sId" value="<?php echo $sId?>">
    <input type="hidden" id="uId" value="<?php echo $uId?>">
    <input type="hidden" id="fId" value="<?php echo $fInfo['fId']?>"/>
    <input type="hidden" id="sName" value="<?php echo $sInfo['sName']?>">
    <input type="hidden" id="fQue_1" value="<?php echo $fInfo['fQue_1']?>">
    <input type="hidden" id="fQue_2" value="<?php echo $fInfo['fQue_2']?>">
    <input type="hidden" id="fQue_3" value="<?php echo $fInfo['fQue_3']?>">
<div class="app_form" id="form_box" style="display:none;">
  
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

<script src="js/main.js"></script>
<script src="js/jquery.form.js" type="text/javascript"></script>
<script src="js/pic_preview.js" type="text/javascript"></script>
<script src="js/society_visitor.js" type="text/javascript"></script>
<?php
	if(is_numeric($concern['isManage'])){
		//已关注
		echo "<script>change_concern(1);</script>";
	}
	if(mysql_num_rows(mysql_query("select aId from apply_information_unselected where uId='$uId' and sId='$sId'"))){
		echo "<script>$('.handle_2').text('等待审核').removeAttr('href');</script>";
	}
?>
</body>
</html>