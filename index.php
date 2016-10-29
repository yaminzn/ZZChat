<?php


if(!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION['loginstatus'])){
	$_SESSION["loginstatus"] = 0;
}

if($_SESSION["loginstatus"] != 0){
	header('Location: http://fc.isima.fr/~bezheng/zzchat/channels.php'); 
	exit();
}

include_once('controleur/CTRLindex.php');

?>