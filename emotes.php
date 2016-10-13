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
		<div class="col-xs-3 maxWidth fullHeight">
			<div class="row fullHeight">
				<!-- Sidebar -->
				<?php include 'bars.php'; ?>
				<!-- Subbar -->
				<div class="col-xs-6 subbar fullHeight">
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

		<div class="col-xs-9 maincontent fullHeight">
			<div class="row fullHeight">
				<br>
				<div class="well">All emotes were taken from www.twitchemotes.com API</div>
				<div class="well">
					<a name="twitch"><h3>Twitch emotes</h3></a><br>
					<?php
					$str = file_get_contents("json/emotes/twitchemotes.json");
					$json = json_decode($str, true);

					$i=0;
					foreach($json['emotes'] as $key=>$value) {
						if($i==0) echo '<div class="row">';
						$text = "<div class=\"col-xs-2\"><center><img src=".str_replace("{image_id}",$value['image_id'],$json['template']['small'])." title=".$key."><br>".$key."</center></div>";
						echo $text;
						$i++;
						if($i==6){
							echo '</div><br>';
							$i = 0;
						}
					}
					?>
				</div>
				<div class="well">
					<a name="BTTV"><h3>Better Twitch TV emotes</h3></a><br>
					<?php
					$str = file_get_contents("json/emotes/bttvemotes.json");
					$json = json_decode($str, true);

					$i=0;
					foreach($json['emotes'] as $key=>$value) {
						if($i==0) echo '<div class="row">';
						$fixed = str_replace('\\',"",$value['code']);
						$text = "<div class=\"col-xs-2\"><center><img src=\"https:".str_replace("{{id}}/{{image}}",$value['id']."/1x",$json['urlTemplate'])."\" title=".$fixed."><br>".$fixed."</center></div>";
						echo $text;
						$i++;
						if($i==6){
							echo '</div><br>';
							$i = 0;
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>