<?php

	include("../_config/config.php");
	include("../_config/db_connect.php");
	

	$errors = [];
	$data = [];

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$status_id = 'A';
   

	$stmt = $dbh->prepare("INSERT INTO registered_users (first_name,last_name,email,status_id) VALUES (:first_name,:last_name,:email,:status_id)");
	$stmt->bindParam('first_name', $first_name, PDO::PARAM_STR,50);
	$stmt->bindParam('last_name', $last_name, PDO::PARAM_STR,125);
	$stmt->bindParam('email', $email, PDO::PARAM_STR,150);
	$stmt->bindParam('status_id', $status_id, PDO::PARAM_STR,1);

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