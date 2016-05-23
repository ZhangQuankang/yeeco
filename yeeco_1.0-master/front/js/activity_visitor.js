// JavaScript Document
$(document).ready(function(){
	//在未启用编辑模式下，表单样式不可用
	$(".board textarea").focus(function(){
			$(this).css("border","1px solid #fff");
	}) 
    $(".board textarea").blur(function(){
			$(this).css("border","1px solid #fff");
	})

})


	
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
//报名参加活动//**************************************************************************************
function apply_activity(){
	var actRange=$("#actRange").val();
	if(actRange=='面向全校'){
		$.ajax({
			type:"GET",
			url:"../background/background_society/activity/apply_activity.php?action=join&actId="+$("#actId").val()+"&uId="+$("#uId").val(),
			async:false,
			success:function(){
				$(".handle_2").html("报名成功");	
				$("#apply_act").attr("href","");
			},
			error:function(){alert("操作失败");}
		})
	}else{
		var isSociety=$("#isSociety").val();
		if(isSociety){
			$.ajax({
				type:"GET",
				url:"../background/background_society/activity/apply_activity.php?action=join&actId="+$("#actId").val()+"&uId="+$("#uId").val(),
				async:false,
				success:function(){
					$(".handle_2").html("报名成功");	
					$("#apply_act").attr("href","");
				},
				error:function(){alert("操作失败");}
			})
		}else{
			alert("该活动是面向社团内部的，您无法参加！");
		}
	}
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
		async:false,
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
		async:false,
		success:function(data){
			$(x).text("赞("+data+")");
			$(x).attr("onclick","praise(this)");
		},
		error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
}
//**************************************************************************************	//切换 关注1/已经关注2
var t=1;
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
		$(".concerned-icon").html("关注此活动");
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
			url:"../background/background_society/activity/apply_activity.php?action=concern&actId="+$("#actId").val()+"&uId="+$("#uId").val(),
			success:function(){
				change_concern(1);
				$("#isJoin").val('1');
			},
			async:false,
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})
		
	}else{
		//如果已经关注，取消关注
		//判断是否已参加了该活动
		if($("#isJoin").val()==1){
			$.ajax({
				type:"GET",
				url:"../background/background_society/activity/apply_activity.php?action=cancel_concern&actId="+$("#actId").val()+"&uId="+$("#uId").val(),
				async:false,
				success:function(){
					change_concern(2);
					$("#isJoin").val('');
				},
				error:function(){alert("操作失败");}
			})
		}else{
			alert("您报名参加了该活动，默认为关注，无法取消关注！");	
		}
	}
}