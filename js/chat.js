function loadUsersList() {
	$.post("modele/online.php", function(data){
		var obj = jQuery.parseJSON(data);
		var j = 0;
		$("#userlist").html('');
		for(i=0;i<obj.length;i++){
			if(obj[i].online == 1){
				$("#userlist").append('<span class="online"><i class="fa fa-circle" aria-hidden="true"></i></span>');
				j++;
			}
			else{
				$("#userlist").append('<span class="offline"><i class="fa fa-circle" aria-hidden="true"></i></span>');
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
				$('#modalLeave').modal('toggle');
				console.log("leaveChannel()");
				window.location.replace("?id=0");
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

//2 mo maximum
function checkImgSize(){
	var file_size = $('#uploadImage')[0].files[0].size;
	if(file_size>2097152) {
		$("#chatbox").append("<span style='color:red'>Error : File size is greater than 2MB</span>");
		return false;
	} 
	return true;
}

$("formUploadImage").submit(function(){
    var formData = new FormData($(this)[0]);

    $.ajax({
        url: "modele/chatProcess.php",
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
            alert(data)
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
});

function sendChat(text){
	//Send image
	if($('#uploadImage').val() != ''){
		console.log("sendImg()");
		if(checkImgSize()){

			var fd = new FormData();
			fd.append('file', $('#uploadImage')[0].files[0]);
			console.log(fd);
			$.ajax({
				url: 'modele/fileProcess.php',
				type: 'POST',
				data: fd,
				//dataType: 'json',
				success: function (data) {
					console.log("data"+data);
				},
				cache: false,
				contentType: false,
				processData: false
			});
		}
		$('#uploadImage').val("");
	}
	//Send text
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