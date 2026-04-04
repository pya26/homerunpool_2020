<?php

	include("../_config/config.php");
	include("../_config/db_connect.php");
	include("../_includes/functions.php");
	    

	$errors = [];
	$data = [];



	if(!is_super_user()){
        print "Only the Super User is allowed back here!";
        exit();
    }

	//$date = $_POST['hr_date'];
	$date = "20260303";


	$url = $GLOBALS['msf_api_v2_base_url'] . 'current_season.json?date=' . $date;
	$season = mysportsfeeds_api_request($url);

	$season_slug = $season->seasons[0]->slug;

	$season_id = get_season_id($season_slug);

	$url_hrs = $GLOBALS['msf_api_v2_base_url'] . $season_slug .'/date/' . $date . '/player_gamelogs.json';

	$year = substr($date, 0, 4);
	$month = substr($date, 4, 2);
	$day = substr($date, 6, 2);

	$column_name = "day" . ltrim($day, '0');


	switch ($month) {
		case '01':
	        $table_string = 'hrs_january';
	        $hr_totals_stored_proc = 'update_january_homerun_totals';
			$msg = 'January';
			$monthName = 'January';
    		$monthNum = 1;
	        break;
	    case '02':
	    	$table_string = 'hrs_february';
	        $hr_totals_stored_proc = 'update_february_homerun_totals';
	        $msg = 'February';
			$monthName = 'February';
    		$monthNum = 2;
	        break;
	    case '03':
	        $table_string = 'hrs_march';
	        $hr_totals_stored_proc = 'update_march_homerun_totals';
	        $msg = 'March';
			$monthName = 'March';
    		$monthNum = 3;
	        break;
	    case '04':
	    	$table_string = 'hrs_april';
	        $hr_totals_stored_proc = 'update_april_homerun_totals';
	        $msg = 'April';
			$monthName = 'April';
    		$monthNum = 4;
	        break;
	    case '05':
	    	$table_string = 'hrs_may';
	        $hr_totals_stored_proc = 'update_may_homerun_totals';
	        $msg = 'May';
			$monthName = 'May';
    		$monthNum = 5;
	        break;
	    case '06':
	    	$table_string = 'hrs_june';
	        $hr_totals_stored_proc = 'update_june_homerun_totals';
	        $msg = 'June';
			$monthName = 'June';
    		$monthNum = 6;
	        break;
	    case '07':
	    	$table_string = 'hrs_july';
	        $hr_totals_stored_proc = 'update_july_homerun_totals';
	        $msg = 'July';
			$monthName = 'July';
    		$monthNum = 7;
	        break;
	    case '08':
	    	$table_string = 'hrs_august';
	        $hr_totals_stored_proc = 'update_august_homerun_totals';
	        $msg = 'August';
			$monthName = 'August';
    		$monthNum = 8;
	        break;
	    case '09':
	    	$table_string = 'hrs_september';
	        $hr_totals_stored_proc = 'update_september_homerun_totals';
	        $msg = 'September';
			$monthName = 'September';
    		$monthNum = 9;
	        break;
	    case '10':
	    	$table_string = 'hrs_october';
	        $hr_totals_stored_proc = 'update_october_homerun_totals';
	        $msg = 'October';
			$monthName = 'October';
    		$monthNum = 10;
	        break;
	    case '11':
	    	$table_string = 'hrs_november';
	        $hr_totals_stored_proc = 'update_november_homerun_totals';
	        $msg = 'November';
			$monthName = 'November';
    		$monthNum = 11;
	        break;
	    case '12':
	        $table_string = 'hrs_december';
	        $hr_totals_stored_proc = 'update_december_homerun_totals';
			$msg = 'December';
			$monthName = 'December';
    		$monthNum = 12;
	    default:
	    	$msg = "default message";
	}


	$hr_response = mysportsfeeds_api_request($url_hrs);

	if(empty($hr_response->gamelogs)){

		$subject = 'Update Homerun Cron Job was Unsuccessful';
		$body = 'The gamelogs api response was empty.';

		$send_mail = mail($to_email, $subject, $body, $headers);		
		exit();
	}


	//loop through gamelogs response and build an array of all players that hit a homerun that day. If a player played in a doubleheader, the array will have two array elements for the player. My array ($all_hrs_array) will include all player id that have only hoit a homerun (which could result in duplicate player ids)
foreach ($hr_response->gamelogs as $key => $value) {

	if($value->stats->batting->homeruns > 0){

		$all_hrs_array[] = ['player_id' =>  $value->player->id, 'firstName' => $value->player->firstName, 'lastName' => $value->player->lastName, 'homeruns' => $value->stats->batting->homeruns];
	}

}


$sumArray2 = [];

foreach ($all_hrs_array as $agentInfo) {

    // create new item in result array if pair 'id'+'name' not exists
    if (!isset($sumArray2[$agentInfo['player_id']])) {
        $sumArray2[$agentInfo['player_id']] = $agentInfo;
    } else {
        // apply sum to existing element otherwise
        $sumArray2[$agentInfo['player_id']]['homeruns'] += $agentInfo['homeruns'];
    }
}

// optional action to flush keys of array
$gamelog_hr_array = array_values($sumArray2);


foreach ($gamelog_hr_array as $key => $value) {

    $playerid =  $value["player_id"];
    $first_name = $value["firstName"];
    $last_name = $value["lastName"];
    $homeruns = $value["homeruns"]; 

    if($homeruns > 0){

      $homerun_array[] = ['player_id' => $playerid, 'player_name' => $first_name ." ".$last_name, 'homerun_num' => $homeruns];
      
      $stmt = $dbh->prepare("UPDATE " . $table_string . " SET " . $column_name  . " = " .$homeruns ." WHERE player_id = ". $playerid ." AND season_id = " . $season_id . "");
        $stmt->execute();

        unset($stmt);

        
        $sp_statement = "CALL ". $hr_totals_stored_proc . "(?,?)";

        $stmt = $dbh->prepare($sp_statement);
        $stmt->bindParam(1, $playerid, PDO::PARAM_INT, 11);
        $stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);
        $stmt->execute();

        unset($stmt);
       
    }


  }



  /**
   * Update monthly_hr_totals table
   */
  $upsert_statement = "INSERT INTO monthly_hr_totals (
        player_id,
        team_id,
        league_id,
        season_id,
        month,
        month_num,
        total_hrs
      )
      SELECT
        ltp.player_id,
        ltp.team_id,
        ltp.league_id,
        ltp.season_id,
        :month AS month,
        :month_num AS month_num,
        h.total AS total_hrs
      FROM league_team_players ltp
      JOIN {$table_string} h 
        ON h.player_id = ltp.player_id 
        AND h.season_id = ltp.season_id
      WHERE ltp.season_id = :season_id
      ON DUPLICATE KEY UPDATE 
        total_hrs = VALUES(total_hrs)";
  	
	$stmt = $dbh->prepare($upsert_statement);
	$stmt->execute([
		':month' => $monthName,
        ':month_num' => $monthNum,
        ':season_id' => $season_id,
	]);

	unset($stmt);





?>