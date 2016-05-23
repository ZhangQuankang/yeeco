<?php
/**活动列表
*请求我所在学校的所有活动；
*1.所需要的参数：学校名称
*2.返回值：该学校的所有活动信息；
*/
	error_reporting(E_ALL & ~E_NOTICE);
	require_once('../conf/connect.php');
	require_once('../conf/json_port.php');
	
	$sSchool= $_POST['sSchool'];

	$query=mysql_query("select actId,actName,actImg,actBeginDate,actBeginTime,actPlace,actDesc,actNum,actFocusNum from society_act_open where actSchool='$sSchool' order by setTime desc");

	if($query && mysql_num_rows($query)){
		while($row = mysql_fetch_assoc($query)){
			$allActivity[]= array(
				'actId' => $row['actId'],
				'actName' => $row['actName'],
				'actImg' => $row['actImg'],
				'actTime' => $row['actBeginDate'].' '.$row['actBeginTime'],
				'actPlace' => $row['actPlace'],
				'actDesc' => $row['actDesc'],
				'actNum' => $row['actNum'],
				'actFocusNum' => $row['actFocusNum']
			);
		}			
	}else{
		$allActivity =  array();
	}
	//echo "<pre>";
	//print_r($allActivity);
	Response::json(219,'该学校的所有活动列表如下',$allActivity);	
?>