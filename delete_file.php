<?php
	if (isset($_POST)) {
		if (isset($_POST['path'])) {
			$path = $_POST['path'];
			
			if ( file_exists($path) ) {
				$path = getenv("DOCUMENT_ROOT") . "/" . $path;
				$response = unlink($path);
				echo $response;
			}
			else {
				echo "error";
			}
		}
		else {
			echo "error";
		}
	}
	else {
		echo "error";
	}
	
?>