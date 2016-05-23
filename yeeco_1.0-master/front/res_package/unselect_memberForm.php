<?php
	error_reporting(E_ALL & ~E_NOTICE);
	require_once('../../background/conf/connect.php');
	$aId = $_POST['aId'];
	$left_aId = $_POST['left_aId'];
	$right_aId = $_POST['right_aId'];
	$sName = $_POST['sName'];
	$fQue_1 = $_POST['fQue_1'];
	$fQue_2 = $_POST['fQue_2'];
	$fQue_3 = $_POST['fQue_3'];

	//print_r(strpos($aIds,$aId));exit;
	//查询成员报名信息
	$aInfo=mysql_fetch_assoc(mysql_query("select * from apply_information_unselected where aId='$aId'"));
	if(!$aInfo){
		echo "no_member";
	}
?>
<strong><?php  echo $sName?>报名表<a href="">&times;</a></strong>
<form action="background/society-apply-form.php" method="post" name="apply_table">
<input type="hidden" name="aId"  value="<?php echo $aId?>"/>
<table cellspacing="0">
  <tr>
    <td width=80>姓名</td>
    <td width=120><input type="text" name="aName" readonly="readonly" value="<?php echo $aInfo['aName']?>"/></td>
    <td width=80>性别</td>
    <td width=120><input type="text" name="aSex" readonly="readonly" value="<?php echo $aInfo['aSex']?>"/></td>
    <td width=100 rowspan="4" class="photo"></td>
  </tr>
  <tr>
    <td>出生年月</td>
    <td><input type="text" name="aBirthday" readonly="readonly" value="<?php echo $aInfo['aBirthday']?>"/></td>
    <td>籍贯</td>
    <td><input type="text" name="aNative" readonly="readonly" value="<?php echo $aInfo['aNative']?>"/></td>
  </tr>
  <tr>
    <td>专业班级</td>
    <td><input type="text" name="aClass" readonly="readonly" value="<?php echo $aInfo['aClass']?>"/></td>
    <td>联系电话</td>
    <td><input type="text" name="aTel" readonly="readonly" value="<?php echo $aInfo['aTel']?>"/></td>
  </tr>
  <tr>
    <td>个人邮箱</td>
    <td><input type="text" name="aEmail" readonly="readonly" value="<?php echo $aInfo['aEmail']?>"/></td>
    <td>QQ</td>
    <td><input type="text" name="aQQ" readonly="readonly" value="<?php echo $aInfo['aQQ']?>"/></td>
  </tr>
  <tr>
    <td>兴趣爱好</td>
    <td colspan="4"><input type="text" name="aFavor" style="width:100%;" readonly="readonly" value="<?php echo $aInfo['aFavor']?>"/></td>
  </tr>
  <tr>
    <td>特长优势</td>
    <td colspan="4"><input type="text" name="aStrong" style="width:100%;" readonly="readonly" value="<?php echo $aInfo['aStrong']?>"/></td>
  </tr>
  <tr>
    <td colspan="5">
    <p>1、<?php echo $fQue_1?></p>
    <textarea name="aAnser_1" readonly="readonly"><?php echo $aInfo['aAnser_1']?></textarea>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <p>2、<?php echo $fQue_2?></p>
    <textarea name="aAnser_2" readonly="readonly"><?php echo $aInfo['aAnser_2']?></textarea>
    </td>
  </tr>   
  <tr>
    <td colspan="5">
    <p>3、<?php echo $fQue_3?></p>
    <textarea name="aAnser_3" readonly="readonly"><?php echo $aInfo['aAnser_3']?></textarea>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <div class="form_remark">
  	  <span>备注：</span><input type="text" name="remark" required="required"  placeholder="点此编辑成员备注" value="<?php echo $aInfo['aRemark']?>" onBlur="save_remark(this)"/>
      <a href="javascript:save_2()" style="" id="a2">保存</a>
    </div>
    </td>
  </tr>
</table>
<div class="handle" style="margin:0 auto;width:340px;">
	<a href="javascript:void(0)" onClick="delete_form_app(this)" id="h1">删除</a><a href="massageBox.php?chooseToId=<?php echo $aInfo['uId']?>" id="h3">发送通知</a><a href="javascript:void(0)" onClick="employ_form_app(this)" id="h4">录用</a>
</div>
         <div style="clear:both;"></div> 
</form>
    <div style="clear:both;"></div>    

<a href="javascript:void(0)" class="turn_left" onclick="next_page(<?php echo $left_aId?>)">&lt;</a>
<a href="javascript:void(0)" class="turn_right" onclick="next_page(<?php echo $right_aId?>)">&gt;</a>