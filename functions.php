<?php

/* Retourne les username avec la couleur associé de la liste d'id + une colonne online */
function returnChatroomOnlineUsers($idList){
	$str = file_get_contents("json/users.json");
	$json = json_decode($str, true);

	$str2 = file_get_contents("json/lastactivity.json");
	$json2 = json_decode($str2, true);

	$date = new DateTime();
	$time = $date->getTimestamp();

	$tab = array();
	foreach($idList as $key=>$value) {	
		$online = 0;
		/*  
		*	5min = 5 * 60 * 10
		*		= 300
		*	User is online if he was active within the last 5 minutes
		*/	
		for($i=0;$i<count($json2['lastactivity']);$i++){
		//	echo $json2['lastactivity'][$i]['userId']." - ".$value."<br>";
			
			if($json2['lastactivity'][$i]['userId'] == $value){
				if($time - 300 < $json2['lastactivity'][$i]['lasttime']){
					$online = 1;
				}
			}
		}
		array_push($tab, array("username" => $json['users'][$value]['username'], "color" => $json['users'][$value]['color'], "online" => $online));
	}

	return $tab;
}

/* Renvoie les id des utilisateurs dans le chat d'id en argument */
function returnChatroomUserIdList($id)
{
	$str = file_get_contents("json/chatroom.json");
	$json = json_decode($str, true);

	return $json['chatroom'][$id]['userIdList'];
}

/* Génère la balise pour avoir une icone d'onglet avec une image aléatoire */
function randomIcon(){
	$str = file_get_contents("json/emotes/twitchemotes.json");
	$json = json_decode($str, true);

	echo '<link rel="icon" type="image/png" href="https://static-cdn.jtvnw.net/emoticons/v1/'.$json['emotes'][array_rand($json['emotes'])]['image_id'].'/1.0" />';
}

/* Vérifie si l'utilisateur est autorisé d'acceder à la chatroom d'id en paramètre */
function checkAuthorization($id){
	$userChatroomsIdList = getUserChatroomsIdList($_SESSION["userId"]);
	if(in_array($id, $userChatroomsIdList)){
		$_SESSION["currentChatId"] = $id;
	}
	else{
		echo "Access Forbidden";
	}
}

/* Retourne la liste des id des utilisateurs dans la chatroom d'id en paramètre */
function getUserChatroomsIdList($id){
	$str = file_get_contents("json/users.json");
	$json = json_decode($str, true);

	return $json['users'][$id]['chatroomIdList'];
}

/* Retourne les info complète sur les utilisateurs de la liste d'id */
function getUserChatroomsList($idList){
	$str = file_get_contents("json/chatroom.json");
	$json = json_decode($str, true);

	$tab = array();
	foreach($idList as $key=>$value) {
		array_push($tab, $json['chatroom'][$value]);
	}

	return $tab;
}

/* Convertie les emotes en balises images */
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
 * 0 : offline
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

	return $json['lastactivity'];
}

//index.php

/*
 * Check cookies for automatic login
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
			$fp = fopen ('json/cookie.json','w'); 
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
	$str = file_get_contents('json/users.json');
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
	$str = file_get_contents('json/users.json');
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