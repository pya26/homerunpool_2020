<?php

	function get_active_season(){
		
		$dbh = $GLOBALS['dbh'];

		$stmt = $dbh->prepare('CALL get_active_season');
		$stmt->execute();

		$active_season_array = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$active_season_array = $row;
		}

		return $active_season_array;
	}





	function dynamic_select($the_array, $element_name, $label = '', $init_value = '') {
	    $menu = '';
	    if ($label != '') $menu .= '
	    	<label for="'.$element_name.'">'.$label.'</label>';
	    $menu .= '
	    	<select name="'.$element_name.'" id="'.$element_name.'">';
	    if (empty($_REQUEST[$element_name])) {
	        $curr_val = $init_value;
	    } else {
	        $curr_val = $_REQUEST[$element_name];
	    }
	    /*
	    foreach ($the_array as $key => $value) {
	        $menu .= '
				<option value="'.$key.'"';
	        if ($key == $curr_val) $menu .= ' selected="selected"';
	        $menu .= '>'.$value.'</option>';
	    }*/
	    /**
	     * Change the foreach loop to a for loop to itterate through the multidimensional array
	     */
	    $menu .= '<option value="">--- Select an API ---</option>';
	    for ($i = 0; $i < count($the_array); $i++) {
	    	$menu .= '<option value="'.$the_array[$i]['api_id'].'"';
	        if ($the_array[$i]['api_id'] == $curr_val) $menu .= ' selected="selected"';
	        $menu .= '>'.$the_array[$i]['api_name'].'</option>';
	    }
	    $menu .= '
	    	</select>';
	    return $menu;
	}





	function list_of_seasons(){

		$dbh = $GLOBALS['dbh'];

		$stmt = $dbh->prepare('CALL sp_get_all_seasons');
		$stmt->execute();

		$seasons_array = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$seasons_array[] = $row;
		}

		return $seasons_array;
	}





	function season_select_menu(){

		$seasons = list_of_seasons();

		$season_select_menu = '<select type="select_season" name="select_season" id="select_season">';
		$season_select_menu .= '<option selected=""></option>';
		foreach($seasons as $season) {
			$season_select_menu .= '<option value="'.$season['id'].'">'.$season['slug'].'</option>';
		}

		$season_select_menu .= '</select>';

		return $season_select_menu;
	}





	function get_api_and_params($api_id){

		$dbh = $GLOBALS['dbh'];

		$api_url_query = $dbh->prepare("SELECT api_name, api_url, api_desc  FROM msf_apis WHERE api_id = ?");
		$api_url_query->bindParam(1, $api_id, PDO::PARAM_INT);
		$api_url_query->execute();

		$api_url_array = [];
		while ($row = $api_url_query->fetch(PDO::FETCH_ASSOC)) {
			$api_url_array = ['api_name' => $row['api_name'],'api_url' => $row['api_url'],'api_desc' => $row['api_desc']];
		}

		$api_params_query = $dbh->prepare("SELECT m.* FROM rel_apis_api_params r JOIN msf_api_params m ON m.api_param_id = r.api_param_id WHERE r.api_id = ? ORDER BY m.api_param_name ASC");
		$api_params_query->bindParam(1, $api_id, PDO::PARAM_INT);
		$api_params_query->execute();

		$api_params_array = [];
		while ($row = $api_params_query->fetch(PDO::FETCH_ASSOC)) {
			$api_params_array[] = ['api_param_id' => $row['api_param_id'],'api_param_name' => $row['api_param_name'],'api_param_filter' => $row['api_param_filter'],'api_param_desc' => $row['api_param_desc']];

		}

		return array_merge($api_url_array, $api_params_array);
	}





	function get_api_url($api_id){

		$dbh = $GLOBALS['dbh'];

		$stmt = $dbh->prepare('CALL sp_get_api_url(:apiid)');
		$stmt->bindParam('apiid', $api_id, PDO::PARAM_INT, 11);
		$stmt->execute();

		$format = 'json';

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

			$url = $row['api_url'];
			$url = str_replace("{format}",$format,$url);

			$api_url_array = array('api_url' => $url);
		}

		if(isset($api_url_array)){
			return $api_url_array['api_url'];
		} else {
			return 'error';
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

		// Send the request & save response to $resp
		$resp = curl_exec($ch);
		$response = json_decode($resp);

		curl_close($ch);

		return $response;
	}





	function current_season(){

		$current_date =  date('Ymd');
		$url = get_api_url(1) . '?date=' . $current_date;

		$current_season = mysportsfeeds_api_request($url);

		if(!empty($current_season->seasons[0])){
			$season = $current_season->seasons[0]->slug;
		} else {
			$season = 'Season not defined';
		}

		return $season;
	}





	function get_all_players(){

		$dbh = $GLOBALS['dbh'];

		$stmt = $dbh->prepare("CALL sp_get_all_players");
		$stmt->execute();
		$player_db_ids = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			/**
			 * added first name and last name for 'add_league_team_players.php'
			 */			
			$player_db_ids[$row['PlayerID']] = $row['FirstName'] . ' ' . $row['LastName'];
			
		}

		return $player_db_ids;
	}





	function get_all_roster_statuses(){

		$dbh = $GLOBALS['dbh'];

		$stmt = $dbh->prepare("CALL sp_get_all_roster_statuses");
		$stmt->execute();

		$status_array = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

		 	$status_array[] = array(
		 		'roster_status_id' => $row['roster_status_id'],
		 		'roster_status_name' => $row['roster_status_name'],
		 		'roster_status_desc' => $row['roster_status_desc']
		 	);
		}

	    return $status_array;
	}





	function get_all_hitter_positions(){

		$dbh = $GLOBALS['dbh'];

		$stmt = $dbh->prepare('CALL sp_get_all_hitter_positions');
		$stmt->execute();

		$position_array = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	      $position_array[$row['position_id']] = $row['position_name'];
	    }

	    return $position_array;
	}





	function get_season_id($season){

		$dbh = $GLOBALS['dbh'];

		$stmt = $dbh->prepare('CALL sp_get_season_id_by_name(:seasonslug)');
		$stmt->bindParam('seasonslug', $season, PDO::PARAM_STR, 15);
		$stmt->execute();
		$rowCount = $stmt->rowCount();

		if($rowCount > 0){
			
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$id = $row['id'];
			}

			return $id;

		} else {
			return 0;
		}
	}





	function insert_players($player_info_response){

		$dbh = $GLOBALS['dbh'];

		// loop through $player_info_response and insert into players database
	    foreach($player_info_response->players as $key => $value) {

	      $stmt = $dbh->prepare("INSERT INTO players (PlayerID,FirstName,LastName,PrimaryPosition,JerseyNumber,TeamID,TeamAbbr,Height,Weight,DOB,Age,BirthCity,BirthCountry,HighSchool,College,Bats,Throws,MLBImage,MLBID,status_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	      $stmt->bindParam(1, $player_id, PDO::PARAM_INT);
	      $stmt->bindParam(2, $first_name, PDO::PARAM_STR, 30);
	      $stmt->bindParam(3, $last_name, PDO::PARAM_STR, 50);
	      $stmt->bindParam(4, $position, PDO::PARAM_STR, 3);
	      $stmt->bindParam(5, $jersey_num, PDO::PARAM_INT);
	      $stmt->bindParam(6, $team_id, PDO::PARAM_INT);
	      $stmt->bindParam(7, $team_abbr, PDO::PARAM_STR, 5);
	      $stmt->bindParam(8, $height, PDO::PARAM_STR, 5);
	      $stmt->bindParam(9, $weight, PDO::PARAM_STR, 8);
	      $stmt->bindParam(10, $dob, PDO::PARAM_STR, 10);
	      $stmt->bindParam(11, $age, PDO::PARAM_INT);
	      $stmt->bindParam(12, $birth_city, PDO::PARAM_STR,75);
	      $stmt->bindParam(13, $birth_country, PDO::PARAM_STR,75);
	      $stmt->bindParam(14, $high_school, PDO::PARAM_STR,100);
	      $stmt->bindParam(15, $college, PDO::PARAM_STR,150);
	      $stmt->bindParam(16, $bats, PDO::PARAM_STR,1);
	      $stmt->bindParam(17, $throws, PDO::PARAM_STR,1);
	      $stmt->bindParam(18, $mlb_image, PDO::PARAM_STR,25);
	      $stmt->bindParam(19, $mlbid, PDO::PARAM_STR,11);
	      $stmt->bindParam(20, $status, PDO::PARAM_STR,1);

	      $player_id = $value->player->id;
	      $first_name = $value->player->firstName;
	      $last_name = $value->player->lastName;
	      $position = $value->player->primaryPosition;
	      $jersey_num = $value->player->jerseyNumber;

	      if(isset($value->player->currentTeam->id)){
	        $team_id = $value->player->currentTeam->id;
	      } else {
	        $team_id = 0;
	      }
	      if(isset($value->player->currentTeam->abbreviation)){
	        $team_abbr = $value->player->currentTeam->abbreviation;
	      } else {
	        $team_abbr = '';
	      }

	      $height = $value->player->height;
	      $weight = $value->player->weight;
	      $dob = $value->player->birthDate;
	      $age = $value->player->age;
	      $birth_city = $value->player->birthCity;
	      $birth_country = $value->player->birthCountry;
	      $high_school = $value->player->highSchool;
	      $college = $value->player->college;
	      $bats = $value->player->handedness->bats;
	      $throws = $value->player->handedness->throws;

	      if(isset($value->player->officialImageSrc)){
	        $split_url = explode('//', $value->player->officialImageSrc);
	        $pieces = explode('/', $split_url[1]);
	        $num = (count($pieces) - 1);
	        $mlb_image = $pieces[$num];
	      } else {
	        $mlb_image = '';
	      }

	      foreach($value->player->externalMappings as $key2 => $value2){
	        $mlbid = $value2->id;
	      }

	      $status = 'A';

	      $stmt->execute();

	    }
	}





	function insert_hrs_february_stub_records($player_ids_array,$season_id){

		$dbh = $GLOBALS['dbh'];

		foreach($player_ids_array as $key => $value) {

    		$stmt = $dbh->prepare('CALL insert_hrs_february_stub_records(?,?)');
		    $player_id = $key;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);

			$stmt->execute();
		}
	}





	function insert_hrs_march_stub_records($player_ids_array,$season_id){

		$dbh = $GLOBALS['dbh'];

		foreach($player_ids_array as $key => $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_march_stub_records(?,?)');
		    $player_id = $key;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);

			$stmt->execute();
		}
	}





	function insert_hrs_april_stub_records($player_ids_array,$season_id){

		$dbh = $GLOBALS['dbh'];

		foreach($player_ids_array as $key => $value) {

			$player_id = $key;

    		$stmt = $dbh->prepare('CALL insert_hrs_april_stub_records(:playerid,:seasonid)');		    

		    $stmt->bindParam('playerid', $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam('seasonid', $season_id, PDO::PARAM_INT, 11);

			$stmt->execute();
		}
	}





	function insert_hrs_may_stub_records($player_ids_array,$season_id){

		$dbh = $GLOBALS['dbh'];

		foreach($player_ids_array as $key => $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_may_stub_records(?,?)');
		    $player_id = $key;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);

			$stmt->execute();
		}
	}





	function insert_hrs_june_stub_records($player_ids_array,$season_id){

		$dbh = $GLOBALS['dbh'];

		foreach($player_ids_array as $key => $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_june_stub_records(?,?)');
		    $player_id = $key;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);

			$stmt->execute();
		}
	}





	function insert_hrs_july_stub_records($player_ids_array,$season_id){

		$dbh = $GLOBALS['dbh'];

		foreach($player_ids_array as $key => $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_july_stub_records(?,?)');
		    $player_id = $key;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);

			$stmt->execute();
		}
	}





	function insert_hrs_august_stub_records($player_ids_array,$season_id){

		$dbh = $GLOBALS['dbh'];

		foreach($player_ids_array as $key => $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_august_stub_records(?,?)');
		    $player_id = $key;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);

			$stmt->execute();
		}
	}





	function insert_hrs_september_stub_records($player_ids_array,$season_id){

		$dbh = $GLOBALS['dbh'];

		foreach($player_ids_array as $key => $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_september_stub_records(?,?)');
		    $player_id = $key;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);

			$stmt->execute();
		}
	}





	function insert_hrs_october_stub_records($player_ids_array,$season_id){

		$dbh = $GLOBALS['dbh'];

		foreach($player_ids_array as $key => $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_october_stub_records(?,?)');
		    $player_id = $key;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);

			$stmt->execute();
		}
	}





	function insert_hrs_november_stub_records($player_ids_array,$season_id){

		$dbh = $GLOBALS['dbh'];

		foreach($player_ids_array as $key => $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_november_stub_records(?,?)');
		    $player_id = $key;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);

			$stmt->execute();
		}
	}
	/*
	function insert_monthly_hrs_stub_records($month,$player_id,$season_id){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		try{

			switch ($month) {
				case 'february':
					$stmt = $dbh->prepare('CALL insert_hrs_february_stub_records(?,?)');
					break;
				case 'march':
					$stmt = $dbh->prepare('CALL insert_hrs_march_stub_records(?,?)');
					break;
				case 'april':
					$stmt = $dbh->prepare('CALL insert_hrs_april_stub_records(?,?)');
					break;
				case 'may':
					$stmt = $dbh->prepare('CALL insert_hrs_may_stub_records(?,?)');
					break;
				case 'june':
					$stmt = $dbh->prepare('CALL insert_hrs_june_stub_records(?,?)');
					break;
				case 'july':
					$stmt = $dbh->prepare('CALL insert_hrs_july_stub_records(?,?)');
					break;
				case 'august':
					$stmt = $dbh->prepare('CALL insert_hrs_august_stub_records(?,?)');
					break;
				case 'september':
					$stmt = $dbh->prepare('CALL insert_hrs_september_stub_records(?,?)');
					break;
				case 'october':
					$stmt = $dbh->prepare('CALL insert_hrs_october_stub_records(?,?)');
					break;
				case 'november':
					$stmt = $dbh->prepare('CALL insert_hrs_november_stub_records(?,?)');
					break;
				}

			$stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);
			$stmt->execute();

			return 200;

		} catch (PDOException $e) {
			//echo 'Connection failed: ' . $e->getMessage();
			return 0;
		}

	}
	*/





	function get_registered_users(){

		$dbh = $GLOBALS['dbh'];

		$stmt = $dbh->prepare("SELECT * FROM registered_users WHERE status_id = 'A' ORDER BY last_name");
	    $stmt->execute();

		$reg_users_array = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$reg_users_array[] = ['reg_id' => $row['reg_id'], 'first_name' => $row['first_name'], 'last_name' => $row['last_name']];
		}

		return $reg_users_array;
	}





	function get_monthly_hrs_for_season($tablename,$season_id){

		$dbh = $GLOBALS['dbh'];

	    $stmt = $dbh->prepare("SELECT player_id FROM {$tablename} WHERE season_id = {$season_id}");
	    $stmt->execute();
	    $record_count = $stmt->rowCount();

	    if($record_count > 0){
			$hr_month_player_db_ids = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$hr_month_player_db_ids[] = $row['player_id'];
			}

			return $hr_month_player_db_ids;

		} else {
			return 0;
		}
	}





	function get_leagues(){

		$dbh = $GLOBALS['dbh'];

		$stmt = $dbh->prepare("SELECT league_id, league_name, league_desc, league_type_id, teams_allowed, date_created, date_updated, created_by, status_id FROM leagues WHERE status_id = 'A' ORDER BY league_name ASC");
	    $stmt->execute();

	    $leagues_array = array();
	    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$leagues_array[] = ['league_id' => $row['league_id'], 'league_name' => $row['league_name']];
		}		

	    return $leagues_array;
	}





	function leagues_select_menu(){

		$get_leagues = get_leagues();

	    $league_select = '<select name="league_id" id="league"><option value=""></option>';

	    for ($x = 0; $x < count($get_leagues); $x++) {

	        $league_id = $get_leagues[$x]['league_id'];
	        $league_name = $get_leagues[$x]['league_name'];

	        $league_select .= '<option value="';
	        $league_select .= $league_id;
	        $league_select .= '">';
	        $league_select .= $league_name;
	        $league_select .= '</option>';

	    }

	    $league_select .= '</select>';

	    return $league_select;
	}





	function get_teams_by_id($reg_id){

		$dbh = $GLOBALS['dbh'];

		$query = $dbh->prepare("SELECT * FROM teams WHERE reg_id=?");
		$query->bindParam(1, $reg_id, PDO::PARAM_INT);
		$query->execute();

		$teams_array = array();
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$teams_array[] = ['team_id' => $row['team_id'], 'team_name' => $row['team_name'], 'status_id' => $row['status_id'], 'date_created' => date_format_table($row['date_created']), 'date_updated' => date_format_table($row['date_updated'])];
		}

		return $teams_array;
	}





	function get_all_teams(){

		$dbh = $GLOBALS['dbh'];

		$query = $dbh->prepare("SELECT * FROM teams WHERE status_id = 'A'");
		$query->bindParam(1, $reg_id, PDO::PARAM_INT);
		$query->execute();

		$teams_array = array();
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$teams_array[] = ['team_id' => $row['team_id'], 'team_name' => $row['team_name']];
		}

		return $teams_array;
	}





	function get_leagues_by_id($league_id){

		$dbh = $GLOBALS['dbh'];

		//$query = $dbh->prepare("SELECT l.league_id, l.league_name, lt.status_id, t.role_id FROM leagues l INNER JOIN league_teams lt ON lt.league_id = l.league_id INNER JOIN teams t ON t.team_id - lt.team_id INNER JOIN registered_users r ON r.reg_id = t.reg_id WHERE r.reg_id = ?");
		$query = $dbh->prepare("SELECT l.league_id, l.league_name FROM leagues l WHERE l.league_id = ? AND l.status_id = 'A'");
		$query->bindParam(1, $league_id, PDO::PARAM_INT);
		$query->execute();

		$leagues_array = array();
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$leagues_array[] = ['league_id' => $row['league_id'], 'league_name' => $row['league_name']];
		}

		return $leagues_array;
	}





	function get_status_name($status_id){

		$dbh = $GLOBALS['dbh'];

		$query = $dbh->prepare("SELECT status_name FROM lkp_status WHERE status_id = ?");
		$query->bindParam(1, $status_id, PDO::PARAM_STR);
		$query->execute();

		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$status_name = $row['status_name'];
		}

		return $status_name;
	}





	function get_roles_name($role_id){

		$dbh = $GLOBALS['dbh'];

		$query = $dbh->prepare("SELECT role_name FROM lkp_roles WHERE role_id = ?");
		$query->bindParam(1, $role_id, PDO::PARAM_INT);
		$query->execute();

		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$role_name = $row['role_name'];
		}

		return $role_name;
	}





	function get_league_info($lid){

		$dbh = $GLOBALS['dbh'];

		$query = $dbh->prepare("SELECT league_name, league_desc, league_type_id, teams_allowed, date_created, date_updated, created_by, status_id FROM leagues WHERE league_id = ?");
		$query->bindParam(1, $lid, PDO::PARAM_INT);
		$query->execute();

		$league_info_array = array();
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$league_info_array[] = ['league_name' => $row['league_name'], 'league_desc' => $row['league_desc'], 'teams_allowed' => $row['teams_allowed'], 'date_created' => $row['date_created'], 'date_updated' => $row['date_updated'], 'created_by' => $row['created_by'], 'status_id' => $row['status_id']];
		}

		return $league_info_array;
	}





	function get_registered_user_name($reg_id){

		$dbh = $GLOBALS['dbh'];

		$query = $dbh->prepare("SELECT first_name, last_name FROM registered_users WHERE reg_id = ?");
		$query->bindParam(1, $reg_id, PDO::PARAM_INT);
		$query->execute();

		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$name = $row['first_name'] . ' ' . $row['last_name'];
		}

		return $name;
	}





	function date_format_table($date){

		return date('n/j/Y',strtotime($date));
	}





	function user_login($email_signin,$password_signin){

		    $dbh = $GLOBALS['dbh'];

		    // set error message variables
		    global $wrongPwdErr, $accountNotExistErr, $emailPwdErr, $verificationRequiredErr, $email_empty_err, $pass_empty_err;		    

		    // clean data 
		    $user_email = filter_var($email_signin, FILTER_SANITIZE_EMAIL);
		    //$pswd = mysqli_real_escape_string($connection, $password_signin);

		    // Query if email exists in db
		    $check_email_exists = get_reg_user_by_email($email_signin);

		    

		    if(!empty($email_signin) && !empty($password_signin)){

		    	
		        /*if(!preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,20}$/", $password_signin)) {
		            $wrongPwdErr = 'Password should be between 6 to 20 charcters long, contains atleast one special chacter, lowercase, uppercase and a digit.';
		            
		            $wrongPwdErr_array = array('msg_code' => 1, 'msg' => $wrongPwdErr);
		            echo json_encode($wrongPwdErr_array);

		        }*/
		        // Check if email exist
		        if($check_email_exists->rowCount() == 0) {
		            //$accountNotExistErr = 'User account does not exist.';
		            $accountNotExistErr = $check_email_exists;
		            
		            $accountNotExistErr_array = array('msg_code' => 2, 'msg' => $accountNotExistErr);
		            echo json_encode($accountNotExistErr_array);

		        } else {

		           // Fetch partial user data
		            while($row = $check_email_exists->fetch(PDO::FETCH_ASSOC)) {
		                $id              = $row['reg_id'];
		                $email           = $row['email'];
		                $pass_word       = $row['password'];
		                $reg_user_status = $row['status_id'];
		            }
		            $check_email_exists->closeCursor();		           
		            

		            // Verify password
		            $password = password_verify($password_signin, $pass_word);


		            // Allow only verified user
		            if($email_signin == $email && $password_signin == $password) {
		               
		               if($reg_user_status == 'A') {
		                    /*if($email_signin == $email && $password_signin == $password) {*/

		                        $update_token = update_reg_users_token($id);

		                        if($update_token < 1){

		                            $verificationRequiredErr = 'Your user account token was not updated. Please contact the site administrator to resolve this issue.';

		                            $verificationRequiredErr_array = array('msg_code' => 4, 'msg' => $verificationRequiredErr);
		                            echo json_encode($verificationRequiredErr_array);

		                        } else {

		                            $get_reg_user_by_id = get_reg_user_by_id($id);
		                                                    
		                            while($row2 = $get_reg_user_by_id->fetch(PDO::FETCH_ASSOC)) {
		                                //Check if logged in user is an administrator.  If so set a "Super User" session to 1
		                                if($row2['role_id'] == 4){
		                                    $_SESSION['super_user'] = 1;
		                                } else {
		                                    $_SESSION['super_user'] = 0;
		                                }
		                                $_SESSION['reg_id']            = $row2['reg_id'];
		                                $_SESSION['firstname']     = $row2['first_name'];
		                                $_SESSION['lastname']      = $row2['last_name'];
		                                $_SESSION['email']         = $row2['email'];
		                                $_SESSION['token']         = $row2['token'];
		                            }
		                        }

		                        $login_session_array = array('msg_code' => 0,'reg_id' => $_SESSION['reg_id'], 'super_user' => $_SESSION['super_user'], 'first_name' => $_SESSION['firstname'], 'last_name' => $_SESSION['lastname']);
		                        echo json_encode($login_session_array);

		                    /*} else {
		                        $emailPwdErr = 'Either email or password is incorrect.';

		                        $emailPwdErr_array = array('msg_code' => 3, 'msg' => $emailPwdErr);
		                        echo json_encode($emailPwdErr_array);

		                    }*/

		                } elseif ($reg_user_status == 'D') {
		                    $verificationRequiredErr = 'Your account is currently pending deletion.';

		                    $verificationRequiredErr_array = array('msg_code' => 4, 'msg' => $verificationRequiredErr);
		                    echo json_encode($verificationRequiredErr_array);

		                } elseif ($reg_user_status == 'S') {
		                    $verificationRequiredErr = 'Your account is currently suspended. Please contact your league commissioner to resolve this issue.';

		                    $verificationRequiredErr_array = array('msg_code' => 4, 'msg' => $verificationRequiredErr);
		                    echo json_encode($verificationRequiredErr_array);

		                } elseif ($reg_user_status == 'P') {
		                    $verificationRequiredErr = 'Your account is currently pending confirmation. Please check your email and click the link to confirm your email address.';

		                    $verificationRequiredErr_array = array('msg_code' => 4, 'msg' => $verificationRequiredErr);
		                    echo json_encode($verificationRequiredErr_array);

		                } elseif ($reg_user_status == 'I') {
		                    $verificationRequiredErr = 'Your account is currently inactive. Please contact your league commissioner to resolve this issue.';

		                    $verificationRequiredErr_array = array('msg_code' => 4, 'msg' => $verificationRequiredErr);
		                    echo json_encode($verificationRequiredErr_array);

		                }

		            } else {
		                $emailPwdErr = 'Password is incorrect.';

		                $emailPwdErr_array = array('msg_code' => 3, 'msg' => $emailPwdErr);
		                echo json_encode($emailPwdErr_array);

		            }

		        }

		    } else {
		        if(empty($email_signin)){
		            $email_empty_err = "Email not provided.";

		            $emailPwdErr_array = array('msg_code' => 5, 'msg' => $email_empty_err);
		            echo json_encode($emailPwdErr_array);

		        }
		        
		        if(empty($password_signin)){
		            $pass_empty_err = "Password not provided.";

		            $pass_empty_err_array = array('msg_code' => 6, 'msg' => $pass_empty_err);
		            echo json_encode($pass_empty_err_array);

		        }            
		    }			
	}





	function forgot_password($email){

		$to       = $email;
		$subject  = 'Testing forgot email';
		$message  = 'Hi, you just received an email using sendmail!';
		/*$headers  = 'From: jumpinjerryjehova@gmail.com' . "\r\n" .
		            'MIME-Version: 1.0' . "\r\n" .
		            'Content-type: text/html; charset=utf-8';*/
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: test@test.com' . "\r\n";

		$result = check_active_email($email);

		if (!$result) {
			$forgot_password_array = array('msg_code' => 0, 'msg' => 'The email you entered is not an active email in our system. Try a different email, or create an account.');
			return $forgot_password_array;
		} else {

			if(mail($to, $subject, $message, $headers)){
				$forgot_password_array = array('msg_code' => 1, 'msg' => 'Email was successfully sent. Please follow the instructions in the email to reset your password.');
				return $forgot_password_array;
			} else {
				$forgot_password_array = array('msg_code' => 2, 'msg' => 'Error occurred while trying to send the email. Contact us.');
				return $forgot_password_array;
			}
		}
	}





	function is_logged_in(){

		if(isset($_SESSION['reg_id']) && !empty($_SESSION['reg_id'])){
			return 1;
		} else {
			return 0;
		}
	}




	function is_super_user(){

		if(is_logged_in() && isset($_SESSION['super_user']) && $_SESSION['super_user'] == 1){
			return 1;
		} else {
			return 0;
		}
	}




	function user_log_out(){

		//session_start();

		// destroy all sessions
		session_destroy();	

		header("Location: ".$GLOBALS['base_url']);

	}





	function check_active_email($email){

		$dbh = $GLOBALS['dbh'];

		$email = $email;

        $query = $dbh->prepare("SELECT * FROM registered_users WHERE email=:email AND status_id = 'A'");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result;
	}





	function get_player_league_teams_by_id($league_id,$team_id,$season_id){

		$dbh = $GLOBALS['dbh'];

		$stmt = $dbh->prepare("SELECT ltp.player_id, p.FirstName, p.LastName FROM league_team_players ltp JOIN Players p ON p.PlayerID = ltp.player_id WHERE ltp.league_id = ? AND ltp.team_id = ? AND ltp.season_id = ?");
	    $stmt->bindParam(1, $league_id, PDO::PARAM_INT);
	    $stmt->bindParam(2, $team_id, PDO::PARAM_INT);
	    $stmt->bindParam(3, $season_id, PDO::PARAM_INT);

	    if ($stmt->execute()) {
	        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	        	$league_team_players[] =  ['player_id' => $row['player_id'], 'first_name' => $row['FirstName'], 'last_name' => $row['LastName']];
	        }

	        return $league_team_players;
	    }
	}





	function get_league_teams($league_id,$season_id){

		$dbh = $GLOBALS['dbh'];

		$league_teams = $dbh->prepare("SELECT lt.team_id, t.team_name FROM league_teams lt LEFT JOIN teams t ON t.team_id = lt.team_id WHERE lt.league_id=:leagueid AND lt.season_id=:seasonid AND lt.status_id = 'A' ORDER BY lt.sort ASC");
	    $league_teams->bindParam("leagueid", $league_id, PDO::PARAM_INT, 11);
	    $league_teams->bindParam("seasonid", $season_id, PDO::PARAM_INT, 11);
	    $league_teams->execute();	

	    return	$league_teams;
	}





	function get_league_team_players($league_id,$season_id,$team_id){

		$dbh = $GLOBALS['dbh'];

		$injury_query = $dbh->prepare('SELECT ltp.*,i.player_id, i.injury_desc, i.playing_probability, p.FirstName, p.LastName FROM league_team_players ltp JOIN injured_players i ON i.player_id = ltp.player_id LEFT JOIN players p ON p.PlayerID = i.player_id WHERE ltp.league_id=:leagueid AND ltp.season_id=:seasonid AND ltp.team_id=:teamid');           
        $injury_query->bindParam("leagueid", $league_id, PDO::PARAM_INT, 11);
        $injury_query->bindParam("seasonid", $season_id, PDO::PARAM_INT, 11);
        $injury_query->bindParam("teamid", $team_id, PDO::PARAM_INT, 11);
        $injury_query->execute();

        return $injury_query;
	}





	function get_champions($team_id,$league_id){

		$dbh = $GLOBALS['dbh'];

		$champ_query = $dbh->prepare('SELECT year FROM champions WHERE team_id=:teamid AND league_id=:leagueid');
        $champ_query->bindParam("teamid", $team_id, PDO::PARAM_INT, 11);
        $champ_query->bindParam("leagueid", $league_id, PDO::PARAM_INT, 11);
        $champ_query->execute();

        return $champ_query;
	}





	function get_last_updated_date($league_id,$season_id){

		$dbh = $GLOBALS['dbh'];

		$stmt = $dbh->prepare('CALL get_last_updated_date(:leagueid,:seasonid)');
	    $stmt->bindParam('leagueid', $league_id, PDO::PARAM_INT);
	    $stmt->bindParam('seasonid', $season_id, PDO::PARAM_INT);
	    $stmt->execute();
	    
	    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	    	$d=strtotime($row['last_date_updated']);
	      	
	      	$last_date =  date("m/d/Y g:i:s a", $d);
	      	//$last_date =  date("m/d/Y", $d);
	    }
	    
	    return $last_date;
	}





	function update_last_updated_date($league_id,$season_id,$date){

		$dbh = $GLOBALS['dbh'];

		$stmt = $dbh->prepare('CALL update_last_updated_date(:leagueid,:seasonid,:date)');
	    $stmt->bindParam('leagueid', $league_id, PDO::PARAM_INT);
	    $stmt->bindParam('seasonid', $season_id, PDO::PARAM_INT);
	    $stmt->bindParam('date', $date, PDO::PARAM_STR);
	    $stmt->execute();
	}





	function delete_injured_players(){
		
		$dbh = $GLOBALS['dbh'];

		$stmt = $dbh->prepare('CALL delete_injured_players');
		$stmt->execute();
	}





	function insert_injured_players($player_id,$injury_desc,$playing_probability){

		$dbh = $GLOBALS['dbh'];

		$stmt = $dbh->prepare('CALL insert_injured_players(:playerid,:injury_desc,:playing_probability)');
	    $stmt->bindParam('playerid', $player_id, PDO::PARAM_INT);
	    $stmt->bindParam('injury_desc', $injury_desc, PDO::PARAM_STR);
	    $stmt->bindParam('playing_probability', $playing_probability, PDO::PARAM_STR);
	    $stmt->execute();
	}





	function get_injured_players(){

		$dbh = $GLOBALS['dbh'];

		$stmt = $dbh->prepare('CALL get_injured_players');
		$stmt->execute();
		$no = $stmt->rowCount();

		if ($no > 0) {
	        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	        	$injured_players[] =  ['player_id' => $row['player_id'], 'injury_desc' => $row['injury_desc'], 'playing_probability' => $row['playing_probability']];
	        }

	        return $injured_players;
	    
	    } else {
	    	return $injured_players = array();
	    }
	}




	function update_reg_users_token($reg_id){

		$dbh = $GLOBALS['dbh'];

		$token = md5(rand().time());
            
        $update_token = $dbh->prepare("UPDATE registered_users SET token = :token WHERE reg_id = :reg_id");
        $update_token->bindParam('token', $token, PDO::PARAM_STR, 255);
        $update_token->bindParam('reg_id', $reg_id, PDO::PARAM_INT);
        $update_token->execute();
        $update_token_count = $update_token->rowCount();

        if($update_token_count == 1){

        	return 1;

        } else {

        	return 0;

        }

	}




	function get_reg_user_by_email($email){

		$dbh = $GLOBALS['dbh'];

		$reg_user_by_email = $dbh->prepare('CALL get_reg_user_by_email(:email)');
	    $reg_user_by_email->bindParam('email', $email, PDO::PARAM_STR, 150);
	    $reg_user_by_email->execute();	 

		return $reg_user_by_email;
	}




	function get_reg_user_by_id($id){

		$dbh = $GLOBALS['dbh'];

		$reg_user_by_id = $dbh->prepare("SELECT * From registered_users WHERE reg_id = :reg_id");
	    $reg_user_by_id->bindParam('reg_id', $id, PDO::PARAM_INT);
	    $reg_user_by_id->execute();
	    
        return $reg_user_by_id;
	}




	function get_registered_user_status($email_signin){

		$dbh = $GLOBALS['dbh'];

		$get_reg_user = $dbh->prepare("SELECT status_id From registered_users WHERE email = :email");
        $get_reg_user->bindParam('email', $email_signin, PDO::PARAM_STR, 150);
        $get_reg_user->execute();

        while($row = $get_reg_user->fetch(PDO::FETCH_ASSOC)) {
        	$status_id = $row['status_id'];
        }

        return $status_id;
	}




	



?>
