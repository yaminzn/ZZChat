<?php

/* Retourne les username avec la couleur associé de la liste d'id + une colonne online */
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
function returnChannelUserIdList($id)
{
	$str = file_get_contents("../json/channel.json");
	$json = json_decode($str, true);

	return $json['channel'][$id]['userIdList'];
}

/* Génère la balise pour avoir une icone d'onglet avec une image aléatoire */
function randomIcon(){
	$str = file_get_contents("json/emotes/twitchemotes.json");
	$json = json_decode($str, true);

	return '<link rel="icon" type="image/png" href="https://static-cdn.jtvnw.net/emoticons/v1/'.$json['emotes'][array_rand($json['emotes'])]['image_id'].'/1.0" />';
}

/* Vérifie si l'utilisateur est autorisé d'acceder à la channel d'id en paramètre */
function checkAuthorization($id){
	$userChannelsIdList = getUserChannelsIdList($_SESSION["userId"]);
	$res = 0;
	if(in_array($id, $userChannelsIdList)){
		$_SESSION["currentChatId"] = $id;
		$res = 1;
	}
	return $res;
}

/* Retourne la liste des id des utilisateurs dans la channel d'id en paramètre */
function getUserChannelsIdList($id){
	$str = file_get_contents("json/users.json");
	$json = json_decode($str, true);

	return $json['users'][$id]['channelIdList'];
}

/* Retourne les info complète sur les utilisateurs de la liste d'id */
function getUserChannelsList($idList){
	$str = file_get_contents("json/channel.json");
	$json = json_decode($str, true);

	$tab = array();
	foreach($idList as $key=>$value) {
		array_push($tab, $json['channel'][$value]);
	}

	return $tab;
}

/* Convertie les emotes en balises images */
function textToEmote($string){
	$text = $string;

	//Twitch global emotes + certain subscriber emotes
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