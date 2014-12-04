<?php
	if (isset($_POST)) {
		if (isset($_POST['path'])) {
			$path = $_POST['path'];
			
			if ( file_exists($path) ) {
				$path = getenv("DOCUMENT_ROOT") . "/" . $path;
				$plain_txt = file_get_contents($path);
				echo $plain_txt;
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