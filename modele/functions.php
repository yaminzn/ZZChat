<?php

include 'return.php';

//Change username color
function changeUsernameColor($userId, $color){
	$tab = returnUsersInfo();

	$tab['users'][$userId]['color'] = $color;

	$fp = fopen ('../json/users.json','w'); 
	fwrite($fp, json_encode($tab));
	fclose($fp);

	$_SESSION['color'] = $color;
}

//Change username password
function changeUsernamePassword($userId, $oldpw, $newpw){
	$res = 0;
	$tab = returnUsersInfo();

	if($tab['users'][$userId]['password'] == sha1($oldpw))
	{
		$tab['users'][$userId]['password'] = sha1($newpw);
		$fp = fopen ('../json/users.json','w'); 
		fwrite($fp, json_encode($tab));
		fclose($fp);

		$res = 1;
	}

	return $res;
}

//Not all commands adds text
//Transform text command to the actual command
function checkCommands($message){
	$find = array('/^!cowsay\s(.*)$/', '/^!commands$/');
	$replace = array('            \\
               \\
                     \\     
                                                         ##        .            
                                             ## ## ##       ==            
                                      ## ## ## ##      ===            
                 /""""""""""""""""""""""""""""""___/ ===        
        ~~~ {~~ ~~~~ ~~~ ~~~~ ~~ ~ /  ===- ~~~   
                        \\______ o                        __/            
                              \\      \\                     __/             
                                    \\______\\_______/', "commands list: !commands, !cowsay *text*");

	foreach($find as $key=>$value){
		if(preg_match_all($value, $message, $matches)){
			if(!empty($matches[1][0])){
				switch ($key) {
				    case 0:
				        $text = "<br> ".$matches[1][0]." <br>".$replace[$key];

						$tab['type'] = "command";
						$tab['time'] = date('H:i');
						$tab['username'] = "Chatbot"; //bot name
						$tab['color'] = "#cc0000";

						//Specific to the type
						$tab['text'] = $text;
						addDataToChannel($tab, $_SESSION['currentChatId']);
				    break;
				}
			}
			else{ 
				switch ($key) {
				    case 1:
				    	$text = $replace[$key];

						$tab['type'] = "command";
						$tab['time'] = date('H:i');
						$tab['username'] = "Chatbot"; //bot name
						$tab['color'] = "#cc0000";

						//Specific to the type
						$tab['text'] = $text;
						addDataToChannel($tab, $_SESSION['currentChatId']);
					break;
				}
			}
		}
	}
}

//Add a databloc to the channel
function addDataToChannel($tab, $channelId){
	$str = file_get_contents("../json/channels/".$channelId.".json");
	$json = json_decode($str, true);

	$json['message'][count($json['message'])] = $tab;

	$fp = fopen ("../json/channels/".$channelId.".json",'w'); 
	fwrite($fp, json_encode($json));
	fclose($fp); 
}

//Transform the BBcode to HTML tags
function showBBcodes($text) {
	// BBcode array
	$find = array(
		'~\[b\](.*?)\[/b\]~s',
		'~\[i\](.*?)\[/i\]~s',
		'~\[u\](.*?)\[/u\]~s',
		'~\[s\](.*?)\[/s\]~s'
	);
	// HTML tags to replace BBcode
	$replace = array(
		'<b>$1</b>',
		'<i>$1</i>',
		'<u>$1</u>',
		'<s>$1</s>'
	);
	// Replacing the BBcodes with corresponding HTML tags
	return preg_replace($find,$replace,$text);
}

//Delete a channel
function deleteChannel($channelId){
	//Remove channel in channel.json
	$str = file_get_contents("../json/channel.json");
	$json = json_decode($str, true);

	unset($json['channel'][$channelId]);
	$json['channel'][$channelId] = array_values($json['channel'][$channelId]);

	$fp = fopen ('../json/channel.json','w'); 
	fwrite($fp, json_encode($json));
	fclose($fp);

	//Remove channel conversation file
	unlink("../json/channels/".$channelId.".json");
}

//Remove a user from a channel
//Delete the userid from the channel's useridlist
//Delete the channelid from the users's channelidlist 
function removeUserFromChannel($userId, $channelId){

	$str = file_get_contents("../json/users.json");
	$json = json_decode($str, true);

	if(($key = array_search($channelId, $json['users'][$userId]['channelIdList'])) !== false) {
    	unset($json['users'][$userId]['channelIdList'][$key]);

    	//Reset the index
    	$json['users'][$userId]['channelIdList'] = array_values($json['users'][$userId]['channelIdList']);
	}

	$fp = fopen ('../json/users.json','w'); 
	fwrite($fp, json_encode($json));
	fclose($fp);


	$str = file_get_contents("../json/channel.json");
	$json = json_decode($str, true);

	if(($key = array_search($userId, $json['channel'][$channelId]['userIdList'])) !== false) {
    	unset($json['channel'][$channelId]['userIdList'][$key]);
    	$json['channel'][$channelId]['userIdList'] = array_values($json['channel'][$channelId]['userIdList']);
	}

	$fp = fopen ('../json/channel.json','w'); 
	fwrite($fp, json_encode($json));
	fclose($fp);

	//Delete channel if it is empty
	if(empty($json['channel'][$channelId]['userIdList'])){
		//deleteChannel($channelId);
	}
}

function createChannelJSON($channelId){
	//Create the channel file
	$filename = "../json/channels/".$channelId.".json";
	$myfile = fopen($filename, "w");

	chmod($filename, 0777);

	//Message on creation
	$tab['message'] =  array(array("username" => "Chatbot", "type" => "text", "text" => "Start chatting by inviting your friends!", "time" => date('H:i'), "color" => "#cc0000"));

	fwrite($myfile, json_encode($tab));
	fclose($myfile);
}

//Add a userId to a channel
function addUserToChannel($userId, $channelId){
	$str = file_get_contents("../json/channel.json");
	$json = json_decode($str, true);

	if (!in_array($userId, $json['channel'][$channelId]['userIdList'])) {
		$json['channel'][$channelId]['userIdList'][count($json['channel'][$channelId]['userIdList'])] = $userId;
	}

	$fp = fopen ('../json/channel.json','w'); 
	fwrite($fp, json_encode($json, JSON_NUMERIC_CHECK));
	fclose($fp);	
}

//Add a channelId to a user
function addtoUserChannelIdList($userId, $channelId){
	$str = file_get_contents("../json/users.json");
	$json = json_decode($str, true);

	if (!in_array($channelId, $json['users'][$userId]['channelIdList'])) {
		$json['users'][$userId]['channelIdList'][count($json['users'][$userId]['channelIdList'])] = $channelId;
	}

	$fp = fopen ('../json/users.json','w'); 
	fwrite($fp, json_encode($json, JSON_NUMERIC_CHECK));
	fclose($fp);	
}

//Create a channel
function createChannel($name, $description){
	$str = file_get_contents("../json/channel.json");
	$json = json_decode($str, true);

	$tab['id'] = $json['channel'][count($json['channel']) - 1]['id'] + 1;
	$tab['name'] = htmlspecialchars($name);
	$tab['description'] = htmlspecialchars($description);
	$tab['userIdList'] = array($_SESSION['userId']);

	$date = new DateTime();
	$tab['date_of_creation'] = $date->getTimestamp();

	$json['channel'][count($json['channel'])] = $tab;

	$fp = fopen ('../json/channel.json','w'); 
	fwrite($fp, json_encode($json));
	fclose($fp);	

	addtoUserChannelIdList($_SESSION['userId'], $tab['id']);
	createChannelJSON($tab['id']);

	return $tab['id'];
}

//Change a channel's description
function changeChannelDescription($newChannelDescription){
	$str = file_get_contents("../json/channel.json");
	$json = json_decode($str, true);

	$json['channel'][$_SESSION['currentChatId']]['description'] = htmlspecialchars($newChannelDescription);

	$fp = fopen ('../json/channel.json','w'); 
	fwrite($fp, json_encode($json));
	fclose($fp);
}

//Change a channel's name
function changeChannelName($newChannelName){
	$str = file_get_contents("../json/channel.json");
	$json = json_decode($str, true);

	$json['channel'][$_SESSION['currentChatId']]['name'] = htmlspecialchars($newChannelName);

	$fp = fopen ('../json/channel.json','w'); 
	fwrite($fp, json_encode($json));
	fclose($fp);
}

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

						$_SESSION['cctoken'] = $token;
						$_SESSION['ccd'] = $date_of_expiry;


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

//Load a user SESSION variables
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

//addAccount.php

/* Add a user to users */
function addUser($username, $pwd){
	
	$str = file_get_contents('../json/users.json');
	$json = json_decode($str, true);
	
	foreach($json['users'] as $key => $product)
	{
		if($product['username'] === $username){
				return 0;
		}
	}
	
	//Valide username
	
	$nb = count($json['users']);
	
	$tab['id'] = $nb;
	$tab['username'] = $username;
	$tab['password'] = sha1($pwd);
	$tab['level'] = 0;
	$tab['color'] = "#000000";
	$tab['channelIdList'] = Array("0");

	
	$json['users'][$nb] = $tab;
	
	$fp = fopen ('../json/users.json','w') or die("Unable to open file users"); 
	fwrite($fp, json_encode($json));
	fclose($fp);

	//Add user to global channel
	addUserToChannel($tab['id'],0);

	return 1;
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