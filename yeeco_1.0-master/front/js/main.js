$(document).ready(function(){

	//表单功能**************************************************************
	//获取焦点改变文本框（当前对象）边框颜色：操作的文本框
    $(":text").focus(function(){
		$(this).css("border","1px solid #00ACFF");
	}) 
	$(":text").blur(function(){
		$(this).css("border","1px solid #ccc");
	})
	$(":password").focus(function(){
		$(this).css("border","1px solid #00ACFF");
	}) 
	$(":password").blur(function(){
		$(this).css("border","1px solid #ccc");
	})
	$("textarea").focus(function(){
		$(this).css("border","1px solid #00ACFF");
	}) 
	$("textarea").blur(function(){
		$(this).css("border","1px solid #ccc");
	})
	$("select").focus(function(){
		$(this).css("border","1px solid #00ACFF");
	}) 
	$("select").blur(function(){
		$(this).css("border","1px solid #ccc");
	})
	
    //单选框被选中时，该选框所对应的label颜色变黑；反之则恢复灰色
	$(":radio").click(function(){
		var inputId = this.id;
		var label = $("label[for='"+inputId+"']");
		$('#'+inputId+'~ label').siblings('label').removeClass("label_selected");
		$('#'+inputId+'~ label').siblings('label').addClass("gray");
        label.addClass("label_selected");
	})
	
	//复选框被选中时，该选框所对应的label颜色变黑；反之则恢复灰色
	$(":checkbox").change(function(){
		var inputId = this.id;
		var label = $("label[for='"+inputId+"']");
    	if(this.checked){
       		label.addClass("label_selected");
   		}else{
			label.removeClass("label_selected");
    	}
	})

});




//***************************************************************************

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

//
//
//form_2_lock = 0;
//function asyncSubmit(){
//	if(form_2_lock == 0 ){
//		form_2_lock = 1;
//		$("#form_2").ajaxSubmit(function(data) { 
//		   quit();
//		   alert("邀请成功！");
//		   form_2_lock = 0;
//		});
//	}
//}