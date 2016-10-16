<?php
	
	include 'functions.php';
	$log = array();

	if(isset($_POST['chatroomId'])){
		$log = returnChatroomOnlineUsers(returnChatroomUserIdList($_POST['chatroomId']));
	}
	else{
		$log = returnOnlineUsers();
	}

	echo json_encode($log);
?>