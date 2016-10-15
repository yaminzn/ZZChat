<ul class="nav nav-sidebar">
	<li><a href="chat.php"><span class="glyphicon glyphicon-comment"></span><span id="chatrooms"> Chatrooms</span></a></li>
</ul>
<ul class="nav nav-sidebar">
	<li><a href="emotes.php"><span class="glyphicon glyphicon-piggy-bank"></span><span id="emotes"> Emotes</span></a></li>
	<li><a href="settings.php"><span class="glyphicon glyphicon-wrench"></span><span id="settings"> Settings</span></a></li>		
</ul>
<ul class="nav nav-sidebar">
	<li><a href="logout.php">
		<span class="glyphicon glyphicon-log-out"></span><span id="logout"> Log out</span></span>
	</a></li>
	<!-- <li><button id="opm" type="button" data-toggle="modal" data-target="#myModal">Who's online?</button></li> -->
</ul>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Who's online?</h4>
			</div>
			<div id="onlinelist" class="modal-body">
			</div>
		</div>
	</div>
</div>