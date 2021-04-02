<?php
	// include functions, configurations, and database configurations file  
	include("../_config/config.php");
	include("../_config/db_connect.php"); 
	include("../_includes/functions.php");
	
   
    $league_id = 10;
    $season_id = 14;


    date_default_timezone_set('America/New_York');
	$date = date('Y-m-d');
	//$newDateTime = date('Y-m-d h:i', strtotime($date));
	print $newDateTime . '<br />';
	
	update_last_updated_date($league_id,$season_id,$date);

	$last_update = get_last_updated_date($league_id,$season_id);
	print $last_update;

?>