<?php
	if(!isset($_POST['function'])){
		exit;
	}

	include 'functions.php';

	$function = $_POST['function'];
	$res = 0;
	
	switch($function) {
		case('changeChannelName'):
			if(!isset($_POST['newChannelName'])) break;
			changeChannelName($_POST['newChannelName']);

			$res = 1;
		break;

		case('changeChannelDescription'):
			if(!isset($_POST['newChannelDescription'])) break;
			changeChannelDescription($_POST['newChannelDescription']);

			$res = 1;
		break;

		case('createChannel'):
			$res = createChannel($_POST['name'], $_POST['description']);
		break;

		case('loadChannelInfo'):	
			$str = file_get_contents("../json/channel.json");
			$json = json_decode($str, true);

			$res = json_encode($json['channel'][$_SESSION['currentChatId']]);
		break;

		case('leaveChannel'):	
			removeUserFromChannel($_SESSION['currentChatId']);
			$res = 1;
		break;
    }
	
    echo $res;
?>