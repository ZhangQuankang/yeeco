/**
 * Created by an.han on 14-2-20.
 */

window.onload = function () {
    var list = document.getElementById('list');
    var boxs = list.children;
    var timer;
	flag=null;
	ccName=null;
	ccId=null;

    //格式化日期
    function formateDate(date) {
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        var d = date.getDate();
        var h = date.getHours();
        var mi = date.getMinutes();
        m = m > 9 ? m : '0' + m;
        return y + '-' + m + '-' + d + ' ' + h + ':' + mi;
    }

    //删除节点
    function removeNode(node) {
        node.parentNode.removeChild(node);
    }

    /**
     * 赞分享
     * @param box 每个分享的div容器
     * @param el 点击的元素
     */
    function praiseBox(box, el) {
        var txt = el.innerHTML;
        var praisesTotal = box.getElementsByClassName('praises-total')[0];
        var oldTotal = parseInt(praisesTotal.getAttribute('total'));
        var newTotal;
        if (txt == '赞') {
            newTotal = oldTotal + 1;
            praisesTotal.setAttribute('total', newTotal);
            praisesTotal.innerHTML = (newTotal == 1) ? '我觉得很赞' : '我和' + oldTotal + '个人觉得很赞';
            el.innerHTML = '取消赞';
        }
        else {
            newTotal = oldTotal - 1;
            praisesTotal.setAttribute('total', newTotal);
            praisesTotal.innerHTML = (newTotal == 0) ? '' : newTotal + '个人觉得很赞';
            el.innerHTML = '赞';
        }
        praisesTotal.style.display = (newTotal == 0) ? 'none' : 'block';
    }

    /**
     * 发评论
     * @param box 每个分享的div容器
     * @param el 点击的元素
     */
    function reply(box, el) {
		var userFace=$("[name='userFace']").val();
        var commentList = box.getElementsByClassName('comment-list')[0];
        var textarea = box.getElementsByClassName('comment')[0];
        var commentBox = document.createElement('div');
        commentBox.className = 'comment-box clearfix';
        commentBox.setAttribute('user', 'self');
        commentBox.innerHTML =
            '<img class="myhead" src="'+userFace+'" alt=""/>' +
                '<div class="comment-content">' +
                '<p class="comment-text"><span class="user">我：</span>' + textarea.value + '</p>' +
                '<p class="comment-time">' +
                formateDate(new Date()) +
                '<a href="javascript:;" class="comment-praise" total="0" my="0" style="">赞</a>' +
                '<a href="javascript:;" class="comment-operate" onclick="del_comment(this);">删除</a>' +
                '</p>' +
                '</div>'
        commentList.appendChild(commentBox);
        textarea.value = '';
        textarea.onblur();
    }

    /**
     * 赞回复
     * @param el 点击的元素
     */
    function praiseReply(el) {
        var myPraise = parseInt(el.getAttribute('my'));
        var oldTotal = parseInt(el.getAttribute('total'));
        var newTotal;
        if (myPraise == 0) {
            newTotal = oldTotal + 1;
            el.setAttribute('total', newTotal);
            el.setAttribute('my', 1);
            el.innerHTML = newTotal + ' 取消赞';
        }
        else {
            newTotal = oldTotal - 1;
            el.setAttribute('total', newTotal);
            el.setAttribute('my', 0);
            el.innerHTML = (newTotal == 0) ? '赞' : newTotal + ' 赞';
        }
        el.style.display = (newTotal == 0) ? '' : 'inline-block'
    }

    /**
     * 操作留言
     * @param el 点击的元素
     */
    function operate(el) {
        var commentBox = el.parentNode.parentNode.parentNode;
        var box = commentBox.parentNode.parentNode.parentNode;
        var txt = el.innerHTML;
        var user = commentBox.getElementsByClassName('user')[0].innerHTML;
		
        var textarea = box.getElementsByClassName('comment')[0];
        if (txt == '回复') {
			ccId = $(el).parent().parent().parent().find("[name='cId']").val();
            textarea.focus();
            textarea.value = '回复' + user;
			ccName=user;
			flag='回复';
            textarea.onkeyup();
        }
        else {
            removeNode(commentBox);
        }
    }

    //把事件代理到每条分享div容器
    for (var i = 0; i < boxs.length; i++) {

        //点击
        boxs[i].onclick = function (e) {
            e = e || window.event;
            var el = e.srcElement;
            switch (el.className) {

                //关闭分享
                case 'close':
                    removeNode(el.parentNode);
                    break;

                //赞分享
                case 'praise':
                    praiseBox(el.parentNode.parentNode.parentNode, el);
                    break;

                //回复按钮蓝
                case 'btn':
                    reply(el.parentNode.parentNode.parentNode, el);
                    break

                //回复按钮灰
                case 'btn btn-off':
                    clearTimeout(timer);
                    break;

                //赞留言
                case 'comment-praise':
                    praiseReply(el);
                    break;

                //操作留言
                case 'comment-operate':
                    operate(el);
                    break;
            }
        }

        //评论
        var textArea = boxs[i].getElementsByClassName('comment')[0];

        //评论获取焦点
        textArea.onfocus = function () {
            this.parentNode.className = 'text-box text-box-on';
            this.value = this.value == '评论…' ? '' : this.value;
            this.onkeyup();
        }

        //评论失去焦点
        textArea.onblur = function () {
            var me = this;
            var val = me.value;
            if (val == '') {
                timer = setTimeout(function () {
                    me.value = '评论…';
                    me.parentNode.className = 'text-box';
                }, 200);
            }
        }

        //评论按键事件
        textArea.onkeyup = function () {
            var val = this.value;
            var len = val.length;
            var els = this.parentNode.children;
            var btn = els[1];
            var word = els[2];
            if (len <=0 || len > 140) {
                btn.className = 'btn btn-off';
            }
            else {
                btn.className = 'btn';
            }
            word.innerHTML = len + '/140';
        }

    }
	//评论异步提交
	$(".btn").click(function(){
		var nId=$(this).parent().parent().parent().find("[name='nId']").val();
		var userName=$("[name='userName']").val();
		var userId=$("[name='userId']").val();
		var userFace=$("[name='userFace']").val();
		var date = formateDate(new Date());
		var comment=$(this).parent().find(".comment").val();
		if(flag=='回复'){
			  var comment=comment.substring(comment.indexOf('：')+1);
			  $.ajax({
				type:"POST",
				url:"../background/background_comment/comment_reply.php?action=insert",
				data:{
					nId:nId,
					userName:userName,
					userId:userId,
					userFace:userFace,
					date:date,
					comment:comment,
					ccId:ccId,
					ccName:ccName
				},
				async:false,
				success:function(data){
					ccId=null;
					ccName=null;
				},
				error:function(jqXHR){alert("操作失败"+jqXHR.status);}
			})		
		}else{
			$.ajax({
				type:"POST",
				url:"../background/background_comment/comment_reply.php?action=insert",
				data:{
					nId:nId,
					userName:userName,
					userId:userId,
					userFace:userFace,
					date:date,
					comment:comment
				},
				async:false,
				success:function(data){
				},
				error:function(jqXHR){alert("操作失败"+jqXHR.status);}
			})		
		}	
	})
}
//赞的异步提交
function praise(x){
	var c=$(x).parent().attr("class");
	var userId=$("[name='userId']").val();
	if(c=='info clearfix'){
		var p=$(x).parent().find(".praise").text();
		var nId=$(x).parent().parent().parent().find("[name='nId']").val();	
		if(p=='赞'){
			$.ajax({
					type:"POST",
					url:"../background/background_comment/comment_praise.php?action=n",
					data:{
						nId:nId,
						uId:userId
					},
					async:false,
					success:function(data){
						if(data=='已赞过'){
						}else{
							$(x).parent().parent().find(".praises-total").attr("total",data);
						}
					},
					error:function(jqXHR){alert("操作失败"+jqXHR.status);}
			})
		}else{
			$.ajax({
					type:"POST",
					url:"../background/background_comment/comment_praise.php?action=cancel_n",
					data:{
						nId:nId,
						uId:userId
					},
					async:false,
					success:function(data){
						$(x).parent().parent().find(".praises-total").attr("total",data);
						
					},
					error:function(jqXHR){alert("操作失败"+jqXHR.status);}
			})	
		}
	}
	if(c=='comment-time'){
		var p=$(x).parent().find(".comment-praise").text();
		var cId=$(x).parent().parent().parent().find("[name='cId']").val();	
		if(p=='赞'){
			$.ajax({
					type:"POST",
					url:"../background/background_comment/comment_praise.php?action=c",
					data:{
						cId:cId,
						uId:userId
					},
					async:false,
					success:function(data){			
						$(x).parent().parent().find(".comment-praise").attr("total",data);
					},
					error:function(jqXHR){alert("操作失败"+jqXHR.status);}
			})
		}else{
			$.ajax({
					type:"POST",
					url:"../background/background_comment/comment_praise.php?action=cancel_c",
					data:{
						cId:cId,
						uId:userId
					},
					async:false,
					success:function(data){
						$(x).parent().parent().find(".comment-praise").attr("total",data);	
					},
					error:function(jqXHR){alert("操作失败"+jqXHR.status);}
			})	
		}
	}
}
//删除评论
function del_comment(x){
	var cId=$(x).parent().parent().parent().find("[name='cId']").val();
	$.ajax({
		type:"POST",
		url:"../background/background_comment/comment_reply.php?action=delete",
		data:{
			cId:cId		
		},
		success:function(data){	
		},
		error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})	
}
//删除动态
function del_news(x){
	var nId=$(x).parent().find("[name='nId']").val();
	$.ajax({
		type:"POST",
		url:"../background/background_comment/comment_reply.php?action=del_news",
		data:{
			nId:nId		
		},
		success:function(data){	
			$(x).parent().remove();
		},
		error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})	
	
}

// 提交表单
news_lock=0;
function submit_btn(){
	if(news_lock==0){
		news_lock=1;	
		$(".news").ajaxSubmit(function(){  
			news_lock=0;
			location.reload();
		});
	}
}




