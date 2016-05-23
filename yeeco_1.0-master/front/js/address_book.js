// JavaScript Document

$(document).ready(function(){
	
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
	
	$(".top_back").hover(function(){
				$(".top_back").removeClass("transparency");
			},function(){
				$(".top_back").addClass("transparency");
		});
	$(".top").hover(function(){
				$(".top_back").removeClass("transparency");
			},function(){
				$(".top_back").addClass("transparency");
		});
	
	var jWindow = $(window);
	jWindow.scroll(function(){
		var scrollHeight =jWindow.scrollTop();
		if(scrollHeight>310){
		    $('#fixedSide').addClass("scroll");
		}else{
			$('#fixedSide').removeClass("scroll");
		}
	})
		
	//展开成员列表
	$(".unfold").click(function(){
		var state = $(this);	
		var depName = $(this).parent().find(".dep_name").text();
		if(depName=='未分配'){
			depName='0';
		}
		var target = $(this).parent().parent().find("#content_"+depName);
		if(state.text() == '展开'){
			$("#content_"+depName).load("res_package/memberList.php",{"sId":$("#sId").val(),"depName":depName},function(){
				target.slideDown('fast');
			 	state.html('收起<i></i>');
			});
		}else{
			target.slideUp('fast');
			state.html('展开<i></i>');
		}
	})
	//页面加载自动展开
	$("#open_target").trigger("click");	
	
	
	//逐一添加按钮
	$(".invite_1").hover(function(){
		    $(".invite_1 img").fadeIn("fast");
		},function(){
			$(".invite_1 img").fadeOut("fast");
	});
	//批量导入按钮
	$(".invite_2").hover(function(){
		    $(".invite_2 img").fadeIn("fast");
		},function(){
			$(".invite_2 img").fadeOut("fast");
	});
	

	
	
	
})
form_2_lock = 0;
function asyncSubmit(){
	if(form_2_lock == 0 ){
		form_2_lock = 1;
		$("#form_2").ajaxSubmit(function(data) { 
		   quit();
		   alert("邀请成功！");
		   form_2_lock = 0;
		});
	}
}

//关闭报名表
function return_main(){
	movebox('form_box');
	nocover();
}
//切换社团
function change_society(){
	$(".change_society").fadeIn("fast");
	$(document).one("click", function (){//对document绑定一个影藏Div方法
		$(".change_society").hide();
	});
	event.stopPropagation();
}
$(".change_society").click(function (event){
	event.stopPropagation();//阻止事件向上冒泡
});


function export_members(){
	newbox("export_members");
	coverall();
}

function quit(){
	movebox('export_members');
	movebox('add_newMember');
	movebox('exit_society');
	nocover();
}


function add_newMember(){
	var authority=$("#authority").val();
	if(authority!='成员'){
		newbox("add_newMember");
		coverall();
	}else{
		alert("只有社团创建人和管理员才能邀请成员！");
	}
	
}

//打开“逐个添加”添加方式
function add_1(){
    $(".invite_1").animate({marginTop:30,backgroundSize:'120%'});
	$(".invite_2").animate({marginTop:30,backgroundSize:'100%'});
	$(".way_2").fadeOut("fast");
	$(".way_1").fadeIn("fast");
}
//打开“批量导入”添加方式
function add_2(){
	$(".invite_2").animate({marginTop:30,backgroundSize:'120%'});
    $(".invite_1").animate({marginTop:30,backgroundSize:'100%'});
	$(".way_1").fadeOut("fast");
	$(".way_2").fadeIn("fast");
}
//邀请成员-逐个添加-继续添加
var idmem = 1;
function insert_mem(){
	var oForm = document.getElementById("member_all");
    var newHtml = document.createElement("li");
	idmem = idmem +1;
	newHtml.id= "mem_"+idmem;
	var bb = "'mem_"+idmem+"'";
	newHtml.innerHTML = '<input type="text" name="name[]" onfocus="outline_new(this)" onblur="outline_old(this)" placeholder="姓名"/><input type="text" name="telnumber[]" onfocus="outline_new(this)" onblur="outline_old(this)" placeholder="联系方式"/><a href="javascript:deleteMem('+bb+');">-</a><div style="clear:both;"></div>';
	oForm.appendChild(newHtml);
}
//删除所添加成员
function deleteMem(id){
    var parentnode = document.getElementById("member_all");
	var childnode = document.getElementById(id);
	 parentnode.removeChild(childnode);
}

function exit_society(){
	newbox("exit_society");
	coverall();
}
//导出成员
function export_depMenbers(){
	var depName=new Array();
	var i=0;
	var sId=$("#sId").val();
	$("input[name='dep[]']:checkbox").each(function () { 
		if (this.checked){ 
			depName[i]=$(this).attr("value");
			i++;	
		}
	})	
	if(depName[0]==null){
		alert("请选择部门！");
	}else{
		$('#export_form').submit();
		quit();
			
	}
}

function testfunc(){
	alert("hello!")
}
//***********成员列表按钮操作***************************************************************
	//单选与全选
	function choose(x){
		var depName = $(x).attr('value');
		if($(x).attr("id")== "all_"+depName){
			//获取所要全选的部门的dId，该ID存储在全选按钮的value值当中	
			if(x.checked){
				$(":checkbox[name='member_"+depName+"[]']").prop('checked',true)
				$(":checkbox[name='member_"+depName+"[]']").parent().parent().css("background","#ffffd7");
			}else{
				$(":checkbox[name='member_"+depName+"[]']").prop('checked',false)
				$(":checkbox[name='member_"+depName+"[]']").parent().parent().css("background","#fff");
			}
		}else{
			if(x.checked){
				$(x).parent().parent().css("background","#ffffd7");
			}else{
				$(x).parent().parent().css("background","#fff");
			}
		}	
	}
	
	//调换单一成员部门 table_c
	function change_oneDep(x){
		var uId = $(x).parent().parent().find(":checkbox").attr("value");
		var position = $(x).parent().parent().find(".limit").text();
		//设置权限
		if($('#authority').val()=='创建人'){
			if($('#uId').val()==uId){
				alert("您是该社团创建人，无法调换自己！");
			}else if(position!='成员'){
				alert("只能调换成员！");
			}else{
				var target = $(x).parent().parent();
				var html = "<input type='hidden' name='aim_member[]' value='"+uId+"'/>";
				$(html).appendTo(".change_dep form");
				$(".change_dep").appendTo(target).css({"margin-top":"35px","margin-left":"660px"}).show();
				$(document).one("click",
					function(){$(".change_dep").hide()}
				);
				event.stopPropagation();
			}
		}else{
			alert("只有社团创建人可以调换部门！");
		}
	}
	
	//批量调换
	function change_manyDep(x){
		var depName = $(x).parent().parent().find(".check_all").attr("value");
		var c=0;
		var t=0;
		var html="";
		$("input[name='member_"+depName+"[]']:checkbox").each(function () { 
			if (this.checked){ 
				c++;
				var limit = $(this).parent().parent().find(".limit").text();
				if(limit != '成员'){
					t++;
				}
			}
		})
		if(c==0){
			alert("您没有勾选任意一个成员！");
		}else if(t!=0){
			alert("您只能调换成员，请重新勾选！");
		}else{
			var uId=new Array();
			var i=0;
			$("input[name='member_"+depName+"[]']:checkbox").each(function () { 
				if (this.checked){ 									
					uId[i] = $(this).parent().parent().find(":checkbox").attr("value");
					html = "<input type='hidden' name='aim_member[]' value='"+uId[i]+"'/>";
					$(html).appendTo(".change_dep form");
					i++;
				}
			})
			if($('#authority').val()=='创建人'){
				var target = $(x).parent().parent();
				$(".change_dep").appendTo(target).css({"margin-top":"-130px","margin-left":"420px"}).show();
				$(document).one("click", function (){//对document绑定一个影藏Div方法
					$(".change_dep").hide();
				});
				event.stopPropagation();
			}else{
				alert("只有社团创建人可以调换部门！");
			}
		}
	}
	function noDisappear(event){
		$(document).unbind();
		event.stopPropagation();//阻止事件向上冒泡
	}


	//删除单一成员 table_b
	function delete_one(x){
		var uId=new Array();
		var i=0;
		uId[i] = $(x).parent().parent().find(":checkbox").attr("value");
		var depName = $(x).parent().parent().parent().find(".check_all").attr("value");
		var position = $(x).parent().parent().find(".limit").text();
		var sId=$("#sId").val();
		if($('#authority').val()=='创建人'){
			if($('#uId').val()==uId[i]){
				alert("您是该社团创建人，无法删除自己！");
			////**************************************在这里执行异步提交以后的内容
			}else{
				i++;
				coverall();
				newbox("del_notice");
				$("#sureDelete").bind("click",function(){
					$.ajax({
						type:"POST",
						url:"../background/background_society/society_modify_form.php?action=del_societyMembers&sId="+sId+"&depName="+depName,
						data:{
							uId:uId,
						},
						success:function(data){
							for(var j=0;j<i;j++){
								$('#'+uId[j]).parent().parent().remove();
							}	
							closeWindow();
						},
						error:function(jqXHR){alert("操作失败"+jqXHR.status);}
					})		
				});		
			}
		}else if($('#authority').val()=='管理员'){
			if($('#uId').val()==uId[i]){
				alert("您是该社团部门管理员，无法删除自己！");
			}else if($('#user_dep').val()==depName){
				if(position!='成员'){
					alert("您无法删除社团管理员");
				}else{
					i++;
					coverall();
					newbox("del_notice");
					$("#sureDelete").bind("click",function(){
						$.ajax({
							type:"POST",
							url:"../background/background_society/society_modify_form.php?action=del_societyMembers&sId="+sId+"&depName="+depName,
							data:{
								uId:uId,
							},
							success:function(data){
								for(var j=0;j<i;j++){
									$('#'+uId[j]).parent().parent().remove();
								}				
								closeWindow();
							},
							error:function(jqXHR){alert("操作失败"+jqXHR.status);}
						})
					});
				}	
			}else{
				alert("您只能删除自己部门的成员！");				
			}
		}
	}

	//取消删除
	function closeWindow(){
		$("#sureDelete").unbind();
		movebox("del_notice");
		nocover();
	}
	
	//批量删除选中的指定部门的成员
	function delete_many(x){
		var depName = $(x).parent().parent().find(".check_all").attr("value");
		var sId=$("#sId").val();
		var c=0;
		var t=0;
		$("input[name='member_"+depName+"[]']:checkbox").each(function () { 
			if (this.checked){ 
				c++;
				var limit = $(this).parent().parent().find(".limit").text();
				if(limit != '成员'){
					t++;
				}
			}
		})
		if(c==0){
			alert("您没有勾选任意一个成员！");
		}else if(t!=0){
			alert("您只能删除成员，请重新勾选！");
		}else{
			var uId=new Array();
			var i=0;
			$("input[name='member_"+depName+"[]']:checkbox").each(function () { 
				if (this.checked){ 									
					uId[i] = $(this).parent().parent().find(":checkbox").attr("value");
					i++;
				}
			})
			if($('#authority').val()=='创建人'){
				coverall();
				newbox("del_notice");
				$("#sureDelete").bind("click",function(){
					$.ajax({
						type:"POST",
						url:"../background/background_society/society_modify_form.php?action=del_societyMembers&sId="+sId+"&depName="+depName,
						data:{
							uId:uId,
						},
						success:function(data){
							for(var j=0;j<i;j++){
								$('#'+uId[j]).parent().parent().remove();
							}
							closeWindow();				
						},
						error:function(jqXHR){alert("操作失败"+jqXHR.status);}
					})
				});
			}else if($('#authority').val()=='管理员'){
				if($('#user_dep').val()==depName){
					coverall();
					newbox("del_notice");
					$("#sureDelete").bind("click",function(){
						$.ajax({
							type:"POST",
							url:"../background/background_society/society_modify_form.php?action=del_societyMembers&sId="+sId+"&depName="+depName,
							data:{
								uId:uId,
							},
							success:function(data){
								for(var j=0;j<i;j++){
									$('#'+uId[j]).parent().parent().remove();
								}
								closeWindow();				
							},
							error:function(jqXHR){alert("操作失败"+jqXHR.status);}
						})
					});
				}else{
					alert("您只能删除自己部门的成员！");				
				}
			}
		}
	}	
		
		
	//单独发送通知	
	function send_oneMsg(x){
		var target = "<input name='chooseToId' value='"+$(x).parent().parent().find(":checkbox").attr("value")+"'>";
		$("#testForm").html(target).submit();
	}
	
	function send_manyMsg(x){
		var depName = $(x).parent().parent().find(".check_all").attr("value");
		var sId=$("#sId").val();
		var c=0;
		$("input[name='member_"+depName+"[]']:checkbox").each(function () { 
			if (this.checked){ 
				c++;
			}
		})
		if(c<=1){
			alert("群发消息请勾选至少两名成员！");
		}else{
			var target = '';
			$("input[name='member_"+depName+"[]']:checkbox").each(function () { 
				if (this.checked){ 	
					target += "<input name='chooseToId[]' value='"+$(this).parent().parent().find(":checkbox").attr("value")+"'>";	
				}
			})
			$("#testForm").html(target).submit();
		}
	}
	
	//加载更多
	function add_moreMember(x){
		var i=$(x).parent().parent().parent().find(".i");
		var j=$(x).parent().parent().parent().find(".j");
		var depName=$(x).parent().find(".check_all").attr("value");
		if(depName=='未分配'){
			depName=0;
		}
		var sId=$("#sId").val();
		var that = $(x);
		$.ajax({
				type:"POST",
				url:"../background/background_society/society_memLoad.php?sId="+sId+"&depName="+depName,
				data:{
					i:i.val(),
					j:j.val(),
				},
				success:function(data){	
					index=data.indexOf('@');
					index1=data.indexOf('+');
					data1=data.substr(0,index-1);
					data2=data.substr(index+1,index1-1);
					data3=data.substr(index1+1);
					if(data1==''){
						that.text("到底儿了~");
					}else{
						i.before(data1).val(data2);	
						j.val(data3);
						//权限管理
						if($('#authority').val()=='成员'){
							$(".table_b").remove();
							$(".table_c").remove();
							$(".table_e").remove();
						}
					}			
				},
				error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})		
	}
	//删除未激活成员
	function del_preuser(x){
		var depName = $(x).parent().parent().parent().find(".check_all").attr("value");
		var uId = $(x).parent().parent().find(":checkbox");
		var position = $(x).parent().parent().find(".limit").text();
		var sId=$("#sId").val();
		if($("#authority").val()=='成员'){
			alert("只有社团创建人或管理员才能删除");
		}else if($("#authority").val()=='创建人' ){
			$.ajax({
				type:"POST",
				url:"../background/background_society/society_modify_form.php?action=del_preMember&sId="+sId,
				data:{
					uId:uId.attr("value"),
				},
				success:function(data){
						uId.parent().parent().remove();				
				},
				error:function(jqXHR){alert("操作失败"+jqXHR.status);}
			})	
		}else if(depName==$('#user_dep').val()){
			if(position!='成员'){
				alert("您只能删除成员！");	
			}else{
				$.ajax({
					type:"POST",
					url:"../background/background_society/society_modify_form.php?action=del_preMember&sId="+sId,
					data:{
						uId:uId.attr("value"),
					},
					success:function(data){			
						uId.parent().parent().remove();
					},
					error:function(jqXHR){alert("操作失败"+jqXHR.status);}
				})	
			}
		}else{
			alert("您只能删除自己部门的成员！");
		}
	
	}
	//提醒激活
	function warn_active(x){
		var uId = $(x).parent().parent().find(":checkbox");		
		var that = $(x).parent().parent().find(".table_f");	
		var sId=$("#sId").val();
		$.ajax({
			type:"POST",
			url:"../background/background_society/society_modify_form.php?action=warn_active",
			data:{
				uId:uId.attr("value"),
				sName:$("#sName").val(),
			},
			async:false,
			success:function(data){	
				if(data){
					that.text("已提醒");
					that.removeAttr("onclick");
				}		
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})	
	}
	
	