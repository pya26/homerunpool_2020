<?php

	include("../_config/config.php");
	include("../_config/db_connect.php");
	include("../_includes/functions.php");
	    

	$errors = [];
	$data = [];


	delete_injured_players();

    // set file name of api
  	$api_file = 'injuries.json';


  	$url_params = '?position=C,1B,2B,3B,SS,LF,CF,RF,DH,OF,P';

  	// set full url to be passed to the curl_request function 
    $url = $GLOBALS['msf_api_v2_base_url'] . $api_file . $url_params;

	// call the API function to request all players info that was selected (season,statuses, positions)  and set variable for the response. I named the response variable
	// $player_info_response even though it will return all player info, but I'm only using it to build an array of the ID's to pass into another API call
	$player_injury_response = mysportsfeeds_api_request($url);


	
	$injury_array = [];
	foreach($player_injury_response->players as $key => $value) {
			
		$player_id = $value->id;
		$name = $value->firstName . ' ' . $value->lastName;
		$team = $value->currentTeam->abbreviation;
		$primary_position = $value->primaryPosition;
		$injury_desc = $value->currentInjury->description;
		$playing_probability = $value->currentInjury->playingProbability;

		$injury_array[] = ['player_id' => $player_id, 'player_name' => $name, 'team' => $team, 'position' => $primary_position, 'injury_desc' => $injury_desc, 'playing_probability' => $playing_probability];

		//print  $player_id . ' ('.$value->primaryPosition.')' .' - '. $value->firstName . ' - ' . $value->lastName . ' - ' . $injury_desc . ' - ' . $playing_probability . '<br />';
		insert_injured_players($player_id,$injury_desc,$playing_probability);
	}



	$league_id = $GLOBALS['league_id'];

	$url = $GLOBALS['msf_api_v2_base_url'] . 'current_season.json?date=' . $date;
	$season = mysportsfeeds_api_request($url);

	$season_slug = $season->seasons[0]->slug;

	$season_id = get_season_id($season_slug);
    
    date_default_timezone_set('America/New_York');
	$thedatetime = date('Y-m-d H:i:s', time());
	

	update_last_updated_date($league_id,$season_id,$thedatetime);


	if (!empty($errors)) {
	    $data['success'] = false;
	    $data['errors'] = $errors;
	} else {
	    $data['success'] = true;
	    $data['message'] = 'Success!';
	    $data['injuries'] = $injury_array;
	}




	echo json_encode($data);



?>