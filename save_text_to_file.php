<?php
	$txt = "";
	$path = "";
	
	if (isset($_POST)) {
		if (isset($_POST['text'])) {
			$txt = $_POST['text'];
		}
		
		if (isset($_POST['path'])) {
			$path = $_POST['path'];
			echo "saved";
		}
		else {
			echo "error";
		}
	}
	else {
		echo "error";
	}
	//print_r($_POST);
	
	$dir = "datoteke";
	chmod($dir, 0777);
	
	$file_location = getenv("DOCUMENT_ROOT") . "/" . $path;
	chmod($file_location, 0777);
	file_put_contents($file_location, $txt);
	return "saved"
?>