<?php

//Set cookies if remember me checkbox was checked
if(isset($_SESSION['ccid'])){
	setcookie("id", $_SESSION['ccid'], $_SESSION['ccd']);

	unset($_SESSION['ccid']);
}

if(isset($_SESSION['cctoken'])){
	setcookie("token", $_SESSION['cctoken'], $_SESSION['ccd']);

	unset($_SESSION['ccd']);
	unset($_SESSION['cctoken']);
}

include 'modele/functions.php';
include 'modele/return.php';

//Update online users list
updateUserActivity();

//Remove inexistant users
removeGhostUsers();


//Load the correct channel
if(isset($_GET["id"])){
	$id = $_GET["id"];
	if(checkAuthorization($id) == 0) {
		header('Location: http://fc.isima.fr/~bezheng/zzchat/'); 
	}
	else{
		$_SESSION["currentChatId"] = $id;
	}
}

$channelsList = getUserChannelsList(getUserChannelsIdList($_SESSION["userId"]));
$username = $_SESSION['username'];
$icon = randomIcon();

//Not really working
if($_SESSION['level'] > 0){
	$adminpanel = '<a class="dropdown-item" href="adminpanel.php">ADMIN</a>';
}


include('vue/VUEchannels.php');

?>