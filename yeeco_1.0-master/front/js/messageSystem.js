// JavaScript Document
//**********************************本地数据库************************************
var source;//服务器通信资源

//查询或创建本地数据库
$(document).ready(function(){
	if(typeof(openDatabase) !== "function"){
		alert("很抱歉，您的浏览器暂不支持即使消息，请使用chrome、Firefox等高级浏览器！")
		window.history.go(-1);
	}
	dataBase = openDatabase('msgdb', '1.0', 'message dataBase', 5 * 1024 * 1024);
	dataBase.transaction( function(tx) { 
		tx.executeSql(
			"create table if not exists recent_msg_list (userId INTEGER, targetName TEXT, targetFace TEXT, targetId TEXT, lastTime INTEGER, lastMsg TEXT, targetSid INTEGER)"//, unread INTEGER
		);
		tx.executeSql(
			"create table if not exists message (userId INTEGER, targetId TEXT, msgTime INTEGER, msgBody TEXT, flag INTEGER)"
		);
	});
	//查询数据库中已有的最近联系人列表
	var userId = $("[name='userId']").val();
	query_msg_list(userId);
	
	//与服务器建立连接，随时接收服务器收到的新消息
	if(typeof(EventSource)!=="undefined"){
		source=new EventSource("../background/message/request_msg.php?msgFromId="+userId);
		source.onmessage=function(event){
			//document.getElementById("result2").innerHTML+=event.data + "<br />";
			if (!event.data.match("^\{(.+:.+,*){1,}\}$")){
				//alert("请求重传")
			}else{
					//通过这种方法可将字符串转换为对象
				var obj = jQuery.parseJSON(event.data);
				var notice = obj.notice;
				$.unique(notice);//过滤掉数组中重复的元素
				for (var i = 0; i < notice.length; i++) {
					//notice[i]为未读消息，将未读消息在最近联系人列表中通知用户
					inform(userId,notice[i]);
				};
			}
		}	
	}else{
		alert("对不起，您的浏览器暂不支持即时消息推送~");
	}
});

//新消息通知，此消息为非当前联系人的新消息
function inform(userId,newInform){
	//查看当前联系人列表中是否已有此联系人
	dataBase.transaction(function (tx) {
		tx.executeSql(
			"select targetId from recent_msg_list where userId = ? and targetId = ?",
			[userId,newInform],
			function (tx, result) { //执行成功的回调函数
				var len = result.rows.length;
				if(len){
					//此人在列表中已存在，直接置顶，并显示小气泡
					var targetLi = $("#"+newInform).parent().parent();
					$("<span></span>").appendTo(targetLi.find(".userFace"))
					$(".msg_list ul").prepend(targetLi);
				}else{
					//此人在列表中不存在
					var newInformName; 
					var newInformFace;
					//向后台获取此联系人的相关信息
					$.ajax({
						type:"GET",
						url:"../background/message/request_unread.php?userId="+userId+"&targetId="+newInform,
						async:false,
						success:function(data){
							var obj = jQuery.parseJSON(data);
							newInformName = obj.userName;
							newInformFace = obj.userFace;
						},
						error:function(jqXHR){alert("操作失败"+jqXHR.status);}
					})
					//将此联系人作为最新联系人插入到数据库中
					delete_msg_list(userId,newInform);
					insert_list(userId, newInform, newInformName, newInformFace, Date.parse(new Date())/1000, "");
					//将此联系人添加到最近联系人列表顶部
					var new_html = "<a href='javascript:void(0)' onclick='openSingleChat(\""+newInform+"\",this)'><li><div class='userFace'><img src='../"+newInformFace+"' /><span></span></div><strong>"+newInformName+"</strong><p>"+""+"</p><i class='delete_msg' id='"+newInform+"'>删除</i></li></a>";
					$(".msg_list ul").prepend(new_html);
					
				}
			}
		)
	});
}

//查询当前的联系人列表
function query_msg_list(userId){
	dataBase.transaction(function (tx) {
		tx.executeSql(
			"select * from recent_msg_list where userId = ? order by lastTime", [userId],
			function (tx, result) { //执行成功的回调函数
				var	isExist = 0;
				var len = result.rows.length;
				var top_html;
				for (i = 0; i < len; i++){
					var targetId = result.rows.item(i)['targetId'];
         			var targetName = result.rows.item(i)['targetName'];
					var targetFace = result.rows.item(i)['targetFace'];
					var lastMsg = result.rows.item(i)['lastMsg'];
					if(targetId === newTarget){
						isExist = 1;
						top_html = "<a href='javascript:void(0)' onclick='openSingleChat(\""+targetId+"\",this)'><li><div class='userFace'><img src='../"+targetFace+"' /></div><strong>"+targetName+"</strong><p>"+lastMsg+"</p><i class='delete_msg' id='"+targetId+"'>删除</i></li></a>";
					}else{
						var new_html = "<a href='javascript:void(0)' onclick='openSingleChat(\""+targetId+"\",this)'><li><div class='userFace'><img src='../"+targetFace+"' /></div><strong>"+targetName+"</strong><p>"+lastMsg+"</p><i class='delete_msg' id='"+targetId+"'>删除</i></li></a>";
						$(".msg_list ul").prepend(new_html);
					}
      			}
				if(newTarget!= "noBody"){
				//查看已有的联系人列表中是否有目标联系人
					if(isExist){
						//alert("此人在联系人列表中已经存在！");
					}else{
						//将此联系人作为最新联系人插入到数据库中;
						delete_msg_list(userId,newTarget);
						insert_list(userId, newTarget, newTargetName, newTargetFace, Date.parse(new Date())/1000, "" ,targetSid);
						//将此联系人添加到最近联系人列表顶部
						top_html = "<a href='javascript:void(0)' onclick='openSingleChat(\""+newTarget+"\",this)'><li><div class='userFace'><img src='../"+newTargetFace+"' /></div><strong>"+newTargetName+"</strong><p>"+""+"</p><i class='delete_msg' id='"+newTarget+"'>删除</i></li></a>";
					}
					$(".msg_list ul").prepend(top_html);
					openSingleChat(newTarget,$(".msg_list ul").children().first());
				}
				
				//为按钮添加删除事件
				$(".delete_msg").click(function (event){
					//页面上的删除
					delete_chat(this);
					//数据库里的删除
					var userId = $("[name='userId']").val();
					var targetId = $(this).attr('id');
					
					delete_msg(userId,targetId);
					delete_msg_list(userId,targetId);
					event.stopPropagation();//阻止事件向上冒泡
				});
	
			},
			function (tx, error) {
				alert('查询失败: ' + error.message);
			}
		);
	});
}

//查询历史消息(查询与谁的聊天记录)
function query_msg(userId,targetId){
	var myName = $("[name='userName']").val();
	var myFace = $("[name='userFace']").val();
	var targetName = $("[name='toUserName']").val();
	var targetFace = $("[name='toUserFace']").val();

	dataBase.transaction(function (tx) {
		tx.executeSql(
		//查询20条记录，分页问题待解决************************************************************
			"select * from message where userId = ? and targetId = ? limit 20", [userId,targetId],
			function (tx, result) { 
				var len = result.rows.length;
				for (i = 0; i < len; i++){
         			var msgBody = result.rows.item(i)['msgBody'];
					var msgTime = result.rows.item(i)['msgTime'];
					var flag = result.rows.item(i)['flag'];
					if(flag == 0){//这是自己发出的消息
						var new_html = "<li class='Tx_msg'><div class='msg_face'><img src='"+myFace+"' /></div><div class='conbine'><em>"+myName+"</em><div class='msg_content'><p>"+msgBody+"</p></div></div><span class='send_time'>"+formateDate(new Date(msgTime *1000))+"</span><div style='clear:both;'></div></li>";
						$("#oldMsg").before(new_html);
					}else{//这是接收到的消息
						var new_html = "<li class='Rx_msg'><div class='msg_face'><img src='"+targetFace+"' /></div><div class='conbine'><em>"+targetName+"</em><div class='msg_content'><p>"+msgBody+"</p></div></div><span class='send_time'>"+formateDate(new Date(msgTime* 1000))+"</span><div style='clear:both;'></div></li>";
						$("#oldMsg").before(new_html);
						//$(new_html).appendTo(".massages ul");
					}
      			}
			},
			function (tx, error) {
				alert('查询失败: ' + error.message);
			}
		);
	});
}

//更新最近联系人（联系人ID，最近一则消息的时间，最近一则消息的内容）
function update_list(){
	var userId = $("[name='userId']").val();
	var targetId = $("[name='toId']").val();
	var lastMsg = $(".massages ul li").last().find(".msg_content p").text();
	$(".msg_list ul li").first().find("p").text(lastMsg);
	var lastTime = Date.parse(new Date())/1000;
	dataBase.transaction(function (tx) {
		tx.executeSql(
			"update recent_msg_list set lastTime=?, lastMsg=? where userId = ? and targetId = ?",
			[lastTime,lastMsg,userId,targetId],
			function () { 
				//alert('更新数据成功'); 
			},
			function (tx, error) { 
				alert('添加数据失败: ' + error.message);
			}
		);
	});
}

//新增最近联系人（联系人ID，最近一则消息的时间，最近一则消息的内容）
function insert_list(userId, targetId, targetName, targetFace, lastTime, lastMsg, targetSid){
	dataBase.transaction(function (tx) {
		tx.executeSql(
			"insert into recent_msg_list (userId, targetId, targetName, targetFace, lastTime, lastMsg, targetSid) values(?, ?, ?, ?, ?, ?, ?)",
			[userId, targetId, targetName, targetFace, lastTime, lastMsg, targetSid],
			function () { 
				//alert('添加数据成功'); 
			},
			function (tx, error) { 
				alert('添加数据失败: ' + error.message);
			}
		);
	});
}


//新增消息记录（消息对象ID，消息内容，消息时间）
function insert_msg(userId,targetId,msgBody,msgTime,flag){
	dataBase.transaction(function (tx) {
		tx.executeSql(
			"insert into message (userId, targetId, msgTime, msgBody, flag) values(?, ?, ?, ?, ?)",
			[userId,targetId,msgTime,msgBody,flag],
			function () { 
				//alert('添加数据成功'); 
			},
			function (tx, error) { 
				alert('添加数据失败: ' + error.message);
			}
		);
	});
}

//删除聊天记录
function delete_msg(userId,targetId){
	dataBase.transaction(function (tx) {
		tx.executeSql(
			"delete from message where userId = ? and targetId = ?",
			[userId,targetId],
			function (tx, result) {
			},
			function (tx, error) {
				alert('删除失败: ' + error.message);
			}
		);
	});
}
//删除最近联系人
function delete_msg_list(userId,targetId){
	dataBase.transaction(function (tx) {
		tx.executeSql(
			"delete from recent_msg_list where userId = ? and targetId= ?",
			[userId,targetId],
			function (tx, result) {
			},
			function (tx, error) {
				alert('删除失败: ' + error.message);
			}
		);
	});
}
//*********************************************************收发消息******************************************************


	
//打开并接收消息
function openSingleChat(msgToId,x){
	//保存上一个聊天对象为最近一次的联系人
	update_list();
	
	//清除聊天窗口内的所有内容、
	$(".massages ul li").remove();
	$(".massages .mass_tag").remove();
		
	//将当前对象置顶并高亮显示并删除小气泡
	$(".msg_list ul li").css("background","#fff");
	$(".msg_list ul").prepend(x);
	$(x).children("li").css("background","#ffffd7");
	$(x).find("span").remove();

	var msgFromId = $("[name='userId']").val();
	//alert("您的ID为："+msgFromId+"，跟您通信的人ID为："+msgToId);
		
	if(typeof(EventSource)!=="undefined"){
		//如果浏览器支持此技术， 则执行：
			
		//打开聊天窗口
		$(".state_1").hide();
		$(".state_2").show();
			
		//获取当前联系人的相关数据
		$("[name='toId']").val(msgToId);
		var toUserName =$(x).find("strong").text();
		var toUserFace = $(x).find(".userFace img").attr("src");
		$("[name='toUserName']").val(toUserName);
		$("[name='toUserFace']").val(toUserFace);
	
		//获取与当前联系人曾经的聊天记录
		query_msg(msgFromId,msgToId);
		
		//如果是群发，新增群发标签
		if(msgToId.indexOf(',')>0){
			var massHtml = "<div class='mass_tag'>您将要给以下好友群发消息："+toUserName+"。<br/>社团管理员还可以改为<a href='javascript:mobileWin("+msgFromId+",\""+msgToId+"\")'>发送手机短信</a></div>";
			$("#currentMsg").before(massHtml);
		}

		//断开上一次与服务器的通信，再与服务器建立新的连接
		source.close();
		source=new EventSource("../background/message/request_msg.php?msgToId="+msgToId+"&msgFromId="+msgFromId);
		
		//当收到消息时
		source.onmessage=function(event){
			//document.getElementById("result1").innerHTML+=event.data + "<br />";
			//判断返回值不是 json 格式
			if (!event.data.match("^\{(.+:.+,*){1,}\}$")){
				//alert("请求重传")
			}else{
				//通过这种方法可将字符串转换为对象
				var obj = jQuery.parseJSON(event.data);
				var notice = obj.notice;
				var message = obj.message;
				if(notice[0]){
					$.unique(notice);//过滤掉数组中重复的元素
					for (var i = 0; i < notice.length; i++) {
						//notice[i]为未读消息，将未读消息在最近联系人列表中通知用户
						inform(msgFromId,notice[i]);
					};
				}	
				if(message[0]){
					//将新消息在聊天窗口中弹出
					for (var i = 0; i < message.length; i++) {
						var RxmsgBody = obj.message[i].msgBody;
						var RxmsgTime = obj.message[i].msgTime;
						//把收到的消息存入本地数据库
						insert_msg(msgFromId,msgToId,RxmsgBody,RxmsgTime,1);
						var new_html = "<li class='Rx_msg'><div class='msg_face'><img src='"+toUserFace+"' /></div><div class='conbine'><em>"+toUserName+"</em><div class='msg_content'><p>"+RxmsgBody+"</p></div></div><span class='send_time'>"+formateDate(new Date(RxmsgTime* 1000))+"</span><div style='clear:both;'></div></li>";
						$("#currentMsg").before(new_html);
						//$(new_html).appendTo(".massages ul");	
					};
				}
			}	
		};
			
	}else{//如果浏览器不支持此技术， 则执行
		alert("对不起，您的浏览器暂不支持即时消息推送~");
	}
}


//当以下事件发生时，认为用户结束了当前一次回话
window.onbeforeunload = function(e) {
	update_list();
}

//发送消息
function send_massage(){
	var userName = $("[name='userName']").val();
	var userFace = $("[name='userFace']").val();
	var massage = $("[name='message']").val();
	var msgFromId = $("[name='userId']").val();
	var targetId = $("[name='toId']").val();
	var date = Date.parse(new Date())/1000;
	
	$("#massage_form").ajaxForm(function(data){
		//把发出的消息存入本地数据库
		insert_msg(msgFromId,targetId,massage,date,0);
		var new_html = "<li class='Tx_msg'><div class='msg_face'><img src='"+userFace+"' /></div><div class='conbine'><em>"+userName+"</em><div class='msg_content'><p>"+massage+"</p></div></div><span class='send_time'>"+formateDate(new Date(date *1000))+"</span><div style='clear:both;'></div></li>";
		$("#currentMsg").before(new_html);
		$("[name='message']").val("");
	});
}
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
//添加回车发送事件
	$("#msgBody").keydown(function(event){
		if(event.which == 13){
			send_massage();
			$("#massage_form").submit();
		}
	})

function send_mobileMsg(){
	var userName = $("[name='userName']").val();
	var userFace = $("[name='userFace']").val();
	var massage = "【手机短信】"+$("[name='m_message']").val();
	var msgFromId = $("[name='userId']").val();
	var targetId = $("[name='toId']").val();
	var date = Date.parse(new Date())/1000;
	$("#mobileMsg_form").ajaxForm(function(data){
		//更新发送手机信息的时间
		dataBase.transaction(function (tx) {
		tx.executeSql(
			"update recent_msg_list set lastTime=?,lastMsg=? where userId = ? and targetId = ?",
			[date,massage,msgFromId,targetId],
			function () { 
				//alert('更新数据成功'); 
			},
			function (tx, error) { 
				alert('添加数据失败: ' + error.message);
			}
		);
	});
		//把发出的消息存入本地数据库
		insert_msg(msgFromId,targetId,massage,date,0);
		var new_html = "<li class='Tx_msg'><div class='msg_face'><img src='"+userFace+"' /></div><div class='conbine'><em>"+userName+"</em><div class='msg_content'><p>"+massage+"</p></div></div><span class='send_time'>"+formateDate(new Date(date *1000))+"</span><div style='clear:both;'></div></li>";
		$("#currentMsg").before(new_html);
		$("[name='message']").val("");
		alert(data);
		quit();
	});
}




//发送手机短信窗口
function mobileWin(userId,targetId){
	//查询本地缓存，找到uId和sId，确定用户身份
	dataBase.transaction(function (tx) {
		tx.executeSql(
			"select lastMsg,targetSid,lastTime from recent_msg_list where userId = ? and targetId = ? limit 1", [userId,targetId],
			function (tx, result) { 
				var flag=1;
				var lastMsg = result.rows.item(0)['lastMsg'];
         		var sId = result.rows.item(0)['targetSid'];
				var lastTime = result.rows.item(0)['lastTime'];
				var nowTime=Date.parse(new Date())/1000;
				if(lastMsg.indexOf("【手机短信】")>=0){
					if(eval(nowTime-lastTime)>180){
						flag=1;
					}else{
						flag=0;	
					}
				}
				if(eval(flag)){
					$.ajax({
							type:"POST",
							url:"../background/message/mobile_msg.php",
							data:{
								action:'getIdentity',
								sId:sId,
								uId:userId
							},
							async:false,
							success:function(data){		
								if(eval(data)){
									newbox("mobile_msg");
									coverall();
								}else{
									alert("您是社团成员，不能发送手机短信！");	
								}	
							},
							error:function(jqXHR){alert("操作失败"+jqXHR.status);}
						})
				}else{
				  alert("您发送手机短信太过频繁，请稍后操作！");
				}	
			},
			function (tx, error) {
				alert('查询失败: ' + error.message);
			}
		);
	});
	
	
}

//关闭发送短信窗口
function quit(){	
	movebox("mobile_msg");
	nocover();
}

