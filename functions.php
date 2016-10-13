<?php

function checkAuthorization($id){
	$userChatroomsIdList = getUserChatroomsIdList($_SESSION["userId"]);
	if(in_array($id, $userChatroomsIdList)){
		$_SESSION["currentChatId"] = $id;
	}
	else{
		echo "Access Forbidden";
	}
}

function getUserChatroomsIdList($id){
	$str = file_get_contents("json/users.json");
	$json = json_decode($str, true);

	return $json['users'][$id]['chatroomIdList'];
}

function getUserChatroomsList($idList){
	$str = file_get_contents("json/chatroom.json");
	$json = json_decode($str, true);

	$tab = array();
	foreach($idList as $key=>$value) {
		array_push($tab, $json['chatroom'][$value]);
	}

	return $tab;
}

function textToEmote($string){
	$text = $string;

	//Twitch global emotes + certain subscriber emotes
	$str = file_get_contents("json/emotes/twitchemotes.json");
	$json = json_decode($str, true);

	foreach($json['emotes'] as $key=>$value) {
		$text = preg_replace("/(?<!\S)".$key."(?!\S)/",
			"<img src=".str_replace("{image_id}",$value['image_id'],$json['template']['small'])." title=".$key.">",
			$text);
	}

	//BTTV global emotes
	$str = file_get_contents("json/emotes/bttvemotes.json");
	$json = json_decode($str, true);

	foreach($json['emotes'] as $key=>$value) {
		$text = preg_replace("/(?<!\S)".$value['code']."(?!\S)/","<img src=\"https:".str_replace("{{id}}/{{image}}",$value['id']."/1x",$json['urlTemplate'])."\" title=".str_replace('\\',"",$value['code']).">",$text);
	}

	return $text;
}

//Online.php

/*
 * Return array of lastactivity.json with an online column
 * 1 : online
 * 0 : offfline
 */
function returnOnlineUsers(){
	/* 	Get file content */
	$str = file_get_contents('json/lastactivity.json');
	$json = json_decode($str, true);

	/* 	Get current timestamp (UNIX time) */
	$date = new DateTime();
	$time = $date->getTimestamp();

	/*  
	*	5min = 5 * 60 * 10
	*		= 300
	*	User is online if he was active within the last 5 minutes
	*/	
	for($i=0;$i<count($json['lastactivity']);$i++){
		if($time - 300 < $json['lastactivity'][$i]['lasttime']){
			$json['lastactivity'][$i]['online'] = 1;
		}
		else{
			$json['lastactivity'][$i]['online'] = 0;
		}
	}

	return json_encode($json['lastactivity']);
}

//index.php

/*
 * Check cookies for an automatic login
 */
function checkCookieAutoLogin(){
	if(isset($_COOKIE['id']) && isset($_COOKIE['token'])){
		$str = file_get_contents('json/cookie.json');
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

						$_SESSION["loginstatus"] = 1;
						$_SESSION["username"] = $json['cookie'][$i]['username'];

						//SET SESSION VARIABLE!!

						//TO DO 


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
			$fp = fopen ('json/cookie.json','w'); 
			fwrite($fp, json_encode($tab));
			fclose($fp);
			header("Refresh:0");
		}
	}
}

//formvalidation.php

/*
 * Check if $username and $pwd exist in $tab
 */
function checkuser($username, $pwd)
{
	$str = file_get_contents('json/users.json');
	$json = json_decode($str, true);

	foreach($json['users'] as $key => $product)
	{
		if($product['username'] === $username){
			if($product['password'] === $pwd){
				$_SESSION["username"] = $product['username'];
				$_SESSION['color'] = $product['color'];
				$_SESSION["userId"] = $product['id'];
				$_SESSION["currentChatId"] = 0;
				return 1;
			}
		}
	}
	return 0;
}

//Chat.php

/*
 * Return list of users in users.json
 */
function getUserList(){
	$str = file_get_contents('json/users.json');
	$json = json_decode($str, true);

	$userList = array();

	for($i=0;$i<count($json['users']);$i++){
		$userList[$i] = $json['users'][$i]['username'];
	}

	return $userList;
}

/* 
 * Remove users registered in lastastivity.json but not in users.json 
 */
function removeGhostUsers(){
	$str = file_get_contents('json/lastactivity.json');
	$json = json_decode($str, true);

	$userList = getUserList();
	$tab["lastactivity"] = array();

	for($i=0;$i<count($json['lastactivity']);$i++){
		$res = array_search($json['lastactivity'][$i]['username'], $userList);
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
		if($json['lastactivity'][$i]['username'] === $_SESSION["username"]){
			$json['lastactivity'][$i]['lasttime'] = $date->getTimestamp();
			$json['lastactivity'][$i]['ip'] = $_SERVER['REMOTE_ADDR'];
			$res = 1;
		}
	}

	if($res == 0){
		$tab['username'] = $_SESSION["username"];
		$tab['lasttime'] = $date->getTimestamp();
		$tab['ip'] = $_SERVER['REMOTE_ADDR'];
		$json['lastactivity'][count($json['lastactivity'])] = $tab;
	}

	$fp = fopen ('json/lastactivity.json','w'); 
	fwrite($fp, json_encode($json));
	fclose($fp);
}

?>