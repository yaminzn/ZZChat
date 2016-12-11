/******************************************************************************* Right side *******************************************************************************/

//Load the online user list
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

//Load the kick list
$("#kKickUsers").click(function() {
	$.post("modele/online.php", function(data){
		var obj = jQuery.parseJSON(data);
		$("#kickUsersList").html('');
		if(obj.length != 0){
			$.each(obj, function( index, value ) {
				$("#kickUsersList").append('<li class="list-group-item"><label class="form-check-inline"><input class="form-check-input" value="'+value.username+'" type="checkbox">\t'+value.username+'</label></li>');
			});
		}
		else{
			$("#kickUsersList").html('You are alone!');
		}		
	});
});

//Send the kick query
$("#submitBtnKickUsers").click(function() {
	var selected = [];
	$('#kickUsersList input:checked').each(function() {
	    selected.push($(this).attr('value'));
	});
	
	$.post("modele/channelProcess.php", {function : "kickUsers", list : selected}, function(data){
		console.log(data);
		loadUsersList();
		location.reload();
	});
});

//Load the add list
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

//Send the add query
$("#submitBtnAddUsers").click(function() {
	var selected = [];
	$('#addUsersList input:checked').each(function() {
	    selected.push($(this).attr('value'));
	});
	$.post("modele/channelProcess.php", {function : "addUsers", list : selected}, function(data){
		console.log(data);
		loadUsersList();
		$('#modalAddUsers').modal('toggle');
	});
});

//Send the leave query, same thing as kicking yourself
$("#submitBtnLeave").click(function() {
	$.post("modele/channelProcess.php", {function : "leaveChannel"}, function(data){
				$('#modalLeave').modal('toggle');
				console.log("leaveChannel()");
				window.location.replace("http://fc.isima.fr/~bezheng/zzchat/channels/");
	});
});

//Click Trigger
$("#submitBtnCreateChannel").click(function() {
	$("#formCreateChannel").submit(function(){
		validateformCreateChannel();
	});
});

//Send the channel creation query
function validateformCreateChannel(){
	var name = $("#createChannelName").val();
	var description = $("#createChannelDescription").val().replace(/\n/g, '<br />').substring(0,200);
	$.post("modele/channelProcess.php", {function : "createChannel", name : name, description : description }, function(data){
		$('#modalcreateChannel').modal('toggle');
		console.log("createChannel()");
		window.location.replace("channels/"+data);
	});
	$("#newChannelDescription").val("");
	$("#createChannelDescription").val("");
}

//Click Trigger
$("#submitBtnNewChannelName").click(function() {
	$("#formRenameChannel").submit(function(){
		validateformRenameChannel();
	});
});

//Send the channel rename query
function validateformRenameChannel(){
	var name = $("input[name=newChannelName]").val();
	$.post("modele/channelProcess.php", {function : "changeChannelName", newChannelName : name }, function(data){
			loadChannelInfo();
			$('#modalRenameChannel').modal('toggle');
			console.log("changeChannelName()");
	});
	$("input[name=newChannelName]").val("");
}

//Click trigger
$("#submitBtnChangeChannelDescription").click(function() {
	if ($.trim($("#newChannelDescription").val())) {
		$("#formChangeChannelDescription").submit(function(){
			validateformChangeChannelDescription();
		});
	}
});

//Send the description change query, only 200 characters are sent
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

//Load the current channel's information in the page (navbar, left side, ...) 
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

//Click trigger
$("#sendMessageBtn").click(function() {
	chat.send($("#chatMsgTextArea").val());
});


//Fruits = history, register the last 20 valid sent messages
var fruitsCursor = 0;
var fruits = [""];

$("#chatMsgTextArea").keydown(function(e) {
	switch(e.which) {
	    case 13: //Enter
			e.preventDefault();
			//You can't send only spaces
			if($("#chatMsgTextArea").val() && $.trim($("#chatMsgTextArea").val()) != ''){	
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
		//Save the current input
		fruits[0] = $("#chatMsgTextArea").val();
});


//Send files
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

//Send the data type gif
function sendGif(url){
	stateStartValue[stateOverview['currentChatId']]++;	
	$.post("modele/chatProcess.php", { function : "send", type : "gif",  url : url }, function(data){
	});
	chat.update();
	console.log("sendGif()");	
	$("#chatbox").animate({ scrollTop: $("#chatbox").prop('scrollHeight') });
}

//Send the data type text
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

//Clear the typing textarea
function clear(){
	$("#chatMsgTextArea").val('').focus();
}

//Get the state array
function getStateOfChat() {
	$.post("modele/chatProcess.php", { function : "getState"}, function(data){
		var obj = jQuery.parseJSON(data);
		stateOverview = obj;
		//console.log(stateOverview);
		console.log("getStateOfChat()");
	});
}

//Get the initial state array
function initStateStartValue(){
	$.post("modele/chatProcess.php", { function : "getState"}, function(data){
		var obj = jQuery.parseJSON(data);
		//console.log(obj);
		stateStartValue = obj.channels;
		console.log("initStateStartValue()");
	});
}

//Add recieved messages to chat div
// normal message = text
// chat command = command
// file = file
// gif = gif
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

// state overview = array of lines count in each chat the user is in, updated each second
// state start value = array of lines count in each chat the user is in when he joined, not updated*
var stateOverview = new Array();
stateOverview['currentChatId'] = 0;
stateOverview['channels'] = new Array;
stateOverview['channels'][0] = 0;

var stateStartValue = new Array();

// See if there's any new lines in each chat the user is in
function updateChat(){	
	$.post("modele/chatProcess.php", {function : "update", state : stateOverview['channels'][stateOverview['currentChatId']]}, function(data){
		var obj = jQuery.parseJSON(data);
		//Add new lines if yes
		for (var i = obj.data.length - 1; i >= 0; i--) {
			addElementToChat(obj, i);
		}	
		if(obj.data.length > 0){
			//Auto scroll the chat div if the users is scrolled down at the bottom
			if($("#chatbox").scrollTop() + 800 > $("#chatbox").prop('scrollHeight')){
				$("#chatbox").animate({ scrollTop: $("#chatbox").prop('scrollHeight') });
			}
		}

		//Need to update some things, see below
		stateOverview['channels'][stateOverview['currentChatId']] = obj.state;
		getStateOfChat();
		updateChannelsTag();
		console.log("update()");

	});
}

//Not really useful but whatever
function Chat () {
	this.update = updateChat;
	this.send = sendChat;
	this.getState = getStateOfChat;
}

//Get the chat entire content with a 0 state
//init = first update
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

//Display the new messages tags
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

//Initiate all popovers
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

	//Update unread message count on focus
	//the problem is that chat is not updated while focused in but ON focus
	$('#chatMsgTextArea').focus(function() {
		stateStartValue[stateOverview['currentChatId']] = stateOverview['channels'][stateOverview['currentChatId']];
		updateChannelsTag();
	});
});

//Search gif triggers
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

//Is this working or even used? I don't know
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

//Send the search gif query using the GIPHY API, 50 gifs maximum
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

//Display the query results in the popover
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


//Load the emotes, you're going to have a bad time with a shitty laptop
function loadEmotesPopover(){
	$.getJSON("json/emotes/twitchemotes.json", function(data){ 
		$.each(data.emotes, function(key, value){
			$("#emotes_global").append('<img src="'+data.template.small.replace("{image_id}",value.image_id)+'" class="emote" title="'+key+'" />');
		});
	});

	$.getJSON("json/emotes/bttvemotes.json", function(data){
		$.each(data.emotes, function(key, value){
			$("#emotes_bttv").append('<img src="https:'+data.urlTemplate.replace("{{id}}/{{image}}",value.id+"/1x")+'" class="emote" title="'+value.code.replace('\\',"")+'" />');
		});
	});

	$.getJSON("json/emotes/customemotes.json", function(data){ 
		$.each(data.subemotes, function(key, value){
			$("#emotes_custom").append('<img src="'+data.template.small.replace("{image_id}",value.image_id)+'" class="emote" title="'+value.code+'" />');
		});
		$.each(data.miscemotes, function(key, value){
			$("#emotes_custom").append('<img src="'+value.image_link+'" class="emote miscemote" title="'+value.code+'" />');
		});
	});
};	

/******************************************************************************* File upload popover *******************************************************************************/

//File upload handling
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

//Files to upload array
var filesToUpload = [];

//Checks the files size, maximum is 8Mo
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

//Send the color change query
$("#submitColor").on('click', function(){
	var c = $("#Ucolor").val();
	$.post("modele/channelProcess.php", { function : "changeColor", newColor : c}, function(data){
		console.log(data);
		console.log("changeColor()");
		$('#modalSettings').modal('toggle');
	});
 });

//Send the password change query
$("#submitUserPassword").on('click', function(){
	if($("#newUserPassword").val() != $("#verifyNewUserPassword").val()){
		$("#errpw").html("New password does not match");
	}
	else{
		$.post("modele/channelProcess.php", { function : "changePw", oldpw : $("#previousUserPassword").val(), newpw : $("#verifyNewUserPassword").val()}, function(data){
			if(data != 1){
				$("#errpw").html("Wrong old password");
			}
			else{
				$("#errpw").html("Success!");
			}
			console.log(data);
		});
	}
 });


