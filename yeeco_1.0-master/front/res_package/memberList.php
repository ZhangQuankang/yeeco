<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../background/conf/connect.php');
$sId=$_POST['sId'];
$depName=$_POST['depName'];

//获取已激活用户社团关系信息
$user_society_r=mysql_query("select userId,isManage,depBelong,position from user_society_relation where societyId='$sId' and depBelong='$depName' limit 0,10");
if($user_society_r && mysql_num_rows($user_society_r)){
	    while($row = mysql_fetch_assoc($user_society_r)){			
			$user_r[]=$row;
			$uInfo[]=mysql_fetch_assoc(mysql_query("select userFace from user where uId='$row[userId]'"));
			$ueInfo[]=mysql_fetch_assoc(mysql_query("select userName,userTel,userSex,userClass from userextrainfo where uId='$row[userId]'"));
		}
}
?>
<ul class="table">
                <li><span>选择</span><span>姓名</span><span>专业班级</span><span>手机号码</span><span>部门</span><span>职位</span><span>操作</span></li>
<?php 
		$i=0;$j=0;
		if($user_r){
			foreach($user_r as $value_2){
				if($depName=='0'){
					$depName='未分配';
				}
?>				
                <li>
                <span><input type="checkbox" id="<?php echo $value_2['userId']?>" value="<?php echo $value_2['userId']?>" name="member_<?php echo $depName?>[]" onclick="choose(this)"/></span><span><img src="../<?php echo $uInfo[$i]['userFace']?>"/><?php echo $ueInfo[$i]['userName']?>&nbsp;&nbsp;<?php echo $ueInfo[$i]['userSex']?></span><span><?php echo $ueInfo[$i]['userClass']?></span><span><?php echo $ueInfo[$i]['userTel']?></span><span><?php echo $depName?></span><span class="limit"><?php echo $value_2['position']?></span><span class="cap"><a href="javascript:void(0)" class="table_b" onclick="delete_one(this)">删除</a><a href="javascript:void(0)" class="table_c" onclick="change_oneDep(this)">调换部门</a><a href="javascript:void(0)" class="table_d" onclick="send_oneMsg(this)">发送通知</a></span>
                             
                </li>
<?php 
				$i++;
			}
		}	
?>     
<input type="hidden" class="i" value="<?php echo $i?>"/>
<input type="hidden" class="j" value="<?php echo $j?>"/>
                <li><span><input type="checkbox" class="check_all" id="all_<?php echo $depName?>" value="<?php echo $depName?>" onclick="choose(this)"/></span><span style="border-right:0;"><label for="all_<?php echo $depName?>">全选</label></span><a href="javascript:void()" class="load_more" onclick="add_moreMember(this)">加载更多<i></i></a></li>
              </ul>
        	  <div class="handle">
                <p>操作：</p><a href="javascript:void(0)" id="h1" class="h1" onclick="delete_many(this)">删除</a><a href="javascript:void(0)" id="h2" class="h2"onclick='change_manyDep(this)'>调换部门</a><a href="javascript:void(0)" id="h3" class="h3" onclick="send_manyMsg(this)">发送通知</a>
              </div>
            <div style="clear:both;"></div>
<script>
	//权限管理
	if($('#authority').val()=='成员'){
		$(".table_b").remove();
		$(".table_c").remove();
		$(".h1").remove();
		$(".h2").remove();
		$(".h3").css({
			"margin":"0 65px",
			"width":"200px"
		});
	}
</script>