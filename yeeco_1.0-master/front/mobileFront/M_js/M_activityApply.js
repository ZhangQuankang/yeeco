// JavaScript Document// JavaScript Document

function findUser(){	
	if($('[name="aName"]').val()==""){
		alert("用户名不能为空！");	
	}else if($('[name="aTel"]').val()==""){
		alert("电话号码不能为空！");
	}else if($('[name="aClass"]').val()==""){
		alert("专业班级不能为空！");
	}else{
		$(".isSubmitting").show();
		//验证用户身份（是否是注册用户）
		$.ajax({
			type:"POST",
			url:"../../background/web_app/M_activityApplyB.php",
			data:{
				ousertel:$('[name="aTel"]').val(),
				actId:$('[name="actId"]').val(),
			},
			//dataType:,
			async:false,
			success:function(data){
				$(".isSubmitting").hide();
				checkUser(data);
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})
	}
}

function checkUser(data){
			if(data == 200){
				$("#userName_1").text($('[name="aName"]').val())
				$("#userTel_1").text($('[name="aTel"]').val())
				$('[name="state"]').val('200');
				$("#index_1").hide();
				$("#index_2").show();
			}else if(data == 201){
				$("#userName_2").text($('[name="aName"]').val())
				$("#userTel_2").text($('[name="aTel"]').val())
				$('[name="state"]').val('201');
				//请求发送验证码
				request_code();
				$("#index_1").hide();
				$("#index_3").show();
			}else if(data == 202){
				$("#userName_2").text($('[name="aName"]').val())
				$("#userTel_2").text($('[name="aTel"]').val())
				$('[name="state"]').val('202');
				//请求发送验证码
				request_code();
				$("#index_1").hide();
				$("#index_3").show();
			}else if(data == 203){
				alert("您已经报过名了！");
			}else{
				alert("操作失败，未知错误，请联系客服！");
			}
}
		
//执行倒计时，使strong标签中显示剩余时间
var timer = null;
var t=60;
function countDown(){
	$(".reSend").attr("onclick","");
    if(timer){
		clearTimeout(timer);
		timer = null;
	}	
	timer = setTimeout(function(){
		t = t-1;
		$(".reSend").html("剩余"+t+"秒");
		if(t != 0 ){
		    countDown();
		}else{
			t=60;
			$(".reSend").attr("onclick","request_code()");
			$(".reSend").text("重新发送");
		}
    },1000)
}

			
//var test_code;	
	
function request_code(){
	//验证用户身份（是否是注册用户）
	$.ajax({
		type:"POST",
		url:"../../background/background_person/form_register.php?action=testcode",
		data:{
			usertel:$('[name="aTel"]').val(),
		},
		async:false,
		//dataType:,
		success:function(data){
			countDown();//开启倒计时
			test_code = data;
		},
		error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
}


//检查验证码是否正确，提交表单
function form_submit(){
	if($("[name='password_2']").val()==""){
		alert("密码不能为空！");
	}else{
		var input_code = $('[name="testCode"]').val();
		if(test_code == input_code){
			$("#pre_applyForm").submit();
		}else{
			alert("验证码输入错误，请重新输入");
		}
	}
}
