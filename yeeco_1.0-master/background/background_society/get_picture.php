<?php

	error_reporting(E_ALL & ~E_NOTICE);
//生成唯一字符串的文件名
	function getUniName(){
	    return md5(uniqid(microtime(true),true));	
	}
	//得到文件的后缀名
	function getExt($filename){
		$t=explode(".",$filename);
	    return strtolower(end($t));
	}	
function getImg($folder){
	//把传递来的信息入库;
	$filename = $_FILES['pic']['name'];
	if($filename){
		$type = $_FILES['pic']['type'];
		$tmp_name = $_FILES['pic']['tmp_name'];
		$errow = $_FILES['pic']['errow'];
		$size = $_FILES['pic']['size'];
		$allowExt = array("gif","jpeg","jpg","png","wbmp");
		$maxSize = 1048576;
		if($errow == UPLOAD_ERR_OK){
			$ext = getExt($filename);
			$filename = getUniName().".".$ext;
			$destination = $folder."/".$filename;	
			//限制上传文件的类型
			if(!in_array($ext,$allowExt)){
				
				exit('非法文件类型！'); 
			}
			if($size>$maxSize){
				exit('文件过大！'); 
			}
				if(is_uploaded_file($tmp_name)){
					if(move_uploaded_file($tmp_name,$destination)){
						if(strpos($destination,'defined_face')){
							Img($destination,70,70,1);
						}else if(strpos($destination,'fresh') || strpos($destination,'activity')){
							Img($destination,600,340,1);
						}else{
							
							Img($destination,130,130,1);
						}
						
						return  $destination;
					}else{
						echo "<script>alert('文件移动失败！')</script>";
					}
				}else{
					echo "<script>alert('文件上传方式错误！')</script>";
				}
			
		}else{
			echo "<script>alert('图片上传错误！');window.location.href='../../front/society_establish.php'</script>";
		}
	}else{
		return NULL;
	}
}
?>