    //下面用于多图片上传预览功能 
    function setImagePreviews(avalue) {
        var docObj = document.getElementById("pic");
        var fileList = docObj.files;
            var imgObjPreview = document.getElementById("pre_img"); 
            if (docObj.files) {
                //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要以下方法
                imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);               
            }else {
                 //IE下，使用滤镜 
                docObj.select(); 
                var imgSrc = document.selection.createRange().text;
                var localImagId = document.getElementById("pre_img");
                //图片异常的捕捉，防止用户修改后缀来伪造图片
                try {
                    localImagId.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
                    localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
                }
                catch (e) {
                    alert("您上传的图片格式不正确，请重新选择!");
                    return false;
                }
                imgObjPreview.style.display = 'none';
                document.selection.empty();
            }
        return true;
    }
 
//清除图片
function delete_pic(){
	document.getElementById("pre_img").src = "../image/web_image/社团封面.png";
	var file = $(":file");
    file.after(file.clone().val(""));
    file.remove()
	$("#textfield").val("");
}