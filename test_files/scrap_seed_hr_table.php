<?php

	// Include functions, configurations, & database cennection files
	
	try {
	    include("../_config/config.php");
	    include("../_config/db_connect.php");
	    include("../_includes/functions.php");
	 } catch (PDOException $e) {
	    echo 'Connection failed: ' . $e->getMessage();     
	 }




	// set URL parameter variables
	
	if(isset($_GET['season'])){
		$season = $_GET['season'];
		$season_id = get_season_id($season);
	} else {
		$season_id = 0;
	}

	

	// Get array of all player ids in the players atble
	$all_db_players_array = get_all_players();


	/*print "<pre>";
	print_r($all_db_players_array);
	print "</pre>";*/



	insert_hrs_march_stub_records26($all_db_players_array,$season_id);


	function insert_hrs_march_stub_records26($player_ids_array,$season_id){

		$dbh = $GLOBALS['dbh'];

		foreach($player_ids_array as $key => $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_march_stub_records(?,?)');
		    $player_id = $key;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);

			$stmt->execute();
		}
	}





?>