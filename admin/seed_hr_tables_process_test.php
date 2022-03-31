<?php

	

    $errors = [];
	$data = [];

	
	if(isset($_POST['selected_season'])){
		$season = $_POST['selected_season'];
	} else {
		$season_id = 0;
	}


	if (!empty($errors)) {
	    $data['success'] = false;
	    $data['errors'] = $errors;
	} else {
	    $data['success'] = true;
	    $data['message'] = 'Success!';
	}

	


	echo json_encode($data);

	




?>
