// JavaScript Document
$(document).ready(function(){
	//在未启用编辑模式下，表单样式不可用
	$(".board textarea").focus(function(){
		var isEdit = $("#a2").attr("style").indexOf("display"); 
		if(isEdit==0){
			$(this).css("border","1px solid #fff");
		}
	}) 
    $(".board textarea").blur(function(){
		var isSaved = $("#a2").attr("style").indexOf("display"); 
		if(isSaved==0){
			$(this).css("border","1px solid #fff");
		}
	})
		//全选
	$("#all").click(function(){
			if(this.checked){
				$(":checkbox[name='member[]']").prop('checked',true)
				$("#key").parent().parent().css("background","#ffffd7");
			}else{
				$(":checkbox[name='member[]']").prop('checked',false)
				$("#key").parent().parent().css("background","#fff");
			}
	})
		//单选
	$(":checkbox").change(function(){
		if($(this).attr("id")== "key"){
			if(this.checked){
				$(this).parent().parent().css("background","#ffffd7");
			}else{
				$(this).parent().parent().css("background","#fff");
			}
		}	
	})

	//报名表下，表单样式不可用
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

	$("#read_form").hover(function(){
		$("#read_form i").css("background-position","0 -75px");
	},function(){
		$("#read_form i").css("background-position","0 0");
	})
	
	//添加备注信息
	$(".add_remark").click(function(){
		$(this).text('保存').attr('class','save_remark');
		$(this).parent().parent().find(".edit_box").show();
		jQuery.getScript('js/fresh_detail.js');
	})
	//保存备注信息
	$(".save_remark").click(function(){
		var content = $(this).parent().parent().find("#remark").val();	
		if(content==''){
			content='添加备注';
		}
		var aId = $(this).parent().parent().find(":checkbox").val();
		$(this).text(content).attr('class','add_remark');
		$(this).parent().parent().find(".edit_box").hide();
		////**************************************在这里执行异步提交以后的内容
		$.ajax({
			type:"POST",
			url:"../background/background_society/society_apply_form.php",
			//dataType:"json",
			data:{
				action:"saveRemark",
				aId:aId,
				remark:content,
			},
			success:function(data){
				//alert(data);
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})
	})
	//加载更多
	$("#load_more").click(function(){
		var actId=$("#actId").val();
		var i=$("#i").val();
		$.ajax({
			type:"POST",
			url:"../background/background_society/activity/activity_memLoad.php",
			data:{
				actId:actId,
				i:i,
			},
			success:function(data){
				index=data.indexOf('@');
				data1=data.substr(0,index-1);
				data2=data.substr(index+1);
				$("#i").val(data2).before(data1);
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})	
	})
})

//选中的添加备注
function add_edit(){
	var c=0;
	$("input[name='member[]']:checkbox").each(function () { 
		if (this.checked){ 
			c++;
		}
	})
	if(c==0){
		alert("您没有勾选任意一个成员！")
	}else{
		$(".edit_box").animate({width:'200px'});
		$(".handle p").animate({margin:'0 20px 0 10px'});
		$("#h2").text('保存').attr('href','javascript:save_selected()');	
		$("#remark_selected").trigger("focus");
	}
}

//保存已选备注信息
function save_selected(){
	var content = $("#remark_selected").val();	
	var aId=new Array();
	var i=0;
	$("input[name='member[]']:checkbox").each(function () { 
		if (this.checked){ 
			aId[i] = $(this).val();
			i++;
			$(this).parent().parent().find(".add_remark").text(content);
		}
	}) 
	$.ajax({
			type:"POST",
			url:"../background/background_society/society_apply_form.php",
			//dataType:"json",
			data:{
				action:"saveRemark_selected",
				aId:aId,
				remark:content,
			},
			success:function(data){
				//alert(data);
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})
	$(".edit_box").animate({width:'0px'});
	$(".handle p").animate({margin:'0 110px 0 10px'},function(){});
	$("#h2").text('添加备注').attr('href','javascript:add_edit()');
}


	
var t=0;
//活动详情
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

//编辑公告
function edit(){
	$("#board_text").removeAttr("readonly");
	$("#board_text").focus();
	$("#a1").hide();
	$("#a2").show();	
    $(".board textarea").css("border","1px solid #00acff");
}
//保存公告
function save(){
	$("#board_text").attr("readonly","readonly");
	$("#a1").show();
	$("#a2").hide();
	$(".board textarea").css("border","1px solid #fff");
	var status=$(".close_act").text();
	////**************************************在这里执行异步提交以后的内容
	$.ajax({
			type:"POST",
			url:"../background/background_society/activity/saveBoard.php",
			data:{
				board:$("#board_text").val(),
				actId:$("#actId").val(),
				status:status,
			},
			//dataType:,
			success:function(data){
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
}
//关闭活动
function close_act(){
	if($("#user_limit")=='成员'){
		alert("您是成员，不能关闭或者删除活动");
	}else{
		coverall();
		newbox('notice_box');
	}
}
//取消关闭活动
function cancel_close(){
	nocover();
	movebox('notice_box');
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
		async:false,
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



