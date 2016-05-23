// JavaScript Document


//*************************************************************
//检查一个对象是否包含在另外一个对象中的方法
function contains(parentNode, childNode) {
    if (parentNode.contains) {
        return parentNode != childNode && parentNode.contains(childNode);
    } else {
        return !!(parentNode.compareDocumentPosition(childNode) & 16);
    }
}

//检查鼠标是否真正从外部移入或者移出对象的函数
function checkHover(e,target){
    if (getEvent(e).type=="mouseover")  {
        return !contains(target,getEvent(e).relatedTarget||getEvent(e).fromElement) && !((getEvent(e).relatedTarget||getEvent(e).fromElement)===target);
    } else {
        return !contains(target,getEvent(e).relatedTarget||getEvent(e).toElement) && !((getEvent(e).relatedTarget||getEvent(e).toElement)===target);
    }
}
function getEvent(e){
    return e||window.event;
}


//******************************************************************
//页面加载时产生的事件响应
window.onload = function () {
	var timer = setTimeout;
	var currentId = 1
	
	function play(){
		var nextId = currentId + 1;
		if(nextId > 4){
			nextId = 1;
		}
		timer = setTimeout(function(){
			$(".banner_bg a").fadeOut();
			$("#img_"+nextId).fadeIn().css("display","inline-block");
			$(".control ul li a").removeClass("current");
			$("#btn_"+nextId).addClass("current");
			currentId = nextId;
			play();
		},4000)
	}
	
    $(".banner_bg").hover(
		function(event){
			event.stopPropagation();
			clearTimeout(timer);
			timer = null;
		},
		function(event){
			event.stopPropagation();
			play();
		}	
	);
	
	$(".control ul li a").click(function(){
		var nextId = $(this).attr("id").substr(4);
		$(".banner_bg a").fadeOut();
		$("#img_"+nextId).fadeIn().css("display","inline-block");
		$(".control ul li a").removeClass("current");
		$("#btn_"+nextId).addClass("current");
		currentId = nextId
		clearTimeout(timer);
		timer = null;
		play();
	})
	
	play();
	
		

	
	//鼠标划过cards，遮罩层消失；
    document.getElementById('cards').onmouseover=function(){
        if(checkHover(window.event,this)){
            $("#cards_cover").fadeOut();
        }
    }
    //鼠标离开cards，遮罩层出现；
     document.getElementById('cards').onmouseout=function(){
        if(checkHover(window.event,this)){
	        $("#cards_cover").fadeIn();
        }
    }


	
	//**********消息提醒红点点***************
	$(".top_right").hover(function(){
			$(".msgNotice").animate({"top":"116px","left":"15px"});
		},function(){
			$(".msgNotice").animate({"top":"0","left":"0"});
		}
	);	


}
var timer = null;
//出现相应card名片详情
function cardIn(x){
	//获取相应名片详情的id
	var det = '#'+x.id+'_det';
	if(timer){
		clearTimeout(timer);
		timer = null;
	}
	timer = setTimeout(function(){
		var cover = x.id+'_cover';
        var state = document.getElementById(cover).style.display;  
			if(state == "none"){
			    $(det).fadeIn("fast");
			}   
	},700)	
}

function cardOut(x){
    //获取相应名片详情的id
	var det = '#'+x.id+'_det';
	 $(det).fadeOut("fast");
}

//鼠标划过card对象，移除相应的遮罩层
function movecover(x){
	//获取相应遮罩层的id
	var cover = '#'+x.id+'_cover';
    if(checkHover(window.event,x)){
        $(cover).fadeOut("fast");
    }
	//跳出响应的名片详情
	cardIn(x);
}
//鼠标离开card对象，出现相应的遮罩层
function recover(x){
	//获取相应遮罩层的id
	var cover = '#'+x.id+'_cover';
    if(checkHover(window.event,x)){
        $(cover).fadeIn("fast");
    }
	//隐藏响应的card详情
	cardOut(x);
}

//打开或关闭我的社团
function mysociety(){
	$(".my_society").animate({right:"0"},300);
	$(document).one("click", function (){//对document绑定一个影藏Div方法
		$(".my_society").animate({right:"-340px"},300);
	});
	event.stopPropagation();
}

$(".my_society_in").click(function (event){
	event.stopPropagation();//阻止事件向上冒泡
});
function hidden(){
	$(".my_society").animate({right:"-340px"},300);
}

//寻找社团
function find_society(){
	scrollTo(0,1300);
}

//**活动推荐部分动画效果****************************************************************
	$(".act_body li").hover(function(){
		$(this).find(".act_img img").animate({height:"110%",width:"110%",margin:"-9px -14px"},300);
		$(this).find(".decs").fadeIn("fast");
		$(this).find(".act_tips").fadeOut("fast");
	},function(){
		$(this).find(".act_img img").animate({height:"100%",width:"100%",margin:"0"},300);
		$(this).find(".decs").fadeOut("fast");
		$(this).find(".act_tips").fadeIn("fast");
	});
	
	
