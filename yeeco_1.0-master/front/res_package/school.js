// JavaScript Document
//页面加载时进行的函数
window.onload = function (){
	
//******************************下拉菜单****************************************
	//点击下拉菜单事件
	var i=0;
	var mark=0;	
	var mark_2=0;	
	$(".ui-select-dock").click(function (event) {
		if(i==0){
			$(".ui-select-options").fadeIn();
			$(".ui-icon-triangleb").css({'background-position':'14px 16px'});
			i=1;
			$(document).one("click", function () {//对document绑定一个影藏Div方法
			    $(".ui-select-options").hide();
				$(".ui-icon-triangleb").css({'background-position':'14px -21px'});
				i=0;
			});
			event.stopPropagation();//点击阻止事件冒泡到document
		}
	});
	$(".ui-select-options").click(function (event) {
		event.stopPropagation();//在Div区域内的点击事件阻止冒泡到document
	});

	
    //拖拽事件，滚动条滚动
    $('.ui-scrollbar-bar').mousedown(function(){
        var patch=event.clientY;
        $(document).mousemove(function (event){
			$("*").addClass("temp_c");
            var oy=event.clientY;
			var d=oy-patch;
			//拖拽时产生的事件响应
			var t=d+mark;//t表示进度条距离顶部的高度
			$(".ui-scrollbar-bar").addClass("temp_b");
			if(t<=198 && t>=0){
				$('.ui-scrollbar-bar').css({'top':t});
				$('.ui-menu').css({'top':-4.34*t});
			}
            return false;  
        });
    });
    $(document).mouseup(function (){
		$("*").removeClass("temp_c");
	    $(".ui-scrollbar-bar").removeClass("temp_b");
		$(".ui-scrollbar-bar_2").removeClass("temp_b");
        $(this).unbind("mousemove");
	    mark=parseInt($(".ui-scrollbar-bar").css("top"));
		mark_2=parseInt($(".ui-scrollbar-bar_2").css("top"));
    }); 
  
    //重写鼠标滑动事件	
	$(".ui-select-options").on("mousewheel DOMMouseScroll", MouseWheelHandler);
	function MouseWheelHandler(e) {	
	    var scroolly=parseInt($(".ui-scrollbar-bar").css("top"));
		    mark=scroolly;
		e.preventDefault();
		var value = e.originalEvent.wheelDelta || -e.originalEvent.detail;
		var delta = Math.max(-1, Math.min(1, value));
			if (delta < 0) {
				scroolly=scroolly+10;
				if(scroolly<=196 && scroolly>=0){
					$('.ui-scrollbar-bar').css({'top':scroolly});
					$('.ui-menu').css({'top':-4.34*scroolly});					
			    }else{
					$('.ui-scrollbar-bar').css({'top':198});
					$('.ui-menu').css({'top':-4.34*198});	
				}
			}else {
				scroolly=scroolly-10;
				if(scroolly<=196 && scroolly>=0){
					$('.ui-scrollbar-bar').css({'top':scroolly});
					$('.ui-menu').css({'top':-4.34*scroolly});				
			    }else{
					$('.ui-scrollbar-bar').css({'top':0});
					$('.ui-menu').css({'top':0});
				}
			}
		return false;
	}
	

//******************************学校列表****************************************


	var n=65;
    var k=8.2;
    //拖拽事件，滚动条滚动
    $('.ui-scrollbar-bar_2').mousedown(function (){
        var patch=event.clientY;
        $(document).mousemove(function (event){
			$("*").addClass("temp_c");
            var oy=event.clientY;
			var d=oy-patch;
			//拖拽时产生的事件响应
			var t=d+mark_2;//t表示进度条距离顶部的高度
			$(".ui-scrollbar-bar").addClass("temp_b");
			if(t<=270-(2144/n-2) && t>=0){
				$('.ui-scrollbar-bar_2').css({'top':t});
				$('.school_list ul').css({'top':-k*t});
			}
            return false;  
        });
    });
	
	 //重写鼠标滑动事件	
	$(".school_list").on("mousewheel DOMMouseScroll", MouseWheelHandler_2);
	function MouseWheelHandler_2(e) {	
	    var scroolly2=parseInt($(".ui-scrollbar-bar_2").css("top"));
		    mark_2=scroolly2;
		e.preventDefault();
		var value2 = e.originalEvent.wheelDelta || -e.originalEvent.detail;
		var delta2 = Math.max(-1, Math.min(1, value2));
			if (delta2 < 0) {
				scroolly2=scroolly2+10;
				if(scroolly2<=270-(2144/n) && scroolly2>=0){
					$('.ui-scrollbar-bar_2').css({'top':scroolly2});
					$('.school_list ul').css({'top':-k*scroolly2});					
			    }else{
					$('.ui-scrollbar-bar_2').css({'top':270-(2144/n)});
					$('.school_list ul').css({'top':-k*(270-(2144/n))});	
				}
			}else {
				scroolly2=scroolly2-10;
				if(scroolly2<=270-(2144/n) && scroolly2>=0){
					$('.ui-scrollbar-bar_2').css({'top':scroolly2});
					$('.school_list ul').css({'top':-k*scroolly2});				
			    }else{
					$('.ui-scrollbar-bar_2').css({'top':0});
					$('.school_list ul').css({'top':0});
				}
			}
		return false;
	}
	
	
	
//******************************切换省份****************************************
	//点击li选择省份
    $(".ui-select-options ul li").click(function (event){
		var o=$(this).text();
		var pro_id=$(this).attr('data-value'); 
		$(".ui-select-selected").text(o);
		$(".ui-select-options").hide();
		$(".ui-icon-triangleb").css({'background-position':'14px -21px'});
		i=0;
		//更改school_list数据
		$("#school_list ul").load("res_package/school_list.php",{"pro_id":pro_id},function(){
			//计算所需要的li行数
    		n=Math.ceil($(".school_list ul li").length/ 3); 		
        	//确定滚动条高度
	    	$(".ui-scrollbar-bar_2").height(2144/n-6);
			//窗口高度是滚动条高度的k倍
			k=(270*n)/2140;
			if(k<1){
				$('.ui-scrollbar-bar_2').css({'display':'none'});
			}else{
				$('.ui-scrollbar-bar_2').css({'display':'block'});
			}
			$('.ui-scrollbar-bar_2').css({'top':0});
			$('.school_list ul').css({'top':0});
			$.getScript("js/script_person.js");
		});
	});		
	
	
}


