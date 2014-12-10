<?php
	set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
	include('Crypt/RSA.php');
	
	$rsa = new Crypt_RSA();
	$keys_dir = "datoteke/kljucevi"; 
	
	$path = "";
	if (isset($_POST['path'])) {
		$path = "/" . $_POST['path'];
	}
	else {
		echo "error";
		exit();
	}
	
	$public_key_location = getenv("DOCUMENT_ROOT") . "/" . $keys_dir . "/javni_kljuc.txt";
	$public_key = file_get_contents($public_key_location);
	if ($public_key === FALSE ) {
		echo "key-missing";
	}
	else {
		
		$data_location = getenv("DOCUMENT_ROOT") . $path ;
		$data = file_get_contents($data_location);
		$data_items = explode("-- Digital Signature --", $data);
		
		// u zadatku pise "...pri cemu do pogreske (promjene sadrzaja) moze doci u originalnoj datoteci..."
		// stoga ne usporedjujemo sadrzaj potpisane datoteke sa sazetkom (sto ima smisla jer primatelj vjerojatno 
		// nece imati pristup originalnoj datoteci) vec ucitavamo datoteku i usporedjujemo njezin sazetak
		//$org_data = $data_items[0];
		
		
		$org_data_location = getenv("DOCUMENT_ROOT") . str_replace("_signed", "", $path);	
		$org_data = file_get_contents($org_data_location);
		$org_digest = sha1($org_data);
		
		
		$rsa->loadKey($public_key);
		$signed_digest = $rsa->decrypt($data_items[1]);
		
		
		
		if ($signed_digest == $org_digest) {
			echo "valid";
		}
		else {
			echo "error";
		}
	}
?>