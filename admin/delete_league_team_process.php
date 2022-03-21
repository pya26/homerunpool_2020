<?php

	include("../_config/config.php");
	include("../_config/db_connect.php");
	

	$errors = [];
	$data = [];

	$lt_id = $_GET["lt_id"];
	$league_id = $_GET["league_id"];
	$season_id = $_GET["season_id"];



	$stmt = $dbh->prepare("DELETE FROM league_teams WHERE league_teams_id = :lt_id");
	$stmt->bindParam('lt_id', $lt_id, PDO::PARAM_INT);
	
	$stmt->execute();

	unset($stmt);

	header("Location: set_teams_players.php?league_id=".$league_id."&season_id=".$season_id."&class=0");
	
	exit();

	
	//echo json_encode($data);