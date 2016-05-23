// JavaScript Document
sName=$("[name='sName']").val();
fQue_1=$("[name='fQue_1']").val();
fQue_2=$("[name='fQue_2']").val();
fQue_3=$("[name='fQue_3']").val();


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
				$(".key").parent().parent().css("background","#ffffd7");
			}else{
				$(":checkbox[name='member[]']").prop('checked',false)
				$(".key").parent().parent().css("background","#fff");
			}
	})
		//单选
	$(":checkbox").change(function(){
		if($(this).attr("class")== "key"){
			if(this.checked){
				$(this).parent().parent().css("background","#ffffd7");
			}else{
				$(this).parent().parent().css("background","#fff");
			}
		}	
	})

	//报名表下，表达那样式不可用
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

	//查看报名表资料
	$(".check_form").click(function(){
		var aId = $(this).parent().parent().find(":checkbox").val();
		var index = search_index(aIds,aId);
		var left_aId = aIds[index-1];
		var right_aId = aIds[index+1];
		if((index-1) <= -1){
			left_aId = aId;
		}
		if((index+1)>=aIds.length){
			right_aId=aId;
		}
		$("#member_appForm").load("res_package/unselect_memberForm.php",{"aId":aId,"right_aId":right_aId,"left_aId":left_aId,"sName":sName,"fQue_1":fQue_1,"fQue_2":fQue_2,"fQue_3":fQue_3},function(){
			coverall();
			$("#member_appForm").show();
		});		
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
	if(content==''){
			content='添加备注';
		}
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
//批量删除
function del_app(){
	var c=0;
	$("input[name='member[]']:checkbox").each(function () { 
		if (this.checked){ 
			c++;
		}
	})
	if(c==0){
		alert("您没有勾选任意一个成员！")
	}else{
		coverall();
		newbox('del_notice');
	}
}
//取消删除
function cancel_del(){
	nocover();
	movebox('del_notice');
}
function del_app_act(){
		var aId=new Array();
		var i=0;
		$("input[name='member[]']:checkbox").each(function () { 
			if (this.checked){ 
				aId[i] = $(this).val();
				i++;
			}
		}) 
		$.ajax({
			type:"POST",
			url:"../background/background_society/society_apply_form.php",
			//dataType:"json",
			data:{
				action:"del_app",
				aId:aId,
			},
			success:function(data){
				for(var j=0;j<i;j++){
					$('#'+aId[j]).remove();
				}
				nocover();
				movebox('del_notice');
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})
}


//批量录用
function employ(){
	var c=0;
	$("input[name='member[]']:checkbox").each(function () { 
		if (this.checked){ 
			c++;
		}
	})
	if(c==0){
		alert("您没有勾选任意一个成员！")
	}else{
		coverall();
		newbox('employ_notice');
	}
}
//取消录用
function cancel_employ(){
	nocover();
	movebox('employ_notice');
}
//录用
function employ_act(){
	var c=0;
	$("input[name='member[]']:checkbox").each(function () { 
		if (this.checked){ 
			c++;
		}
	})
	if(c==0){
		alert("您没有勾选任意一个成员！")
	}else{
		var aId=new Array();
		var i=0;
		$("input[name='member[]']:checkbox").each(function () { 
			if (this.checked){ 
				aId[i] = $(this).val();
				i++;
			}
		}) 
		$.ajax({
			type:"POST",
			url:"../background/background_society/society_apply_form.php",
			//dataType:"json",
			data:{
				action:"employ",
				aId:aId,
			},
			async:false,
			success:function(data){
				for(var j=0;j<i;j++){
					$('#'+aId[j]).remove();
				}
				nocover();
				movebox('employ_notice');
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})
	}
}

//查看打印报名表
function read_form(){
	coverall();
	newbox('form_box');
}
//关闭报名表
function return_main(){
	movebox('form_box');
	nocover();
}
	
var t=0;
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
	////**************************************在这里执行异步提交以后的内容
	$.ajax({
			type:"POST",
			url:"../background/background_society/saveBoard.php",
			data:{
				board:$("#board_text").val(),
				sId:$("#sId").val(),
				
			},
			//dataType:,
			success:function(data){
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
}
//停止纳新
function stopFresh(){
	coverall();
	newbox('notice_box');
}
//取消停止纳新
function cancel_closed(){
	movebox('notice_box');
	nocover();
}

//********************************************************************************************************
//编辑报名表内备注
function save_remark(x){
	var remark=$(x).val();
	var aId=$(x).parent().parent().parent().parent().parent().parent().find("[name='aId']").val();
	$.ajax({
		type:"POST",
		url:"../background/background_society/society_apply_form.php",
		data:{
			action:"saveRemark",
			aId:aId,
			remark:remark,
		},
		success:function(data){},
		error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
}
//删除报名表内成员
function delete_form_app(x){
	var aId=new Array();
	aId[0]=$(x).parent().parent().find("[name='aId']").val();
	$.ajax({
		type:"POST",
		url:"../background/background_society/society_apply_form.php",
		data:{
			action:"del_app",
			aId:aId,
		},
		success:function(data){
			var index = search_index(aIds,aId);
			aIds.remove(index);
			next_page(aIds[index]);
			
		},
		error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
}
//录用报名表内成员
function employ_form_app(x){
	var aId=new Array();
	aId[0]=$(x).parent().parent().find("[name='aId']").val();
	$.ajax({
		type:"POST",
		url:"../background/background_society/society_apply_form.php",
		data:{
			action:"employ",
			aId:aId,
		},
		async:false,
		success:function(data){	
			var index = search_index(aIds,aId);
			aIds.remove(index);
			next_page(aIds[index]);
		},
		error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
}

//批量发送通知
function send_manyMsg(){
	var c=0;
	$("input[name='member[]']:checkbox").each(function () { 
		if (this.checked){ 
			c++;
		}
	})
	if(c==0){
		alert("您没有勾选任意一个成员！")
	}else{
		var aId=new Array();
		var i=0;
		var str = "";
		$("input[name='member[]']:checkbox").each(function () { 
			if (this.checked){ 
				aId[i] = $(this).val();
				str+='aId%5B%5D='+aId[i]+'&';
				i++;
			}
		})
		window.location.href="massageBox.php?action=applyNotice&"+str+"sId="+$("#sId").val();
	} 
}


//下一张
function next_page(aId){
	var index = search_index(aIds,aId);
	var left_aId = aIds[index-1];
	var right_aId = aIds[index+1];
	if((index-1) <= -1){
		left_aId = aId;
	}
	if((index+1)>=aIds.length){
		right_aId=aId;
	}
	$("#member_appForm").load("res_package/unselect_memberForm.php",{"aId":aId,"right_aId":right_aId,"left_aId":left_aId,"sName":sName,"fQue_1":fQue_1,"fQue_2":fQue_2,"fQue_3":fQue_3},function(response){
		if(response=='no_member'){
			location.reload();
		}
	});
}


//寻找元素在数组中的位置
function search_index(arr,str){
	for(var k=0;k<=arr.length-1;k++){
		if(arr[k]==str){
			return k;		
		}	
	}
}
//重组数组
Array.prototype.remove=function(dx) 
{ 
    if(isNaN(dx)||dx>this.length){return false;} 
    for(var i=0,n=0;i<this.length;i++) 
    { 
        if(this[i]!=this[dx]) 
        { 
            this[n++]=this[i] 
        } 
    } 
    this.length-=1 
} 
//加载更多
$("#load_more").click(function(){
	var sId=$("#sId").val();
	var a =$(this).parent();	
	$.ajax({
		type:"POST",
		url:"../background/background_society/fresh_memLoad.php",
		data:{
			sId:sId,
			i:i,
		},
		success:function(data){
			if(data==''){
				$("#load_more").text("到底儿了~");
			}else{
				a.before(data);
				//查看报名表资料
				$(".check_form").click(function(){
					var aId = $(this).parent().parent().find(":checkbox").val();
					var index = search_index(aIds,aId);
					var left_aId = aIds[index-1];
					var right_aId = aIds[index+1];
					if((index-1) <= -1){
						left_aId = aId;
					}
					if((index+1)>=aIds.length){
						right_aId=aId;
					}
					$("#member_appForm").load("res_package/unselect_memberForm.php",{"aId":aId,"right_aId":right_aId,"left_aId":left_aId,"sName":sName,"fQue_1":fQue_1,"fQue_2":fQue_2,"fQue_3":fQue_3},function(){
						coverall();
						$("#member_appForm").show();
					});		
				})
			
			}
			
			
		},
		error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})	
	
})




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

