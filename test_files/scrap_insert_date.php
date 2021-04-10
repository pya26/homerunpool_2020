<?php
	// include functions, configurations, and database configurations file  
	include("../_config/config.php");
	include("../_config/db_connect.php"); 
	include("../_includes/functions.php");
	
   
    $league_id = 10;
    $season_id = 14;


    date_default_timezone_set('America/New_York');
	
	$thedate = date('Y-m-d');
	$thedatetime = date('Y-m-d H:i:s', time());

	print $thedate;
	print '<br />';
	print $thedatetime;

	//$stmt = $dbh->prepare('INSERT INTO test_date_update (thedate,thedatetime) VALUES (?,?)');
	$stmt = $dbh->prepare('UPDATE last_updated SET last_date_updated = ? WHERE last_updated_id = 1');
    $stmt->bindParam(1, $thedatetime, PDO::PARAM_STR);
    $stmt->execute();





?>