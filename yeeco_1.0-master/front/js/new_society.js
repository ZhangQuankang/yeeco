// JavaScript Document

var timer = null;
var t=6;
//执行倒计时，使strong标签中显示剩余时间
function turn(){
    document.getElementById("page_pre").style.display="none";
	document.getElementById("guide").style.display=""; 
	document.getElementById("0").style.display=""; 
}
function countDown(){
    if(timer){
		clearTimeout(timer);
		timer = null;
	}	
	timer = setTimeout(function(){
		t = t-1;
		$(".time").html(t);
		if(t != 0 ){
		    countDown();
		}else{
			if(document.getElementById("page_pre").style.display == ""){
			    turn();
			}
		}
    },1000)
}



//点击发触页面跳转  page_a表示要去往的页面,page_b表示当前页面
function page_to(page_a,page_b){
	$("#"+page_a).show();
	$("#"+page_b).hide();
	$("#guide li").eq(page_b).removeClass("on");
	$("#guide li").eq(page_a).addClass("on");
//	document.getElementById(page_a).style.display="";
//	document.getElementById(page_b).style.display="none"; 
//	document.getElementById("guide").getElementsByTagName("li").item(page_a).className = 'on';
//	document.getElementById("guide").getElementsByTagName("li").item(page_b).className = ''; 
}
//点击guide实现任意页面跳转,page表示要去页面
function free_skipPage(page){
	$("#0").hide();
	$("#1").hide();
	$("#2").hide();
	$("#3").hide();
	$("#"+page).show();
	$("#guide li").removeClass("on");
	$("#guide li").eq(page).addClass("on");
	//var divId=['0','1','2','3'];
//	for(var i=0;i<=divId.length;i++){
//		if(page==divId[i]){
//			document.getElementById(page).style.display="";
//			document.getElementById("guide").getElementsByTagName("li").item(page).className = 'on';
//		}else{
//			document.getElementById(divId[i]).style.display="none";	
//			document.getElementById("guide").getElementsByTagName("li").item(divId[i]).className = '';
//		}
//	}
}

//异步提交表单功能

form_1_lock = 0;
function asyncSubmit_1(){
	if(form_1_lock == 0 ){
		form_1_lock = 1;
		$("#form_1").ajaxSubmit(function() { 
			page_to('1','0');
		   	form_1_lock = 0;
		});
	}
}
form_2_lock = 0;
function asyncSubmit_2(){
	if(form_2_lock == 0 ){
		form_2_lock = 1;
		$("#form_2").ajaxSubmit(function() { 
			page_to('2','1');
		   	form_2_lock = 0;
		});
	}
}

window.onload = function(){	
    //开启6秒倒计时
    countDown();
	
	//添加部门按钮效果
	$(".add_new a").hover(function(){
		    $(this).animate({width:80});
			$(this).html("添加部门");
		},function(){
			$(this).animate({width:36});
		    $(this).html("+");
	});
	
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
	
}


//动态增加表单
var idNum =1;
function insert(){ 
    var oForm = document.getElementById("all_dep");
    var newHtml = document.createElement("div");
	idNum = idNum +1;
	newHtml.id= "dep_"+idNum;
	newHtml.className="new_dep";
	var aa = "'dep_"+idNum+"'";
	newHtml.innerHTML = '<input type="text" name="dep_name[]" placeholder="部门名称" onfocus="outline_new(this)" onblur="outline_old(this)"/><input type="text" name="position_1[]" placeholder="职位" onfocus="outline_new(this)" onblur="outline_old(this)"/><input type="text" name="position_2[]" placeholder="职位" onfocus="outline_new(this)" onblur="outline_old(this)"/><input type="text" name="position_3[]" placeholder="职位" onfocus="outline_new(this)" onblur="outline_old(this)"/><input type="text" name="manager_1[]" placeholder="姓名" onfocus="outline_new(this)" onblur="outline_old(this)"/><input type="text" name="manager_2[]" placeholder="姓名" onfocus="outline_new(this)" onblur="outline_old(this)"/><input type="text" name="manager_3[]" placeholder="姓名" onfocus="outline_new(this)" onblur="outline_old(this)"/><input type="text" name="tel_1[]" placeholder="联系方式" onfocus="outline_new(this)" onblur="outline_old(this)"/><input type="text" name="tel_2[]" placeholder="联系方式" onfocus="outline_new(this)" onblur="outline_old(this)"/><input type="text" name="tel_3[]" placeholder="联系方式" onfocus="outline_new(this)" onblur="outline_old(this)"/><a href="javascript:deleteDep('+ aa +');">-</a>';
	oForm.appendChild(newHtml);
	$(".new_dep a").hover(function(){
		    $(this).animate({width:80,left:16});
			$(this).html("删除部门");
		},function(){
			$(this).animate({width:25,left:44});
		    $(this).html("-");
	});
} 
//删除当前部门html
function deleteDep(id){
     var parentnode = document.getElementById("all_dep");
	 var childnode = document.getElementById(id);
	 parentnode.removeChild(childnode);
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

//生成二维码
function getCode(){
	$("#codediv").load("http://cli.im/api/qrcode",function(){
			
		});
}
