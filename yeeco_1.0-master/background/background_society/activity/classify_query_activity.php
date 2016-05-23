<?php
/**
*活动搜索--模糊查询
*/
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../conf/connect.php');
require_once('../../conf/paging.php');
$action=$_GET['action'];
if($action=='search'){
	$school=$_GET['school'];
	$words=$_POST['words'];
	$query=mysql_query("select * from society_act_open where actName like '%$words%' and actSchool='$school' union select * from society_act_closed where actName like '%$words%' and actSchool='$school'");
	if($query && mysql_num_rows($query)){
    	while($row = mysql_fetch_assoc($query)){
			$actInfo[]=$row;
		}			
	}
	if($actInfo){
		foreach($actInfo as $value){
			//查找该活动所属的社团
			$sName=mysql_fetch_assoc(mysql_query("select sName from society where sId='$value[sId]'"));
			echo "<ul>
                    <li class='course-one'>
                      <a href='activity_visitor.php?actId=".$value['actId']."'>
                        <div class='course-list-img'>
                        	<img src='".substr($value['actImg'],3)."'/>
                        </div>
                        <h5>
                            <span>".$value['actName']."</span>
                        </h5>
                        <div class='tips'>
                        	<p><label style='color:#999;'>社团：</label><span style='color:#333;'>".$sName['sName']."</span></p>
                        	<p><label>类型：</label><span>".$value['actType']."/".$value['isApply']."/".$value['actRange']."</span></p>
                      		<p><label>时间：</label><span style='color:#333;'>".$value['actBeginDate']."&nbsp;".$value['actBeginTime']."&nbsp;&nbsp;~&nbsp;&nbsp;".$value['actEndDate']."&nbsp;".$value['actEndTime']."</span></p>
                      		<p><label>地点：</label><span style='color:#333;'>".$value['actPlace']."</span></p>
                      		<p><label>简介：</label><span class='des'>".$value['actDesc']."</span></p>
                            <p class='number'><strong>.".$value['actNum']."</strong>人报名&nbsp;<strong>".$value['actFocusNum']."</strong>人关注</p>
                       	</div>
                      </a>
                    </li>
				  </ul>";
		}
	}
	echo '@'.count($actInfo);
	exit;
}
//分类查找
if($action=='precise_search'){
	//传入页码
    $page=$_GET['p'];
	$pageSize=12;
	//获取属性
	$going=$_POST['going'];
	$type=$_POST['type'];
	$status=$_POST['status'];
	$school=$_POST['school'];
	if($going=='全部' && $type=='全部'){
		if($status=='最新'){
			$total_result=mysql_fetch_array(mysql_query("select count(*) as n1,(select count(*) from society_act_open where actSchool='$school') as n2 from society_act_closed  where actSchool='$school'"));
			$total=$total_result[0]+$total_result[1];
			$query=mysql_query("select * from society_act_open where actSchool='$school' union
select * from society_act_closed where actSchool='$school' order by setTime desc limit ".($page-1)*$pageSize .",{$pageSize}");
		}
		if($status=='最热'){
			$total_result=mysql_fetch_array(mysql_query("select count(*) as n1,(select count(*) from society_act_open where actSchool='$school') as n2 from society_act_closed  where actSchool='$school'"));
			$total=$total_result[0]+$total_result[1];
			$query=mysql_query("select * from society_act_closed where actSchool='$school' union
select * from society_act_open where actSchool='$school' order by actNum desc limit ".($page-1)*$pageSize .",{$pageSize}");
		}
	}else if($going=='全部' && $type!='全部'){
		if($status=='最新'){
			$total_result=mysql_fetch_array(mysql_query("select count(*) as n1,(select count(*) from society_act_open where actSchool='$school' and actType like '%$type%') as n2 from society_act_closed  where actSchool='$school' and actType like '%$type%'"));
			$total=$total_result[0]+$total_result[1];
			$query=mysql_query("select * from society_act_closed where actSchool='$school' and actType like '%$type%' union
select * from society_act_open where actSchool='$school' and actType like '%$type%' order by setTime desc limit ".($page-1)*$pageSize .",{$pageSize}");
		}
		if($status=='最热'){
			$total_result=mysql_fetch_array(mysql_query("select count(*) as n1,(select count(*) from society_act_open where actSchool='$school' and actType like '%$type%') as n2 from society_act_closed  where actSchool='$school' and actType like '%$type%'"));
			$total=$total_result[0]+$total_result[1];
			$query=mysql_query("select * from society_act_closed where actSchool='$school' and actType like '%$type%' union
select * from society_act_open where actSchool='$school' and actType like '%$type%' order by actNum desc limit ".($page-1)*$pageSize .",{$pageSize}");
		}
	}else if($going=='正在进行' && $type=='全部'){
		if($status=='最新'){
			$total_result=mysql_fetch_array(mysql_query("select count(*) from society_act_open where actSchool='$school'"));
			$total=$total_result[0];
			$query=mysql_query("select * from society_act_open where actSchool='$school' order by setTime desc limit ".($page-1)*$pageSize .",{$pageSize}");
		}
		if($status=='最热'){
			$total_result=mysql_fetch_array(mysql_query("select count(*) from society_act_open where actSchool='$school'"));
			$total=$total_result[0];
			$query=mysql_query("select * from society_act_open where actSchool='$school' order by actNum desc limit ".($page-1)*$pageSize .",{$pageSize}");
		}
	}else if($going=='正在进行' && $type!='全部'){
		if($status=='最新'){
			$total_result=mysql_fetch_array(mysql_query("select count(*) from society_act_open where actSchool='$school' and actType like '%$type%'"));
			$total=$total_result[0];
			$query=mysql_query("select * from society_act_open where actSchool='$school' and actType like '%$type%' order by setTime desc limit ".($page-1)*$pageSize .",{$pageSize}");
		}
		if($status=='最热'){
			$total_result=mysql_fetch_array(mysql_query("select count(*) from society_act_open where actSchool='$school' and actType like '%$type%'"));
			$total=$total_result[0];
			$query=mysql_query("select * from society_act_open where actSchool='$school' and actType like '%$type%' order by actNum desc limit ".($page-1)*$pageSize .",{$pageSize}");
		}
	}else if($going=='已经结束' && $type=='全部'){
		if($status=='最新'){
			$total_result=mysql_fetch_array(mysql_query("select count(*) from society_act_closed where actSchool='$school'"));
			$total=$total_result[0];
			$query=mysql_query("select * from society_act_closed where actSchool='$school' order by setTime desc limit ".($page-1)*$pageSize .",{$pageSize}");
		}
		if($status=='最热'){
			$total_result=mysql_fetch_array(mysql_query("select count(*) from society_act_closed where actSchool='$school'"));
			$total=$total_result[0];
			$query=mysql_query("select * from society_act_closed where actSchool='$school' order by actNum desc limit ".($page-1)*$pageSize .",{$pageSize}");
		}
	}else if($going=='已经结束' && $type!='全部'){
		if($status=='最新'){
			$total_result=mysql_fetch_array(mysql_query("select count(*) from society_act_closed where actSchool='$school' and actType like '%$type%'"));
			$total=$total_result[0];
			$query=mysql_query("select * from society_act_closed where actSchool='$school' and actType like '%$type%' order by setTime desc limit ".($page-1)*$pageSize .",{$pageSize}");
		}
		if($status=='最热'){
			$total_result=mysql_fetch_array(mysql_query("select count(*) from society_act_closed where actSchool='$school' and actType like '%$type%'"));
			$total=$total_result[0];
			$query=mysql_query("select * from society_act_closed where actSchool='$school' and actType like '%$type%' order by actNum desc limit ".($page-1)*$pageSize .",{$pageSize}");
		}
	}
	if($query && mysql_num_rows($query)){
		while($row = mysql_fetch_assoc($query)){
			$actInfo[]=$row;
		}			
	}
	if($actInfo){
		foreach($actInfo as $value){
			//查找该活动所属的社团
			$sName=mysql_fetch_assoc(mysql_query("select sName from society where sId='$value[sId]'"));
			echo "<ul>
                    <li class='course-one'>
                      <a href='activity_visitor.php?actId=".$value['actId']."'>
                        <div class='course-list-img'>
                        	<img src='".substr($value['actImg'],3)."'/>
                        </div>
                        <h5>
                            <span>".$value['actName']."</span>
                        </h5>
                        <div class='tips'>
                        	<p><label style='color:#999;'>社团：</label><span style='color:#333;'>".$sName['sName']."</span></p>
                        	<p><label>类型：</label><span>".$value['actType']."/".$value['isApply']."/".$value['actRange']."</span></p>
                      		<p><label>时间：</label><span style='color:#333;'>".$value['actBeginDate']."&nbsp;".$value['actBeginTime']."&nbsp;&nbsp;~&nbsp;&nbsp;".$value['actEndDate']."&nbsp;".$value['actEndTime']."</span></p>
                      		<p><label>地点：</label><span style='color:#333;'>".$value['actPlace']."</span></p>
                      		<p><label>简介：</label><span class='des'>".$value['actDesc']."</span></p>
                            <p class='number'><strong>".$value['actNum']."</strong>人报名&nbsp;<strong>".$value['actFocusNum']."</strong>人关注</p>
                       	</div>
                      </a>
                    </li>
				  </ul>";	
		}	
	}
	echo '@'.$total.'@'.paging($page,$total);
	exit;
}
?>