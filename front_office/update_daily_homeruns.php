<?php

	try {
		$configs = include('../_config/config.php');
		include("../_includes/header.php");
		include("../_includes/functions.php");
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
		die();
	}

    if(!is_super_user()){
        print "Only the Super User is allowed back here!";
        exit();
    }

	

	//$api_id = $_GET['id'];


	print "<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />";

	//$url = get_api_url($api_id);

	$daily_hr_form = '<form id="daily_hr_form">';
	$daily_hr_form .= '<label for="date">Enter date of game to update homeruns (YYYYMMDD)</label> ';
	$daily_hr_form .= '<input id="date" name="date" type="text"/> ';
	//$daily_hr_form .= '<input id="url" type="hidden" value="'.$url.'" />';
	$daily_hr_form .= '<input id="daily_hr_form_submit" type="submit" value="Get HRs" />';
	$daily_hr_form .= '</form><br />';
	print $daily_hr_form;


	//print $url;

	//print $url;

	/*
	$daily_hr_form = '<form id="daily_hr_form">';
	$daily_hr_form .= 'Date: <input id="date" type="text"/> ';*/
	/*https://api.mysportsfeeds.com/v2.1/pull/mlb/2019-regular/date/20190920/player_gamelogs.json?stats=HR
	https://api.mysportsfeeds.com/v2.1/pull/mlb/{season}/date/{date}/player_gamelogs.{format}*/
	/*$daily_hr_form .= '<input id="season" type="hidden" value="2019-regular" />';
	$daily_hr_form .= '<input id="daily_hr_form_submit" type="submit" value="Submit" />';
	$daily_hr_form .= '</form><br />';
	print $daily_hr_form;*/
	$preload_image = '<div style="max-width: 200px">';
	$preload_image .= '<img src="../images/baseball_loading_2.gif" id="Preloader" style="max-width:100%;display:none;"/>';
	$preload_image .= '</div>';
	print $preload_image;
	//print '<img src="images/griffey1.gif" id="Preloader" style="display:none;" />';

	print '<div id="daily_hr_form_results"></div>';

/*
	// Get cURL resource
	$ch = curl_init();

	// Set url
	curl_setopt($ch, CURLOPT_URL, 'https://api.mysportsfeeds.com/v2.1/pull/mlb/2019-regular/date/20190920/player_gamelogs.json?stats=HR');//player=10495&team=det&force=false

	// Set method
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

	// Set options
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// Set compression
	curl_setopt($ch, CURLOPT_ENCODING, "gzip");

	// Set headers
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		"Authorization: Basic " . base64_encode($configs['msf_apikey_token'] . ":" . $configs['msf_password'])
	]);

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	// Send the request & save response to $resp
	$resp = curl_exec($ch);

	$response = json_decode($resp);

	//print "<pre>";
	//print_r($response->gamelogs[0]->stats->batting->homeruns);
	//print_r($response);
	//print "</pre>";

	foreach($response->gamelogs as $key => $value) {

		$player_id = $value->player->id;
		$player_firstname = $value->player->firstName;
		$player_lastname = $value->player->lastName;
		$homeruns = $value->stats->batting->homeruns;

		if($homeruns > 0){
			print $player_id . ' -- ' . $player_firstname . ' ' . $player_lastname . ' -- ' .$homeruns . '<br />';
		}

	}


	curl_close($ch);
	*/

?>
