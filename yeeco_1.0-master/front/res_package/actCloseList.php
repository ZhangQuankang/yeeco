<?php 
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../background/conf/connect.php');
$sId=$_POST['sId'];
//提取活动信息
$actCloseRes=mysql_query("select * from society_act_closed where sId='$sId'");
if($actCloseRes && mysql_num_rows($actCloseRes)){
	    while($row = mysql_fetch_assoc($actCloseRes)){
			$actClose_info[]=$row;
		}			
}
if($actClose_info){
	foreach($actClose_info as $v){
?>
			<a href="activity_detail.php?actId=<?php echo $v['actId']?>&sId=<?php echo $sId?>" style="color:#333;">
     			<div class="act">
                    <div class="act_ad">
                        <img src="<?php echo substr($v['actImg'],3)?>"/>
                    </div>
                    <ul class="act_tips">
                      <li><strong><?php echo $v['actName']?></strong><span class="number"><strong><?php echo $v['actNum']?></strong>人报名&nbsp;<strong><?php echo $v['actFocusNum']?></strong>人关注</span></li>
                      <li><label>类型：</label><span><?php echo $v['actType']?>/<?php echo $v['isApply']?>/<?php echo $v['actRange']?></span></li>		
                      <li><label>时间：</label><span><?php echo $v['actBeginDate']?>&nbsp;<?php echo $v['actBeginTime']?>&nbsp;&nbsp;~&nbsp;&nbsp;<?php echo $v['actEndDate']?>&nbsp;<?php echo $v['actEndTime']?></span></li>
                      <li><label>地点：</label><span><?php echo $v['actPlace']?></span></li>
                      <li><label>简介：</label><span><?php echo $v['actDesc']?></span></li>
                    </ul>       
                    <div style="clear:both;"></div>
                </div>	
                </a>	
<?php 
	}
}
?>