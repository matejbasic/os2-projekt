<?php
	set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
	include('Crypt/RSA.php');
	include('Crypt/AES.php');
	
	$type = "symetric";
	$path = "";
	$action = "";
	$dir = "datoteke/kljucevi";
	
	if (isset($_POST['type'])) {
		$type = $_POST['type'];
	}	
	if (isset($_POST['path'])) {
		$path = "/".$_POST['path'];
	}	
	if (isset($_POST['action'])) {
		$action = $_POST['action'];
	}	
	
	if ( $type == "symetric" ) {
		
		$secret_key_location = getenv("DOCUMENT_ROOT") . "/" . $dir . "/tajni_kljuc.txt";
		$secret_key = file_get_contents($secret_key_location);
		
		if ($secret_key === FALSE) {
			echo "key-missing";
		}
		else {
			$cipher = new Crypt_AES(CRYPT_AES_MODE_ECB);
			$cipher->setKey($secret_key);
			
			
			$data_location = getenv("DOCUMENT_ROOT") . $path ;
			$data = file_get_contents($data_location);
			$locationArray = explode(".", $data_location );
			
			if ( $action == "encryption" ) {
				$encrypted_data = $cipher->encrypt($data);
				$encrypted_data_location = $locationArray[0] . "_AESencrypted" . "." . $locationArray[1];
				file_put_contents($encrypted_data_location, $encrypted_data);
				
				echo "encrypted";
			}
			else {
				$decrypted_data = $cipher->decrypt($data);
				$decrypted_data_location = $locationArray[0] . "_AESdecrypted" . "." . $locationArray[1];
				file_put_contents($decrypted_data_location, $decrypted_data);
				
				echo "decrypted";
			}
		}
	}
	else {
		
		$rsa = new Crypt_RSA();
		$data_location = getenv("DOCUMENT_ROOT") . $path ;
		
		if ( $action == "encryption" ) {
			$public_key_location = getenv("DOCUMENT_ROOT") . "/". $dir . "/javni_kljuc.txt";
			
			$locationArray = explode(".", $data_location );
			
			$encrypted_data_location = $locationArray[0] . "_RSAencrypted" . "." . $locationArray[1];
			
			$data = file_get_contents($data_location);
			$public_key = file_get_contents($public_key_location);
			if ($public_key === FALSE) {
				echo "key-missing";
			}
			else {
				$rsa->loadKey($public_key);
				$encrypted_data = $rsa->encrypt($data);
				
				file_put_contents($encrypted_data_location, $encrypted_data);
				echo "encrypted";
			}
		}
		else {
			$private_key_location = getenv("DOCUMENT_ROOT") . "/" . $dir . "/privatni_kljuc.txt";
			
			$locationArray = explode(".", $data_location );
			
			$decrypted_data_location = $locationArray[0] . "_RSAdecrypted" . "." . $locationArray[1];
			
			$data = file_get_contents($data_location);
			$private_key = file_get_contents($private_key_location);
			if ($private_key === FALSE) {
				echo "key-missing";
			}
			else {
				$rsa->loadKey($private_key);
				$decrypted_data = $rsa->decrypt($data);
				
				file_put_contents($decrypted_data_location, $decrypted_data);
				
				echo "decrypted";
			}
		}
	}
	
?>