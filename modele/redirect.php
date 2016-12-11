<?php
//Are you logged in?
if(!isset($_SESSION["loginstatus"]) || $_SESSION["loginstatus"] == 0){
	header('Location: http://fc.isima.fr/~bezheng/zzchat/'); 
	exit();
}

?>