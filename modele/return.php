<?php

//Almost all functions that return a value
//Some others are in functions.php

//return the user id with a username in parameter
function getUserId($username){
	$tab = returnUsersInfo();
	$size = count($tab['users']);

	for($i=0;$i<$size;$i++){
		if($tab['users'][$i]['username'] == $username)
			return $tab['users'][$i]['id'];
	}
	return -1;
}

//return the entire channel file
function returnChannelsInfo(){
	$str = file_get_contents("../json/channel.json");
	$json = json_decode($str, true);

	return $json;
}

//return the entire users file
function returnUsersInfo(){
	$str = file_get_contents("../json/users.json");
	$json = json_decode($str, true);

	return $json;
}

//Return user channelIdList
function returnUserChannelIdList($userId){
	$str = file_get_contents("../json/users.json");
	$json = json_decode($str, true);

	return $json['users'][$_SESSION['userId']]['channelIdList'];
}

//Return the specified chat state
function returnGetState($chatId){
	$str = file_get_contents("../json/channels/".$chatId.".json");
	$json = json_decode($str, true);
	
	return count($json['message']);
}

//Return an array with the username color, username and online value(0 or 1)
function returnChannelOnlineUsers($idList){
	$str = file_get_contents("../json/users.json");
	$json = json_decode($str, true);

	$str2 = file_get_contents("../json/lastactivity.json");
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

//return the users id in the specified channel
function returnChannelUserIdList($id)
{
	$str = file_get_contents("../json/channel.json");
	$json = json_decode($str, true);

	return $json['channel'][$id]['userIdList'];
}

//Generate a random tab icon HTML code
function randomIcon(){
	$str = file_get_contents("json/emotes/twitchemotes.json");
	$json = json_decode($str, true);

	return '<link rel="icon" type="image/png" href="https://static-cdn.jtvnw.net/emoticons/v1/'.$json['emotes'][array_rand($json['emotes'])]['image_id'].'/1.0" />';
}


//Check if the users belongs to the specified chat
function checkAuthorization($id){
	$userChannelsIdList = getUserChannelsIdList($_SESSION["userId"]);
	$res = 0;
	if(in_array($id, $userChannelsIdList)){
		$res = 1;
	}
	return $res;
}

//Return the chat id list for a specified user
function getUserChannelsIdList($id){
	$str = file_get_contents("json/users.json");
	$json = json_decode($str, true);

	return $json['users'][$id]['channelIdList'];
}

//return an array of channel information for each userId in the list
function getUserChannelsList($idList){
	$str = file_get_contents("json/channel.json");
	$json = json_decode($str, true);

	$tab = array();
	foreach($idList as $key=>$value) {
		array_push($tab, $json['channel'][$value]);
	}

	return $tab;
}

//Transform all emotes in images
function textToEmote($string){
	$text = $string;

	$str = file_get_contents("../json/emotes/twitchemotes.json");
	$json = json_decode($str, true);

	foreach($json['emotes'] as $key=>$value) {
		$text = preg_replace("/(?<!\S)".$key."(?!\S)/",
			"<img src=".str_replace("{image_id}",$value['image_id'],$json['template']['small'])." title=".$key.">",
			$text);
	}

	//BTTV global emotes
	$str = file_get_contents("../json/emotes/bttvemotes.json");
	$json = json_decode($str, true);

	foreach($json['emotes'] as $key=>$value) {
		$text = preg_replace("/(?<!\S)".$value['code']."(?!\S)/","<img src=\"https:".str_replace("{{id}}/{{image}}",$value['id']."/1x",$json['urlTemplate'])."\" title=".str_replace('\\',"",$value['code']).">",$text);
	}

	//Custom emotes
	$str = file_get_contents("../json/emotes/customemotes.json");
	$json = json_decode($str, true);

	foreach($json['subemotes'] as $key=>$value) {
		$text = preg_replace("/(?<!\S)".$value['code']."(?!\S)/","<img src=".str_replace("{image_id}",$value['image_id'],$json['template']['small'])." title=".$value['code'].">",$text);
	}
	foreach($json['miscemotes'] as $key=>$value) {
		$text = preg_replace("/(?<!\S)".$value['code']."(?!\S)/","<img src=".$value['image_link']." class=\"miscemote\" title=".$value['code'].">",$text);
	}	

	//Text formatting
	$text = showBBcodes($text);
	
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
	$str = file_get_contents('../json/lastactivity.json');
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

?>