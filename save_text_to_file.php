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
	
	$file_name = "files";
	chmod($file_name, 0777);
	
	$file_location = getenv("DOCUMENT_ROOT") . "/" . $path;
	file_put_contents($file_location, $txt);
	
?>