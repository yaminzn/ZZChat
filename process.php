<?php
	if(!isset($_POST['function'])){
		exit;
	}

	include 'functions.php';

	$function = $_POST['function'];
	$log = array();
	
	switch($function) {
		
		case('send'):
			if(empty($_POST['message'])){
				break;
			}

			$message = htmlentities(strip_tags($_POST['message']));
			
			if (preg_match("/^[\s]+$/", $message)) {
				break;
			}

			$str = file_get_contents("json/chatrooms/".$_SESSION['currentChatId'].".json");
			$json = json_decode($str, true);

			// remove last two lines 
			$remove = 2; 
			// starting position ( skip the last \n in the file if it exists) 
			$pos = -2; 
			// file to open 
			$fp = fopen ("json/chatrooms/".$_SESSION['currentChatId'].".json",'a+'); 
			while($remove != 0) 
			{ 
				if(fseek($fp, $pos--, SEEK_END) == -1 ) 
				{ 
					break; 
				} 
				else if ( fgetc ( $fp ) == "\n" ) 
				{ 
					$remove -= 1; 
				} 
			}
			ftruncate($fp, ftell($fp));

			$tab['username'] = $_SESSION["username"];
			$tab['text'] = $message;
			$tab['time'] = date('H:i');
			$tab['color'] = $_SESSION["color"];
			
			fwrite($fp, ",\n".json_encode($tab)."\n]\n}");
			fclose($fp); 
								
		break;
		
		
		case('update'):
			$state = $_POST['state'];
			
			$str = file_get_contents("json/chatrooms/".$_SESSION['currentChatId'].".json");
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
			$str = file_get_contents("json/chatrooms/".$_SESSION['currentChatId'].".json");
			$json = json_decode($str, true);
			$log['state'] = count($json['message']);
		break;

		case('loadChatroomInfo'):	
			$str = file_get_contents("json/chatroom.json");
			$json = json_decode($str, true);

			$log = $json['chatroom'][$_POST['id']];

		break;

    }
	
    echo json_encode($log);
?>