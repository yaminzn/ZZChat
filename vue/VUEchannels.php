
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>ZZ Chat</title>
	<base href="http://fc.isima.fr/~bezheng/zzchat/">

	<!-- <link rel="stylesheet" href="css/sidebar.css" type="text/css" /> -->
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="css/chat.css" type="text/css" />
	<link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
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
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalSettings"><i class="fa fa-cogs" aria-hidden="true"></i> Settings</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Log out</a>
							<?php if(isset($adminpanel)) echo $adminpanel; ?>
						</div>
					</li>
					<li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#modalcreateChannel">Create channel <i class="fa fa-plus-square-o" aria-hidden="true"></i></a></li>
					<div class="container-fluid">

						<?php 

							foreach($channelsList as $key=>$value) {
								//echo '<li class="nav-item"><a class="nav-link" href="channels/'.$key.'">'.$value['name'].'</a></li>';
								  echo'<a href="channels/'.$value['id'].'" class="list-group-item">
		  	<div class="channelList">
		    	<span '; ?> <?php if($value['id'] == $_SESSION['currentChatId']) echo 'id="currentChannel"'; ?> <?php echo 'class="channelName">'.$value['name'].'</span>
		    	<span class="tag tag-info pull-xs-right"></span>
		  	</div>
		  </a>';
							}
						?>
					</div>
					<?php print_r($_SESSION); 

					?>
				</ul>
			</div>
		</div>
		<div class="col-md-10 no-padding-margin">
			<nav class="navbar navbar-full navbar-light bg-faded">
				<a id="roomName" class="navbar-brand" href="#">roomname</a>
				<ul class="nav navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i>
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a href="#" class="dropdown-item" id="aAddUsers" data-toggle="modal" data-target="#modalAddUsers">Add
							</a>
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalKick">Kick
  							</a>
							<a href="#" class="dropdown-item" data-toggle="modal" data-target="#modalRenameChannel">Rename channel
							</a>
							<a href="#" class="dropdown-item" data-toggle="modal" data-target="#modalChangeChannelDescription">Change description
							</a>
							<?php if($_SESSION['currentChatId'] != 0) { ?>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalLeave">Leave</a>
							<?php } ?>
						</div>
					</li>
						
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
							<a class="dropdown-item" href="emotes.php" target="_blank">Emotes
							</a>
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalCommands">Chat commands
							</a>
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalShortcuts">Shortcuts
							</a>
						</div>
					</li>
				</ul>
			</nav>

			<div class="row no-padding-margin">
				<div class="col-md-9 no-padding-margin">
					<div class="row no-padding-margin">
						<div id="chatbox" class="chatboxDiv container-fluid">
							Loading...
						</div>
					</div>
					<div class="row no-padding-margin">
						<div id="bottomchat">
							<textarea id="chatMsgTextArea"  name="message" placeholder="Type your message here" autofocus></textarea>
							<div>
							<!--
								<form method="post" id="formUploadImage" action="javascript:void(0);" enctype="multipart/form-data">
								<i class="fa fa-picture-o" aria-hidden="true"></i><input type="file" id="uploadImage" name="uploadImage" multiple='multiple'>
								</form>
							-->
								<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
									<div class="btn-group btn-group-sm" role="group" aria-label="First group">
										<button type="button" id="bold" class="btn btn-secondary"><i class="fa fa-bold" aria-hidden="true"></i></button>
										<button type="button" id="italic" class="btn btn-secondary"><i class="fa fa-italic" aria-hidden="true"></i></button>
										<button type="button" id="underline" class="btn btn-secondary"><i class="fa fa-underline" aria-hidden="true"></i></button>
										<button type="button" id="strike" class="btn btn-secondary"><i class="fa fa-strikethrough" aria-hidden="true"></i></button>
									</div>
									<div class="btn-group btn-group-sm" role="group" aria-label="Second group">
										<button type="button" class="btn btn-secondary btn-sm fileUploadPO"><i class="fa fa-paperclip" aria-hidden="true"></i></button>
										<button type="button" class="btn btn-secondary gifPO po"><i class="fa fa-film" aria-hidden="true"></i></button>
										<button type="button" class="btn btn-secondary emotesPO po"><i class="fa fa-smile-o" aria-hidden="true"></i></button>
									</div>
									<div class="pull-right">
										<button type="button" id="sendMessageBtn" class="btn btn-sm btn-primary">Send</button>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="row">
					<div class="col-md-12">
					<div id="channelDescription">Channel's description</div>
					<br>
					</div>
					</div>
					<div class="row">
					<div class="col-md-12">
					<div id="userlist">Users list</div>
					</div>
					</div>
					
				</div>
			</div>
		</div>


		<!-- MODAL -->
		<div class="modal fade" id="modalCommands" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Commands</h4>
					</div>
					<div class="container">
						<br>
						!commands in chat to see all available commands
						<br>
						<br>
					</div>
				</div>
			</div>
		</div>


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
						<br><br>
						While in the typing area, use up and down arrow keys to navigate through all your typed messages!
						<br><br>
					</div>
				</div>
			</div>
		</div>


		<div class="modal fade" id="modalKick" role="dialog">
			<div class="modal-dialog">
 				<div class="modal-content">
 					<div class="modal-header">
 						<button type="button" class="close" data-dismiss="modal">&times;</button>
 						<h4 class="modal-title">Kick people</h4>
 					</div>
 					<div class="container">
 
 						<div class="list-user"></div>
 
 						<br>
						<button type="button" class="btn btn-success btn-block" data-dismiss="modal">Cancel</button>
 						<button id="submitqsfqsfqsfqsfqqfqqsf" type="button" class="btn btn-danger btn-block">Confirm</button>
 						<br>
 					</div>
 				</div>
 			</div>
 		</div>

		<div class="modal fade" id="modalAddUsers" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add users</h4>
					</div>
					<div class="container">
						<br>
							<form class="form-inline" action="javascript:void(0);">
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-addon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></div>
										<input type="text" class="form-control" id="searchUser" placeholder="Search for a user">
									</div>
								</div>
							
							<br>
							<br>
							<div>
								<ul id="addUsersList" class="list-group">
								</ul>
							</div>
							<br>
							<button type="submit" id="submitBtnAddUsers" class="btn btn-primary">Add</button>
							</form>
						<br>
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
						<h4 class="modal-title">Change description</h4>
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

		<div id="gif_popover_content_wrapper">
			<div class="gifWrapper container-fluid">
				<div class="gifSearchbar">
					<div class="container">
						<div class="input-group">
							<input type="text" id="search" placeholder="Search for gifs" class="form-control" autofocus>
							<span class="input-group-btn"><button class="btn btn-primary" type="button" id="gifSearchBtn">Go!</button></span>
						</div>
					</div>
				</div>
				<div id="gifRes">
				<br><br><br><br><br><br>Pss, wanna buy some gifs?<br>
					┴┬┴┤( ͡° ͜ʖ├┬┴┬ 
				</div>
			</div>
		</div>

		<div id="emotes_popover_content_wrapper">
			<div class="emotesWrapper">
				<ul class="nav nav-tabs">
					<li class="nav-item"><a class="nav-link active" id="a_emotes_global" data-toggle="tab" href="#emotes_global">Global</a></li>
					<li class="nav-item"><a class="nav-link" id="a_emotes_bttv" data-toggle="tab" href="#emotes_bttv">BTTV</a></li>
					<li class="nav-item"><a class="nav-link" id="a_emotes_custom" data-toggle="tab" href="#emotes_custom">Custom</a></li>
				</ul>
				<div class="tab-content">
					<div id="emotes_global" class="tab-pane active">
					</div>
					<div id="emotes_bttv" class="tab-pane">
					</div>
					<div id="emotes_custom" class="tab-pane">
					</div>
				</div>
			</div>
		</div>

		<div id="fileUpload_popover_content_wrapper">
			<div class="fileUploadWrapper">	
				<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
					<div class="btn-group btn-sm" role="group" aria-label="First group">
						<button id="addFileUpload" type="button" class="btn btn-secondary">
							<label id="labelfile-upload" for="file-upload" style="margin: 0 0 0 0;">
								Add files
							</label>
						</button>
						<button id="upload" type="button" class="btn btn-secondary">Upload</button>
					</div>
				</div>
				<div id="fileList">
					<ul id="fileUl" class="list-group">
					</ul>
				</div>
			</div>
		</div>
		<input id="file-upload" type="file" style="display: none;" multiple='multiple' />

		<?php include 'VUEsettings.php'; ?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
		<script src="js/chat.js"></script>
		<script src="js/bootstrap.js"></script>
		<script type="text/javascript" language="javascript">

			$("ul.lang-choice li").on("click", "img", function(){
				let fic = "lang/" + $(this).attr("value") + "-lang.php";
				$.get(fic, function(){
					location.reload();
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
