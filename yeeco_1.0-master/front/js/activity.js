// JavaScript Document
$(document).ready(function(){
	
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
//展开正在进行的活动
function unfold_1(){
	$(".all_act_ing").slideDown('fast');
	$('[href="javascript:unfold_1()"]').hide();
	$('[href="javascript:fold_1()"]').show();
}

//展开正在进行的活动
function fold_1(){
	$(".all_act_ing").slideUp('fast');
	$('[href="javascript:fold_1()"]').hide();
	$('[href="javascript:unfold_1()"]').show();
}

//展开正在进行的活动
function unfold_2(){
	$(".all_act_ed").slideDown('fast');
	$('[href="javascript:unfold_2()"]').hide();
	$('[href="javascript:fold_2()"]').show();
}

//展开正在进行的活动
function fold_2(){
	$(".all_act_ed").slideUp('fast');
	$('[href="javascript:fold_2()"]').hide();
	$('[href="javascript:unfold_2()"]').show();
}
//给展开按钮添加点击事件，实现异步加载
$(".unfold_2").click(function(){
	$(".all_act_ed").load("res_package/actCloseList.php",{"sId":$("#sId").val()},function(){		
	});
})
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