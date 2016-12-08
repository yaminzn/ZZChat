<?php

ini_set('display_errors','on');
error_reporting(E_ALL);

if(!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION['loginstatus'])){
	$_SESSION["loginstatus"] = 0;
}

$_SESSION['lang'] = 'fr';

if(!isset($_SESSION['lang'])){
	include("lang/en-lang.php");
	$_SESSION['lang'] = "en";
}
else{
	include("lang/". $_SESSION['lang'] ."-lang.php");
}


if($_SESSION["loginstatus"] != 0){
	header('Location: http://fc.isima.fr/~bezheng/zzchat/channels.php'); 
	exit();
}


include_once('controleur/CTRLindex.php');

?>