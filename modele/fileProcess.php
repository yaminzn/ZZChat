<?php
if(empty($_FILES)) {
	echo "No files";
}

include 'functions.php';
//print_r($_FILES);
//Number of files
$n = count($_FILES['fileToUpload']['name']);
$filePath = '../files/'.$_SESSION['currentChatId'].'/';

for($i=0;$i<$n;$i++){
	//Check file error
	if($_FILES['fileToUpload']['error'][$i] != 0){
		break;
	}
	//Check file size, 8 Mo
	if($_FILES['fileToUpload']['size'][$i] > 8000000){
		break;
	}
	//Save it
	$id = count(scandir("../files/".$_SESSION['currentChatId'])) - 2;
	$name = $id."_~".$_SESSION['currentChatId']."_~".$_FILES['fileToUpload']['name'][$i];

	if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'][$i], $filePath.$name)) {
		//Always defined
		$tab['type'] = "file";
		$tab['time'] = date('H:i');
		$tab['username'] = $_SESSION["username"];
		$tab['color'] = $_SESSION["color"];

		//Specific to the type
		$tab['filename'] = $name;

		addDataToChannel($tab, $_SESSION['currentChatId']);
	  	echo "Upload is valid, and was successfully uploaded.\n";
	} else {
	   echo "Upload failed";
	}
}

?>