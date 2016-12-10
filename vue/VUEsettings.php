<!-- Settings = Modal -->

<div class="modal fade" id="modalSettings" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<ul class="nav nav-tabs">
					<li class="nav-item "><a class="nav-link active" data-toggle="tab" href="#home"><?php echo SETTINGS_HOME; ?></a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu1"><?php echo SETTINGS_PW; ?></a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#lang"><?php echo SETTINGS_LANG; ?></a></li>
				<!--	<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu2">Channels</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu3">Account</a></li> -->
				</ul>
				<div class="tab-content">
					<div id="home" class="tab-pane active">
						<br>
						<div class="container">
							<?php echo SET_COLOR_MSG; ?> : <input type="color" id="Ucolor" name="favcolor" value=<?php echo "\"".$_SESSION['color']."\""; ?>>
													<br>
						<button id="submitColor" type="submit" class="btn btn-primary"><?php echo BTN_SAVE; ?></button>
						</div>

					</div>
					<div id="menu1" class="tab-pane">
						<div class="container">
							<br>
							<h3><?php echo SET_PW_TITLE; ?></h3>
							<form id="formChangeUserPassword" action="javascript:void(0);">
								<div class="form-group">
									<label for="previousUserPassword"><?php echo SET_PW_PREV; ?></label>
									<input type="text" class="form-control" id="previousUserPassword" required>
								</div>
								<div class="form-group">
									<label for="newUserPassword"><?php echo SET_PW_NEW; ?></label>
									<input type="text" class="form-control" name="newUserPassword" id="newUserPassword" required>
								</div>
								<div class="form-group">
									<label for="verifyNewUserPassword"><?php echo SET_PW_VERIFY; ?></label>
									<input type="text" class="form-control" name="verifyNewUserPassword" id="verifyNewUserPassword" required>
								</div>
								<button id="submitUserPassword" type="submit" class="btn btn-primary"><?php echo SET_PW_VALID; ?></button>
							</form>
							<span id="errpw"></span>
						</div>
					</div>

					<div id="lang" class="tab-pane">
						<div class="container">
							<br>
							<h3><?php echo SET_LANG_TITLE; ?></h3>
							<!-- Gestion des langues -->
							<form id="changeLang" action="javascript:void(0);">
								<select id="lang">
									<option value="en"><?php echo SET_LANG_EN; ?></option>
									<option value="fr"><?php echo SET_LANG_FR; ?></option>
								</select>
								<br><br>
								<button id="submitLang" type="submit" class="btn btn-primary"><?php echo BTN_SAVE; ?></button>
							</form>
						</div>
					</div>

					<!--
					<div id="menu2" class="tab-pane">
						<br>
						<div class="row">
							<div class="col-sm-4">
								Timestamp
							</div>
							<div class="btn-group col-sm-8">
								<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Small button
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="#">On</a>
									<a class="dropdown-item" href="#">Off</a>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								Night mode
							</div>
							<div class="btn-group col-sm-8">
								<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Small button
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="#">On</a>
									<a class="dropdown-item" href="#">Off</a>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								Desktop notifications
							</div>
							<div class="btn-group col-sm-8">
								<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Small button
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="#">On</a>
									<a class="dropdown-item" href="#">Off</a>
								</div>
							</div>
						</div>

					</div>
					
					<div id="menu3" class="tab-pane">
						<div class="container">
							<br>
							<h3>Delete my account</h3><br>
							<form id="formChangeUserPassword" action="javascript:void(0);">
								<input type="checkbox" name="deleteAccount" id="deleteAccount"> My account will be permanently deleted. All data will be lost.<br><br>
								<div class="form-group">
									<label for="verifyNewUserPassword">Confirm with your password</label>
									<input type="password" class="form-control" name="verifyNewUserPassword" id="verifyNewUserPassword" required>
								</div><br>
								<button id="btnDeleteAccount" type="submit" class="btn btn-danger">Delete</button>
							</form>
						</div>
					</div>
					-->
				</div>
			</div>
		</div>
	</div>
</div>