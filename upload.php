<?php
if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(move_uploaded_file($_FILES['upl']['tmp_name'], 'datoteke/'.$_FILES['upl']['name'])){
		echo '{"status":"success"}';
		exit;
	}
}

echo '{"status":"error"}';
exit;