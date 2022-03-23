<?php

	include("../_config/config.php");
	include("../_config/db_connect.php");
	

	$errors = [];
	$data = [];

	$active_season_id = $_POST['active_season_id'];
    


	/*if (!empty($errors)) {
	    $data['success'] = false;
	    $data['errors'] = $errors;
	} else {
	    $data['success'] = true;
	    $data['message'] = 'Success!';
	}*/
	$stmt = $dbh->prepare("CALL update_active_season(:season_id)");
	$stmt->bindParam('season_id', $active_season_id, PDO::PARAM_INT);
	
	if($stmt->execute() == false){
		$pdo_error = $stmt->errorInfo();
		$data['success'] = false;
		$data['message'] = $pdo_error[2];
	} else {
		$data['success'] = true;
		$data['message'] = 'Success!';
	}
	

	unset($stmt);

	
	echo json_encode($data);