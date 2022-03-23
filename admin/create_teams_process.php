<?php

	include("../_config/config.php");
	include("../_config/db_connect.php");
	

	$errors = [];
	$data = [];

	$reg_id = $_POST['reg_id'];
	$team_name = $_POST['team_name'];
	$role_id = $_POST['role_id'];
	$status_id = 'A';

	
	$stmt = $dbh->prepare("INSERT INTO teams (team_name, reg_id, role_id, status_id) VALUES (:team_name,:reg_id,:role_id,:status_id)");
    $stmt->bindParam('team_name', $team_name, PDO::PARAM_STR, 150);    
    $stmt->bindParam('reg_id', $reg_id, PDO::PARAM_INT, 11);
    $stmt->bindParam('role_id', $role_id, PDO::PARAM_INT, 11);
    $stmt->bindParam('status_id', $status_id, PDO::PARAM_STR, 1);


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