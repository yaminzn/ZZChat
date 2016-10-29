<?php

include 'modele/functions.php';
include 'modele/return.php';

$icon = randomIcon();

if($_SESSION['level'] > 0){
	$adminpanel = '<a class="dropdown-item" href="adminpanel.php">ADMIN</a>';
}

$channelsList = getUserChannelsList(getUserChannelsIdList($_SESSION["userId"]));
$username = $_SESSION['username'];

$usersArr = returnUsersInfo();
$channelsArr = returnChannelsinfo();

include('vue/VUEadminpanel.php');

?>