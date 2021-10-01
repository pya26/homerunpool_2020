<?php
	// include functions, configurations, and database configurations file  
	include("../_config/config.php");
	include("../_config/db_connect.php"); 
	include("../_includes/functions.php");


	
	delete_injured_players();


	
	// set file name of api
  	$api_file = 'injuries.json';


  	$url_params = '?position=C,1B,2B,3B,SS,LF,CF,RF,DH,OF';

  	// set full url to be passed to the curl_request function 
    $url = $GLOBALS['msf_api_v2_base_url'] . $api_file . $url_params;

	// call the API function to request all players info that was selected (season,statuses, positions)  and set variable for the response. I named the response variable
	// $player_info_response even though it will return all player info, but I'm only using it to build an array of the ID's to pass into another API call
	$player_injury_response = mysportsfeeds_api_request($url);

	

	/*$mung = get_injured_players(12258);*/

	/*print "<pre>";
	print_r($player_injury_response);
	print "</pre>";
	exit();*/

	foreach($player_injury_response->players as $key => $value) {
		//print $value->id . ' -- '. $value->firstName . ' ' . $value->lastName . ' -- ' . $value->currentInjury->description . ' -- ' . $value->currentInjury->playingProbability . '<br />';
	
		$player_id = $value->id;
		$first_name = $value->firstName;
		$last_name = $value->lastName;
		$injury_desc = $value->currentInjury->description;
		$playing_probability = $value->currentInjury->playingProbability;

		print  $player_id . ' - ' . $first_name . ' ' . $last_name . ' - ' . $injury_desc . ' - ' . $playing_probability . '<br />';
		//insert_injured_players($player_id,$injury_desc,$playing_probability);
	}



	$league_id = $GLOBALS['league_id'];
    $season_id = 14;

    date_default_timezone_set('America/New_York');
	$thedatetime = date('Y-m-d H:i:s', time());
		

	//update_last_updated_date($league_id,$season_id,$thedatetime);

	print "done";



	
	
?>




