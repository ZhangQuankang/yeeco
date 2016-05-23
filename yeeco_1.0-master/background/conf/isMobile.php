<?php
function isMobile()
{ 
foreach (getallheaders() as $name => $value) {
	if($name == "User-Agent"){
		$temp = "Apache-HttpClient";
		$isMobile = strpos($value,$temp);
		if($isMobile === false){
			return false;
		}else{
			return true;
		}
	}  
}
} 
?>