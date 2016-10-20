<?php
	include 'functions.php';
	include 'return.php';

	$log = array();
	$log = returnChannelOnlineUsers(returnChannelUserIdList($_SESSION['currentChatId']));

	//$log = returnOnlineUsers();

	echo json_encode($log);
?>