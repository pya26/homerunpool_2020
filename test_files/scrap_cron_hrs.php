<?php

    include('../_config/config.php');
    include('../_config/db_connect.php');
    include('../_includes/functions.php');


	$date = date("Ymd",strtotime("-1 days"));	

	$url = $GLOBALS['msf_api_v2_base_url'] . 'current_season.json?date=' . $date;
	$season = mysportsfeeds_api_request($url);

	$season_slug = $season->seasons[0]->slug;

	//$season_id = get_season_id($season_slug);

	$season_id = 14;

	$url_hrs = $GLOBALS['msf_api_v2_base_url'] . $season_slug .'/date/' . $date . '/player_gamelogs.json';

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




	$hr_response = mysportsfeeds_api_request($url_hrs);

/*print "<pre>";
print_r($hr_response);
print "</pre>";

exit();*/

	foreach ($hr_response->gamelogs as $key => $value) {
		$playerid =  $value->player->id;
		$first_name = $value->player->firstName;
		$last_name = $value->player->lastName;
		$homeruns = $value->stats->batting->homeruns;
	

		if($homeruns > 0){
			
			$stmt = $dbh->prepare("UPDATE " . $table_string . " SET " . $column_name  . " = " .$homeruns ." WHERE player_id = ? AND season_id = ?");
		    $stmt->bindParam(1, $playerid, PDO::PARAM_INT, 11);
		    $stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);
		    $stmt->execute();

		    unset($stmt);

		    
		    $sp_statement = "CALL ". $hr_totals_stored_proc . "(?,?)";

		    $stmt = $dbh->prepare($sp_statement);
		    $stmt->bindParam(1, $playerid, PDO::PARAM_INT, 11);
		    $stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);
		    $stmt->execute();

		    unset($stmt);

		    $player_hrs = array(
				'player_id' => $playerid,
				'player_firstname' => $first_name,
				'player_lastname' => $last_name,
				'homeruns' => $homeruns
			);
			$player_hr_array[] = $player_hrs;
		   
		}

	}









print_r($player_hr_array);





	/*
	$yesterday_date_format = strtotime($date);
 	$yesterday_date_format = date('n/j/Y', $yesterday_date_format);	

	$from_email = "support@homerunpool.com";
	$to_email = "pya2626@gmail.com";

	$subject = "Homeruns hit yesterday ".$yesterday_date_format;

	$headers = "Reply-To: The Sender <".$from_email.">\r\n";
	$headers .= "Return-Path: The Sender <".$from_email.">\r\n";
	$headers .= "From: Homerunpool.com <".$from_email.">\r\n";
	$headers .= "Organization: Homerunpool.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
	$headers .= "X-Priority: 3\r\n";
	$headers .= "X-Mailer: PHP". phpversion() ."\r\n";

	$body = "The following players hit homeruns yesterday on ".$yesterday_date_format.". \r\n\r\n";

	foreach ($player_hr_array as $key => $value) {

		$body .= $value['player_id'] .' '. $value['player_firstname'] .' '. $value['player_lastname'] . " (". $value['homeruns'] .")";

	}

	$send_mail = mail($to_email, $subject, $body, $headers);

*/

	

?>