<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../background/conf/connect.php');
$sId=$_POST['sId'];
$uId=$_POST['uId'];
$fId=$_POST['fId'];
$sName=$_POST['sName'];
$fQue_1=$_POST['fQue_1'];
$fQue_2=$_POST['fQue_2'];
$fQue_3=$_POST['fQue_3'];
//查找用户信息表
$uInfo=mysql_fetch_array(mysql_query("select * from userextrainfo where uId='$uId'"));
//查找部门信息
$dep=mysql_query("SELECT depName FROM department WHERE societyId='$sId'");
if($dep && mysql_num_rows($dep)){
	    while($row = mysql_fetch_assoc($dep)){
			//$dId[]=$row['dId'];
			$depName[]=$row['depName'];
		}			
}
?>

	<strong><?php echo $sName?>&nbsp;·&nbsp;报名表<a href="javascript:return_main()">&times;</a></strong>
      <label><span>*</span>填写报名表：</label>
<form action="../background/background_society/society_apply_form.php" method="post" name="apply_table" id="apply_table">
       <input type="hidden" name="sId" value="<?php echo $sId?>">
       <input type="hidden" name="uId" value="<?php echo $uId?>">
       <input type="hidden" name="fId" value="<?php echo $fId?>">
<table cellspacing="0">
  <tr>
    <td width=80>姓名</td>
    <td width=120><input type="text" name="aName" required="required" value="<?php echo $uInfo['userName']?>"/></td>
    <td width=80>性别</td>
    <td width=120><input type="text" name="aSex" required="required" value="<?php echo $uInfo['userSex']?>"/></td>
    <td width=100 rowspan="4" class="photo">
      <img id="pre_img"/>
      <input type="file" class="file" name="pic" id="pic" onchange="setImagePreviews()"/>
      <input type='button'/>
	</td>
  <tr>
    <td>出生年月</td>
    <td><input type="text" name="aBirthday" placeholder="格式：yyyy-m-d" value="<?php echo $uInfo['userBirth']?>"/></td>
    <td>籍贯</td>
    <td><input type="text" name="aNative" placeholder="格式：省份-地级市" value="<?php echo $uInfo['userPlace']?>"/></td>
  </tr>
  <tr>
    <td>专业班级</td>
    <td><input type="text" name="aClass" required="required" value="<?php echo $uInfo['userClass']?>"/></td>
    <td>联系电话</td>
    <td><input type="text" name="aTel" required="required" readonly="readonly" value="<?php echo $uInfo['userTel']?>"/></td>
  </tr>
  <tr>
    <td>个人邮箱</td>
    <td><input type="text" name="aEmail" value="<?php echo $uInfo['userEmail']?>"/></td>
    <td>QQ</td>
    <td><input type="text" name="aQQ" value="<?php echo $uInfo['userQQ']?>"/></td>
  </tr>
  <tr>
    <td>兴趣爱好</td>
    <td colspan="4"><input type="text" name="aFavor" style="width:100%;"/></td>
  </tr>
  <tr>
    <td>特长优势</td>
    <td colspan="4"><input type="text" name="aStrong" style="width:100%;"/></td>
  </tr>
  <tr>
    <td colspan="5">
    <p>1、<?php echo $fQue_1?></p>
    <textarea name="aAnser_1"></textarea>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <p>2、<?php echo $fQue_2?></p>
    <textarea name="aAnser_2"></textarea>
    </td>
  </tr>   
  <tr>
    <td colspan="5">
    <p>3、<?php echo $fQue_3?></p>
    <textarea name="aAnser_3"></textarea>
    </td>
  </tr>
</table>
<label><span>*</span>选择部门：</label>
<select name="department">
                <option value="0">任意部门</option>
<?php
	for($i=0;$i<=sizeof($depName)-1;$i++){
?>
                <option value="<?php echo $depName[$i]?>"><?php echo $depName[$i]?></option>
<?php
}
?>
            </select>
<input type="button" value="提交" class="button" onclick="applySubmit()">
         <div style="clear:both;"></div> 
</form>
    <div style="clear:both;"></div>