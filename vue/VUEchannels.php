
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>ZZ Chat</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<!-- <link rel="stylesheet" href="css/sidebar.css" type="text/css" /> -->
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="css/chat.css" type="text/css" />

	<?php echo $icon; ?>
	
</head>
<body>
	<div class="container-fluid no-padding-margin">
		<div class="col-md-2 no-padding-margin sidebar">
			<div >
				<ul class="nav nav-pills nav-stacked">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $username; ?></a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="settings.php">Settings</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="logout.php">Log out</a>
							<?php if(isset($adminpanel)) echo $adminpanel; ?>
						</div>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Bookmarks</a>
					</li>
					<li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#modalcreateChannel">Channels +</a></li>
					<?php 
					foreach($channelsList as $key=>$value) {
						echo '<li class="nav-item"><a class="nav-link" href="?id='.$key.'">'.$value['name'].'</a></li>';
					}
					?>

				</ul>
			</div>
		</div>
		<div class="col-md-10 no-padding-margin">
			<nav class="navbar navbar-full navbar-light bg-faded">
				<a id="roomName" class="navbar-brand" href="#">roomname</a>
				<ul class="nav navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="#">Add
							</a>
							<a class="dropdown-item" href="#">Kick
							</a>
							<a href="#" class="dropdown-item" data-toggle="modal" data-target="#modalRenameChannel">Rename channel
							</a>
							<a href="#" class="dropdown-item" data-toggle="modal" data-target="#modalChangeChannelDescription">Change description
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalLeave">Leave</a>
						</div>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="#">Mute</a>
					</li>						
					<li class="nav-item">
						<a class="nav-link" href="#">Bookmark</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Help
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
							<a class="dropdown-item" href="emotes.php" target="_blank">Emotes
							</a>
							<a class="dropdown-item" href="#">Chat commands
							</a>
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalShortcuts">Shortcuts
							</a>
						</div>
					</li>
				</ul>
			</nav>

			<div class="row no-padding-margin">
				<div class="col-md-10 no-padding-margin">
					<div class="row no-padding-margin">
						<div id="chatbox" class="chatboxDiv container-fluid">
							Loading...
						</div>
					</div>
					<div class="row no-padding-margin">
						<div id="bottomchat">
							<div>
								<textarea id="chatMsgTextArea"  name="message" placeholder="Type your message here" autofocus></textarea>
								FILE CAMERA EMOTE GIF
								<span class="pull-right"><button type="button" id="sendMessageBtn" class="btn sendMessageBtn">Send</button></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<span id="userlist">Users list</span>
				</div>
			</div>
		</div>


		<!-- MODAL -->
		<div class="modal fade" id="modalShortcuts" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Shortcuts</h4>
					</div>
					<div class="container">
						<br>
							HOLD CTRL AND TYPE "WTF" FOR ℱ𝓪𝓷𝓬𝔂 𝓦𝓣ℱ
						<br>
						<br>
					</div>
				</div>
			</div>
		</div>
	</div>

		<div class="modal fade" id="modalLeave" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Are you sure you want to leave?</h4>
					</div>
					<div class="container">
						<br>
						<button type="button" class="btn btn-success btn-block" data-dismiss="modal">Cancel</button>
						<button id="submitBtnLeave" type="button" class="btn btn-danger btn-block">Confirm</button>
						<br>
					</div>
				</div>
			</div>
		</div>
	</div>


		<div class="modal fade" id="modalRenameChannel" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Rename channel</h4>
					</div>
					<div class="container">
						<br>
						<form id="formRenameChannel" action="javascript:void(0);">
							<div class="form-group">
								<label for="previousChannelName">Previous name</label>
								<input type="text" class="form-control" id="previousChannelName" disabled>
							</div>
							<div class="form-group">
								<label for="newChannelName">New name</label>
								<input type="text" class="form-control" name="newChannelName" id="newChannelName" required autofocus>
							</div>
							<button id="submitBtnNewChannelName" type="submit" class="btn btn-primary">Save changes</button>
						</form>
						<br>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalChangeChannelDescription" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Change channel</h4>
					</div>
					<div class="container">
						<br />
						<form id="formChangeChannelDescription" action="javascript:void(0);">
							<div class="form-group">
								<label for="previousChannelDescription">Previous description</label>
								<div id="previousChannelDescription"></div>
							</div>
							<div class="form-group">
								<label for="newChannelDescription">New description</label>
								<textarea class="form-control" name="newChannelDescription" id="newChannelDescription" rows="5" autofocus></textarea>
							</div>
							<button id="submitBtnChangeChannelDescription" type="submit" class="btn btn-primary">Save changes</button>
						</form>
						<br />
					</div>
				</div>
			</div>
		</div>


		<div class="modal fade" id="modalcreateChannel" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Create channel</h4>
					</div>
					<div class="container">
						<br />
						<form id="formCreateChannel" action="javascript:void(0);">
							<div class="form-group">
								<label for="createChannelName">Name</label>
								<input type="text" class="form-control" name="createChannelName" id="createChannelName" required autofocus>
							</div>
							<div class="form-group">
								<label for="createChannelDescription">Description</label>
								<textarea class="form-control" name="createChannelDescription" id="createChannelDescription" rows="5"></textarea>
							</div>
							<button id="submitBtnCreateChannel" type="submit" class="btn btn-primary">Create</button>
						</form> 
						<br />
					</div>
				</div>
			</div>
		</div>

		<script src="js/chat.js"></script>
		<script src="js/bootstrap.js"></script>
		<script type="text/javascript" language="javascript">
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
				loadChannelInfo();
				loadUsersList();
				setInterval('loadUsersList()',30000);
			});
		</script>
	</body>
</html>