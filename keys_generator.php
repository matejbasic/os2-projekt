<?php
	set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
	include('Crypt/RSA.php');
	include('Crypt/Random.php');
	
	//RSA keys
	$rsa = new Crypt_RSA();
	extract($rsa->createKey()); 
	//print_r($privatekey);
	//print_r($publickey);
	
	//AES key
	$secretkey = bin2hex(crypt_random_string(8));
	//print_r($secretkey);
	
	
	$dir = "files/kljucevi";
	if ( !file_exists($dir) ) {
		$old_mask = umask(0);
		mkdir($dir, 0777);
		umask($old_mask);
	}
	else {
		chmod($dir, 0777);
	}
	
	$file_location = getenv("DOCUMENT_ROOT") . "/" . $dir . "/javni_kljuc.txt";
	file_put_contents($file_location, $publickey);
	
	
	$file_location = getenv("DOCUMENT_ROOT") . "/" . $dir . "/privatni_kljuc.txt";
	file_put_contents($file_location, $privatekey);
	
	$file_location = getenv("DOCUMENT_ROOT") . "/" . $dir . "/tajni_kljuc.txt";
	file_put_contents($file_location, $secretkey);
	
	echo "generated";
?>