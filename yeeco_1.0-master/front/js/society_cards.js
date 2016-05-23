//异步提交表单功能
$(document).ready(function () {
     //提交表单
    $("#search_form").ajaxForm(function(data) {  
     	var index=data.indexOf('@');
     	var data1=data.substr(0,index-1);
		var data2=data.substr(index+1);
		$('#body').html(data1);
		$('#snum').text(data2);
		$('#paging').html("");
    });
});
//加载页面自动出发事件
$('#all').bind("myClick", function(){  
 	precise_search();
});
$('#all').trigger("myClick");
//搜索选中社团
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
	var cert=$(".s1").find(".on").children("a").text();
	var cate=$(".s2").find(".on").children("a").text();
	var status=$('.tool-left').find(".active").text();
	$.ajax({
			type:"POST",
			url:"../background/background_society/classify_query_society.php?action=precise_search&p="+p,
			data:{
				"cert":cert,
				"cate":cate,
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
				$('#snum').text(data2);
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
	var cert=$(".s1").find(".on").children("a").text();
	var cate=$(".s2").find(".on").children("a").text();
	var status=$('.tool-left').find(".active").text();
	$.ajax({
			type:"POST",
			url:"../background/background_society/classify_query_society.php?action=precise_search&p="+page,
			data:{
				"cert":cert,
				"cate":cate,
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
				$('#snum').text(data2);
				if(data1!=''){
					$('#paging').html(data3);
				}
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
	
}
