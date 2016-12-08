<?php
	if(!isset($_POST['function'])){
		exit;
	}

	include 'functions.php';
	include 'return.php';

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
			removeUserFromChannel($_SESSION['userId'], $_SESSION['currentChatId']);
			$res = 1;
		break;

		case('addUsers'):	
			if(!isset($_POST['list'])) break;

			$tab['type'] = "text";
			$tab['time'] = date('H:i');
			$tab['username'] = "Chatbot"; //bot name
			$tab['color'] = "#cc0000";

			//Specific to the type
			$tab['text'] = "[b]".$_SESSION['username']."[/b] added";

			foreach ($_POST['list'] as $key => $value) {
				$userid = getuserId($value);
				if($userid != -1){
					 addtoUserChannelIdList($userid, $_SESSION['currentChatId']);
					 addUserToChannel($userid, $_SESSION['currentChatId']);
					 $tab['text'] = $tab['text']." [b]".$value."[/b]";
				}
				$tab['text'] = $tab['text']." !";
			}

			addDataToChannel($tab, $_SESSION['currentChatId']);

			$res = 1;
		break;

		case('loadAddUsersList'):
			$str = file_get_contents('../json/users.json');
			$json = json_decode($str, true);

			$userList = array();
			$tab = $json['users'];
			$size = count($tab);
			for($i=0;$i<$size;$i++){
				$userList[$i] = $json['users'][$i]['id'];
			}

			$result = array_diff($userList, returnChannelUserIdList($_SESSION['currentChatId']));
			$res = array();
			foreach ($tab as $key => $value) {
				if(in_array($value['id'], $result))
					array_push($res, $value['username']);
			}
			$res = json_encode($res);
		break;
    }
	
    echo $res;
?>