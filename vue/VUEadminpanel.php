<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>ZZ Chat</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="css/chat.css" type="text/css" />

	<?php randomIcon(); ?>
	
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
						echo '<li class="nav-item"><a class="nav-link" href="channels.php?id='.$key.'">'.$value['name'].'</a></li>';
					}
					?>

				</ul>
			</div>
		</div>
		<div class="col-md-10 no-padding-margin">
			<div class="container">
				<!-- Main content -->	
				Users: <br>
				<table class="table table-hover table-sm table-striped table-bordered">
					<thead>
						<tr>
							<?php
								foreach($usersArr['users'][0] as $key=>$value) {
									echo "<th>".$key."</th>";
								}
							?>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($usersArr['users'] as $key=>$value) {
							echo "<tr>";
							foreach($value as $key2=>$value2) {
								echo "<td>";
								print_r($value2);
								echo "</td>";
							}
							echo "</tr>";
						}
						?>
					</tbody>
				</table>
				<br>
				Channels:<br>
				<table class="table table-hover table-sm table-striped table-bordered">
					<thead>
						<tr>
							<?php
								foreach($channelsArr['channel'][0] as $key=>$value) {
									echo "<th>".$key."</th>";
								}
							?>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($channelsArr['channel'] as $key=>$value) {
							if($value != null){
								echo "<tr>";
								foreach($value as $key2=>$value2) {
									echo "<td>";
									print_r($value2);
									echo "</td>";
								}
								echo "</tr>";
							}
						}
						?>
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