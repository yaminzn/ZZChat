<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>ZZ Chat</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="css/bootstrap.css">

</head>
<body>
	<div class="container">
		<div>All emotes were taken from www.twitchemotes.com API</div><br>
		<div>
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
		</div><br>
		<div>
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
</body>
</html>