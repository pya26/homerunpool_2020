<?php

	include("../_config/config.php");
	include("../_config/db_connect.php");

	$errors = [];
	$data = [];
	
	$league_id = $_POST['league_id'];
	$season_id = $_POST['season_id'];
	$team_id = $_POST['team_id'];
	$player_id = $_POST['player_id'];
	$status_id = 'A';
	$sort = $_POST['draft_order'];
	
	$stmt = $dbh->prepare("INSERT INTO league_team_players (league_id,team_id,player_id,season_id,status_id,sort) VALUES (:league_id,:team_id,:player_id,:season_id,:status_id,:sort)");
	$stmt->bindParam('league_id', $league_id, PDO::PARAM_INT);
	$stmt->bindParam('team_id', $team_id, PDO::PARAM_INT);	
	$stmt->bindParam('player_id', $player_id, PDO::PARAM_INT);
	$stmt->bindParam('season_id', $season_id, PDO::PARAM_INT);
	$stmt->bindParam('status_id', $status_id, PDO::PARAM_STR,1);
	$stmt->bindParam('sort', $sort, PDO::PARAM_INT);	
	
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