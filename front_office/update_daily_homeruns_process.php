<?php

	$date = $_GET['date'];


include("../_config/config.php");
include("../_config/db_connect.php");
include("../_includes/functions.php");


$url = $GLOBALS['msf_api_v2_base_url'] . 'current_season.json?date=' . $date;
$season = mysportsfeeds_api_request($url);



$season_slug = $season->seasons[0]->slug;

$seasonid = get_season_id($season_slug);

$url_hrs = $GLOBALS['msf_api_v2_base_url'] . $season_slug .'/date/' . $date . '/player_gamelogs.json';

$year = substr($date, 0, 4);
$month = substr($date, 4, 2);
$day = substr($date, 6, 2);

$column_name = "day" . ltrim($day, '0');
//exit(123);

//print $year . '<br />';
//print $month . '<br />';
//print $day . '<br />';

switch ($month) {
	case '01':
        $table_string = 'hrs_january';
        $hr_totals_stored_proc = 'update_january_homerun_totals';
        break;
    case '02':
    	$table_string = 'hrs_february';
        $hr_totals_stored_proc = 'update_february_homerun_totals';
        $msg = "February";
        break;
    case '03':
        $table_string = 'hrs_march';
        $hr_totals_stored_proc = 'update_march_homerun_totals';
        $msg = "March";
        break;
    case '04':
    	$table_string = 'hrs_april';
        $hr_totals_stored_proc = 'update_april_homerun_totals';
        $msg = "April";
        break;
    case '05':
    	$table_string = 'hrs_may';
        $hr_totals_stored_proc = 'update_may_homerun_totals';
        $msg = "May";
        break;
    case '06':
    	$table_string = 'hrs_june';
        $hr_totals_stored_proc = 'update_june_homerun_totals';
        $msg = "June";
        break;
    case '07':
    	$table_string = 'hrs_july';
        $hr_totals_stored_proc = 'update_july_homerun_totals';
        $msg = "July";
        break;
    case '08':
    	$table_string = 'hrs_august';
        $hr_totals_stored_proc = 'update_august_homerun_totals';
        $msg = "August";
        break;
    case '09':
    	$table_string = 'hrs_september';
        $hr_totals_stored_proc = 'update_september_homerun_totals';
        $msg = "September";
        break;
    case '10':
    	$table_string = 'hrs_october';
        $hr_totals_stored_proc = 'update_october_homerun_totals';
        $msg = "October";
        break;
    case '11':
    	$table_string = 'hrs_november';
        $hr_totals_stored_proc = 'update_november_homerun_totals';
        $msg = "November";
        break;
    case '12':
        $table_string = 'hrs_december';
        $hr_totals_stored_proc = 'update_december_homerun_totals';
    default:
    	$msg = "default message";
}




$hr_response = mysportsfeeds_api_request($url_hrs);



foreach ($hr_response->gamelogs as $key => $value) {
	$playerid =  $value->player->id;
	$first_name = $value->player->firstName;
	$last_name = $value->player->lastName;
	$homeruns = $value->stats->batting->homeruns;

	if($homeruns > 0){
		
		$stmt = $dbh->prepare("UPDATE " . $table_string . " SET " . $column_name  . " = " .$homeruns ." WHERE player_id = ". $playerid ." AND season_id = " . $seasonid . "");
	    $stmt->execute();

	    $stmt = $dbh->prepare("CALL ". $hr_totals_stored_proc . "(?,?)");
	    $stmt->bindParam(1, $playerid, PDO::PARAM_INT, 11);
	    $stmt->bindParam(2, $seasonid, PDO::PARAM_INT, 11);
	    $stmt->execute();
	   
	}

}



	//print $url . '<br />';

	/**
	 * get the season based on the date passed in the url
	 */
	/*
	if (strpos($url, '{season}') !== false) {
		$api_id = 1;	$configs['current_season_api_id']
		$current_season_api_url = get_api_url($api_id);
		$current_season_api_url .= '?date=' . $date;


		$season = mysportsfeeds_api_request($current_season_api_url);

		$season_slug = $season->seasons[0]->slug;

		$url = str_replace("{season}",$season_slug,$url);
	}
	*/



	/*if(strpos($url, '{date}') !== false){
		$url = str_replace("{date}",$date,$url);
	}

	if(strpos($url, '$game') !== false){
		$url = str_replace("{game}",'<input id="game" type="text"/>',$url);
	}

	*/

	//echo json_encode(mysportsfeeds_api_request($url_hrs));

	//$response = mysportsfeeds_api_request($url_hrs);

	/*print json_encode($response);
	exit();*/

	/*
	foreach ($response->gamelogs as $key => $value) {
		print $value->player->id . '<br />';

		$player_id = $value->player->id;
		$player_firstname = $value->player->firstName;
		$player_lastname = $value->player->lastName;
		$homeruns =$value->stats->batting->homeruns;

		if($homeruns > 0){
			print $player_id . ' - '. $player_firstname . ' - '. $player_lastname . ' - '. $homeruns . ' - season ID = ' . $season_id . '<br />';

			$player_hrs = array(
				'player_id' => $player_id,
				'player_firstname' => $player_firstname,
				'player_lastname' => $player_lastname,
				'homeruns' => $homeruns,
				'season_id' => $season_id
			);
			$player_hr_array[] = $player_hrs;
		}
	}
	*/


	/*print '<pre>';
	print_r($player_hr_array);
	print '</pre>';*/

	//echo json_encode($player_hr_array);
	echo json_encode($hr_response);



?>
