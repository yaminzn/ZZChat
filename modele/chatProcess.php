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
			if(empty($_POST['message'])){
				break;
			}

			$message = htmlentities(strip_tags($_POST['message']));
			
			if (preg_match("/^[\s]+$/", $message)) {
				break;
			}

			$str = file_get_contents("../json/channels/".$_SESSION['currentChatId'].".json");
			$json = json_decode($str, true);

			$tab['username'] = $_SESSION["username"];
			$tab['text'] = $message;
			$tab['time'] = date('H:i');
			$tab['color'] = $_SESSION["color"];

			$json['message'][count($json['message'])] = $tab;

			$fp = fopen ("../json/channels/".$_SESSION['currentChatId'].".json",'w'); 
			fwrite($fp, json_encode($json));
			fclose($fp); 
								
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