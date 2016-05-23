// JavaScript Document

function activate(){
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
	//弹出激活对话框
    newbox('email_box');
	//弹出遮罩层
	coverall();
	}
}

function return_reg(){
	//隐藏激活对话框
    movebox('email_box');
	//取消遮罩层
	nocover();
}



