<?php
error_reporting(E_ALL & ~E_NOTICE);
//判断网页是否被重新排版
$isChange = 0;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')&&strpos($_SERVER['REQUEST_URI'], 'nsukey') ){
	$isChange = 1;
}
require_once('../../background/conf/connect.php');
$sId=$_GET['sId'];

//查找社团信息
$sInfo=mysql_fetch_assoc(mysql_query("select * from society where sId='$sId'"));
//查找纳新信息
$fInfo=mysql_fetch_assoc(mysql_query("select * from society_fresh where sId='$sId'"));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=2.0,initial-scale=1.0,user-scalable=no">
<title><?php echo $sInfo['sName']?>·社团详情</title>
<link href="M_css/M_societyVisitor.css" type="text/css" rel="stylesheet">
<script src="../js/jquery-1.11.1.js"></script>
</head>

<body>

<div class="top">
	<?php echo $sInfo['sName']?>
</div>
<div class="cover" id="cover">
	<img src="<?php echo $fInfo['fImg']?>"/>
</div>

<!--页面被重新排版时的策略-->
<?php
if(!$isChange){
	//如果没有被重新排版，需要用js对海报尺寸进行动态调整
?>
<script>
	var coverWidth = $("#cover").width();
	$("#cover").height(coverWidth/1.76);
</script>
<?php
}
?>


<div class="summary">
	<ul>
    	<li class="a">
        <?php 
			if($sInfo['isFresh']){		
		?>
            	<em>正在纳新</em>           
        <?php
			}else{
		?>
        		<em>纳新关闭</em>
        <?php 		
			}
		?>
        	<p>当前状态</p>
        </li>
        <li class="b">
            <em><?php echo $fInfo['fNum']?$fInfo['fNum']:0;?></em>
        	<p>申请人数</p>
        </li>
        <li class="c">
            <em><?php echo $sInfo['sNum']?></em>
        	<p>现有成员</p>
        </li>
    </ul>
    <div style="clear:both;"></div>
</div>

<div class="base_info block">
  <ul>
    <li><label>社团名称：</label><span><?php echo $sInfo['sName']?></span></li>
    <li><label>创建人：</label><span><?php echo $sInfo['sPrincipal']?></span></li>
    <li><label>社团性质：</label><span><?php echo $sInfo['sCate']?></span></li>
    <li><label>社团简介：</label><p><?php echo $sInfo['sDesc']?></p></li> 
  </ul>
</div>

<div class="board block">
	<strong>公告栏</strong>
    <p><span style="margin-right:29px;"></span><?php echo $sInfo['Board']?$sInfo['Board']:'当前暂无公告！';?></p>
</div>
<?php
	if($sInfo['isFresh']){
?>
<div class="freshNews block">
	<strong>纳新公告</strong>
    <p><span style="margin-right:29px;"></span><?php echo $fInfo['fAnn']?></p>
</div>

<div class="freshDetail block">
	<strong>纳新详情</strong>
    <p><pre id="detail"><?php echo $fInfo['fDetail']?></pre></p>
</div>
<?php
	}
	
if($isChange){
	//若被重新排版，更改报名方式
?>
<div class="method block">
	<strong>报名方式</strong>
    <p><span style="margin-right:29px;"></span>点击屏幕右上方，选择在其他浏览器中打开；</p>
    <p><span style="margin-right:29px;"></span>在新窗口中拖至页面底部，选择“申请加入”；</p>
</div>
<?php
}else{
?>
<a href="M_applyForm.php?sId=<?php echo $sId?>&sSchool=<?php echo $sInfo['sSchool']?>&fId=<?php echo $fInfo['fId']?>" id="goOn"><div class="join">申请加入</div></a>
<?php
}
?>


<?php
	if(empty($sInfo['isFresh'])){
?>
<script>
	$("#goOn").removeAttr("href");
	$("#goOn").click(function(){
		alert("当前为纳新关闭状态，暂不能申请！")
	})
</script>
<?php
	}
?>
</body>
</html>