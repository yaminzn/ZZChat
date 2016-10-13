function sendChat(text){
	$.post("process.php", { function : "send", message : text }, function(data){
	});
	clear();
	chat.update();
	$("#chatbox").animate({ scrollTop: $("#chatbox").prop('scrollHeight') });
	console.log("send()");
}

function clear(){
	$("#sendmsg").val('').focus();
}

function getStateOfChat() {
	$.post("process.php", { function : "getState"}, function(data){
		var obj = jQuery.parseJSON(data);
		state = obj.state;
		console.log("getStateOfChat()");
	});
}

function updateChat(){	
	$.post("process.php", {function : "update", state : state}, function(data){
		var obj = jQuery.parseJSON(data);
		for (var i = 0; i < obj.data.length; i++) {
			$("#chatbox").append('<div class="chatmessage"><span class="timestamp">'+obj.data[i].time+'</span> <span style="color:'+obj.data[i].color+'">'+obj.data[i].username+'</span> <span class="colon"> : </span><span>'+obj.data[i].text+'</span></div>');
		}	
		state = obj.state;
		console.log("update()");
	});

}

function Chat () {
	this.update = updateChat;
	this.send = sendChat;
	this.getState = getStateOfChat;
}

function init(){
	$.post("process.php", {function : "update", state : 0}, function(data){
		var obj = jQuery.parseJSON(data);
		for (var i = obj.data.length - 1; i >= 0; i--) {
			$("#chatbox").append('<div class="chatmessage"><span class="timestamp">'+obj.data[i].time+'</span> <span style="color:'+obj.data[i].color+'">'+obj.data[i].username+'</span><span class="colon"> : </span><span>'+obj.data[i].text+'</span></div>');
		}	
		state = obj.state;
		$("#chatbox").animate({ scrollTop: $("#chatbox").prop('scrollHeight') }, 20);
		console.log("init()");
	});
}