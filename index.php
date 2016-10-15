<?php

if(!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION['loginstatus'])){
	$_SESSION["loginstatus"] = 0;
}

if($_SESSION["loginstatus"] != 0){
	header('Location: http://fc.isima.fr/~bezheng/zzchat/chat.php'); 
	exit();
}

include 'functions.php';

checkCookieAutoLogin();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>ZZ Chat</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Custom CSS-->
	<link href="css/index.css" rel="stylesheet"> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<?php randomIcon(); ?>
	
</head>
<body>

	<div class="container" id="cadre">
		<h1>
			<p class="text-center">ZZ Chat</p>
		</h1>
		<br>
		
		<div id="scadre">
			<form id="form" class="form-signin"  action="javascript:void(0);">
				<div class="input-group">
					<span class="input-group-addon" ><span class="glyphicon glyphicon-user"></span></span>
					<input type="text" class="form-control" name="username" placeholder="Username" autofocus required>
				</div>	  
				<div class="input-group">
					<span class="input-group-addon" >
						<span class="glyphicon glyphicon-pencil"></span></span>
						<input type="password" class="form-control" name="password" placeholder="Password" required>
					</div>	
					<div id="error">
					</div> 	
					<div class="checkbox">
						<label><input id="rememberme" name="rememberme" type="checkbox">Remember me</label>
					</div>
					<button type="submit" class="btn btn-primary">Sign in</button>
				</div>	
			</form> 
			<button id="help" class="btn btn-warning">Create my account :D</button>
		</div>

		<script type="text/javascript" language="javascript">
			function validateForm(){
				var un = $("input[name=username]").val();
				var pw = $("input[name=password]").val();
				var cb = $('#rememberme').is(":checked");
				$.post("formvalidation.php", {username : un , password : pw, checkbox : cb}, function(data){
					if(data == 1){
						window.location.replace("http://fc.isima.fr/~bezheng/zzchat/chat.php");
					}
					else if(data == 0){
						$("#error").html('<br><div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error</strong>, wrong username/password.</div>');
					}
				});
			}


			$("#help").click(function() {
				$("#error").html('<br><div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> ( ° ͜ʖ͡°)╭∩╮ No</strong></div>');
			});

			$("#form").submit(function(){
				validateForm();
			});
		</script>
	</body>
	</html>