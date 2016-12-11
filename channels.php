<?php

//Redirect user if he's not logged in
include_once('modele/redirect.php');

if(!isset($_SESSION['lang'])){
	include("lang/en-lang.php");
	$_SESSION['lang'] = "en";
}
else{
	include("lang/". $_SESSION['lang'] ."-lang.php");
}

include_once('controleur/CTRLchannels.php');

?>