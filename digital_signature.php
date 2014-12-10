<?php
	set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
	include('Crypt/RSA.php');
	
	$rsa = new Crypt_RSA();
	$keys_dir = "datoteke/kljucevi"; 
	
	$path = "";
	if (isset($_POST['path'])) {
		$path = "/" . $_POST['path'];
	}	
	//load data
	$data_location = getenv("DOCUMENT_ROOT") . $path ;
	$data = file_get_contents($data_location);
	
	$location_array = explode(".", $data_location );
	
	$format = $location_array[sizeof($location_array) - 1];
	$private_key_location = getenv("DOCUMENT_ROOT") . "/" . $keys_dir . "/privatni_kljuc.txt";
	$private_key = file_get_contents($private_key_location);
	if ($private_key === FALSE ) {
		echo "key-missing";
	}
	else {
		//digest data
		$digested_data_location = $location_array[0] . "_digested" . ".txt";
		$digested_data = file_get_contents($digested_data_location);
		if ( $digested_data === false ) {
			$digested_data = sha1($data);
			file_put_contents($digested_data_location, $digested_data);
		}
	
		//encrypt data (RSA)
		$rsa->loadKey($private_key);
		$encrypted_data = $rsa->encrypt($digested_data);
		
		$encrypted_data_location = $location_array[0] . "_digested_encrypted" . ".txt";
		file_put_contents($encrypted_data_location, $encrypted_data);
		
		//all together
		$signature_data_location = $location_array[0] . "_signed" . "." . $format;
		file_put_contents($signature_data_location, $data . "-- Digital Signature --" . $encrypted_data);
		
		echo "signed";
	}
?>