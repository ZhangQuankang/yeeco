<?php
function paging($page,$total){
//显示页数
$showPage=5;
$pageSize=12;
////总条数
//$total_sql="select count(*) from page";
//$total_result=mysql_fetch_array(mysql_query($total_sql));
//$total=$total_result[0];
//总页数
$total_pages=ceil($total/$pageSize);
//分页条
$page_banner="<div class='pageDvd'>";
//计算偏移量
$pageoffset=($showPage-1)/2;
if($page>1){
	$page_banner.="<a href='javascript:void()' onclick='paging_ajax(1,this)'>首页</a>";
	$page_banner.="<a href='javascript:void()' onclick='paging_ajax(".$page.",this)'><上一页</a>";	
}else{
	$page_banner.="<span class='disable'>首页</span>";
	$page_banner.="<span class='disable'><上一页</span>";
}
$start=1;
$end=$total_pages;
if($total_pages>$showPage){
	if($page>$pageoffset+1){
		$page_banner.="...";
	}
	if($page>$pageoffset){
		$start=$page-$pageoffset;
		$end=$total_pages>$page+$pageoffset?$page+$pageoffset:$total_pages;
	}else{
		$start=1;
		$end=$total_pages>$showPage?$showPage:$total_pages;
	}
	if($page+$pageoffset>$total_pages){
		$start=$start-($page+$pageoffset-$end);
	}
}
for($i=$start;$i<=$end;$i++){
	if($page==$i){
		$page_banner.="<span class='current'>{$i}</span>";
	}else{
		$page_banner.="<a href='javascript:void()' onclick='paging_ajax(".$i.",this)'>{$i}</a>";
	}
}
//尾部省略
if($total_pages>$showPage&&$total_pages>$page+$pageoffset){
	$page_banner.="...";
}
if($page<$total_pages){//".$url."?p=".($page+1)."
	$page_banner.="<a href='javascript:void()' onclick='paging_ajax(".$page.",this)'>下一页></a>";
	$page_banner.="<a href='javascript:void()' onclick='paging_ajax(".$total_pages.",this)'>尾页</a>";
}else{
	$page_banner.="<span class='disable'>下一页></span>";
	$page_banner.="<span class='disable'>尾页</span>";
}
$page_banner.="</div>";
return $page_banner;	
	
}


?>