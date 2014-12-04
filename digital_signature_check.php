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
	
	$org_data_path = str_replace("_signed", "", $path);
	
	
	$org_data = file_get_contents($org_data_path);
	$org_data_signed = $data_items[0];
	
	
	$public_key_location = getenv("DOCUMENT_ROOT") . "/files/kljucevi/javni_kljuc.txt";
	$public_key = file_get_contents($public_key_location);
	$rsa->loadKey($public_key);
	$decrypted_digest = $rsa->decrypt($data_items[1]);
	$org_digest = sha1($org_data);
	$org_signed_digest = sha1($org_data_signed);
	
	if ($decrypted_digest == $org_digest && $decrypted_digest == $org_signed_digest) {
		echo "valid";
	}
	else {
		echo "error";
	}
?>