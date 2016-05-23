<?php
/**社团列表
*请求我所在学校的所有社团；
*1.所需要的参数：学校名称
*2.返回值：该学校的所有社团信息；
*/
	error_reporting(E_ALL & ~E_NOTICE);
	require_once('../conf/connect.php');
	require_once('../conf/json_port.php');
	
	$sSchool = $_POST['sSchool'];

	$query=mysql_query("select sId,sName,sCate,sDesc,sNum,sImg from society where sSchool='$sSchool'");
	if($query && mysql_num_rows($query)){
		while($row = mysql_fetch_assoc($query)){
			$allSociety[]=$row;
		}			
	}else{
		$allSociety =  array();
	}
	
	Response::json(221,'该学校的所有社团列表如下',$allSociety);	
?>