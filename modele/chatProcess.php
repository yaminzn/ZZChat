<?php
	if(!isset($_POST['function'])){
		exit;
	}

	include 'functions.php';
	include 'return.php';

	$function = $_POST['function'];

	$log = array();

	//Process all chat related queries
	
	switch($function) {
		
		//When the user send data
		case('send'):
			switch ($_POST['type']) {
				//If it's a regular message
				case "text":
					//His status is updated
					updateUserActivity();
					if(empty($_POST['message'])){
						break;
					}

					$message = htmlentities(strip_tags($_POST['message']));

					//Don't accept blank messages
					if (preg_match("/^[\s]+$/", $message)) {
						break;
					}

					//Always defined
					$tab['type'] = "text";
					$tab['time'] = date('H:i');
					$tab['username'] = $_SESSION["username"];
					$tab['color'] = $_SESSION["color"];

					//Specific to the type
					$tab['text'] = $message;

					addDataToChannel($tab, $_SESSION['currentChatId']);

					//Check if this was a command
					checkCommands($message);

				break;
				//If it's a gif
				case "gif":
					if(empty($_POST['url'])){
						break;
					}

					//Always defined
					$tab['type'] = "gif";
					$tab['time'] = date('H:i');
					$tab['username'] = $_SESSION["username"];
					$tab['color'] = $_SESSION["color"];

					//Specific to the type
					$tab['url'] = $_POST['url'];

					addDataToChannel($tab, $_SESSION['currentChatId']);

				break;
			}					
		break;
		
		//Return new lines in the current chat
		case('update'):
			$state = $_POST['state'];
			
			$str = file_get_contents("../json/channels/".$_SESSION['currentChatId'].".json");
			$json = json_decode($str, true);
			$count = count($json['message']);

			//echo '<pre>' . print_r($json['message'], true) . '</pre>';

			if ($state == $count){
				$log['state'] = $state;
				$log['data'] = false;
			}
			else{
				$text = array();
				
				for($i=$state;$i<$count;$i++) {
					$test[$i-$state] = textToEmote($json['message'][$count-$i+$state-1]);
				}
				$log['data'] = $test;
			}

			$log['state'] = $count;
		break;

		//return the state array, see "stateOverview" in JS
		case('getState'):
			$list = returnUserChannelIdList($_SESSION['userId']);
			$size = count($list);
			$tab = array();
			for($i=0;$i<$size;$i++){
				$tab["$list[$i]"] = returnGetState($list[$i]);
			}

			$log['currentChatId'] = $_SESSION['currentChatId'];
			$log['channels'] = $tab;
		break;
    }
	//Returned in json for the JS
    echo json_encode($log);
?>