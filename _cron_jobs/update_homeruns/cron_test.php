<?php

	try {
		include("../_config/_config.php");
		include("../_config/_db_config.php");
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}

	/*
	$stmt = $dbh->prepare("SELECT * FROM registered_users WHERE status_id = 'A' ORDER BY last_name");
	$stmt->execute();

	$reg_users_array = array();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$reg_users_array[] = ['reg_id' => $row['reg_id'], 'first_name' => $row['first_name'], 'last_name' => $row['last_name']];
	}


	print_r($reg_users_array);
	*/

	//Get yesterday's date. Format as 'YYYYMMDD' (ex. 20200319)
	//$yesterday_date = date("Ymd",strtotime("-1 days"));
	$yesterday_date = '20190401';

	$url = $GLOBALS['msf_api_v2_base_url'] . 'current_season.json?date=' . $yesterday_date;

	$season = mysportsfeeds_api_request($url);

	$season_slug = $season->seasons[0]->slug;

	$seasonid = get_season_id($season_slug);

	$url_hrs = $GLOBALS['msf_api_v2_base_url'] . $season_slug .'/date/' . $yesterday_date . '/player_gamelogs.json';

	$year = substr($yesterday_date, 0, 4);
	$month = substr($yesterday_date, 4, 2);
	$day = substr($yesterday_date, 6, 2);

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

	$yesterday_hr_array = [];
	foreach ($hr_response->gamelogs as $key => $value) {
		$playerid =  $value->player->id;
		$first_name = $value->player->firstName;
		$last_name = $value->player->lastName;
		$homeruns = $value->stats->batting->homeruns;
		

		if($homeruns > 0){
			
			
			$stmt = $dbh->prepare("UPDATE " . $table_string . " SET " . $column_name  . " = " .$homeruns ." WHERE player_id = ". $playerid ." AND season_id = " . $seasonid . "");
		    $stmt->execute();
		    
		    $sp_statement = "CALL ". $hr_totals_stored_proc . "(?,?)";

		    $stmt = $dbh->prepare($sp_statement);
		    $stmt->bindParam(1, $playerid, PDO::PARAM_INT, 11);
		    $stmt->bindParam(2, $seasonid, PDO::PARAM_INT, 11);
		    $stmt->execute();

		    unset($stmt);
		   
		    //$yesterday_hr_array[] = ['api_param_id' => $row['api_param_id'],'api_param_name' => $row['api_param_name'],'api_param_filter' => $row['api_param_filter'],'api_param_desc' => $row['api_param_desc']];
		    $yesterday_hr_array[] = $first_name.' '.$last_name.' -- HR\'s('.$homeruns.')';			

		    //print $playerid.' -- '.$first_name.' '.$last_name.' -- '.$homeruns.'<br />';
		}

	}

	print "<pre>";
	print_r($yesterday_hr_array);
	print "</pre>";

	if(!empty($yesterday_hr_array)){

 		$yesterday_date_format = strtotime($yesterday_date);
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
		//$body .= " \r\n END \r\n";
		foreach ($yesterday_hr_array as $key => $value) {
			$body .= $value . " \r\n";
		}

		$send_mail = mail($to_email, $subject, $body, $headers);

		if($send_mail){
			print 'email sent';
		}

	} else {
		print 'empty';
	}









	function get_season_id($season){

		try {
			include("../_config/_config.php");
			include("../_config/_db_config.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		$stmt = $dbh->prepare('CALL sp_get_season_id_by_name(?)');
		$stmt->bindParam(1, $season, PDO::PARAM_STR, 15);
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$id = $row['id'];
		}

		if($id > 0){
			return $id;
		} else {
			return 0;
		}

	}




	function mysportsfeeds_api_request($url){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING, "gzip");
		$headers = array(
		    'Content-type: application/json; charset=UTF-8',
		    "Authorization: Basic " . base64_encode($GLOBALS['msf_apikey_token'] . ":" . $GLOBALS['msf_password']),
		);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($ch);
		$response = json_decode($resp);

		curl_close($ch);

		return $response;
	}
	


?>