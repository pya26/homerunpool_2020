<?php

	include("../_config/config.php");
	include("../_config/db_connect.php");
	

	$errors = [];
	$data = [];

	$ltid = $_POST["league_teams_id"];
	$sort = $_POST["sort"];
	$league_id = $_POST["league_id"];
	$season_id = $_POST["season_id"];
		

	/*if (!empty($errors)) {
	    $data['success'] = false;
	    $data['errors'] = $errors;
	} else {
	    $data['success'] = true;
	    $data['message'] = 'Success!';
	}*/


	/*var_dump($_POST);
	exit();*/

	

	
	$stmt = $dbh->prepare("UPDATE league_teams SET sort=:sort WHERE league_teams_id = :ltid");
	$stmt->bindParam('sort', $sort, PDO::PARAM_INT);	
	$stmt->bindParam('ltid', $ltid, PDO::PARAM_INT);	
	$stmt->execute();

	unset($stmt);


	header("Location: set_teams_players.php?league_id=".$league_id."&season_id=".$season_id."&class=0");
	
	exit();

	