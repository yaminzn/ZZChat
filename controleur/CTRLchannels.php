<?php

include 'modele/functions.php';
include 'modele/return.php';

updateUserActivity();
removeGhostUsers();

if(isset($_GET["id"])){
	$id = htmlspecialchars($_GET["id"]);
	if(checkAuthorization($id) == 0) {
		header('Location: http://fc.isima.fr/~bezheng/zzchat/'); 
	}
}

$channelsList = getUserChannelsList(getUserChannelsIdList($_SESSION["userId"]));
$username = $_SESSION['username'];
$icon = randomIcon();

if($_SESSION['level'] > 0){
	$adminpanel = '<a class="dropdown-item" href="adminpanel.php">ADMIN</a>';
}


include('vue/VUEchannels.php');

?>