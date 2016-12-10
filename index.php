<?php


if(!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION['loginstatus'])){
	$_SESSION["loginstatus"] = 0;
}

if($_SESSION["loginstatus"] != 0){
	header('Location: http://fc.isima.fr/~bezheng/zzchat/channels/'); 
	exit();
}

if(!isset($_SESSION['lang'])){
	include("lang/en-lang.php");
	$_SESSION['lang'] = "en";
}
else{
	include("lang/". $_SESSION['lang'] ."-lang.php");
}

include_once('controleur/CTRLindex.php');

?>
