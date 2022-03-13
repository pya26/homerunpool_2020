<?php

	include("../_config/config.php");
	include("../_config/db_connect.php");
	

	$errors = [];
	$data = [];

	$player_id = $_POST['player_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $position = $_POST['position'];
    $jersey_num = $_POST['jersey_num'];
    $team_id = $_POST['team_id'];
    $team_abbr = $_POST['team_abbr'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    if($_POST['dob'] != ''){
    	$dob = $_POST['dob'];
    } else {
    	$dob = NULL;
    }
    
    $age = $_POST['age'];
    $birth_city = $_POST['birth_city'];
    $birth_country = $_POST['birth_country'];
    $high_school = $_POST['high_school'];
    $college = $_POST['college'];
    $bats = $_POST['bats'];
    $throw_hand = $_POST['throw_hand'];
    $mlb_image = $_POST['mlb_image'];
    $mlb_id = $_POST['mlb_id'];
    $status = $_POST['status'];

	if (empty($_POST['player_id'])) {
	    $errors['player_id'] = 'Player ID is required.';
	}

	if (empty($_POST['first_name'])) {
	    $errors['first_name'] = 'Player first name is required.';
	}

	if (empty($_POST['last_name'])) {
	    $errors['last_name'] = 'Player last name is required.';
	}


	if (!empty($errors)) {
	    $data['success'] = false;
	    $data['errors'] = $errors;
	} else {
	    $data['success'] = true;
	    $data['message'] = 'Success!';
	}

	
	$stmt = $dbh->prepare("UPDATE players SET FirstName=:first_name, LastName=:last_name, PrimaryPosition=:position, JerseyNumber=:jersey_num, TeamID=:team_id, TeamAbbr=:team_abbr, Height=:height, Weight=:weight, DOB=:dob,Age=:age, BirthCity=:birth_city, BirthCountry=:birth_country, HighSchool=:high_school, College=:college, Bats=:bats, Throws=:throws, MLBImage=:mlb_image, MLBID=:mlbid, status_id=:status	WHERE PlayerID = :player_id");
	$stmt->bindParam('player_id', $player_id, PDO::PARAM_INT);
	$stmt->bindParam('first_name', $first_name, PDO::PARAM_STR, 30);
	$stmt->bindParam('last_name', $last_name, PDO::PARAM_STR, 50);
	$stmt->bindParam('position', $position, PDO::PARAM_STR, 3);
	$stmt->bindParam('jersey_num', $jersey_num, PDO::PARAM_INT);
	$stmt->bindParam('team_id', $team_id, PDO::PARAM_INT);
	$stmt->bindParam('team_abbr', $team_abbr, PDO::PARAM_STR, 5);
	$stmt->bindParam('height', $height, PDO::PARAM_STR, 5);
	$stmt->bindParam('weight', $weight, PDO::PARAM_STR, 8);
	$stmt->bindParam('dob', $dob, PDO::PARAM_STR);
	$stmt->bindParam('age', $age, PDO::PARAM_INT);
	$stmt->bindParam('birth_city', $birth_city, PDO::PARAM_STR,75);
	$stmt->bindParam('birth_country', $birth_country, PDO::PARAM_STR,75);
	$stmt->bindParam('high_school', $high_school, PDO::PARAM_STR,100);
	$stmt->bindParam('college', $college, PDO::PARAM_STR,150);
	$stmt->bindParam('bats', $bats, PDO::PARAM_STR,1);
	$stmt->bindParam('throws', $throw_hand, PDO::PARAM_STR,1);
	$stmt->bindParam('mlb_image', $mlb_image, PDO::PARAM_STR,100);
	$stmt->bindParam('mlbid', $mlb_id, PDO::PARAM_INT);
	$stmt->bindParam('status', $status, PDO::PARAM_STR,1);
	$stmt->execute();

	
	echo json_encode($data);