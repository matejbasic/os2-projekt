<?php
	
	$path = "";
	if (isset($_POST['path'])) {
		$path = "/" . $_POST['path'];
	}	
	
	$data_location = getenv("DOCUMENT_ROOT") . $path ;
	$data = file_get_contents($data_location);
	$locationArray = explode(".", $data_location );
		
	$digested_data = sha1($data);
	
	$digested_data_location = $locationArray[0] . "_digested" . ".txt";
	file_put_contents($digested_data_location, $digested_data);
			
	
	echo "digested";
?>