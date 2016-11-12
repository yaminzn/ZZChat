<?php
if(empty($_FILES)) {
	echo "No files";
}
print_r($_FILES);
/*
$date = new DateTime();
$type = substr(strstr($_FILES['file']['type'], '/'), 1);
$fileName = $date->getTimestamp().'.'.$type;

$filePath = '../img/channels/'.$_SESSION['currentChatId'].'/'.$fileName;

if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
  echo "File is valid, and was successfully uploaded.\n";
} else {
   echo "Upload failed";
}

addImageToChannel($_SESSION['currentChatId'], $fileName);
*/
?>