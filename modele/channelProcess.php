<?php
	if(!isset($_POST['function'])){
		exit;
	}

	include 'functions.php';
	include 'return.php';

	$function = $_POST['function'];
	$res = 0;

	//Fat ass switch, process all channel related things and user's settings query
	
	switch($function) {
		//Change password
		case('changePw'):
			$res = changeUsernamePassword($_SESSION['userId'], $_POST['oldpw'], $_POST['newpw']);
		break;

		//Change username color
		case('changeColor'):
			if(!isset($_POST['newColor'])) break;
			changeUsernameColor($_SESSION['userId'], $_POST['newColor']);

			$res = 1;
		break;

		//Change channel name
		case('changeChannelName'):
			if(!isset($_POST['newChannelName'])) break;
			changeChannelName($_POST['newChannelName']);

			$res = 1;
		break;

		//Change channel description
		case('changeChannelDescription'):
			if(!isset($_POST['newChannelDescription'])) break;
			changeChannelDescription($_POST['newChannelDescription']);

			$res = 1;
		break;

		//Create channel, with name and description
		case('createChannel'):
			$res = createChannel($_POST['name'], $_POST['description']);
		break;

		//See the loadChannelInfo in JS
		case('loadChannelInfo'):	
			$str = file_get_contents("../json/channel.json");
			$json = json_decode($str, true);

			$res = json_encode($json['channel'][$_SESSION['currentChatId']]);
		break;

		//Bye
		case('leaveChannel'):	
			removeUserFromChannel($_SESSION['userId'], $_SESSION['currentChatId']);
			$res = 1;
		break;

		//Remove users from the user's current channel
		//Chatbot write it in chat
		case('kickUsers'):	
			if(!isset($_POST['list'])) break;

			$tab['type'] = "text";
			$tab['time'] = date('H:i');
			$tab['username'] = "Chatbot"; //bot name
			$tab['color'] = "#cc0000";

			//Specific to the type
			$tab['text'] = "[b]".$_SESSION['username']."[/b] kicked";

			foreach ($_POST['list'] as $key => $value) {
				$userid = getuserId($value);
				if($userid != -1){
					 removeUserFromChannel($userid, $_SESSION['currentChatId']);
					 $tab['text'] = $tab['text']." [b]".$value."[/b]";
				}
				$tab['text'] = $tab['text']." !";
			}

			addDataToChannel($tab, $_SESSION['currentChatId']);

			$res = 1;
		break;

		//Add users to the user's current channel
		//Chatbot write it in chat
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

		//return the name of the people who aren't in chat and can be added
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