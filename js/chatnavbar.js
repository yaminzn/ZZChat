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