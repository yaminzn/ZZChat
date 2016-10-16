<?php
	if(!isset($_POST['function'])){
		exit;
	}

	include 'functions.php';

	$function = $_POST['function'];
	$res = 0;
	
	switch($function) {
		case('changeChatroomName'):
			if(!isset($_POST['newChatroomName'])) break;
			changeChatroomName($_POST['newChatroomName']);

			$res = 1;
		break;

		case('changeChatroomDescription'):
			if(!isset($_POST['newChatroomDescription'])) break;
			changeChatroomDescription($_POST['newChatroomDescription']);

			$res = 1;
		break;
    }
	
    echo $res;
?>