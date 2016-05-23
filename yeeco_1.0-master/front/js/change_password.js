// JavaScript Document// JavaScript Document
//更改绑定的手机号码
function change_tel(){
	$("#sendcode").css("display","block");
	$("[name='userTel']").removeAttr("readonly"); 
	$("[name='userTel']").val("");
	$("[name='userTel']").focus();
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
		$("#onsend").val("剩余"+t+"秒");
		if(t != 0 ){
		    countDown();
		}else{
			t=60;
			$("#onsend").val("重发验证码");
			$("#onsend").attr("onclick","checking_find()");
			$("#onsend").removeClass("disabled");
			$("#onsend").addClass("button");
		}
    },1000)
}


//提示框消失
function disappear(x){
	document.getElementById(x).style.display="none";
	$("#span_4").hide();
}

//错误提示：x表示发生错误的文本框；
function error(x){
	var objid = $(x).attr("name");
	switch(objid){
	case 'userTel':$("#span_4").css("display","block");break;
	case 'password_old':$("#span_1").css("display","block");break;
	case 'password_1':$("#span_2").css("display","block");break;
	case 'password_2':$("#span_3").css("display","block");break;
	}
		
	x.value = "";
	x.focus();
}
//验证密码是否正确
function password_test(){
	var usertel=$("[name='userTel']").val();
	var password_old=$("[name='password_old']").val();
	//***************在这里执行与后台交互的查询操作,提交“当前密码”，通过session保存的id与其进行匹配
	$("#span_1").load("../background/background_person/modify_userinfo.php?action=isright",{"password_old":password_old},function(){
		bbb = $("#span_1").html();
		    if(bbb){
			        $("#span_1").css("display","block");
				}
		});
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
	var password1=$("[name='password_1']").val();
	var password2=x.value;
	if(password2 != ""){
	    if(password1 != password2){
		    error(x);
	    }	
	}
}

//验证账户名是否是标准的手机号码
function checking_find(){
	var usertel=$("[name='usertel']").val();
	var x=$("[name='usertel']");
	var temp=usertel.substring(0,2);
	if(usertel != ""){
	if(usertel.length != 11){
		error(x);
	}else if(temp!="14" && temp!="13" && temp!="15" && temp!="18"){
	    error(x);
	}else{
	    //用户名格式正确，判断该用户是否存在
		//*************************************************************************

		$("#otel").load("../background/background_person/isExistUser.php",{"ousertel":usertel},function(){
			ddd = $("#otel").text();
			if(ddd){
		       $("#otel").css("display","block");
			}else{
				//用户存在，则发送验证码
				send_findcode();
			}
		});
	}		
	}
}

//找回密码，发送验证码
function send_findcode(){
	var usertel = $("[name='usertel']").val();
	$.ajax({
		type:"POST",
		url:"../background/background_person/form_register.php?action=testcode",
		//dataType:"json",
		data:{
			usertel:usertel,
		},
		async:false,
		success:function(data){
			realCode = data;
			//alert(realCode);
		},
		error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})
     //发送验证码
	$("#onsend").val("重发验证码");
	$("#onsend").removeAttr("onclick");
	$("#onsend").removeClass("button");
	$("#onsend").addClass("disabled");
	countDown();
}


function verify_Code(){
	var inputCode = $("#test").val();
	if(inputCode == realCode){
		document.getElementById('tel_form').submit();
	}else{
		alert("验证码输入错误！");
	}
}

