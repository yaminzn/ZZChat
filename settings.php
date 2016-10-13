<?php
/* Redirect to log in page if not logged in */
if(!isset($_SESSION["loginstatus"]) || $_SESSION["loginstatus"] == 0){
	header('Location: http://fc.isima.fr/~bezheng/zzchat/'); 
	exit();
}

include 'functions.php';

updateUserActivity();
removeGhostUsers();

?>


<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>ZZ Chat</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<link rel="stylesheet" href="css/chat.css" type="text/css" />
</head>
<body>
	<div class="row maxWidth fullHeight">
		<div class="col-md-3 maxWidth fullHeight">
			<div class="row fullHeight">
				<!-- Sidebar -->
				<?php include 'bars.php'; ?>
				<!-- Subbar -->
				<div class="col-md-6 subbar fullHeight">
					<div class="row fullHeight">
						<ul class="nav nav-sidebar">
							<li><a class="conv" href="#twitch">Twitch</a></li>
							<li><a class="conv" href="#BTTV">Better Twitch TV</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Main content -->	

		<div class="col-md-9 maincontent fullHeight">
			<div class="row fullHeight">
				
			</div>
		</div>
	</div>
</body>
</html>