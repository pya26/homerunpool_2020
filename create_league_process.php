<?php
  	
  	try {
      include("_includes/header.php");
      include("_config/db_connect.php");
    } catch (PDOException $e) {}



	if (isset($_POST['create-league'])) {
		
		$league_name = $_POST['league_name'];
		$league_desc = $_POST['league_desc'];
		$league_type_id = $_POST['league_type'];
		$teams_allowed = $_POST['teams_allowed'];
		$players_per_team = $_POST['players_per_team'];
		$created_by = $_SESSION['reg_id'];
		$status_id = 'A';

		$stmt = $dbh->prepare("INSERT INTO leagues (league_name, league_desc, league_type_id, teams_allowed, players_per_team, created_by, status_id) VALUES (?,?,?,?,?,?,?)");
		    
	    $stmt->bindParam(1, $league_name, PDO::PARAM_STR, 150);
	    $stmt->bindParam(2, $league_desc, PDO::PARAM_STR);
	    $stmt->bindParam(3, $league_type_id, PDO::PARAM_INT, 11);
	    $stmt->bindParam(4, $teams_allowed, PDO::PARAM_INT, 11);
	    $stmt->bindParam(5, $players_per_team, PDO::PARAM_INT, 11);
	    $stmt->bindParam(6, $created_by, PDO::PARAM_INT, 11);
	    $stmt->bindParam(7, $status_id, PDO::PARAM_STR, 1);
	    $stmt->execute();
	    $league_id = $dbh->lastInsertId();

	    
	    if($stmt->rowCount()){

	    	$stmt = $dbh->prepare("INSERT INTO leagues_teams (league_id, team_id, role_id, status_id) VALUES (?,?,?)");
	    	$stmt->bindParam(1, $league_type_id, PDO::PARAM_INT, 11);
	    	$stmt->bindParam(2, $team_id, PDO::PARAM_INT, 11);
	    	$stmt->bindParam(3, $role_id, PDO::PARAM_INT, 11);
	    	$stmt->bindParam(4, $status_id, PDO::PARAM_STR, 1);

	    } else {
	    	print 'insert hapenned';
	    }
	}


?>