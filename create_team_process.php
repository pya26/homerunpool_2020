<?php
  	
  	try {
      include("_includes/header.php");
      include("_config/db_connect.php");
    } catch (PDOException $e) {}



	if (isset($_POST['create-team'])) {

		$reg_id = $_SESSION['reg_id'];
		$role_id = $_POST['role_id'];
		$team_name = $_POST['team_name'];
		$team_desc = $_POST['team_desc'];
		$league_id = $_POST['league_id'];
		$status_id = 'A';

		$stmt = $dbh->prepare("INSERT INTO teams (team_name, team_desc, reg_id, role_id, status_id) VALUES (?,?,?,?,?)");
		    
	    $stmt->bindParam(1, $team_name, PDO::PARAM_STR, 150);
	    $stmt->bindParam(2, $team_desc, PDO::PARAM_STR);
	    $stmt->bindParam(3, $reg_id, PDO::PARAM_INT, 11);
	    $stmt->bindParam(4, $role_id, PDO::PARAM_INT, 11);
	    $stmt->bindParam(5, $status_id, PDO::PARAM_STR, 1);
	    $stmt->execute();
	}


?>