function loadUsersList() {
	$.post("modele/online.php", function(data){
		var obj = jQuery.parseJSON(data);
		var j = 0;
		$("#userlist").html('');
		for(i=0;i<obj.length;i++){
			if(obj[i].online == 1){
				$("#userlist").append('ON');
				j++;
			}
			else{
				$("#userlist").append('OFF');
			}
			$("#userlist").append(' <span style="color:'+obj[i].color+'">'+obj[i].username+'</span><br>');
		}
		console.log("loadUsersList()");
	});
}

$("#bookmarkBtn").click(function() {
	if($("#bookmarkBtn").hasClass("glyphicon-heart-empty")){
		//ajouter au favoris
	}
	else{
		//retirer des favoris

	}
	$("#bookmarkGlyph").toggleClass("glyphicon-heart-empty glyphicon-heart");
});


$("#submitBtnLeave").click(function() {
	$.post("modele/channelProcess.php", {function : "leaveChannel"}, function(data){
				$('#modalRenameChannel').modal('toggle');
				console.log("leaveChannel()");
				window.location.replace("channels.php");
	});
});


$("#submitBtnCreateChannel").click(function() {
	$("#formCreateChannel").submit(function(){
		validateformCreateChannel();
	});
});

function validateformCreateChannel(){
	var name = $("#createChannelName").val();
	var description = $("#createChannelDescription").val().replace(/\n/g, '<br />');
	$.post("modele/channelProcess.php", {function : "createChannel", name : name, description : description }, function(data){
		$('#modalcreateChannel').modal('toggle');
		console.log("createChannel()");
		window.location.replace("channels.php?id="+data);
	});
	$("#newChannelDescription").val("");
	$("#createChannelDescription").val("");
}



$("#submitBtnNewChannelName").click(function() {
	$("#formRenameChannel").submit(function(){
		validateformRenameChannel();
	});
});

function validateformRenameChannel(){
	var name = $("input[name=newChannelName]").val();
	$.post("modele/channelProcess.php", {function : "changeChannelName", newChannelName : name }, function(data){
			loadChannelInfo();
			$('#modalRenameChannel').modal('toggle');
			console.log("changeChannelName()");
	});
	$("input[name=newChannelName]").val("");
}

$("#submitBtnChangeChannelDescription").click(function() {
	if ($.trim($("#newChannelDescription").val())) {
		$("#formChangeChannelDescription").submit(function(){
			validateformChangeChannelDescription();
		});
	}
});

function validateformChangeChannelDescription(){
	var description = $("#newChannelDescription").val().replace(/\n/g, '<br />');
	console.log(description);
	$.post("modele/channelProcess.php", {function : "changeChannelDescription", newChannelDescription : description }, function(data){
		loadChannelInfo();
		$('#modalChangeChannelDescription').modal('toggle');
		console.log("changeChannelDescription()");
	});
	$("#newChannelDescription").val("");
}

function loadChannelInfo(){
	$.post("modele/channelProcess.php", {function : "loadChannelInfo"}, function(data){
		var obj = jQuery.parseJSON(data);
		$("#roomName").html(obj.name); //Chat name
		$("#previousChannelName").attr("placeholder", obj.name); //Set previous name
		$("#previousChannelDescription").html(obj.description); //Set previous name

		console.log("loadChannelInfo()");
	});
}









function sendChat(text){
	$.post("modele/chatProcess.php", { function : "send", message : text }, function(data){
	});
	clear();
	chat.update();
	$("#chatbox").animate({ scrollTop: $("#chatbox").prop('scrollHeight') });
	console.log("send()");
}

function clear(){
	$("#chatMsgTextArea").val('').focus();
}

function getStateOfChat() {
	$.post("modele/chatProcess.php", { function : "getState"}, function(data){
		var obj = jQuery.parseJSON(data);
		state = obj.state;
		console.log("getStateOfChat()");
	});
}

function updateChat(){	
	$.post("modele/chatProcess.php", {function : "update", state : state}, function(data){
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
	$.post("modele/chatProcess.php", {function : "update", state : 0}, function(data){
		var obj = jQuery.parseJSON(data);
		for (var i = obj.data.length - 1; i >= 0; i--) {
			$("#chatbox").append('<div class="chatmessage"><span class="timestamp">'+obj.data[i].time+'</span> <span style="color:'+obj.data[i].color+'">'+obj.data[i].username+'</span><span class="colon"> : </span><span>'+obj.data[i].text+'</span></div>');
		}	
		state = obj.state;
		$("#chatbox").animate({ scrollTop: $("#chatbox").prop('scrollHeight') }, 20);
		console.log("init()");
	});
}