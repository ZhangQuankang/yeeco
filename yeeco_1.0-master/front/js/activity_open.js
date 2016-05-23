// JavaScript Document

//点击触发表单验证并实现页面跳转
function page_to(page_a,page_b){
	document.getElementById(page_a).style.display="";
	document.getElementById(page_b).style.display="none"; 
	document.getElementById("contact_title").getElementsByTagName("li").item(page_a).className = 'on';
	document.getElementById("contact_title").getElementsByTagName("li").item(page_b).className = ''; 
}


//异步提交表单能功\
activity_form_lock=0;
function aSubmit(){
	if(activity_form_lock==0){
		activity_form_lock=1;
	   $("#activity_form").ajaxSubmit(function(data){
		   activity_form_lock=0;
			page_to('3','2');
			data=data.split('&');
			data1=data[0].substr(3);
			data2=data[1];
			var sId = $('[name="sId"]').val();
			$("#qrcode").attr("src",data1);
			$("#activity_detail").attr("href","activity_detail.php?actId="+data2+"&sId="+sId);
		})
	}
}
//是否需要报名 
function need_app(){
	var temp = $('[name="apply"]').val();
	if(temp == "需要报名"){
		$("#cover_app_time").hide();
	}else{
		$("#cover_app_time").show();
	}
}

//检查第二页的表单是否填写完整
function check_page(){
	var temp = $('[name="apply"]').val();
	var temp_1 = $('[name="activity_name"]').val();
	var temp_2 = $('[name="begin_date_apply"]').val();
	var temp_3 = $('[name="begin_time_apply"]').val();
	var temp_4 = $('[name="end_date_apply"]').val();
	var temp_5 = $('[name="end_time_apply"]').val();
	var temp_6 = $('[name="begin_date"]').val();
	var temp_7 = $('[name="begin_time"]').val();
	var temp_8 = $('[name="end_date"]').val();
	var temp_9 = $('[name="end_time"]').val();
	var temp_10 = $('[name="activity_place"]').val();
	var temp_11 = $('[name="describe"]').val();
	switch(""){
	case temp_1: $('[name="activity_name"]').css("border","1px solid #f00");break;
	case temp_6: $('[name="begin_date"]').css("border","1px solid #f00");break;
	case temp_7: $('[name="begin_time"]').css("border","1px solid #f00");break;
	case temp_8: $('[name="end_date"]').css("border","1px solid #f00");break;
	case temp_9: $('[name="end_time"]').css("border","1px solid #f00");break;
	case temp_10: $('[name="activity_place"]').css("border","1px solid #f00");break;
	case temp_11: $('[name="describe"]').css("border","1px solid #f00");break;
	}
	if(temp_1 && temp_6 && temp_7 && temp_8 && temp_9 && temp_10 && temp_11){
		if(temp == "需要报名"){
			switch(""){
				case temp_2: $('[name="begin_date_apply"]').css("border","1px solid #f00");break;
				case temp_3: $('[name="begin_time_apply"]').css("border","1px solid #f00");break;
				case temp_4: $('[name="end_date_apply"]').css("border","1px solid #f00");break;
				case temp_5: $('[name="end_time_apply"]').css("border","1px solid #f00");break;
			}
			if(temp_2 && temp_3 && temp_4 && temp_5){
				page_to('2','1');
			}
		}else{
			page_to('2','1');	
		}
	}
}
