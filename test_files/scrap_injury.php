<?php
	// include functions, configurations, and database configurations file  
	include("../_config/config.php");
	include("../_config/db_connect.php"); 
	include("../_includes/functions.php");


	// set file name of api
  	$api_file = 'injuries.json';


  	$url_params = '?position=C,1B,2B,3B,SS,LF,CF,RF,DH,OF';

  	// set full url to be passed to the curl_request function 
    $url = $GLOBALS['msf_api_v2_base_url'] . $api_file . $url_params;

	// call the API function to request all players info that was selected (season,statuses, positions)  and set variable for the response. I named the response variable
	// $player_info_response even though it will return all player info, but I'm only using it to build an array of the ID's to pass into another API call
	$player_injury_response = mysportsfeeds_api_request($url);

	print "<pre>";
	print_r($player_injury_response);
	print "<pre>";

	foreach($player_injury_response->players as $key => $value) {
		print $value->id . ' -- '. $value->firstName . ' ' . $value->lastName . ' -- ' . $value->currentInjury->description . ' -- ' . $value->currentInjury->playingProbability . '<br />';
	}

	
	
?>




