<?php 
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');
$page=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>社团名录</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/society_cards.css" type="text/css" rel="stylesheet">
</head>

<body>
<div class="top_back">
  <div class="top">
      <ul>
        <li class="a">社团名录</li>
        <li class="b">返回&nbsp&nbsp;<a href="square.php">易可广场>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>
<input type="hidden" id="school" value="<?php echo $sSchool?>"/>
<input type="hidden" id="page" value="<?php echo $page?>"/>
<div id="main">
    <div class="container">
        <div class="course-content">
            <!--分类：导航-->
            <div class="course-nav-box">
                    <div class="course-nav-hd">
                        <span class="l">所有社团</span>
                        <span class="r">
                        <div class="search-area">
            				<form id="search_form" action="../background/background_society/classify_query_society.php?action=search&school=<?php echo $sSchool?>" name="search_form"  method="post">
                				<input class="search-input" placeholder="搜索社团、关键词" type="text" autocomplete="off" name="words" value=""/>
                				<input type="submit" class="btn_search button" value="搜索"/>
           					</form>
						</div>
                        </span>
                    </div>
                    <!--是否认证-->
                    <div class="course-nav-row">
                        <span class="hd l">是否认证：</span>
                        <div class="bd">
                            <ul class="s1">
                                <li class="course-nav-item on" id="all">
                                    <a href="javascript:void()">全部</a>
                                </li>
                                <li class="course-nav-item">
                                     <a href="javascript:void()">已认证社团</a>
                                </li>
                                <li class="course-nav-item">
                                     <a href="javascript:void()">未认证社团</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!--社团性质-->      
                    <div class="course-nav-row clearfix"> 
                        <span class="hd l">社团性质：</span>
                        <div class="bd">
                            <ul class="s2">
                         <li class="course-nav-item on">
                             <a href="javascript:void()">全部</a>
                         </li>
                         <li class="course-nav-item ">
                             <a href="javascript:void()">学生会（或其所属部门）</a>
                         </li>
                         <li class="course-nav-item ">
                             <a href="javascript:void()">志愿者协会（或其所属部门）</a>
                         </li>
                         <li class="course-nav-item ">
                             <a href="javascript:void()">学术类</a>
                         </li>
                         <li class="course-nav-item ">
                             <a href="javascript:void()">艺术类</a>
                         </li>
                         <li class="course-nav-item ">
                             <a href="javascript:void()">文化类</a>
                         </li>
                         <li class="course-nav-item ">
                             <a href="javascript:void()">体育类</a>
                         </li>
                         <li class="course-nav-item ">
                             <a href="javascript:void()">兴趣类</a>
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
                        <a href="javascript:void()" class="hide-joined">隐藏已参加社团</a>
                    </span>
                    <span class="tool-item">
                        共<b id="snum"></b>个社团
                    </span>
                </div>
            </div>
            <!--主体部分：社团名片-->   
           <div class="course-list">
                <!--社团名片-->
                <div class="js-course-lists">
                       	 <ul id="body">
                  		 </ul>
                 </div>
                 <div style="clear:both;"></div>
                  <div id="paging">          
     			</div>          
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
<script src="js/society_cards.js" type="text/javascript"></script>
</body>
</html>