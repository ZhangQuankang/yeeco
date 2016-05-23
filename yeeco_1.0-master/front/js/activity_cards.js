// JavaScript Document
//异步提交表单功能
     //提交表单
search_form_lock=0;
function aSubmit(){
	if(search_form_lock==0){
		search_form_lock=1;
		$("#search_form").ajaxForm(function(data) {  
			search_form_lock=0;
			var index=data.indexOf('@');
			var data1=data.substr(0,index-1);
			var data2=data.substr(index+1);
			$('#body').html(data1);
			$('#anum').text(data2);
			$('#paging').html("");
		});
	}
}

//加载页面自动出发事件
$('#all').bind("myClick", function(){  
 	precise_search();
});
$('#all').trigger("myClick");
//搜索选中活动
$(".course-nav-item").click(function(){
	$(this).parent().find(".on").removeClass("on");
	$(this).addClass("on");
	precise_search();
})
//最新，最热
$('.sort-item').click(function(){
	$(this).parent().find(".active").removeClass("active");
	$(this).addClass("active");
	precise_search();
})
//搜索操作
function precise_search(){
	var p=$("#page").val();
	var going=$(".s1").find(".on").children("a").text();
	var type=$(".s2").find(".on").children("a").text();
	var status=$('.tool-left').find(".active").text();
	$.ajax({
			type:"POST",
			url:"../background/background_society/activity/classify_query_activity.php?action=precise_search&p="+p,
			data:{
				"going":going,
				"type":type,
				"status":status,
				"school":$("#school").val(),
			},
			async:false,
			success:function(data){
				var index=data.indexOf('@');
				var index1=data.lastIndexOf('@');
				var data1=data.substr(0,index-1);
				var data2=data.substr(index+1,index1-index-1);
				var data3=data.substr(index1+1);
				$('#body').html(data1);
				$('#anum').text(data2);
				if(data1!=''){
					$('#paging').html(data3);
				}else{
					$('#paging').html("");
				}
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
}
//分页异步加载
function paging_ajax(page,x){
	//page为当前页，x为a标签对象
	var after_page=$(x).text();
	if(after_page=='下一页>'){
		page=page+1;	
	}else if(after_page=='<上一页'){
		page=page-1;
	}else if(after_page=='确定'){
		page=$(x).parent().find("[name='p']").val();
	}
	var going=$(".s1").find(".on").children("a").text();
	var type=$(".s2").find(".on").children("a").text();
	var status=$('.tool-left').find(".active").text();
	$.ajax({
			type:"POST",
			url:"../background/background_society/activity/classify_query_activity.php?action=precise_search&p="+page,
			data:{
				"going":going,
				"type":type,
				"status":status,
				"school":$("#school").val(),
			},
			async:false,
			success:function(data){
				var index=data.indexOf('@');
				var index1=data.lastIndexOf('@');
				var data1=data.substr(0,index-1);
				var data2=data.substr(index+1,index1-index-1);
				var data3=data.substr(index1+1);
				$('#body').html(data1);
				$('#anum').text(data2);
				//$('#paging').html(data3);
				if(data1!=''){
					$('#paging').html(data3);
				}
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
}