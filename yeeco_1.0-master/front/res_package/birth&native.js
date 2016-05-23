// JavaScript Document

//判断是否是有31天的月份
function judge_day(){
	var month = $("#birthmonth").val();
	if( month=="1" || month=="3" || month=="5" || month=="7" || month=="8" || month=="10" || month=="12"){
		$("option[value='31']").show();
	}
	if( month=="2" || month=="4" || month=="6" || month=="9" || month=="11"){
	     $("option[value='31']").hide();
	}
}
//加载该省份的所有城市
function load_city(){
	var pro = $("#native_por").val();
	$("#native_city").load("res_package/city_list.php",{"pro":pro});
}


$(document).ready(function(){
  //点击省份的时候加载城市
	$("#native_por").change(function (){
	    load_city();
    });
	//点击月份的时候加载日期
	$("#birthmonth").change(function (){
	    judge_day();
    });
});

