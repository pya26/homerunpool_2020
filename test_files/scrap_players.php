<?php
	// include functions, configurations, and database configurations file  
	include("../_config/config.php");
	include("../_config/db_connect.php"); 
	include("../_includes/functions.php");


	// set file name of api
  	$api_file = 'players.json';


  	//$url_params = '?player=10561';
  	$url_params = '?team=bos';

  	// set full url to be passed to the curl_request function 
    $url = $GLOBALS['msf_api_v2_base_url'] . $api_file . $url_params;

	// call the API function to request all players info that was selected (season,statuses, positions)  and set variable for the response. I named the response variable
	// $player_info_response even though it will return all player info, but I'm only using it to build an array of the ID's to pass into another API call
	$player_response = mysportsfeeds_api_request($url);


	print "<pre>";
	print_r($player_response);
	print "</pre>";
	exit();

	print "<pre>";
	print_r($player_response->players[0]->player->externalMappings[4]);
	print "</pre>";


?>
