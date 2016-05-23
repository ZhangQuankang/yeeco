<?php
function send_sysMsg($targetId,$data,$type){	
	switch($type){
		case 'joinSociety':
			$sName=mysql_fetch_assoc(mysql_query("select sName from society where sId='$data[sId]'"));
			$sName=$sName['sName'];
			$msgBody='您成功加入了'.$sName.',现在是其'.$data['depName'].'的'.$data['position'].'。您可以在“我的社团”下点击此社团进入社团主页。';	
			$msgTime = time();		
			mysql_query("insert into message(msgToId,msgFromId,msgBody,msgTime) values('$targetId','0','$msgBody','$msgTime')");
			break;
		case 'exitSociety':
			$sName=mysql_fetch_assoc(mysql_query("select sName from society where sId='$data[sId]'"));
			$sName=$sName['sName'];
			$msgBody='很遗憾的告诉您，您被请出了 '.$sName.' 。';
			$msgTime = time();	
			mysql_query("insert into message(msgToId,msgFromId,msgBody,msgTime) values('$targetId','0','$msgBody','$msgTime')");
			break;
		case 'ex_SocietyDep':
			$sName=mysql_fetch_assoc(mysql_query("select sName from society where sId='$data[sId]'"));
			$sName=$sName['sName'];
			$msgBody='您被 '.$sName.' 社团调换到了'.$data['depName'].'。';
			$msgTime = time();	
			mysql_query("insert into message(msgToId,msgFromId,msgBody,msgTime) values('$targetId','0','$msgBody','$msgTime')");
			break;
		case 'employSociety':
			$sName=mysql_fetch_assoc(mysql_query("select sName from society where sId='$data[sId]'"));
			$sName=$sName['sName'];
			$msgBody='恭喜您，您已成功被录取加入'.$sName.'的'.$data['sDep'];
			$msgTime = time();	
			mysql_query("insert into message(msgToId,msgFromId,msgBody,msgTime) values('$targetId','0','$msgBody','$msgTime')");
			break;
		case 'unemploySociety':
			$sName=mysql_fetch_assoc(mysql_query("select sName from society where sId='$data[sId]'"));
			$sName=$sName['sName'];
			$msgBody='很遗憾，您没有通过筛选，未能成功加入'.$sName.'。';
			$msgTime = time();	
			mysql_query("insert into message(msgToId,msgFromId,msgBody,msgTime) values('$targetId','0','$msgBody','$msgTime')");
			break;
	}
}

?>