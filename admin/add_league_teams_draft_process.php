<?php

	include("../_config/config.php");
	include("../_config/db_connect.php");

	$errors = [];
	$data = [];
	
	$league_id = $_POST['league_id'];
	$season_id = $_POST['season_id'];
	$team_id = $_POST['team_id'];
	$role_id = $_POST['role_id'];		
	$status_id = $_POST['status_id'];
	
	foreach ($team_id as $key => $value) {
	
		$stmt = $dbh->prepare("INSERT INTO league_teams (league_id,team_id,role_id,season_id,status_id) VALUES (:league_id,:team_id,:role_id,:season_id,:status_id)");
		$stmt->bindParam('league_id', $league_id, PDO::PARAM_INT);
		$stmt->bindParam('team_id', $value, PDO::PARAM_INT);	
		$stmt->bindParam('role_id', $role_id, PDO::PARAM_INT);
		$stmt->bindParam('season_id', $season_id, PDO::PARAM_INT);
		$stmt->bindParam('status_id', $status_id, PDO::PARAM_STR,1);	
		
		if($stmt->execute() == false){
			$pdo_error = $stmt->errorInfo();
			$data['success'] = false;
			$data['message'] = $pdo_error[2];
		} else {
			$data['success'] = true;
			$data['message'] = 'Success!';
		}
	}


	unset($stmt);


	

	echo json_encode($data);