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
	$data_items = explode("-+-", $data);
	
	$org_msg = $data_items[0];
	
	
	$public_key_location = getenv("DOCUMENT_ROOT") . "/files/kljucevi/javni_kljuc.txt";
	$public_key = file_get_contents($public_key_location);
	$rsa->loadKey($public_key);
	$decrypted_digest = $rsa->decrypt($data_items[1]);
	$temp_digest = sha1($org_msg);
	
	if ($decrypted_digest == $temp_digest) {
		echo "valid";
	}
	else {
		echo "error";
	}
?>