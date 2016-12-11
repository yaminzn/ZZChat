<?php 
	if(!isset($_SESSION)) {
		exit();
	}

	include 'functions.php';

	if (!empty($_POST)){
		if(isset($_POST['username']) && isset($_POST['password'])){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$rememberme = $_POST["checkbox"];

			//sucess = 1 if success, != 1 if not
			$sucess = checkuser($username, sha1($password));

			//If user is indentified
			if($sucess == 1){
				loginUser($username);

				//If remember me is checked, adding cookie to cookie.json and to the user's computer
				if($rememberme === "true"){
					//Create cookies on the users device and save the match on the server
					$id = rand();
					$token = hash('sha256', rand());

					$number_of_days = 30 ;
					$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;

					$_SESSION['ccid'] = $id;
					$_SESSION['cctoken'] = $token;
					$_SESSION['ccd'] = $date_of_expiry;

					/* Adding new entry */
					$str = file_get_contents('../json/cookie.json');
					$json = json_decode($str, true);

					$tab["username"] = $username;
					$tab['id'] = $id;
					$tab['token'] = $token;
					$tab['date_of_expiry'] = $date_of_expiry;

					$json['cookie'][count($json['cookie'])] = $tab;

					$fp = fopen ('../json/cookie.json','w'); 
					fwrite($fp, json_encode($json));
					fclose($fp);
				}

			}

			echo $sucess;
		}
	}

?>
