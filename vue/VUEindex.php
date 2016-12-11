
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
	<div class="container" id="cadre" lang="<?php echo LANG; ?>">
		<h1>
			<p class="text-center">ZZ Chat</p>

			<ul class="lang-choice">
				<li><img src="img/drapeaufr.png" title="Site en français" value="fr" /></li>
				<li><img src="img/anglais.png" title="Site en anglais" value="en" /></li>
			</ul>

		</h1>
		<br>
		
		<div id="scadre">
			<form id="form" class="form-signin"  action="javascript:void(0);">
				<div class="input-group">
					<span class="input-group-addon" ><span class="glyphicon glyphicon-user"></span></span>
					<input type="text" class="form-control" name="username" placeholder="<?php echo INPUT_USERNAME_DESC; ?>" autofocus required>
				</div>	  
				<div class="input-group">
					<span class="input-group-addon" >
						<span class="glyphicon glyphicon-pencil"></span>
					</span>
						<input type="password" class="form-control" name="password" placeholder="<?php echo INPUT_PASSWORD_DESC; ?>" required />
				</div>	
				<div id="error"></div> 	
				<div class="checkbox">
					<label><input id="rememberme" name="rememberme" type="checkbox"><?php echo CHECKBOX_TEXT; ?></label>
				</div>
					<button type="submit" class="btn btn-primary btn-block"><?php echo SIGN_IN_TEXT; ?></button>
			</form>
			<br>
			
			<div id="signup" class="alert alert-info">
				<a href="javascript:void(0);" class="close" id="closeup" >&times;</a>
				<h3 class="text-center"><?php echo ACCOUNT_CREATION; ?></h3><br>
				<form id="form-up" class="form-signin"  action="javascript:void(0);">
					<div class="input-group">
						<span class="input-group-addon" ><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" class="form-control" name="username" placeholder="<?php echo INPUT_USERNAME_DESC; ?>" autofocus required>
					</div>	  
					<div class="input-group">
						<span class="input-group-addon" >
							<span class="glyphicon glyphicon-pencil"></span></span>
							<input type="password" class="form-control" name="password" placeholder="<?php echo INPUT_PASSWORD_DESC; ?>" required>
						</div>	
						<div class="error-up">
						</div> 	
						<br>
						<button type="submit" class="btn btn-primary btn-block"><?php echo SIGN_UP_TEXT; ?></button>	
				</form>
			</div>
			
			<button id="help" class="btn btn-warning btn-block"><?php echo CREATE_ACC_TEXT; ?></button>
		</div>

		<script type="text/javascript" language="javascript">
			function validateForm(){
				//console.log("validateForm()");
				var un = $("#form input[name=username]");
				var pw = $("#form input[name=password]");
				var cb = $('#rememberme').is(":checked");
				$.post("modele/formvalidation.php", {username : un.val() , password : pw.val(), checkbox : cb}, function(data){
					console.log(data);
					switch(parseInt(data)){
						case 1:
							window.location.replace("http://fc.isima.fr/~bezheng/zzchat/channels");
							break;
						case 0:
							$("#error").html(err_msg_front + "alert-danger" + err_msg_mid + "<?php echo ERR_WRONG_LOGIN; ?>" + err_msg_back);
							break;
					}
				});
				pw.val("");
			}
			
			function newAccountForm(){
				//console.log("newAccountForm()");
				var un = $("#form-up input[name='username']");
				var pw = $("#form-up input[name='password']");
				$.post("modele/addAccount.php", {username : un.val() , password : pw.val()}, function(data){
					console.log(data);
					switch(parseInt(data)){
						case 1:
							$(".error-up").html(err_msg_front + "alert-success" + err_msg_mid + "<?php echo ACCOUNT_CREATION_SUCCESS; ?>" + err_msg_back);
							break;
						case 0:
							$(".error-up").html(err_msg_front + "alert-danger" + err_msg_mid + "<?php echo ERR_USERNAME_TAKEN; ?>" + err_msg_back);
							break;
						default:
							$('.error-up').html(err_msg_front + "alert-danger" + err_msg_mid + "<?php echo ERR_UNKNOWN; ?>" + err_msg_back);
					}
				});
				un.val("");
				pw.val("");
			}

			var err_msg_front = '<br><div class="alert ',
				err_msg_mid = '" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>',
				err_msg_back = '</div>';


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
			
			$("ul.lang-choice li").on("click", "img", function(){
				let fic = "lang/" + $(this).attr("value") + "-lang.php";
				$.get(fic, function(){
					location.reload();
				});
			});
		</script>
	</body>
	</html>
