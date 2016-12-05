<?php
	if(!isset($_POST['function'])){
		exit;
	}

	include 'functions.php';
	include 'return.php';

	$function = $_POST['function'];

	$log = array();
	
	switch($function) {
		
		case('send'):
			switch ($_POST['type']) {
				case "text":
					if(empty($_POST['message'])){
						break;
					}

					$message = htmlentities(strip_tags($_POST['message']));

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

					checkCommands($message);

				break;

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
				//print_r($test);
				$log['data'] = $test;
			}

			$log['state'] = $count;
		break;
		
		case('getState'):	
			$str = file_get_contents("../json/channels/".$_SESSION['currentChatId'].".json");
			$json = json_decode($str, true);
			
			$log['state'] = count($json['message']);
		break;


    }
	
    echo json_encode($log);
?>