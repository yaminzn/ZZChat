<?php

function deleteChannel($channelId){
	
}

function removeUserFromChannel($userId, $channelId){
	$str = file_get_contents("../json/users.json");
	$json = json_decode($str, true);

	if(($key = array_search($channelId, $json['users'][$userId]['channelIdList'])) !== false) {
    	unset($json['users'][$userId]['channelIdList'][$key]);
	}

	$fp = fopen ('../json/users.json','w'); 
	fwrite($fp, json_encode($json));
	fclose($fp);


//---------------------EN COURS
	$str = file_get_contents("../json/channel.json");
	$json = json_decode($str, true);

	if(($key = array_search($channelId, $json['channel'][$userId]['channelIdList'])) !== false) {
    	unset($json['users'][$userId]['channelIdList'][$key]);
	}

	$fp = fopen ('../json/users.json','w'); 
	fwrite($fp, json_encode($json));
	fclose($fp);

	if(count(returnChannelUserIdList($channelId)) == 0{
		deleteChannel($channelId);
	}
}

function createChannelJSON($channelId){
	$filename = "../json/channels/".$channelId.".json";
	$myfile = fopen($filename, "w");

	chmod($filename, 0777);
	$tab['message'] =  array(array("username" => "Bot", "text" => "You seem alone LUL , start chatting by inviting your friends!", "time" => "99:99", "color" => "yellow"));

	fwrite($myfile, json_encode($tab));
	fclose($myfile);
}

function addtoUserChannelIdList($userId, $channelId){
	$str = file_get_contents("../json/users.json");
	$json = json_decode($str, true);

	array_push($json['users'][$userId]['channelIdList'], $channelId);

	$fp = fopen ('../json/users.json','w'); 
	fwrite($fp, json_encode($json));
	fclose($fp);	
}

function createChannel($name, $description){
	$str = file_get_contents("../json/channel.json");
	$json = json_decode($str, true);

	$tab['id'] = $json['channel'][count($json['channel']) - 1]['id'] + 1;
	$tab['name'] = $name;
	$tab['description'] = $description;
	$tab['userIdList'] = array($_SESSION['userId']);

	$json['channel'][count($json['channel'])] = $tab;

	$fp = fopen ('../json/channel.json','w'); 
	fwrite($fp, json_encode($json));
	fclose($fp);	

	addtoUserChannelIdList($_SESSION['userId'], $tab['id']);
	createChannelJSON($tab['id']);

	return $tab['id'];
}

function changeChannelDescription($newChannelDescription){
	$str = file_get_contents("../json/channel.json");
	$json = json_decode($str, true);

	$json['channel'][$_SESSION['currentChatId']]['description'] = $newChannelDescription;

	$fp = fopen ('../json/channel.json','w'); 
	fwrite($fp, json_encode($json));
	fclose($fp);
}

function changeChannelName($newChannelName){
	$str = file_get_contents("../json/channel.json");
	$json = json_decode($str, true);

	$json['channel'][$_SESSION['currentChatId']]['name'] = $newChannelName;

	$fp = fopen ('../json/channel.json','w'); 
	fwrite($fp, json_encode($json));
	fclose($fp);
}


//index.php

/*
 * Check cookies for automatic login
 */
function checkCookieAutoLogin(){
	if(isset($_COOKIE['id']) && isset($_COOKIE['token'])){
		$str = file_get_contents('../json/cookie.json');
		$json = json_decode($str, true);
		$tab['cookie'] = array();

		$date = new DateTime();
		$time = $date->getTimestamp();

		/*
		 * 0 = Not found
		 * -1 = Error, fuck you hacker
		 * 1 = Found
		 */
		$res = 0;

		for($i=0;$i<count($json['cookie']);$i++){
			//If cookie is not expired
			if($json['cookie'][$i]['date_of_expiry'] > $time - 2592000){
				//If cookie id is valid
				if($json['cookie'][$i]['id'] == $_COOKIE['id']){
					//If cookie token is valid
					if($json['cookie'][$i]['token'] == $_COOKIE['token']){

						loginUser($json['cookie'][$i]['username']);

						$token = hash('sha256', rand());

						$number_of_days = 30 ;
						$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
						setcookie("token", $token, $date_of_expiry);

						$json['cookie'][$i]['token'] = $token;
						$json['cookie'][$i]['date_of_expiry'] = $date_of_expiry;

						//New token was generated
						$res = 1;
					}
					else{
						$res = -1;
					}
				}
				array_push($tab['cookie'], $json['cookie'][$i]);
			}
		}
		//Save new token
		if($res == 1){
			$fp = fopen ('../json/cookie.json','w'); 
			fwrite($fp, json_encode($tab));
			fclose($fp);
			header("Refresh:0");
		}
	}
}

//formvalidation.php

/*
 * Check if $username and $pwd exist
 */
function checkuser($username, $pwd)
{
	$str = file_get_contents('../json/users.json');
	$json = json_decode($str, true);

	foreach($json['users'] as $key => $product)
	{
		if($product['username'] === $username){
			if($product['password'] === $pwd){
				return 1;
			}
		}
	}
	return 0;
}

/* Log l'utilisateur sur le site, charge ses variables de session */
function loginUser($username){
	$str = file_get_contents('../json/users.json');
	$json = json_decode($str, true);

	foreach($json['users'] as $key => $product)
	{
		if($product['username'] === $username){
				$_SESSION["loginstatus"] = 1;
				$_SESSION["username"] = $product['username'];
				$_SESSION['color'] = $product['color'];
				$_SESSION["userId"] = $product['id'];
				$_SESSION["currentChatId"] = 0;
				$_SESSION["level"] = $product['level'];
		}
	}
}

//Chat.php

/*
 * Return list of users id in users.json
 */
function getUserIdList(){
	$str = file_get_contents('json/users.json');
	$json = json_decode($str, true);

	$userList = array();

	for($i=0;$i<count($json['users']);$i++){
		$userList[$i] = $json['users'][$i]['id'];
	}

	return $userList;
}

/* 
 * Remove users registered in lastastivity.json but not in users.json 
 */
function removeGhostUsers(){
	$str = file_get_contents('json/lastactivity.json');
	$json = json_decode($str, true);

	$userList = getUserIdList();
	$tab["lastactivity"] = array();

	for($i=0;$i<count($json['lastactivity']);$i++){
		$res = array_search($json['lastactivity'][$i]['userId'], $userList);
		if(!($res === FALSE)){
			array_push($tab["lastactivity"], $json['lastactivity'][$i]);
		}
	}
	
	$fp = fopen ('json/lastactivity.json','w'); 
	fwrite($fp, json_encode($tab));
	fclose($fp);
}

/*
 * Update lastactivity.json
 */
function updateUserActivity(){
	$str = file_get_contents('json/lastactivity.json');
	$json = json_decode($str, true);
	$res = 0;
	$date = new DateTime();

	for($i=0;$i<count($json['lastactivity']);$i++){
		if($json['lastactivity'][$i]['userId'] === $_SESSION["userId"]){
			$json['lastactivity'][$i]['lasttime'] = $date->getTimestamp();
			$json['lastactivity'][$i]['ip'] = $_SERVER['REMOTE_ADDR'];
			$res = 1;
		}
	}

	if($res == 0){
		$tab['userId'] = $_SESSION["userId"];
		$tab['lasttime'] = $date->getTimestamp();
		$tab['ip'] = $_SERVER['REMOTE_ADDR'];
		$json['lastactivity'][count($json['lastactivity'])] = $tab;
	}

	$fp = fopen ('json/lastactivity.json','w'); 
	fwrite($fp, json_encode($json));
	fclose($fp);
}

?>