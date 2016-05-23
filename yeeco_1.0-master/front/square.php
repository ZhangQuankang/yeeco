<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');

//查找用户
$find_user = mysql_query("select * from user where uId='$uId' limit 1");
$result_user = mysql_fetch_array($find_user);
//查找用户相关社团ID
$user_society_Id=mysql_query("SELECT societyId FROM user_society_relation WHERE userId='$uId' and isManage<>4 and isManage<>3");
if($user_society_Id && mysql_num_rows($user_society_Id)){
	    while($row = mysql_fetch_assoc($user_society_Id)){
			$societyId[]=$row['societyId'];
		}			
}

//获取我所参加的社团名称
if($societyId){
	foreach($societyId as $value){
		$res=mysql_fetch_assoc(mysql_query("select sId,sName from society where sId='$value'"));
		$mySociety[]=$res;
	}
}
//查找所有社团
$query=mysql_query("SELECT sId,sImg,sName,sDesc,sNum,sCate FROM society WHERE sSchool='$sSchool' order by sNum desc limit 29");
if($query && mysql_num_rows($query)){
	    while($row = mysql_fetch_assoc($query)){
			$society[]=$row;
		}			
}
//$i=1;print_r($i);
//print_r($society);print_r($i);;print_r(++$i);exit;
//查找活动
$query=mysql_query("select * from society_act_open where actSchool='$sSchool' order by actFocusNum desc limit 8");
if($query && mysql_num_rows($query)){
	    while($row = mysql_fetch_assoc($query)){
			$acts[]=$row;
		}			
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>易可社团-广场</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet"/>
<link href="css/square.css" type="text/css" rel="stylesheet"/>
<script src="js/jquery-1.11.1.js" type="text/javascript"></script>
</head>


<body>


    <div class="top_back">
      <div class="top">
          <div class="top_logo"><a href="../index.jsp"><img src="../image/web_image/logo1.png"/></a></div>
          <div class="top_right">
              <ul>
                <li>
                    <span><img src="../<?php echo $result_user['userFace']?>"/></span>
<?php
	if(mysql_num_rows(mysql_query("select  msgId  from message where msgToId='$uId'"))){
?>                      
                	<span class="msgNotice"></span>
<?php
	}
?>                    
                    <span><?php echo $_SESSION['userName']?></span>
                </li> 
                <div style="clear:both;"></div>
                <a href="myconcern.php"><li>个人中心</li></a>
                <a href="massageBox.php"><li>消息盒子</li></a>
                <a href="../background/background_person/login.php?action=logout"><li>退出登录</li></a>
              </ul>
          </div>
      </div>
    </div>
    <div style="clear:both;"></div>
    
<div class="banner_wrap"> 
        <!-- 幻灯片基本结构 添加类名current置顶显示 具体效果开发同事看需要做 -->
        <div class="banner_bg">
            <a href="javascript:void(0);" style="display:inline-block" id="img_1"><img src="../image/user_image/defaultImg/testAnnounce_1.png" width="1380" height="440" /></a>
            <a href="javascript:void(0);" id="img_2"><img src="../image/user_image/defaultImg/testAnnounce_2.png" width="1380" height="440" /></a>
            <a href="javascript:void(0);" id="img_3"><img src="../image/user_image/defaultImg/testAnnounce_3.png" width="1380" height="440" /></a>
            <a href="javascript:void(0);" id="img_4"><img src="../image/user_image/defaultImg/testAnnounce_4.png" width="1380" height="440" /></a>  
        </div>
        <div class="control">
            <ul>
                <li><a href="javascript:void(0);" id="btn_1" class="current"></a></li>
                <li><a href="javascript:void(0);" id="btn_2"></a></li>
                <li><a href="javascript:void(0);" id="btn_3"></a></li>
                <li><a href="javascript:void(0);" id="btn_4"></a></li>
            </ul>
        </div>
</div>
<div class="handdles">
	<ul>
	  <li><a href="society_establish.php" class="handdle">创建社团</a></li>
      <li><a href="javascript:void(0)" class="handdle" onclick="find_society()">寻找社团</a></li>
      <li><a href="javascript:void(0)" onclick="mysociety()" class="handdle">我的社团</a></li>
    </ul>
</div>

<div class="my_society">
	
		<div class="list_title"><span>我的社团</span><a href="javascript:hidden()" style="margin-left:120px;font-size:26px">&times;</a></div>
        <ul>
        <?php 
			if($mySociety){
				for($i=0;$i<=sizeof($mySociety)-1;$i++){
		?>
          	<li><a href="society_home.php?sId=<?php echo $mySociety[$i]['sId']?>"><?php echo $mySociety[$i]['sName']?></a></li>
         <?php 
		 	}}
		 ?>
        </ul>
    
</div>


<!--活动推荐-->
<div class="act_recommend">
	<div class="title">活动推荐</div>
	<div class="act_body">
      <ul>
<?php
	for($i=0;$i<=7;$i++){
?>
 		<li>
          <a href="activity_visitor.php?actId=<?php echo $acts[$i]['actId']?>"  >
             <div class="act_img">
                 <img src="<?php echo substr($acts[$i]['actImg'],3)?>" alt="">
          	 </div>
             <div class="decs" style="display:none">
             	 <p><?php echo $acts[$i]['actDesc']?></p>
             </div>
          	 <div class="act_tips">
             	 <h2><?php echo $acts[$i]['actName']?></h2>
             	 <span class="act_l"><?php echo $acts[$i]['actFocusNum']?>关注</span>
             	 <span class="act_r"><?php echo $acts[$i]['actBeginDate'].' '.$acts[$i]['actBeginTime']?></span>
             </div>
          </a>
        </li>
<?php
	}
?>
      </ul>
      <div style="clear:both;"></div>
    </div>
    <div class="more_act">
    	<a href="activity_cards.php" class="button">更多活动</a>
    </div>
</div>

<!--社团封面墙-->
<div class="society_card" id="cards">
  <div class="card_in">
    <div id="card_1" class="card_a" onmouseover="movecover(this)" onmouseout="recover(this)">
        <a href="society_establish.php"><img src="../image/user_image/defaultImg/createNew.png"/>
</a>
        <div id="card_1_cover" class="card_a_cover"></div>
        <div id="card_1_det" class="card_a_det" style="display:none;">
            <strong>创建一个社团</strong>
            <p class="jianjie">这里填写社团简介</p>
            <p class="leibie">这里填写社团类别</p>
            <p class="renshu">这里填写当前人数</p>
        </div>
    </div>
    
    <div class="card_b">
        <div id="card_7" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[0]['sId']?>"  ><img src="<?php echo substr($society[0]['sImg'],3)?>"/></a>
            <div id="card_7_cover" class="card_c_cover"></div>
            <div id="card_7_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[0]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[0]['sDesc']?></p>
            </div>
        </div>
        <div id="card_8" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[1]['sId']?>"  ><img src="<?php echo substr($society[1]['sImg'],3)?>"/></a>
            <div id="card_8_cover" class="card_c_cover"></div>
            <div id="card_8_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[1]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[1]['sDesc']?></p>
            </div>
        </div>
        <div id="card_9" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[2]['sId']?>"  ><img src="<?php echo substr($society[2]['sImg'],3)?>"/></a>
            <div id="card_9_cover" class="card_c_cover"></div>
            <div id="card_9_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[2]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[2]['sDesc']?></p>
            </div>
        </div>
        <div id="card_10" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[3]['sId']?>"  ><img src="<?php echo substr($society[3]['sImg'],3)?>"/></a>
            <div id="card_10_cover" class="card_c_cover"></div>
            <div id="card_10_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[3]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[3]['sDesc']?></p>
            </div>
        </div>
    </div>
    <div id="card_2" class="card_a" onmouseover="movecover(this)" onmouseout="recover(this)">
        <a href="society_visitor.php?sId=<?php echo $society[4]['sId']?>"  ><img src="<?php echo substr($society[4]['sImg'],3)?>"/></a>
        <div id="card_2_cover" class="card_a_cover"></div>
        <div id="card_2_det" class="card_a_det" style="display:none;">
        	<strong><?php echo $society[4]['sName']?></strong></li>
            <p class="jianjie"><?php echo $society[4]['sDesc']?></p>
            <p class="leibie"><?php echo $society[4]['sCate']?></p>
            <p class="renshu">现有成员&nbsp;<?php echo $society[4]['sNum']?>&nbsp;人</p>
        </div>
    </div>
    
    <div class="card_b">
        <div id="card_11" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[5]['sId']?>"  ><img src="<?php echo substr($society[5]['sImg'],3)?>"/></a>
            <div id="card_11_cover" class="card_c_cover"></div>
            <div id="card_11_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[5]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[5]['sDesc']?></p>
            </div>
        </div>
        <div id="card_12" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[6]['sId']?>"  ><img src="<?php echo substr($society[6]['sImg'],3)?>"/></a>
            <div id="card_12_cover" class="card_c_cover"></div>
            <div id="card_12_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[6]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[6]['sDesc']?></p>
            </div>
        </div>
        <div id="card_13" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[7]['sId']?>"  ><img src="<?php echo substr($society[7]['sImg'],3)?>"/></a>
            <div id="card_13_cover" class="card_c_cover"></div>
            <div id="card_13_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[7]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[7]['sDesc']?></p>
            </div>
        </div>
        <div id="card_14" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[8]['sId']?>"  ><img src="<?php echo substr($society[8]['sImg'],3)?>"/></a>
            <div id="card_14_cover" class="card_c_cover"></div>
            <div id="card_14_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[8]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[8]['sDesc']?></p>
            </div>
        </div>
    </div>
    
    <div id="card_3" class="card_a" onmouseover="movecover(this)" onmouseout="recover(this)">
        <a href="society_visitor.php?sId=<?php echo $society[9]['sId']?>"  ><img src="<?php echo substr($society[9]['sImg'],3)?>"/></a>
        <div id="card_3_cover" class="card_a_cover"></div>
        <div id="card_3_det" class="card_e_det" style="display:none;">
        	<strong><?php echo $society[9]['sName']?></strong></li>
            <p class="jianjie"><?php echo $society[9]['sDesc']?></p>
            <p class="leibie"><?php echo $society[9]['sCate']?></p>
            <p class="renshu">现有成员&nbsp;<?php echo $society[9]['sNum']?>&nbsp;人</p>
        </div>
    </div>
    
    <div class="card_b">
        <div id="card_15" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[10]['sId']?>"  ><img src="<?php echo substr($society[10]['sImg'],3)?>"/></a>
            <div id="card_15_cover" class="card_c_cover"></div>
            <div id="card_15_det" class="card_d_det" style="display:none;">
          		<strong><?php echo $society[10]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[10]['sDesc']?></p>
            </div>
        </div>
        <div id="card_16" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[11]['sId']?>"  ><img src="<?php echo substr($society[11]['sImg'],3)?>"/></a>
            <div id="card_16_cover" class="card_c_cover"></div>
            <div id="card_16_det" class="card_d_det" style="display:none;">
            	<strong><?php echo $society[11]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[11]['sDesc']?></p>
            </div>
        </div>
        <div id="card_17" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[12]['sId']?>"  ><img src="<?php echo substr($society[12]['sImg'],3)?>"/></a>
            <div id="card_17_cover" class="card_c_cover"></div>
            <div id="card_17_det" class="card_d_det" style="display:none;">
            	<strong><?php echo $society[12]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[12]['sDesc']?></p>
            </div>
        </div>
        <div id="card_18" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[13]['sId']?>"  ><img src="<?php echo substr($society[13]['sImg'],3)?>"/></a>
            <div id="card_18_cover" class="card_c_cover"></div>
            <div id="card_18_det" class="card_d_det" style="display:none;">
            	<strong><?php echo $society[13]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[13]['sDesc']?></p>
            </div>
        </div>
    </div>
    <div class="card_b">
        <div id="card_19" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[14]['sId']?>"  ><img src="<?php echo substr($society[14]['sImg'],3)?>"/></a>
            <div id="card_19_cover" class="card_c_cover"></div>
            <div id="card_19_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[14]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[14]['sDesc']?></p>
            </div>
        </div>
        <div id="card_20" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[15]['sId']?>"  ><img src="<?php echo substr($society[15]['sImg'],3)?>"/></a>
            <div id="card_20_cover" class="card_c_cover"></div>
            <div id="card_20_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[15]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[15]['sDesc']?></p>
            </div>
        </div>
        <div id="card_21" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[16]['sId']?>"  ><img src="<?php echo substr($society[16]['sImg'],3)?>"/></a>
            <div id="card_21_cover" class="card_c_cover"></div>
            <div id="card_21_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[16]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[16]['sDesc']?></p>
            </div>
        </div>
        <div id="card_22" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[17]['sId']?>"  ><img src="<?php echo substr($society[17]['sImg'],3)?>"/></a>
            <div id="card_22_cover" class="card_c_cover"></div>
            <div id="card_22_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[17]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[17]['sDesc']?></p>
            </div>
        </div>
    </div>
    
    <div id="card_4" class="card_a" onmouseover="movecover(this)" onmouseout="recover(this)">
        <a href="society_visitor.php?sId=<?php echo $society[18]['sId']?>"  ><img  src="<?php echo substr($society[18]['sImg'],3)?>"/></a>
        <div id="card_4_cover" class="card_a_cover"></div>
        <div id="card_4_det" class="card_a_det" style="display:none;">
        	<strong><?php echo $society[18]['sName']?></strong></li>
            <p class="jianjie"><?php echo $society[18]['sDesc']?></p>
            <p class="leibie"><?php echo $society[18]['sCate']?></p>
            <p class="renshu">现有成员&nbsp;<?php echo $society[18]['sNum']?>&nbsp;人</p>
        </div>
    </div>
    
    <div class="card_b">
        <div id="card_23" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[19]['sId']?>"  ><img src="<?php echo substr($society[19]['sImg'],3)?>"/></a>
            <div id="card_23_cover" class="card_c_cover"></div>
            <div id="card_23_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[19]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[19]['sDesc']?></p>
            </div>
        </div>
        <div id="card_24" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[20]['sId']?>"  ><img src="<?php echo substr($society[20]['sImg'],3)?>"/></a>
            <div id="card_24_cover" class="card_c_cover"></div>
            <div id="card_24_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[20]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[20]['sDesc']?></p>
            </div>
        </div>
        <div id="card_25" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[21]['sId']?>"  ><img src="<?php echo substr($society[21]['sImg'],3)?>"/></a>
            <div id="card_25_cover" class="card_c_cover"></div>
            <div id="card_25_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[21]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[21]['sDesc']?></p>
            </div>
        </div>
        <div id="card_26" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[22]['sId']?>"  ><img src="<?php echo substr($society[22]['sImg'],3)?>"/></a>
            <div id="card_26_cover" class="card_c_cover"></div>
            <div id="card_26_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[22]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[22]['sDesc']?></p>
            </div>
        </div>
    </div>
    
    <div id="card_5" class="card_a" onmouseover="movecover(this)" onmouseout="recover(this)">
        <a href="society_visitor.php?sId=<?php echo $society[23]['sId']?>"  ><img src="<?php echo substr($society[23]['sImg'],3)?>"/></a>
        <div id="card_5_cover" class="card_a_cover"></div>
        <div id="card_5_det" class="card_a_det" style="display:none;">
        	<strong><?php echo $society[23]['sName']?></strong></li>
            <p class="jianjie"><?php echo $society[23]['sDesc']?></p>
            <p class="leibie"><?php echo $society[23]['sCate']?></p>
            <p class="renshu">现有成员&nbsp;<?php echo $society[23]['sNum']?>&nbsp;人</p>
        </div>
    </div>
    
    <div class="card_b">
        <div id="card_27" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[24]['sId']?>"  ><img src="<?php echo substr($society[24]['sImg'],3)?>"/></a>
            <div id="card_27_cover" class="card_c_cover"></div>
            <div id="card_27_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[24]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[24]['sDesc']?></p>
            </div>
        </div>
        <div id="card_28" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[25]['sId']?>"  ><img src="<?php echo substr($society[25]['sImg'],3)?>"/></a>
            <div id="card_28_cover" class="card_c_cover"></div>
            <div id="card_28_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[25]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[25]['sDesc']?></p>
            </div>
        </div>
        <div id="card_29" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[26]['sId']?>"  ><img src="<?php echo substr($society[26]['sImg'],3)?>"/></a>
            <div id="card_29_cover" class="card_c_cover"></div>
            <div id="card_29_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[26]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[26]['sDesc']?></p>
            </div>
        </div>
        <div id="card_30" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[27]['sId']?>"  ><img src="<?php echo substr($society[27]['sImg'],3)?>"/></a>
            <div id="card_30_cover" class="card_c_cover"></div>
            <div id="card_30_det" class="card_c_det" style="display:none;">
            	<strong><?php echo $society[27]['sName']?></strong></li>
                <p class="jianjie"><?php echo $society[27]['sDesc']?></p>
            </div>
        </div>
    </div>
    <div id="card_6" class="card_a" onmouseover="movecover(this)" onmouseout="recover(this)">
        <a href="society_visitor.php?sId=<?php echo $society[28]['sId']?>"  ><img src="<?php echo substr($society[28]['sImg'],3)?>"/></a>
        <div id="card_6_cover" class="card_a_cover"></div>
        <div id="card_6_det" class="card_e_det" style="display:none;">
        	<strong><?php echo $society[28]['sName']?></strong></li>
            <p class="jianjie"><?php echo $society[28]['sDesc']?></p>
            <p class="leibie"><?php echo $society[28]['sCate']?></p>
            <p class="renshu">现有成员&nbsp;<?php echo $society[28]['sNum']?>&nbsp;人</p>
        </div>
    </div>
  </div> 
  <div class="cover" id="cards_cover">社团名片墙</div> 
</div>
<div style="clear:both;"></div>

<div class="more_society">
    <a href="society_cards.php" class="button">更多社团</a>
</div>


<div class="mobile_client">
	<p style="line-height:80px;display:block;text-align:center;font-size:36px;">APP正在加紧开发中~~~</p>
	<img src="../image/web_image/下载APP.png" width="677" height="431" /> 
</div>

<div class="about_us">
</div>
<div class="footer">
	<p><a href="temp_page.html">招才纳士</a><a href="temp_page.html">联系我们</a><a href="temp_page.html">意见反馈</a><a href="temp_page.html">网站地图</a><a href="temp_page.html">新手学堂</a></p>
    <div class="hr"></div>
    <p>中国·陕西·西安市·长安区·西安邮电大学 710100 | 陕ICP备 15010814 号</p>
    <p>好点子，新生活</p>
</div>
<script src="js/square.js" type="text/javascript"></script>
</body>
</html>
