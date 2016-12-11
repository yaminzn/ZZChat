<?php
//Destroy everything
if(isset($_SESSION)) {
	setcookie("id", "", time() - 3600);
	setcookie("token", "", time() - 3600);

	unset($_SESSION);
	session_destroy();
	session_write_close();
}

header('Location: http://fc.isima.fr/~bezheng/zzchat/');
exit;

?>