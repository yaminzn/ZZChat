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
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="css/chat.css" type="text/css" />
	<link rel="stylesheet" href="css/sidebar.css" type="text/css" />
	<link rel="stylesheet" href="css/scrollbar.css" type="text/css" />
	<link rel="stylesheet" href="css/chatnavbar.css" type="text/css" />

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
									<li><a href="#">Bookmarks</a></li>
									<div class="separator"></div>
									<li><a href="#">All</a></li>
									<?php 
										$chatroomsIdList = getUserChatroomsIdList($_SESSION["userId"]);
										$chatroomsList = getUserChatroomsList($chatroomsIdList);

										foreach($chatroomsList as $key=>$value) {
											echo '<li><a href="?id='.$key.'">'.$value['name'].'</a></li>';
										}
									?>
									<li><a href="#" data-toggle="modal" data-target="#modalNewRoom"><span class="glyphicon glyphicon-plus"></span> New room</a></li>
									<li><a><button id="compact" type="button" >Compact</button></a></li>
								</ul>
							</div>
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
										<textarea id="rooxsescription"  name="rooxsescription" maxlength="300" placeholder="Description"></textarea>
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

			<div id="center" class="col-xs-9 no-padding-margin">
				<div class="container-fluid no-padding-margin">
					<div class="row no-padding-margin">
						<!-- Chatbox 10-2 -->
						<div class="col-xs-10 chatFrame no-padding-margin">
							<div class="row ">
								<div class="col-xs-12">
									<div>
									<?php include 'chatnavbar.php'; ?>
									</div>
									<div id="chatbox" class="chatboxDiv container-fluid">
										Loading...
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<div id="bottomchat">
										<div>
											<textarea id="chatMsgTextArea"  name="message" placeholder="Type your message here" autofocus></textarea>

										</div>
										<div class="biggerButton">
											<span class="glyphicon glyphicon-file"></span>
											<span class="glyphicon glyphicon-camera"></span>
											<span class="glyphicon glyphicon-piggy-bank"></span>
											<span class="glyphicon glyphicon-th-large"></span>

											<span class="pull-right"><button type="button" id="sendMessageBtn" class="btn sendMessageBtn">Send</button></span>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Barre de droite -->
						<div class="col-xs-2">
							<?php 
								print_r($_SESSION);
							?>
							
						
						</div>
					</div>
				</div>
			</div>
	<div id="myPopoverContent"></div>
			<script src="js/chatnavbar.js"></script>
			<script src="js/chat.js"></script>
			<script src="js/fixedbars.js"></script>
			<script type="text/javascript" language="javascript">
					var compacted = false;

					$("#compact").click(function() {
					$("#sidebarframe").toggleClass("col-xs-6 col-xs-2");
					$("#subbarframe").toggleClass("col-xs-6 col-xs-10");
					$("#left").toggleClass("col-xs-3 col-xs-2");
					$("#center").toggleClass("col-xs-9 col-xs-10");

					if(compacted){
						compacted = false;
						$("#chatrooms").html(' Chatrooms');
						$("#emotes").html(' Emotes');
						$("#settings").html(' Settings');
						$("#logout").html(' Logout');
					}
					else{
						compacted = true;
						$("#chatrooms").html('');
						$("#emotes").html('');
						$("#settings").html('');
						$("#logout").html('');
					}
				});

				$("#sendMessageBtn").click(function() {
					chat.send($("#chatMsgTextArea").val());
				});

				$("#chatMsgTextArea").keypress(function(e) {
					if(e.keyCode == 13){
						e.preventDefault();
						chat.send($(this).val());
					}
				});

				$(document).ready(function(){
					$("#chatbox").empty();

					chat =  new Chat();
					chat.getState();

					setTimeout('init()', 500);
					setInterval('chat.update()',2000);	
					loadChatnavbarInfo();
					loadUsersList();
					setInterval('loadUsersList()',30000);

					//popovers set up
					popoverOptions = {
						html : true,
						content: function () {
					            return $('#myPopoverContent').html();
					        },
				        trigger: 'hover',
				        animation: false,
				        placement: 'bottom'
				    };
				    $('#userlist').popover(popoverOptions);


					popoverOptions = {
						content: "Bookmark this chatroom",
				        trigger: 'hover',
				        animation: false,
				        placement: 'right'
				    };
				    $('#bookmarkBtn').popover(popoverOptions)
				});
			</script>
		</body>
		</html>