<?php
/* Redirect to log in page if not logged in */
if(!isset($_SESSION["loginstatus"]) || $_SESSION["loginstatus"] == 0){
	header('Location: http://fc.isima.fr/~bezheng/zzchat/'); 
	exit();
}

include 'functions.php';

updateUserActivity();
removeGhostUsers();

if(isset($_GET["id"])){
	$id = htmlspecialchars($_GET["id"]);
	checkAuthorization($id);
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>ZZ Chat</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	<!-- Enlever -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<link rel="stylesheet" href="css/chat.css" type="text/css" />


</head>
<body>
	<div class="row maxWidth fullHeight">
		<div class="col-xs-3 maxWidth fullHeight">
			<div class="row fullHeight">
				<div class="col-xs-6 sidebar fullHeight">	
				<!-- Sidebar & subbar -->
				<?php include 'bars.php'; ?>
				<!-- Subbar -->
				</div>
				<div class="col-xs-6 subbar fullHeight">
					<div class="row fullHeight">
						<div class="title">Salons</div>
						<div class="separator"></div>
						<ul class="nav nav-sidebar">
							<?php 
							$chatroomsIdList = getUserChatroomsIdList($_SESSION["userId"]);
							//print_r($chatroomsIdList);
							$chatroomsList = getUserChatroomsList($chatroomsIdList);
	
							foreach($chatroomsList as $key=>$value) {
								echo '<li><a href="?id='.$key.'">'.$value['name'].'</a></li>';
							}
							?>
							<li><a href="#" data-toggle="modal" data-target="#modalNewRoom"><span class="glyphicon glyphicon-plus"></span> New room</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>



		<!-- Modal -->
		<div class="modal fade" id="modalNewRoom" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Create new room</h4><br />
						<div>
							<form id="newRoom" class="form-signin">
								<div class="input-group">
									<input type="text" class="form-control" name="username" placeholder="Name" autofocus required>
									<textarea id="roomDescription"  name="roomDescription" maxlength="300" placeholder="Description"></textarea>
								</div>	  
								autocompletion system
								add users...
								</form> 
						</div>
					</div>
				</div>
			</div>
		</div>


		<!-- Main content -->	

		<div class="col-xs-9 maincontent fullHeight">
			<div class="row fullHeight">
				<!-- Chatbox 10-2 -->
				<div class="col-xs-10 fullHeight main">
					<div >
						<h1>Chatbox</h1>
						<div id="chatbox" class="chatbox">
							Loading...
						</div>
						<div id="interface">
							<div>
								<textarea id="sendmsg"  name="message" maxlength="150" placeholder="Type your message here" autofocus></textarea>
							</div>
						</div>
					</div>
				</div>
				<!-- Barre de droite -->
				<div class="col-xs-2 fullHeight">
					mettre des trucs ici
				</div>
			</div>
		</div>
	</div>
	
	<script src="js/chat.js"></script>
	<script type="text/javascript" language="javascript">
		$("#opm").click(function() {
			$.post("online.php", function(data){
				var obj = jQuery.parseJSON(data);
				$("#onlinelist").html('');
				for(i=0;i<obj.length;i++){
					var date = new Date(obj[i].lasttime*1000);
					if(obj[i].online == 1){
						$("#onlinelist").append('<span class="glyphicon glyphicon-stop online"></span>');
					}
					else{
						$("#onlinelist").append('<span class="glyphicon glyphicon-stop offline"></span>');
					}
					$("#onlinelist").append(' '+obj[i].username+'<br>'+date+'<br>');
				}
			});
		});

		$("#send").click(function() {
			chat.send($("#sendmsg").val());
		});



		$("#sendmsg").keypress(function(e) {
			if(e.keyCode == 13){
				e.preventDefault();
				chat.send($(this).val());
			}
		});

		function togMenu(){
			if(menuShown){
				$("#menu").hide();
				menuShown = false;
				$('#showMenu').addClass("btn btn-info");
				$('#showMenu span').addClass("glyphicon glyphicon-circle-arrow-right");
				$('#showMenu span').text("   Menu");

				$('#rooms').removeClass("col-md-offset-2");
				$('#core').removeClass("col-md-offset-4");

			}
			else{
				$("#menu").show();
				menuShown = true;

				$('#showMenu').removeClass("btn btn-info");
				$('#showMenu span').removeClass("glyphicon glyphicon-circle-arrow-right");
				$('#showMenu span').text("");

				$('#rooms').addClass("col-md-offset-2");
				$('#core').addClass("col-md-offset-4");

			}
		}

		var menuShown = true;

		$('.toggle-menu').click(function(){
			togMenu();
		});

		$('#options').click(function() {
			alert('Affiche options');
		});

		$('#friend-list').click(function() {
			alert('Affiche gens connectés');
		});

		$('#smileys').click(function() {
			alert('Affiche smileys');
		});

		$(document).ready(function(){
			$("#chatbox").empty();

			chat =  new Chat();
			chat.getState();

			setTimeout('init()', 500);
			setInterval('chat.update()',2000);	
		});
	</script>
</body>
</html>
