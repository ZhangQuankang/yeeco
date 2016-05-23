//获取焦点改变文本框（当前对象的父标签）边框颜色：操作的文本框
function register_text_in(x){
    x.parentNode.style.border="1px solid #00ACFF";
	if(x.id == "username"){$(".icon_1").css("background-position","8px 4px");}
	if(x.id == "password"){$(".icon_2").css("background-position","-48px 4px");}	
}

//失去焦点改变文本框（当前对象的父标签）边框颜色：操作的文本框
function register_text_out(x){
    x.parentNode.style.border="1px solid #ccc";
	if(x.id == "username"){$(".icon_1").css("background-position","8px -44px");}
	if(x.id == "password"){$(".icon_2").css("background-position","-48px -44px");}	
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





