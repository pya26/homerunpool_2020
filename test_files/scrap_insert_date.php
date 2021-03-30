<?php
	// include functions, configurations, and database configurations file  
	include("../_config/config.php");
	include("../_config/db_connect.php"); 
	include("../_includes/functions.php");
	
   
    $league_id = 10;
    $season_id = 14;

	update_last_updated_date($league_id,$season_id);

	$last_update = get_last_updated_date($league_id,$season_id);
	print $last_update;

?>