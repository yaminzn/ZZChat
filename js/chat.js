/******************************************************************************* Right side *******************************************************************************/

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

/******************************************************************************* Navbar buttons *******************************************************************************/
$("#aAddUsers").click(function() {
	$.post("modele/channelProcess.php", {function : "loadAddUsersList"}, function(data){
		console.log('loadAddUsersList()');
		$("#addUsersList").html('');
		var obj = jQuery.parseJSON(data);
		if(obj.length != 0){
			$.each(obj, function( index, value ) {
				$("#addUsersList").append('<li class="list-group-item"><label class="form-check-inline"><input class="form-check-input" value="'+value+'" type="checkbox">\t'+value+'</label></li>');
			});
		}
		else{
			$("#addUsersList").html('Everybody is in the chat!');
		}
	});
});

$("#submitBtnAddUsers").click(function() {
	var selected = [];
	$('#addUsersList input:checked').each(function() {
	    selected.push($(this).attr('value'));
	});
	$.post("modele/channelProcess.php", {function : "addUsers", list : selected}, function(data){
		console.log(data);
		loadUsersList() 
		$('#modalAddUsers').modal('toggle');
	});
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
	var description = $("#createChannelDescription").val().replace(/\n/g, '<br />').substring(0,200);
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
	var description = $("#newChannelDescription").val().replace(/\n/g, '<br />').substring(0,200);
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
		$("#currentChannel").html(obj.name); //Chat name
		$("#previousChannelName").attr("placeholder", obj.name); //Set previous name
		$("#previousChannelDescription").html(obj.description); //Set previous name
		$("#channelDescription").html(obj.description);

		console.log("loadChannelInfo()");
	});
}

/******************************************************************************* Chat *******************************************************************************/
$("#sendMessageBtn").click(function() {
	chat.send($("#chatMsgTextArea").val());
});

var fruitsCursor = 0;
var fruits = [""];

$("#chatMsgTextArea").keydown(function(e) {
	switch(e.which) {
	    case 13: //Enter
			e.preventDefault();
			if($("#chatMsgTextArea").val()){	
				chat.send($(this).val());
				fruits.unshift("");
				fruitsCursor = 0;
				if(fruits.length > 20)
					fruits.pop();
			}
	    break;
	    case 40: //Down
	    	if(fruitsCursor > 0 && fruits.length > 1){
	        	fruitsCursor--;
	        	$("#chatMsgTextArea").val(fruits[fruitsCursor]);
	        }
	    break;
	    case 38: //Up
	    	if(fruitsCursor < (fruits.length - 1) && fruits.length > 1){
	        	fruitsCursor++;
	     	   $("#chatMsgTextArea").val(fruits[fruitsCursor]);
	     	}
	    break;
	}
}).bind('input propertychange', function() {
		fruits[0] = $("#chatMsgTextArea").val();
});

function sendFiles(){
	var l = filesToUpload.length;
	if(l>0){
		
		var fd = new FormData();
		for (var i=0; i<l; i++) {
			fd.append("fileToUpload[]", filesToUpload[i]);
		}

		console.log(fd);
		$.ajax({
			url: 'modele/fileProcess.php',
			type: 'POST',
			data: fd,
				//dataType: 'json',
				success: function (data) {
					console.log(data);
				},
				cache: false,
				contentType: false,
				processData: false
		});


		filesToUpload = [];
		$("#fileUl").html('');
	}
	else{
		console.log("Var is empty");
	}
}

function sendGif(url){
	$.post("modele/chatProcess.php", { function : "send", type : "gif",  url : url }, function(data){
	});
	chat.update();
	console.log("sendGif()");	
}

function sendChat(text){
	//Send text
	$.post("modele/chatProcess.php", { function : "send", type : "text",  message : text }, function(data){
	});
	clear();
	stateStartValue[stateOverview['currentChatId']]++;
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
		stateOverview = obj;
		//console.log(stateOverview);
		console.log("getStateOfChat()");
	});
}

function initStateStartValue(){
	$.post("modele/chatProcess.php", { function : "getState"}, function(data){
		var obj = jQuery.parseJSON(data);
		//console.log(obj);
		stateStartValue = obj.channels;
		console.log("initStateStartValue()");
	});
}

function addElementToChat(obj, i){
	switch(obj.data[i].type) {
		case "text":
			$("#chatbox").append('<div class="chatmessage"><span class="timestamp">'+obj.data[i].time+'</span> <span style="color:'+obj.data[i].color+'">'+obj.data[i].username+'</span> <span class="colon"> : </span><span>'+obj.data[i].text+'</span></div>');
		break;
		case "command":
			stateStartValue[stateOverview['currentChatId']]++;			
			$("#chatbox").append('<div class="chatmessage"><span class="timestamp">'+obj.data[i].time+'</span> <span style="color:'+obj.data[i].color+'">'+obj.data[i].username+'</span> <span class="colon"> : </span><span class="command">'+obj.data[i].text+'</span></div>');
		break;
		case "gif":
			$("#chatbox").append('<div class="chatmessage"><span class="timestamp">'+obj.data[i].time+'</span> <span style="color:'+obj.data[i].color+'">'+obj.data[i].username+'</span> <span class="colon"> : </span><img class="gif img-thumbnail" style="vertical-align: text-top" src="'+obj.data[i].url+'" /></div>');
		break;
		case "file":
			var split = obj.data[i].filename.split("_~");
			$("#chatbox").append('<div class="chatmessage"><span class="timestamp">'+obj.data[i].time+'</span> <span style="color:'+obj.data[i].color+'">'+obj.data[i].username+'</span> <span class="colon"> : </span><a href="files/'+split[1]+'/'+obj.data[i].filename+'" class="btn btn-success btn-sm" role="button" download="'+split[2]+'">'+split[2]+' <i class="fa fa-download" aria-hidden="true"></i></a></div>');
		break;
		default:
			console.log("Error : unknown type");
	}		
}

var stateOverview = new Array();
stateOverview['currentChatId'] = 0;
stateOverview['channels'] = new Array;
stateOverview['channels'][0] = 0;

var stateStartValue = new Array();

function updateChat(){	
	$.post("modele/chatProcess.php", {function : "update", state : stateOverview['channels'][stateOverview['currentChatId']]}, function(data){
		var obj = jQuery.parseJSON(data);
		for (var i = obj.data.length - 1; i >= 0; i--) {
			addElementToChat(obj, i);
		}	
		stateOverview['channels'][stateOverview['currentChatId']] = obj.state;
		getStateOfChat();
		updateChannelsTag();
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
		console.log(obj);
		for (var i = obj.data.length - 1; i >= 0; i--) {
			addElementToChat(obj, i);
		}	
		stateOverview['channels'][stateOverview['currentChatId']] = obj.state;
		initStateStartValue();
		$("#chatbox").animate({ scrollTop: $("#chatbox").prop('scrollHeight') }, 20);
		console.log("init()");
	});
}

function updateChannelsTag(){
	var tab = [];
	$.each(stateStartValue, function( index, value ) {
		tab.push(index);
	});
	$(".tag").each(function(index) {
		var res = stateOverview['channels'][tab[index]] - stateStartValue[tab[index]];
		if(res != 0){
			$(this).html(res);
		}
		else{
			$(this).html('');
		}
  		//console.log( index + ": " + stateOverview['channels'][index] );
	});
}

/******************************************************************************* Gif/Emote popover *******************************************************************************/

$(document).ready(function(){
	$('.gifPO').popover({ 
		html : true,
		trigger : 'manual',
		placement : 'top',
		container: 'body',
		content: function() {
			return $('#gif_popover_content_wrapper').html();
		}
	}).click(function(e) {
		$(".po").not(this).popover('hide');
		$(".fileUploadPO").popover('hide');
		$(this).popover('toggle');
		e.stopPropagation();
	});

	$('.emotesPO').popover({ 
		html : true,
		trigger : 'manual',
		placement : 'top',
		container: 'body',
		content: $('#emotes_popover_content_wrapper').remove().html()
	}).click(function(e) {
		$(".po").not(this).popover('hide');
		$(".fileUploadPO").popover('hide');
		$(this).popover('toggle');
		loadEmotesPopover();
		e.stopPropagation();
	});

	$('.fileUploadPO').popover({ 
		html : true,
		trigger : 'manual',
		placement : 'top',
		container: 'body',
		content: $('#fileUpload_popover_content_wrapper').remove().html()
	}).click(function(e) {
		filesToUpload = [];
		$(".po").not(this).popover('hide');
		$(this).popover('toggle');
		e.stopPropagation();
	});

	$('#chatMsgTextArea').focus(function() {
		stateStartValue[stateOverview['currentChatId']] = stateOverview['channels'][stateOverview['currentChatId']];
		updateChannelsTag();
	});
});

$('body').on("click", "button#gifSearchBtn", function(){
	queryGif();
}).on("keypress", "input#search", function(e){
	if(e.keyCode == 13){
		queryGif();
	}
}).on("click", ".gifList" ,function(){
	//send
	sendGif($(this).attr('src'));
	console.log($(this).attr('src'));
	closeAllPopovers(1);
}).on('click', function (e) {

	closeAllPopovers(e);
}).on('click', ".emote", function () {
	$("#chatMsgTextArea").val($("#chatMsgTextArea").val()+$(this).attr('title')+" ").focus();
	closeAllPopovers(1);
});
/*
$(".gifList").on('click', ".gifList", function (e) {
	closeAllPopovers(e);
});*/

function closeAllPopovers(e){
	if(e==1){
		$('.po').each(function () {
			$(this).popover('hide');
        });
		$(".fileUploadPO").popover('hide');
	}
	else{
		/*
		if(e.target.id != "file-upload" || e.target.id != "labelfile-upload"){
		
			$('.po').each(function () {
	        //the 'is' for buttons that trigger popups
	        //the 'has' for icons within a button that triggers a popup
		        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.po').has(e.target).length === 0) {
		        	$(this).popover('hide');
		        }

	    	}); 
    	}
    	*/
	}
}

/*
var results;
var count;
*/
/*
$("#res").scroll(function() {
	if(($("#res")[0].scrollHeight - $("#res").scrollTop() == $("#res").outerHeight() )) { //Not at the bottom of the div
		console.log("bottom");
		loadGif();
	}
});*/

function queryGif(){
	$(".popover #gifRes").html(''); //Vide la div
	//count = false;
	var str = $(".popover #search").val().replace(/ /g, '+'); //Remplace les espaces par des +
	$.getJSON("http://api.giphy.com/v1/gifs/search?q="+str+"&api_key=dc6zaTOxFJmzC&limit=50", function(data){ //Récupération du JSON, 50 gifs
		var results = data.data;
		//count = 1;
		console.log(data);		
		if (results.length) {
			loadGif(results); //Load only l first gifs, more if scroll down
		} else {
			console.log("length false"); //0 résultat
			$(".popover #gifRes").html("No results found");
		}
	});
}

function loadGif(results){
/*
	if(count !== false){
			console.log("add");
		var l = (results.length > 5*count) ? 5*count : results.length; 
		for(var i = (count-1)*5;i<l;i++){
			var url = results[i].images.downsized.url;
			$(".popover #res").append(buildImg(url));
		}
		count++;
		if(results.length < 5*count){
			count = false;
			$(".popover #res").append("<p>No more gifs</p>");
			data = false;
		} 
	}
*/

	for(var i = 0;i<results.length;i++){
		var url = results[i].images.downsized.url;
		$(".popover #gifRes").append('<img src="'+url+'" class="gifList" alt="gif" />');
	}
	$(".popover #gifRes").append("<p>No more gifs</p>");
}

function loadEmotesPopover(){
	$.getJSON("json/emotes/twitchemotes.json", function(data){ //Récupération du JSON, 50 gifs
		$.each(data.emotes, function(key, value){
			$("#emotes_global").append('<img src="'+data.template.small.replace("{image_id}",value.image_id)+'" class="emote" title="'+key+'" />');
		});
	});

	$.getJSON("json/emotes/bttvemotes.json", function(data){ //Récupération du JSON, 50 gifs
		$.each(data.emotes, function(key, value){
			$("#emotes_bttv").append('<img src="https:'+data.urlTemplate.replace("{{id}}/{{image}}",value.id+"/1x")+'" class="emote" title="'+value.code.replace('\\',"")+'" />');
		});
	});

	$.getJSON("json/emotes/customemotes.json", function(data){ //Récupération du JSON, 50 gifs
		$.each(data.subemotes, function(key, value){
			$("#emotes_custom").append('<img src="'+data.template.small.replace("{image_id}",value.image_id)+'" class="emote" title="'+value.code+'" />');
		});
		$.each(data.miscemotes, function(key, value){
			$("#emotes_custom").append('<img src="'+value.image_link+'" class="emote miscemote" title="'+value.code+'" />');
		});
	});
};	

/******************************************************************************* File upload popover *******************************************************************************/

$("body").on('click', "#upload",function () {
	sendFiles();
	$('.fileUploadPO').popover('hide');
}).on('change','#file-upload' , function(){ 
	checkUploadFile(); 
}).on('click','.fileItem' , function(){ //Remove files in the ul list and in the upload variable array
	var fileToRemove = $(this).find(".file_name").html();
	for(var i=0; i<filesToUpload.length; i++){
		if(filesToUpload[i].name == fileToRemove){
				filesToUpload.splice(i, 1);
		}
	}
	$(this).remove();
});

var filesToUpload = [];

 function checkUploadFile(){
 	var files = $('#file-upload').prop("files");
 	//console.log(files);
 	filesToUpload = [];
 	$("#fileUl").html('');
 	if(files.length != 0){
	 	//console.log(files);
	 	$.each(files, function(index, value){
	 		var sizeInMB = (value.size / (1024*1024)).toFixed(2);
	 		if(parseInt(sizeInMB) < 8){
	 			filesToUpload.push(files[index]);
	 			$("#fileUl").append('<li class="list-group-item fileItem"><span class="file_name">'+value.name+'</span> <br> '+sizeInMB+' Mo<i class="fa fa-times pull-right ulic" aria-hidden="true"></i></li>');
	 		//console.log(value.name);
	 		}
	 		else{
	 			$("#fileUl").append('<li class="list-group-item fileItem fileTooBig">[Error : filesize > 8 Mo, file will not be uploaded] '+value.name+' / '+sizeInMB+' Mo<i class="fa fa-times pull-right ulic" aria-hidden="true"></i></li>');
	 		}
	 	});
	}
	console.log(filesToUpload);
 }

 /******************************************************************************* Text formatting *******************************************************************************/
$("#bold").on('click', function(){
	addFormatting("bold");
 });
$("#italic").on('click', function(){
	addFormatting("italic");
 });
$("#underline").on('click', function(){
	addFormatting("underline");
 });
$("#strike").on('click', function(){
	addFormatting("strike");
 });

function addFormatting(i){
	var letter;
	switch(i) {
		case "bold":
			letter = "b";
		break;
		case "italic":
			letter = "i";
		break;
		case "underline":
			letter = "u";
		break;
		case "strike":
			letter = "s";
		break;
	}
	$("#chatMsgTextArea").val($("#chatMsgTextArea").val()+'['+letter+'][/'+letter+']').focus();
}