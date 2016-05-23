
//获取焦点改变文本框（当前对象的父标签）边框颜色：操作的文本框
function register_text_in(x){
    x.parentNode.style.border="1px solid #00ACFF";
	switch(x.id){
		case "usertel" :$(".icon_1").css("background-position","-102px 4px");break;
		case "password1" :$(".icon_2").css("background-position","-156px 4px");break;
		case "password2" :$(".icon_3").css("background-position","-210px 4px");break;
		case "realname" :$(".icon_4").css("background-position","-264px 4px");break;
		case "school" :$(".icon_5").css("background-position","-318px 4px");break;
	}
}

//失去焦点改变文本框（当前对象的父标签）边框颜色：操作的文本框
function register_text_out(x){
     x.parentNode.style.border="1px solid #ccc";
	 switch(x.id){
		case "usertel" :$(".icon_1").css("background-position","-102px -43px");break;
		case "password1" :$(".icon_2").css("background-position","-156px -43px");break;
		case "password2" :$(".icon_3").css("background-position","-210px -43px");break;
		case "realname" :$(".icon_4").css("background-position","-264px -43px");break;
		case "school" :$(".icon_5").css("background-position","-318px -43px");break;
	}
}

//弹出全屏遮罩层
function coverall(){
	$("body").append("<div class='back'></div>");
}
//取消全屏遮罩层
function nocover(){
	$(".back").remove("");
}

// JavaScript Document
//弹出窗口：要弹出窗口的id
function newbox(wid){
	$('#'+wid).fadeIn("fast");	
}

//窗口消失：要消失窗口的id
function movebox(wid){
	$('#'+wid).fadeOut("fast");
}


//提示框消失
function disappear(x){
	document.getElementById(x).style.display="none";
}
var timer = null;
var t=60;
//执行倒计时，使strong标签中显示剩余时间
function countDown(){
    if(timer){
		clearTimeout(timer);
		timer = null;
	}	
	timer = setTimeout(function(){
		t = t-1;
		$(".time").html(t);
		if(t != 0 ){
		    countDown();
		}else{
			$("#resend").removeClass("gray");
			$("#resend").attr("href","javascript:sendcode();"); 
		}
    },1000)
}
//发送验证码
function sendcode(){
	//发送验证码
	var usertel=$("#usertel").val();
	$.ajax({
			type:"POST",
			url:"../background/background_person/form_register.php?action=testcode",
			//dataType:"json",
			data:{
				usertel:usertel,
			},
			success:function(data){
				realCode = data;
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
	//重置并开启倒计时
    $("#resend").addClass("gray");
	$("#resend").removeAttr("href"); 
	t=60;
	countDown();
}
//切换至验证页面并发送验证码
function toTest(){
	//点击注册时触发表单是否为空验证
    var usertel=$("#usertel");
	var pass_1=$("#password1");
	var pass_2=$("#password2");
	var name=$("#realname");
	var school=$("#school");
	if(usertel.val() == ""){
		error(usertel);
	}else if(aaa != ""){
		disappear('otel');
	    error(usertel);
	}else if(pass_1.val() == ""){
	    error(pass_1);
	}else if(pass_2.val() == ""){
	    error(pass_2);
	}else if(name.val() == ""){
		error(name);
	}else if(school.val() == ""){
	    error(school);
	}else{
		//所有字段都已填写清楚，继续后续操作
		$("#target_number").text(usertel.val());
		$(".register_box").css("display","none");
	    $(".test").css("display","block");
		countDown();
	}
    //******************这里需要补充发送验证码的代码
	sendcode();
	
}
//返回注册页面
function toRegister(){
    //******************这里需要补充发送验证码的代码
    $(".register_box").css("display","block");
	$(".test").css("display","none");
}


//错误提示：x表示发生错误的文本框；
function error(x){
	var objid = $(x).attr("id");

	switch(objid){
	case 'usertel':document.getElementById("span_1").style.display="block";break;
	case 'password1':document.getElementById("span_2").style.display="block";break;
	case 'password2':document.getElementById("span_3").style.display="block";break;
	case 'realname':document.getElementById("span_4").style.display="block";break;
	case 'school':document.getElementById("span_5").style.display="block";break;
	}
		
	x.value = "";
	x.focus();
}


//验证账户名是否是标准的手机号码
function checking_1(x){
	var usertel=x.value;
	var temp=usertel.substring(0,2);
	if(usertel != ""){
	if(usertel.length != 11){
		error(x);
	}else{
	    //用户名格式正确，判断该用户是否已经被注册
		$("#otel").load("../background/background_person/form_register.php",{"ousertel":usertel},function(){
			aaa = $("#otel").html();
			    if(aaa){
			        $("#otel").css("display","block");
				}
		});
	}		
	}
}

//验证密码的格式是否正确
function checking_2(x){
	var password1=x.value;
	if(password1 != ""){
	if(password1.length<6){
	    error(x);
	}	
	}
}

//验证密码是否一致
function checking_3(x){
	var password1=document.getElementById("password1").value;
	var password2=x.value;
	if(password2 != ""){
	if(password1 != password2){
		error(x);
	}	
	}
}

//选择学校
function chooseSchool(){
	coverall();
	newbox('school_box');
}

//关闭选择
function closeChoose(){
	nocover();
	movebox('school_box');	
}

$(document).ready(function(){
	//将所选择的学校名称填入表单   	
	$("#school_list ul li a").click(function (event){
	    var slected_school=$(this).text();
		$("input[name='school']").val(slected_school);
		closeChoose();
    });
});


function verify_Code(){
	var inputCode = $("#test").val();
	if(inputCode == realCode){
		document.getElementById("registerForm").submit();	
	}else{
		alert("验证码输入错误！");
	}
}