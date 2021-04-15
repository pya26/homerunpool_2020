<?php


  	try {
       include("../_config/config.php");
      include("../_includes/header.php");
      include("../_config/db_connect.php");
      include("../_includes/functions.php");
    } catch (PDOException $e) {}

    if(!is_super_user()){
        print "Only the Super User is allowed back here!";
        exit();
    }


	if (isset($_POST['create-team'])) {

    if($_POST['reg_id']){
      $reg_id = $_POST['reg_id'];
    } else {
      $reg_id = $_SESSION['reg_id'];
    }

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
    $team_id = $dbh->lastInsertId();


    if($stmt->rowCount()){

      $stmt = $dbh->prepare("INSERT INTO league_teams (league_id, team_id, role_id, status_id) VALUES (?,?,?,?)");
      $stmt->bindParam(1, $league_id, PDO::PARAM_INT, 11);
      $stmt->bindParam(2, $team_id, PDO::PARAM_INT, 11);
      $stmt->bindParam(3, $role_id, PDO::PARAM_INT, 11);
      $stmt->bindParam(4, $status_id, PDO::PARAM_STR, 1);
      $stmt->execute();
      print 'both inserts happened';

      header("Location: create_team.php");

    } else {
      print '2nd insert did not happen';
    }
	}


?>
