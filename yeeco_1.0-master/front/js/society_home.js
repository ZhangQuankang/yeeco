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
})

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