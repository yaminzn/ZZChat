function loadUsersList() {
	$.post("online.php", { chatroomId : 0 }, function(data){
		var obj = jQuery.parseJSON(data);
		var j = 0;
		$("#myPopoverContent").html('');
		for(i=0;i<obj.length;i++){
			if(obj[i].online == 1){
				$("#myPopoverContent").append('<span class="glyphicon glyphicon-stop online"></span>');
				j++;
			}
			else{
				$("#myPopoverContent").append('<span class="glyphicon glyphicon-stop offline"></span>');
			}
			$("#myPopoverContent").append(' <span style="color:'+obj[i].color+'">'+obj[i].username+'</span><br>');
		}
		$('#userlistSpan').html(j+'/'+obj.length+' ');
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

$("#submitBtnNewChatroomName").click(function() {
	$("#formRenameChatroom").submit(function(){
		validateformRenameChatroom();
	});
});

function validateformChangeChatroomDescription(){
	var name = $("input[name=newChatroomName]").val();
	$.post("chatnavbarprocess.php", {function : "changeChatroomName", newChatroomName : name }, function(data){
			loadChatnavbarInfo();
			$('#modalRenameChatroom').modal('toggle');
			console.log("changeChatroomName()");
	});
	$("input[name=newChatroomName]").val("");
}

$("#submitBtnChangeChatroomDescription").click(function() {
	if ($.trim($("#newChatroomDescription").val())) {
		$("#formChangeChatroomDescription").submit(function(){
			validateformChangeChatroomDescription();
		});
	}
});

function validateformChangeChatroomDescription(){
	var description = $("#newChatroomDescription").val().replace(/\n/g, '<br />');
	console.log(description);
	$.post("chatnavbarprocess.php", {function : "changeChatroomDescription", newChatroomDescription : description }, function(data){
		loadChatnavbarInfo();
		$('#modalChangeChatroomDescription').modal('toggle');
		console.log("changeChatroomDescription()");
	});
	$("#newChatroomDescription").val("");
}

function loadChatnavbarInfo(){
	$.post("process.php", {function : "loadChatroomInfo"}, function(data){
		var obj = jQuery.parseJSON(data);
		$("#roomName").html(obj.name); //Chat name
		$("#previousChatroomName").attr("placeholder", obj.name); //Set previous name
		$("#previousChatroomDescription").html(obj.description); //Set previous name

		console.log("loadChatroomInfo()");
	});
}