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
	$("#native_city").load("../res_package/city_list.php",{"pro":pro});
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

function findUser(){	
	if($('[name="aName"]').val()==""){
		alert("用户名不能为空！");	
	}else if($('[name="aTel"]').val()==""){
		alert("电话号码不能为空！");
	}else if($('[name="aClass"]').val()==""){
		alert("专业班级不能为空！");
	}else if( isNaN($("[name='aQQ']").val()) && $("[name='aQQ']").val() != ""){
		alert("QQ号码格式不正确！");
	}else{
		$(".isSubmitting").show();
		//验证用户身份（是否是注册用户）
		$.ajax({
			type:"POST",
			url:"../../background/web_app/M_applyFormB.php",
			data:{
				ousertel:$('[name="aTel"]').val(),
				sId:$('[name="sId"]').val(),
			},
			async:false,
			//dataType:,
			success:function(data){
				checkUser(data);
				$(".isSubmitting").hide();
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
				alert("您已经是此社团的成员！");
			}else if(data == 204){
				alert("您已经提交过报名表了！");
			}else{
				alert("操作失败，未知错误，请联系客服！");
			}
}
	
function request_code(){
		//二维码
		$.ajax({
			type:"POST",
			url:"../../background/background_person/form_register.php?action=testcode",
			data:{
				usertel:$('[name="aTel"]').val(),
			},
			//dataType:,
			async:false,
			success:function(data){
				countDown();//开启倒计时
				test_code = data;
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})		
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

			