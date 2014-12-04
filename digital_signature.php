<?php
	set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
	include('Crypt/RSA.php');
	
	$rsa = new Crypt_RSA();
	
	$path = "";
	if (isset($_POST['path'])) {
		$path = "/" . $_POST['path'];
	}	
	//load data
	$data_location = getenv("DOCUMENT_ROOT") . $path ;
	$data = file_get_contents($data_location);
	
	$locationArray = explode(".", $data_location );
	
	//digest data
	$digested_data_location = $locationArray[0] . "_digested" . ".txt";
	$digested_data = file_get_contents($digested_data_location);
	if ( $digested_data === false ) {
		$digested_data = sha1($data);
		file_put_contents($digested_data_location, $digested_data);
	}
	//encrypt data (RSA)
	$private_key_location = getenv("DOCUMENT_ROOT") . "/files/kljucevi/privatni_kljuc.txt";
	$private_key = file_get_contents($private_key_location);
	$rsa->loadKey($private_key);
	$encrypted_data = $rsa->encrypt($digested_data);
	
	$encrypted_data_location = $locationArray[0] . "_digested_encrypted" . ".txt";
	file_put_contents($encrypted_data_location, $encrypted_data);
	
	//all together
	$signature_data_location = $locationArray[0] . "_signed" . ".txt";
	file_put_contents($signature_data_location, $data . "-+-" . $encrypted_data);
	
	echo "signed";
?>