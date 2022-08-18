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

	$date = $_POST['hr_date'];
	//$date = "20220712";


	$url = $GLOBALS['msf_api_v2_base_url'] . 'current_season.json?date=' . $date;
	$season = mysportsfeeds_api_request($url);

	$season_slug = $season->seasons[0]->slug;

	$season_id = get_season_id($season_slug);

	$season_slug = $season->seasons[0]->slug;

	$season_id = get_season_id($season_slug);

	$url_hrs = $GLOBALS['msf_api_v2_base_url'] . $season_slug .'/date/' . $date . '/player_gamelogs.json'; //?player=Semien'

	$hr_response = mysportsfeeds_api_request($url_hrs);

	$year = substr($date, 0, 4);
	$month = substr($date, 4, 2);
	$day = substr($date, 6, 2);

	$column_name = "day" . ltrim($day, '0');

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



/*

	//echo "<br>find arrays with duplicate value for 'name'<br>";
	foreach ($hr_response->gamelogs as $current_key => $current_array) {  

		if($current_array->stats->batting->homeruns > 0){
		$single_game_hrs_array[] = ['player_id' => $current_array->player->id, 'firstName' => $current_array->player->firstName, 'lastName' => $current_array->player->lastName, 'homeruns' => $current_array->stats->batting->homeruns];
		}

		$playerid = $current_array->player->id;
		$homeruns = $current_array->stats->batting->homeruns;   


		foreach ($hr_response->gamelogs as $search_key => $search_array) {
			if ($search_array->player->id == $current_array->player->id) {

				if ($search_key != $current_key) {

					$dh_hrs = $current_array->stats->batting->homeruns + $search_array->stats->batting->homeruns;

					if($dh_hrs > 0){
						$dh_hrs_array[] = ['player_id' => $current_array->player->id, 'firstName' => $current_array->player->firstName, 'lastName' => $current_array->player->lastName, 'homeruns' => $dh_hrs];
					}

				} 
			}
		}

	}

	//var_dump($dh_hrs_array);


	//check if doubheader was played today. If so, merge the single game and double header arrays. If not, just return single game array
  if(isset($dh_hrs_array) && count($dh_hrs_array)  > 0){
  
    // Call function that will return one unique record for each player that playerd a doubleheader and hit a homerun(s) 
    $double_header_hrs = unique_multidim_array($dh_hrs_array,'player_id');

    // Build array of player ids from $double_header_hrs array to be removed from $single_game_hrs_array.
    foreach($double_header_hrs as $key => $value){
      unset($single_game_hrs_array[$key]);
    }

    // Remove records from $single_game_hrs_array that are in $double_header_hrs matching by player_id
    foreach($single_game_hrs_array as $key => $value){

      foreach($double_header_hrs as $key2 => $value2){

        if($value["player_id"] == $value2["player_id"]){
          unset($single_game_hrs_array[$key]);
        }

      } 

    }

    // combine single game array and double header game arrays
    $gamelog_hr_array = array_merge($single_game_hrs_array, $double_header_hrs);

  } else {

    $gamelog_hr_array = $single_game_hrs_array;

  }

*/

	

/*
	print "<table border=1>";
	print "<tr style='vertical-align: top;''>";
	print "<td>";
	//print_r(count($homerun_array));
	print "</td>";
	print "<td>";
	print_r(count($single_game_hrs_array));
	print "</td>";
	print "<td>";
	print_r(count($dh_hrs_array));
	print "</td>";
	print "<td>";
	print_r(count($gamelog_hr_array));
	print "</td>";
	print "</tr>";

	print "<tr style='vertical-align: top;'>";
	    print "<td>";
	      
	        print "<pre>";
	       // print_r($homerun_array);
	        print "<pre>";
	     
	    print "</td>";

	    print "<td>";
	      
	        print "<pre>";
	        print_r($single_game_hrs_array);
	        print "<pre>";
	      
	    print "</td>";

	    print "<td>";
	      
	        print "<pre>";
	        print_r($dh_hrs_array);
	        print "<pre>";
	      
	    print "</td>";

	    print "<td>";
	      
	        print "<pre>";
	        print_r($gamelog_hr_array);
	        print "<pre>";
	      
	    print "</td>";
	  print "</tr>";


	print "</table>";

	exit();
	*/
	
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


	if (!empty($errors)) {
	    $data['success'] = false;
	    $data['errors'] = $errors;
	} else {
	    $data['success'] = true;
	    $data['message'] = 'Success!';
	    $data['homeruns'] = $homerun_array;
	}




	echo json_encode($data);

?>