<?php
	// include functions, configurations, and database configurations file  
	include("../_config/config.php");
	include("../_config/db_connect.php"); 
	include("../_includes/functions.php");


	// set file name of api
  	$api_file = 'players.json';


  	//$url_params = '?player=mike-trout';
  	$url_params = '?team=bos';
  	//$url_params = '?season=2026-regular&player=ohtani&limit=10'; MUNETAKA MURAKAMI
    //$url_params = '?season=2026-regular&player=devers-12551';


  	// set full url to be passed to the curl_request function 
    $url = $GLOBALS['msf_api_v2_base_url'] . $api_file . $url_params;

	// call the API function to request all players info that was selected (season,statuses, positions)  and set variable for the response. I named the response variable
	// $player_info_response even though it will return all player info, but I'm only using it to build an array of the ID's to pass into another API call
	$players = mysportsfeeds_api_request($url);

    
    print "<pre>";
	print_r($players);
	print "</pre>";
	exit();
/*
	print "<pre>";
	print_r($player_response->players[0]->player->externalMappings[4]);
	print "</pre>";*/


	$teamLookup = [];

    if (!empty($players->references->teamReferences)) {
        foreach ($players->references->teamReferences as $teamRef) {
            $teamLookup[$teamRef->id] = $teamRef->name ?? '';
        }
    }

    // 2. Loop through players
    if (!empty($players->players)) {
        foreach ($players->players as $playerWrapper) {

            if (empty($playerWrapper->player)) {
                continue;
            }

            $player = $playerWrapper->player;

            $firstName       = $player->firstName ?? '';
            $lastName        = $player->lastName ?? '';
            $primaryPosition = $player->primaryPosition ?? '';

            // Prefer teamAsOfDate->id, fallback to currentTeam->id
            $teamId = $playerWrapper->teamAsOfDate->id
                ?? $player->currentTeam->id
                ?? null;

            $teamName = $teamId && isset($teamLookup[$teamId])
                ? $teamLookup[$teamId]
                : '';

            echo $firstName . ' ' . $lastName . ' | '
               . $primaryPosition . ' | '
               . $teamName . "<br />";
        }
    }


?>
