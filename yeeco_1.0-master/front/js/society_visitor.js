// JavaScript Document
$(document).ready(function(){
	$(".board textarea").focus(function(){
		$(this).css("border","1px solid #fff");
	}) 
    $(".board textarea").blur(function(){
		$(this).css("border","1px solid #fff");
	})
    
	//报名表-取消表单边框的样式
	$(".app_form textarea").focus(function(){
		$(this).css("border","0 solid #fff");
	})
	$(".app_form :text").focus(function(){
		$(this).css("border","0 solid #fff");
	})
	$(".app_form textarea").blur(function(){
		$(this).css("border","0 solid #fff");
	})
	$(".app_form :text").blur(function(){
		$(this).css("border","0 solid #fff");
	})



})
	//切换 关注1/已经关注2
function change_concern(t){	
	if(t==1){
		$(".concern").attr('id','concerned');
		$(".concerned-icon").html("已关注");
		$("#concerned").hover(function(){
			$("#concerned i").css("background-position","-76px 0");
		},function(){
			$("#concerned i").css("background-position","-76px -74px");
		});
	}else if(t==2){
		$(".concern").attr('id','concern');
		$(".concerned-icon").html("关注此社团");
		$("#concern").hover(function(){
			$("#concern i").css("background-position","0 -74px");
		},function(){
			$("#concern i").css("background-position","0 0");
		});
	}
}

//关注或取消关注
function concern(){	
	var type=$(".concern").attr('id');
	if(type == 'concern'){

		//如果未关注，进行关注
		$.ajax({
			type:"GET",
			url:"../background/background_society/isConcern.php?action=concern&sId="+$("#sId").val()+"&uId="+$("#uId").val(),
			success:function(){
				change_concern(1);
				$("#isManage").val('4');
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})
		
	}else{
		//如果已经关注，取消关注
		var isManage=$("#isManage").val();
		if(isManage==4){
			$.ajax({
				type:"GET",
				url:"../background/background_society/isConcern.php?action=cancelConcern&sId="+$("#sId").val()+"&uId="+$("#uId").val(),
				success:function(){
					change_concern(2);
					$("#isManage").val('');
				},
				error:function(){alert("操作失败");}
			})
		}else{
			alert("您是该社团成员，默认为关注，无法取消关注！");	
		}
	}
}
var t=1;
//纳新详情
function detail(){
	if(t==0){
		$("#detail").slideDown("fast");
		$(".more").css("background-position","0 0");
		t=1;
	}else{
		$("#detail").slideUp("fast");
		$(".more").css("background-position","0 -25px");
		t=0;
	}
}
//申请加入
function apply_form(t){
	if(t==0){
		alert("当前为纳新关闭状态，无法申请加入！");
	}else{
		var sId = $("#sId").val();
		var uId = $("#uId").val();
		var fId = $("#fId").val();
		var sName = $("#sName").val();
		var fQue_1 = $("#fQue_1").val();
		var fQue_2 = $("#fQue_2").val();
		var fQue_3 = $("#fQue_3").val();
		//查询是否该成员已经加入社团
		$.ajax({
				type:"POST",
				url:"../background/background_society/society_apply_form.php",
				data:{
					action:"isMember",
					sId:$("#sId").val(),
					uId:$("#uId").val(),
				},
				async:false,
				//dataType:,
				success:function(data){
					if(data){
						alert("你已经是该社团成员");
					}else{
						$("#form_box").load("res_package/apply_form.php",{"sId":sId,"uId":uId,"fId":fId,"sName":sName,"fQue_1":fQue_1,"fQue_2":fQue_2,"fQue_3":fQue_3},function(){
							coverall();
							newbox('form_box');
						})
					}
				},
				error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})	
	}	
}


//提交报名表
apply_table_lock = 0;
function applySubmit(){
	if($("[name='aSex']").val()!="男" || $("[name='aSex']").val()!="女"){
		alert("性别只能填写“男”或“女”！");
	}else if(isNaN($("[name='aQQ']").val())|| $("[name='aQQ']").val() == ""){
		alert("QQ号码格式不正确！");
	}else{
		if(apply_table_lock == 0){
			apply_table_lock = 1;
			$("#apply_table").ajaxSubmit(function() {  
				apply_table_lock = 0;
				alert("提交成功！"); 
				return_main();
				$('.handle_2').text('等待审核').removeAttr('href');
			});
		}
	}
}


//关闭报名表
function return_main(){
	movebox('form_box');
	nocover();
}
//**************************************************************************************
var current_host = ""

//对于评论的回复
function reply(x){
	var state = $(x).text();
	var isContent = $(x).parent().find(".sec_replys").find(".content");
	if(state == "回复"){
		$(x).text("收起回复")
		$(x).parent().find(".sec_replys").show();
	}else{
		$(x).text("回复")
		$(x).parent().find(".sec_replys").hide();
	}
	if(isContent.length){
		$(x).parent().find(".replayBox").hide();
		$(x).parent().find(".say_too").show();
	}else{
		$(x).parent().find(".say_too").hide();
		$(x).parent().find(".replayBox").show();
		current_host = $(x).parent().find(".user_name").text();
	}	
}

//对于回复的回复
function reply2(x){
	$(x).parent().parent().parent().find(".replayBox").show().find("[name='comment']").focus();
	$(x).parent().parent().parent().find(".say_too").hide();
	current_host = $(x).parent().find(".host").text();
}

//提交表单 对于回复的回复
function submit_btn_2(x){
	var userId = $("[name='userId']").val();
	var userName = $("[name='userName']").val();
	var userFace = $("[name='userFace']").val();
	var nId = $("[name='nId']").val();
	var comment = $(x).parent().find("[name='comment']").val();
	var ccId = $(x).parent().find("[name='ccId']").val();
	var date = formateDate(new Date());
	$("[name='date']").val(date);
	var target = $(x).parent().parent();
	$.ajax({
		type:"POST",
		url:"../background/background_comment/comment_reply.php?action=insert",
			//dataType:"json",
		data:{
			userId:userId,
			userName:userName,
			userFace:userFace,
			comment:comment,
			date:date,
			nId:nId,
			ccId:ccId,
			ccName:current_host,
		},
		success:function(cId){
			var new_html = "<li class='content'><div class='user_face2'><img src='"+userFace+"'/></div><div class='right_body'><input type='hidden' name='cId' value='"+cId+"'><span class='reply_content'><strong class='host'>"+userName+"</strong>回复<strong>"+current_host+"</strong>:&nbsp;"+comment+"</span><a class='delete2' href='javascript:void(0)' onclick='delete2(this)'>删除</a><span class='send_time2'>"+date+"</span><a class='praise' href='javascript:void(0)' onclick='praise(this)'>赞</a></div><div style='clear:both;'></div></li>"
			$(target).before(new_html);
		},
		error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
	$(x).parent().find("[name='comment']").val("");
	$(x).parent().parent().hide();
	$(x).parent().parent().parent().find(".say_too").show();	
}

//我也说一句
function I_say(x){
	$(x).parent().parent().find(".replayBox").show();
	$(x).parent().hide();
	current_host = $(x).parent().parent().parent().parent().find(".user_name").text();
}

//提交表单 发表评论
function submit_btn(x){
	var userName = $("[name='userName']").val();
	var userFace = $("[name='userFace']").val();
	var comment = $(x).parent().find("[name='comment']").val();
	var date = formateDate(new Date());
	$("[name='date']").val(date);
	$(".first_comment").ajaxForm(function(cId){
		var new_html = "<li><div class='user_face'><img src='"+userFace+"'/></div><div class='right_body'><input type='hidden' name='cId' value='"+cId+"'><strong class='user_name'>"+userName+"</strong><pre>"+comment+"</pre><a href='javascript:void(0)' class='delete' onclick='delete1(this)'>删除</a><span class='send_time'>"+date+"</span><a class='praise' href='javascript:void(0)' onclick='praise(this)'>赞</a></div><div style='clear:both;'></div></li>"
		$(".big_comment").prepend(new_html);
		$(x).parent().find("[name='comment']").val("");
	});
}

//删除评论
function delete1(x){
	$(x).parent().parent().remove();
	var cId = $(x).parent().find("[name='cId']").val();
	$.ajax({
		type:"POST",
		url:"../background/background_comment/comment_reply.php?action=delete",
			//dataType:"json",
		data:{
			cId:cId
		},
		success:function(data){
		},
		error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
	
}
//删除回复
function delete2(x){
	$(x).parent().parent().remove();
	var cId = $(x).parent().find("[name='cId']").val();
	$.ajax({
		type:"POST",
		url:"../background/background_comment/comment_reply.php?action=delete",
			//dataType:"json",
		data:{
			cId:cId
		},
		success:function(data){
		},
		error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
}

//格式化日期
function formateDate(date) {
    var y = date.getFullYear();
    var m = date.getMonth() + 1;
    var d = date.getDate();
    var h = date.getHours();
    var mi = date.getMinutes();
    m = m > 9 ? m : '0' + m;
    return y + '-' + m + '-' + d + ' ' + h + ':' + mi;
}		
//**************************************************************************************
//赞
function praise(x){
	var cId=$(x).parent().find("[name='cId']").val();
	var uId=$("[name='userId']").val();
	$.ajax({
		type:"POST",
		url:"../background/background_comment/comment_praise.php?action=c",
			//dataType:"json",
		data:{
			cId:cId,
			uId:uId
		},
		success:function(data){
			$(x).text("取消赞("+data+")");
			$(x).attr("onclick","praise_cancel(this)");
		},
		error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
}
//取消赞
function praise_cancel(x){
	var cId=$(x).parent().find("[name='cId']").val();
	var uId=$("[name='userId']").val();
	$.ajax({
		type:"POST",
		url:"../background/background_comment/comment_praise.php?action=cancel_c",
			//dataType:"json",
		data:{
			cId:cId,
			uId:uId
		},
		success:function(data){
			$(x).text("赞("+data+")");
			$(x).attr("onclick","praise(this)");
		},
		error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
}



