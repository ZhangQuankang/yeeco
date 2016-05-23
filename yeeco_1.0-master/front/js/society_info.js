// JavaScript Document
$(document).ready(function(e) {
    //权限管理
	if($('#authority').val()!='创建人'){
		$(".mod").remove();	
	}
})
contact_form_lock = 0;
function save_info(){
	//表单验证
	var a = $('[name="society_name"]').val();
	var b = $('[name="describe"]').val();
	var i = 0;
	$('[name="type[]"]').each(function(){
        if(this.checked){
		 i++;
		}
    });
	
	if( a=="" || b=="" || i==0){
		newbox('notice');
	}else{	
		//验证完成
		movebox('notice');	
		//提交表单
		if(contact_form_lock == 0){
			contact_form_lock = 1;
			$(".contact_form").ajaxSubmit(function() {  
				contact_form_lock = 0;
				alert("已保存"); 
				location.reload();
			});
		}
	}
}
//修改基本资料
function change_info(){
	$(".base_info").hide();
	$('[href="javascript:change_info()"]').hide();
	$(".contact").show();
	$('[href="javascript:back_info()"]').show();
}

//返回基本资料
function back_info(){
	$(".contact").hide();
	$('[href="javascript:back_info()"]').hide();
	$(".base_info").show();
	$('[href="javascript:change_info()"]').show();
}


//修改部门信息
function change_dep(){
	$(".dep_info").hide();
	$('[href="javascript:change_dep()"]').hide();
	$(".framwork").show();
	$('[href="javascript:back_dep()"]').show();
}

//返回部门信息
function back_dep(){
	$(".framwork").hide();
	$('[href="javascript:back_dep()"]').hide();
	$(".dep_info").show();
	$('[href="javascript:change_dep()"]').show();
}

//动态增加表单
//var idNum =1;
function insert(){ 
    var oForm = document.getElementById("all_dep");
    var newHtml = document.createElement("div");
	var idNum=$("#i").val();
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
