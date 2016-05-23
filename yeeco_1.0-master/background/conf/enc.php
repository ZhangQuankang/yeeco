<?php
error_reporting(E_ALL & ~E_NOTICE);
function code($str){
		$asc=array(58,59,60,61,62,63,64,91,92,93,94,95,96);
		$temp=rand(65,90);
		$strs="";
		$strs.=chr($temp);
		$k="";
		$flag=false;
		for($i=0;$i<=10;$i++){
			for($j=0;$j<=12;$j++){
				if(($str[$i]+$temp) == $asc[$j]){
					$strs.=chr($str[$i]+$temp+16);
					$k.=$i;
					$flag=true;
					break;
					}
			}
			if(!$flag){
				$strs.=chr($str[$i]+$temp);
			}else{
				$flag=false;
			}
		}
		if($k != "" && $k[strlen($k)-1]=='0'){
			$k[strlen($k)-2]='@';
			$k=substr($k,0,strlen($k)-1);
			}	
		return $strs.$k;		
}
function decode($str){
		$temp="";
		$strs="";
		$k="";
		$code="";
		$flag=false;
		$temp=ord(substr($str,0,1));
		$strs=substr($str,1,11);
		$k=substr($str,12);//print_r($k);exit;
		if($k != "" && $k[strlen($k)-1]=='@'){
			
			$flag1=true;
		}else{
			$flag1=false;		
		}
		for($i=0;$i<=10;$i++){
			if($k != ""){
				for($j=0;$j<=strlen($k)-1;$j++){
					if(strval($i) == $k[$j]){
						$code.=ord($strs[$i])-$temp-16;
						$flag=true;
						break;
					}
				}	
			}
			if($i==10 && $flag1){
				$code.=ord($strs[$i])-$temp-16;
				$flag=true;
			}
			
			if(!$flag){
				$code.=ord($strs[$i])-$temp;
			}else{
				$flag=false;		
			}
		}
	return $code;
}
?>