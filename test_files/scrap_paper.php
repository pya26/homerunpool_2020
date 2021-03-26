<?php
	// include functions, configurations, and database configurations file  
	include("../_config/config.php");
	include("../_config/db_connect.php"); 
	include("../_includes/functions.php");

	/**
     * Set active season variables
     */
    $active_season = get_active_season();
    $season_id = $active_season["id"];

	$league_teams = $dbh->prepare("select lt.team_id, lt.season_id, t.team_name, lt.status_id, lt.sort from league_teams lt left join teams t ON t.team_id = lt.team_id where lt.season_id = ? AND lt.status_id = 'A' order by sort ASC");
	$league_teams->bindParam(1, $season_id, PDO::PARAM_INT, 11);
	$league_teams->execute();


	while ($row = $league_teams->fetch(PDO::FETCH_ASSOC)) {
		print $row['team_id'] . " -- " . $row['team_name'] . " -- " . $row['season_id'] . " -- " . $row['status_id'] . " -- " . $row['sort'] . "<br />";
	}
	
	/*print "<pre>";
	print_r($team_players->fetch(PDO::FETCH_ASSOC));
	print "</pre>";*/
?>




