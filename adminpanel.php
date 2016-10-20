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
	if(checkAuthorization($id) == 0) {
		header('Location: http://fc.isima.fr/~bezheng/zzchat/'); 
	}
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
									<li><a href="#">Users</a></li>
									<li><a href="#">Chatroom</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Main content -->	

			<div id="center" class="col-xs-9 no-padding-margin">
				<div class="container-fluid no-padding-margin">
					<div class="row no-padding-margin">
<table class="table table-inverse table-hover table-sm table-striped table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Username</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>


					</div>
				</div>
			</div>



			<script type="text/javascript" language="javascript">

				$(document).ready(function(){

				});
			</script>
		</body>
		</html>