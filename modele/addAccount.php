<?php
	include 'functions.php';

	if (!empty($_POST)){
		//Add a new user to the users file
		if(isset($_POST['username']) && isset($_POST['password'])){			
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			$res = addUser($username, $password);
			
			echo $res;
		}
	}

?>
