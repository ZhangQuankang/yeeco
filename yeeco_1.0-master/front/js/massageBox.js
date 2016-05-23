// JavaScript Document
//页面加载时进行的函数


//msg_list事件******************************************
		var msgList_height=parseInt($(".msg_list").height());
		//计算当前msg_list中li的数目、
		var li_num = $(".msg_list ul li").length;
		//计算前msg_list ul的总体高度
		var msgUl_height =  71 * li_num;
		if(msgUl_height>msgList_height){
			$(".ui-scrollbar-bar").show();	
		}
		var k = (msgUl_height-msgList_height)/(msgList_height-66);	
		
    function delete_chat(x){
		$(x).parent().remove();
		//获取当前msg_list的高度
		msgList_height=parseInt($(".msg_list").height());
		//计算当前msg_list中li的数目、
		li_num = $(".msg_list ul li").length;
		//计算前msg_list ul的总体高度
		msgUl_height =  71 * li_num;
		if(msgList_height>msgUl_height){
			$(".ui-scrollbar-bar").hide();	
		}
		k = (msgUl_height-msgList_height)/(msgList_height-66);	
	}

    //拖拽事件，滚动条滚动
	var mark=0;	
	var mark_2=0;
	
	
    $('.ui-scrollbar-bar').mousedown(function(){
        var patch=event.clientY;
        $(document).mousemove(function (event){
			$("*").addClass("temp_c"); 
            var oy=event.clientY;
			var d=oy-patch;
			//拖拽时产生的事件响应
			var t=d+mark;//t表示进度条距离顶部的高度
			$(".ui-scrollbar-bar").addClass("temp_b");
			if(t<=msgList_height-66 && t>=0){
				$('.ui-scrollbar-bar').css({'top':t});
				$('.msg_list ul').css({'top':-k*t});
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
	
	//重写鼠标轮滚动事件	
	$(".msg_list").on("mousewheel DOMMouseScroll", MouseWheelHandler);
	function MouseWheelHandler(e) {	
	    var scroolly=parseInt($(".ui-scrollbar-bar").css("top"));
		    mark=scroolly;
		e.preventDefault();
		var value = e.originalEvent.wheelDelta || -e.originalEvent.detail;
		var delta = Math.max(-1, Math.min(1, value));
			if (delta < 0) {
				if(msgUl_height>msgList_height){
					scroolly=scroolly+40;
					if(scroolly<=msgList_height-66 && scroolly>=0){
						$('.ui-scrollbar-bar').css({'top':scroolly});
						$('.msg_list ul').css({'top':-k*scroolly});					
					}else{
						$('.ui-scrollbar-bar').css({'top':msgList_height-66});
						$('.msg_list ul').css({'top':-k*(msgList_height-66)});	
					}
				}
			}else {
				scroolly=scroolly-40;
				if(scroolly<=msgList_height-66 && scroolly>=0){
					$('.ui-scrollbar-bar').css({'top':scroolly});
					$('.msg_list ul').css({'top':-k*scroolly});				
			    }else{
					$('.ui-scrollbar-bar').css({'top':0});
					$('.msg_list ul').css({'top':0});
				}
			}
		return false;
	}
	
	
	




