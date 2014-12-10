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
		
		// u zadatku pise: "Kod provjere digitalnog potpisa se očekuje da se provjeri ispravnost digitalnog potpisa 
		// pri čemu do pogreške (promjene sadržaja) može doći u originalnoj datoteci ili u datoteci koja sadržava 
		// digitalni potpis. "
		// stoga ne usporedjujemo samo sadrzaj potpisane datoteke sa nj sazetkom (sto ima smisla jer primatelj vjerojatno 
		// nece imati pristup originalnoj datoteci) vec usporedjujemo sazetak ucitane originalne datoteke, originalni
		// sazetak digitalno potpisane datoteke i novokreirani sazetak potpisane datoteke
		//$org_data = $data_items[0];
		
		
		$org_data_location = getenv("DOCUMENT_ROOT") . str_replace("_signed", "", $path);	
		$org_data = file_get_contents($org_data_location);
		$org_digest = sha1($org_data);
		
		
		$rsa->loadKey($public_key);
		$signed_org_digest = $rsa->decrypt($data_items[1]);
		
		$signed_digest = sha1($data_items[0]);
		
		if ($org_digest == $signed_org_digest && $org_digest == $signed_digest && $signed_org_digest == $signed_digest) {
			echo "valid";
		}
		else {
			echo "error";
		}
	}
?>