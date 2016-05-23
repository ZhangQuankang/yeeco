<?php 
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');
$page=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>活动列表</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<script src="js/jquery-1.11.1.js"></script>
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/activity_cards.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="top_back">
  <div class="top">
      <ul>
        <li class="a">活动列表</li>
        <li class="b">返回&nbsp&nbsp;<a href="square.php">易可广场>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>
<input type="hidden" id="school" value="<?php echo $sSchool?>"/>
<input type="hidden" id="page" value="<?php echo $page?>"/>
<div id="main">
		<div class="course-content">
            <!--分类：导航-->
            <div class="course-nav-box">
                    <div class="course-nav-hd">
                        <span class="l">所有活动</span>
                        <span class="r">
                        <div class="search-area">
            				<form id="search_form" action="../background/background_society/activity/classify_query_activity.php?action=search&school=<?php echo $sSchool?>" name="search_form"  method="post">
                				<input class="search-input" placeholder="搜索活动名称关键词" type="text" autocomplete="off" name="words" value=""/>
                				<input type="button" class="btn_search button" value="搜索" onclick="aSubmit()"/>
           					</form>
						</div>
                        </span>
                    </div>
                    <!--是否认证-->
                    <div class="course-nav-row">
                        <span class="hd l">活动状态：</span>
                        <div class="bd">
                            <ul class="s1">
                                <li class="course-nav-item on" id="all">
                                    <a href="javascript:void()">全部</a>
                                </li>
                                <li class="course-nav-item">
                                     <a href="javascript:void()">正在进行</a>
                                </li>
                                <li class="course-nav-item">
                                     <a href="javascript:void()">已经结束</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!--社团性质-->      
                    <div class="course-nav-row clearfix"> 
                        <span class="hd l">活动类型：</span>
                        <div class="bd">
                            <ul class="s2">
                         <li class="course-nav-item on">
                             <a href="javascript:void()">全部</a>
                         </li>
                         <li class="course-nav-item ">
                             <a href="javascript:void()">比赛</a>
                         </li>
                         <li class="course-nav-item ">
                             <a href="javascript:void()">晚会</a>
                         </li>
                         <li class="course-nav-item ">
                             <a href="javascript:void()">会议</a>
                         </li>
                         <li class="course-nav-item ">
                             <a href="javascript:void()">聚会</a>
                         </li>
                         <li class="course-nav-item ">
                             <a href="javascript:void()">其他</a>
                         </li>
                     </ul>
                        </div>
                    </div>
                    
                </div>
            <!--排序方式、隐藏已参加-->    
            <div class="course-tool-bar clearfix">
                <div class="tool-left l">
                    <a href="javascript:void()" class="sort-item active">最热</a>
                    <a href="javascript:void()" class="sort-item">最新</a>
                </div>
                <div class="tool-right r">
                    <span class="tool-item">
                        共<b id="anum"></b>个活动
                    </span>
                </div>
            </div>
        </div>       
    <div class="container">
        <!--主体部分：社团名片-->   
            <div class="course-list">
               <!--社团名片-->
               <div class="js-course-lists" id="body">
               </div> 
               <div id="paging">          
     			</div>      
           </div>

<div class="right">   
  <div class="advertisement">
      <div class="ad_title">
        <li class="ad_title_li">推广链接</li>
      </div>
      <div class="ad_img"><img src=""></div>
      <div class="ad_img"><img src=""></div>
      <div class="ad_img"><img src=""></div>
      <div class="ad_img"><img src=""></div>
      <div style="clear:both;"></div>
  </div> 
</div>
   
	<div style="clear:both;"></div>
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



<script src="js/jquery.form.js" type="text/javascript"></script>
<script src="js/main.js"></script>
<script src="js/activity_cards.js" type="text/javascript"></script>
</body>
</html>