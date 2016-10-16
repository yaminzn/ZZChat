<ul class="nav nav-pills nav-stacked sidebarpill">
	<li><a href="chat.php"><span class="glyphicon glyphicon-comment"></span><span id="chatrooms"> Chatrooms</span></a></li>

	<li><a href="emotes.php"><span class="glyphicon glyphicon-piggy-bank"></span><span id="emotes"> Emotes</span></a></li>
	<li><a href="settings.php"><span class="glyphicon glyphicon-wrench"></span><span id="settings"> Settings</span></a></li>		

	<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span><span id="logout"> Log out</span></span></a></li>
	<?php if($_SESSION['level']>0) include 'adminsidebar.php'; ?>
</ul>