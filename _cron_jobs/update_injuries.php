<?php

    include('/home1/homeruo9/public_html/_config/config.php');
    include('/home1/homeruo9/public_html/_config/db_connect.php');
    include('/home1/homeruo9/public_html/_includes/functions.php');

    delete_injured_players();

    // set file name of api
  	$api_file = 'injuries.json';


  	$url_params = '?position=C,1B,2B,3B,SS,LF,CF,RF,DH,OF,P';

  	// set full url to be passed to the curl_request function 
    $url = $GLOBALS['msf_api_v2_base_url'] . $api_file . $url_params;

	// call the API function to request all players info that was selected (season,statuses, positions)  and set variable for the response. I named the response variable
	// $player_info_response even though it will return all player info, but I'm only using it to build an array of the ID's to pass into another API call
	$player_injury_response = mysportsfeeds_api_request($url);

	
	foreach($player_injury_response->players as $key => $value) {
		//print $value->id . ' -- '. $value->firstName . ' ' . $value->lastName . ' -- ' . $value->currentInjury->description . ' -- ' . $value->currentInjury->playingProbability . '<br />';
	
		$player_id = $value->id;
		$injury_desc = $value->currentInjury->description;
		$playing_probability = $value->currentInjury->playingProbability;

		//print  $player_id . ' - ' . $injury_desc . ' - ' . $playing_probability . '<br />';
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



    


























    $from_email = "support@homerunpool.com";
	$to_email = "pya2626@gmail.com";

	$subject = "Injuries updated";

	$headers = "Reply-To: The Sender <".$from_email.">\r\n";
	$headers .= "Return-Path: The Sender <".$from_email.">\r\n";
	$headers .= "From: Homerunpool.com <".$from_email.">\r\n";
	$headers .= "Organization: Homerunpool.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
	$headers .= "X-Priority: 3\r\n";
	$headers .= "X-Mailer: PHP". phpversion() ."\r\n";

	$body = "Injuries have been updated\r\n\r\n";

	

	$send_mail = mail($to_email, $subject, $body, $headers);



?>