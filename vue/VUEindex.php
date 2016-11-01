
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
						<span class="glyphicon glyphicon-pencil"></span>
					</span>
						<input type="password" class="form-control" name="password" placeholder="Password" required />
				</div>	
				<div id="error"></div> 	
				<div class="checkbox">
					<label><input id="rememberme" name="rememberme" type="checkbox">Remember me</label>
				</div>
					<button type="submit" class="btn btn-primary">Sign in</button>
			</form>
			<br>
			
			<div id="signup" class="alert alert-info">
				<a href="javascript:void(0);" class="close" id="closeup" >&times;</a>
				<h3 class="text-center">Account creation</h3><br>
				<form id="form-up" class="form-signin"  action="javascript:void(0);">
					<div class="input-group">
						<span class="input-group-addon" ><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" class="form-control" name="username" placeholder="Username" autofocus required>
					</div>	  
					<div class="input-group">
						<span class="input-group-addon" >
							<span class="glyphicon glyphicon-pencil"></span></span>
							<input type="password" class="form-control" name="password" placeholder="Password" required>
						</div>	
						<div class="error-up">
						</div> 	
						<br>
						<button type="submit" class="btn btn-primary">Sign up</button>	
				</form>
			</div>
			
			<button id="help" class="btn btn-warning">Create my account :D</button>
		</div>

		<script type="text/javascript" language="javascript">
			function validateForm(){
				//console.log("validateForm()");
				var un = $("#form input[name=username]").val();
				var pw = $("#form input[name=password]").val();
				var cb = $('#rememberme').is(":checked");
				$.post("modele/formvalidation.php", {username : un , password : pw, checkbox : cb}, function(data){
					console.log(data);
					if(data == 1){
						window.location.replace("http://fc.isima.fr/~bezheng/zzchat/channels.php");
					}
					else if(data == 0){
						$("#error").html('<br><div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error</strong>, wrong username/password.</div>');
					}
				});
			}
			
			function newAccountForm(){
				//console.log("newAccountForm()");
				var un = $("#form-up input[name='username']").val();
				var pw = $("#form-up input[name='password']").val();
				$.post("modele/addAccount.php", {username : un , password : pw}, function(data){
					console.log(data);
					if(data == 1){
						$(".error-up").html('<br><div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Your account has been created.</div>');
					}
					else if(data == 0){
						$(".error-up").html('<br><div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error</strong>, username already taken.</div>');
					}
				});
			}


			$("#help").click(function() {
				$('#signup').show();
				$("#help").hide();
			});
			
			$("#closeup").click(function() {
				$('#signup').hide();
				$("#help").show();
			});

			$("#form").submit(function(){
				validateForm();
			});
			
			$("#form-up").submit(function(){
				newAccountForm();
			});
		</script>
	</body>
	</html>