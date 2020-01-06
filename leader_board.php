<?php
  try {
      include("_includes/header.php");
      include("_includes/functions.php");
      include("_config/db_connect.php");
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      die();
    }

    print isset($_SESSION['reg_id']) . '<br />';
    print isset($_SESSION['lid']) . '<br />';

   

    
    if(!isset($_SESSION['reg_id']) && !isset($_GET['lid'])){
    	$redirect_url = "login.php?redirect=" . $_SERVER['REQUEST_URI'];
      header("Location: ".$redirect_url);
    } elseif (isset($_SESSION['reg_id']) && !isset($_GET['lid'])){
    	header("Location: front_office.php");
    } elseif (!isset($_SESSION['reg_id']) && isset($_GET['lid'])){
    	$redirect_url = "login.php?redirect=" . $_SERVER['REQUEST_URI'];
      header("Location: ".$redirect_url);
    }

    /*
    if(!isset($_GET['lid'])){
      header("Location: login.php");
    }*/

?>

<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />

<h1>Leader Board</h1>

<?php

$league_info = get_league_info($_GET['lid']);

foreach($league_info as $key => $value){

	$league_info_data = 'League Name: ' . $value['league_name'] . '<br />';
	$league_info_data .= 'League Description: ' . $value['league_desc'] . '<br />';
	$league_info_data .= 'Teams Allowed: ' . $value['teams_allowed'] . '<br />';
	$league_info_data .= 'Date Created: ' . date('n/j/Y',strtotime($value['date_created'])) . '<br />';
	$league_info_data .= 'Date Updated: ' . date('n/j/Y',strtotime($value['date_updated'])) . '<br />';
	$league_info_data .= 'Created By: ' . get_registered_user_name($value['created_by']) . '<br />';
	$league_info_data .= 'League Status: ' . get_status_name($value['status_id']) . '<br />';

}
print $league_info_data;

?>
