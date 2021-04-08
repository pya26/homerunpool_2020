<?php
	// include functions, configurations, and database configurations file  
	include("../_config/config.php");
	include("../_config/db_connect.php"); 
	include("../_includes/functions.php");




	// Call function to return all players in database
    $player_db_ids = get_all_players();
   /* print "<pre>";
	print_r($player_db_ids);
	print "</pre>";*/

	

	// set file name of api
  	$api_file = 'players.json';

$player_ids = "10202,10237,10268,10269,10297,10303,10325,10326,10327,10331,10332,10355,10408,10409,10410,10411,10437,10469,10474,10476,10495,10496,10497,10503,10506,10524,10530,10557,10561,10586,10590,10609,10615,10616,10617,10671,10672,10675,10701,10726,10734,10756,10759,10763,10853,10874,10879,10939,10998,11022,11049,11053,11062,11092,1110311105,11107,11136,11176,11234,11239,11251,11258,12201,12217,2235,12239,12258,12314,12335,12361,12414,12551,12553,12563,12565,12590,13996,14135,14254,14255,14258,14271,1427814285,14309,14448,14451,14628,14745";  	


	$url_params = '?player='.$player_ids;
  	// set full url to be passed to the curl_request function 
    $url = $GLOBALS['msf_api_v2_base_url'] . $api_file . $url_params;

	// call the API function to request all players info that was selected (season,statuses, positions)  and set variable for the response. I named the response variable
	// $player_info_response even though it will return all player info, but I'm only using it to build an array of the ID's to pass into another API call
	$player_response = mysportsfeeds_api_request($url);


	/*print "<pre>";
	print_r($player_response->players[0]->player->id);
	print "</pre>";
	//exit();*/
	/*
	$player_id = $player_response->players[0]->player->id;
	$external_mappings = $player_response->players[0]->player->externalMappings;

	foreach($external_mappings as $key => $value){		

		if($value->source == 'MLB.com'){
			print $value->id;
		}

	}
	*/

	/*print "<pre>";
	print_r($player_response->players);
	print "</pre>";*/

	foreach($player_response->players as $key => $value){	

		$player = $value->player->id;

		//print_r($value->player->externalMappings);	

		foreach($value->player->externalMappings as $key2 => $value2){

			if($value2->source == 'MLB.com'){
				//print $player . $value2->id . '<br />';

				$mlbid = $value2->id;

				$stmt = $dbh->prepare('UPDATE players SET MLBID = ? WHERE PlayerID = ?');
			    $stmt->bindParam(1, $mlbid, PDO::PARAM_INT);
			    $stmt->bindParam(2, $player, PDO::PARAM_INT);
			    $stmt->execute();
			}
		}

		/*if($value->player->$external_mappings->source == 'MLB.com'){
			print $value->id;
		}*/

	}


?>
