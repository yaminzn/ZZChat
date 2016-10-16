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
	<link rel="stylesheet" href="css/bootstrap.css">

	<link rel="stylesheet" href="css/chat.css" type="text/css" />
</head>
<body>

	<!DOCTYPE html>
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>ZZ Chat</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
		<link rel="stylesheet" href="css/sidebar.css" type="text/css" />
		<link rel="stylesheet" href="css/scrollbar.css" type="text/css" />

		<?php randomIcon(); ?>	
	</head>
	<body>
		<div>
			<div class="row no-padding-margin">
				<div id="left" class="col-xs-3 no-padding-margin">
					<div clas="container-fluid">
						<div class="row no-padding-margin">
							<div id="sidebarframe" class="col-xs-6 no-padding-margin sidebarframe">
								<div class="pre-scrollable text-left">
									<?php include 'sidebar.php'; ?>
								</div>
							</div>
							<!-- Subbar -->
							<div id="subbarframe" class="col-xs-6 no-padding-margin subbarframe">
								<div class="subbar pre-scrollable text-left">
									<ul class="nav nav-pills nav-stacked subbarpill">
										<li><a href="#">ADD</a></li>
										<li><a href="#">SCROLL SPY</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Main content -->	

				<div id="center" class="col-xs-9 no-padding-margin">
					<div clas="container-fluid">
						<div class="pre-scrollable">
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
			</div>
		</div>	
		<script type="text/javascript" language="javascript">
			/* Fix affix width */
			$("#sidebar").width($("#sidebarframe").width());
			$("#subbar").width($("#subbarframe").width());
		</script>
	</body>
</html>