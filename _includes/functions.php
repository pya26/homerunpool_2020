<?php


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

		try {
			$configs = include("_config/config.php");
    		include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			die();
		}

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

		try {
			$configs = include("_config/config.php");
    		include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			die();
		}

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

		try {
			$configs = include("_config/config.php");
    		include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}		
		
		$stmt = $dbh->prepare('CALL sp_get_api_url(?)');
		$stmt->bindParam(1, $api_id, PDO::PARAM_INT, 11);
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

		try {
			$configs = include("_config/config.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			die();
		}
		
		$ch = curl_init();	
		curl_setopt($ch, CURLOPT_URL, $url);	
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	
		curl_setopt($ch, CURLOPT_ENCODING, "gzip");
		$headers = array(
		    'Content-type: application/json; charset=UTF-8',
		    "Authorization: Basic " . base64_encode($configs['msf_apikey_token'] . ":" . $configs['msf_password']),
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

		if(isset($current_season->seasons[0]->slug)){
			$season = $current_season->seasons[0]->slug;
		} else {
			$season = 'Season not defined';
		}

		return $season;
	}




	function get_all_players(){

		try {
			$configs = include("_config/config.php");
    		include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		$stmt = $dbh->prepare("CALL sp_get_all_players");
		$stmt->execute();
		$player_db_ids = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$player_db_ids[] = $row['PlayerID'];
		}

		return $player_db_ids;

	}




	function get_all_roster_statuses(){

		try {
			$configs = include("_config/config.php");
    		include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}		
		
		$stmt = $dbh->prepare("CALL sp_get_all_roster_statuses");
		$stmt->execute();

		$status_array = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {		 
		  $status_array[$row['roster_status_id']] = $row['roster_status_name'];
		  //$status_array[$row['roster_status_desc']] = $row['roster_status_desc'];*/
		}

	    return $status_array;
	}




	function get_all_hitter_positions(){

		try {
			$configs = include("_config/config.php");
    		include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}		
		
		$stmt = $dbh->prepare('CALL sp_get_all_hitter_positions');
		$stmt->execute();

		$position_array = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	      $position_array[$row['position_id']] = $row['position_name'];
	    }

	    return $position_array;

	}




	function get_season_id($season){

		try {
			$configs = include("_config/config.php");
    		include("_config/db_connect.php");
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




	function insert_players($player_info_response){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

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

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		foreach($player_ids_array as $value) {
			
    		$stmt = $dbh->prepare('CALL insert_hrs_february_stub_records(?,?)');
		    $player_id = $value;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);	

			$stmt->execute();			
		}			
	}

		
	


	function insert_hrs_march_stub_records($player_ids_array,$season_id){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		foreach($player_ids_array as $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_march_stub_records(?,?)');
		    $player_id = $value;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);	

			$stmt->execute();					
		}
	}


	function insert_hrs_april_stub_records($player_ids_array,$season_id){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		foreach($player_ids_array as $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_april_stub_records(?,?)');
		    $player_id = $value;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);	

			$stmt->execute();					
		}
	}


	function insert_hrs_may_stub_records($player_ids_array,$season_id){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		foreach($player_ids_array as $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_may_stub_records(?,?)');
		    $player_id = $value;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);	

			$stmt->execute();					
		}
	}


	function insert_hrs_june_stub_records($player_ids_array,$season_id){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		foreach($player_ids_array as $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_june_stub_records(?,?)');
		    $player_id = $value;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);	

			$stmt->execute();					
		}
	}


	function insert_hrs_july_stub_records($player_ids_array,$season_id){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		foreach($player_ids_array as $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_july_stub_records(?,?)');
		    $player_id = $value;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);	

			$stmt->execute();					
		}
	}


	function insert_hrs_august_stub_records($player_ids_array,$season_id){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		foreach($player_ids_array as $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_august_stub_records(?,?)');
		    $player_id = $value;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);	

			$stmt->execute();					
		}
	}


	function insert_hrs_september_stub_records($player_ids_array,$season_id){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		foreach($player_ids_array as $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_september_stub_records(?,?)');
		    $player_id = $value;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);	

			$stmt->execute();					
		}
	}


	function insert_hrs_october_stub_records($player_ids_array,$season_id){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		foreach($player_ids_array as $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_october_stub_records(?,?)');
		    $player_id = $value;

		    $stmt->bindParam(1, $player_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);	

			$stmt->execute();					
		}
	}


	function insert_hrs_november_stub_records($player_ids_array,$season_id){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		foreach($player_ids_array as $value) {
    		$stmt = $dbh->prepare('CALL insert_hrs_november_stub_records(?,?)');
		    $player_id = $value;

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


	function get_monthly_hrs_for_season($tablename,$season_id){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
		
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

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		$stmt = $dbh->prepare("SELECT league_id, league_name, league_desc, league_type_id, teams_allowed, date_created, date_updated, created_by, status_id FROM leagues WHERE status_id = 'A' ORDER BY league_name ASC");
	    $stmt->execute();
	    //$result = $stmt->fetch(PDO::FETCH_ASSOC);

	    $leagues_array = array();
	    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$leagues_array[] = ['league_id' => $row['league_id'], 'league_name' => $row['league_name']];
		}
		//, 'league_desc' => $row['league_desc'], 'league_type_id' => $row['league_type_id'], 'teams_allowed' => $row['teams_allowed'], 'commissioner' => $row['commissioner'], 'date_created' => $row['date_created'], 'date_updated' => $row['date_updated'], 'created_by' => $row['created_by'], 'status_id' => $row['status_id']]

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

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		$query = $dbh->prepare("SELECT * FROM teams WHERE reg_id=?");
		$query->bindParam(1, $reg_id, PDO::PARAM_INT);
		$query->execute();

		$teams_array = array();
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {		
			$teams_array[] = ['team_id' => $row['team_id'], 'team_name' => $row['team_name'], 'status_id' => $row['status_id'], 'date_created' => date_format_table($row['date_created']), 'date_updated' => date_format_table($row['date_updated'])];
		}

		return $teams_array;
	}


	function get_leagues_by_id($reg_id){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		$query = $dbh->prepare("SELECT l.league_id, l.league_name, lt.status_id, t.role_id FROM leagues l INNER JOIN league_teams lt ON lt.league_id = l.league_id INNER JOIN teams t ON t.team_id - lt.team_id INNER JOIN registered_users r ON r.reg_id = t.reg_id WHERE r.reg_id = ?");
		$query->bindParam(1, $reg_id, PDO::PARAM_INT);
		$query->execute();

		$leagues_array = array();
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {		
			$leagues_array[] = ['league_id' => $row['league_id'], 'league_name' => $row['league_name'], 'status_id' => $row['status_id'], 'role_id' => $row['role_id']];
		}

		return $leagues_array;		
	}


	function get_status_name($status_id){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		$query = $dbh->prepare("SELECT status_name FROM lkp_status WHERE status_id = ?");
		$query->bindParam(1, $status_id, PDO::PARAM_STR);
		$query->execute();

		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$status_name = $row['status_name'];
		}

		return $status_name;
	}


	function get_roles_name($role_id){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		$query = $dbh->prepare("SELECT role_name FROM lkp_roles WHERE role_id = ?");
		$query->bindParam(1, $role_id, PDO::PARAM_INT);
		$query->execute();

		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$role_name = $row['role_name'];
		}

		return $role_name;
	}


	function get_league_info($lid){

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

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

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

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




	function user_login($email,$pwd){

		session_start();

		try {
			$configs = include("_config/config.php");
			include("_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		$email = $email;
        $password = $pwd;

        $query = $dbh->prepare("SELECT * FROM registered_users WHERE email=:email AND status_id = 'A'");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

		//$user_login_array = array('userid_login' => $email, 'user_password' => $pwd);

		if (!$result) {

            //echo '<p class="error">Username password combination is wrong!</p>';

        } else {

            if (password_verify($password, $result['password'])) {
                
                
                //Check if logged in user is an administrator.  If so set a "Super User" session to 1
                if($result['role_id'] == 4){
                    $_SESSION['super_user'] = 1;
                } else {
                    $_SESSION['super_user'] = 0;
                }

                $_SESSION['reg_id'] = $result['reg_id'];
                $reg_id = $_SESSION['reg_id'];
                $_SESSION['first_name'] = $result['first_name'];
                $_SESSION['last_name'] = $result['last_name'];
                //echo '<p class="success">Congratulations, you are logged in!</p>';        

                $query = $dbh->prepare("SELECT * FROM teams WHERE reg_id=:regid AND status_id = 'A'");
                $query->bindParam("regid", $reg_id, PDO::PARAM_STR);
                $query->execute();

                /*if ($query->rowCount() > 1) {

                    if($_POST['redirect'] == ''){
                        header("Location: front_office.php");
                    } else {
                        header("Location: " . $_POST['redirect']);
                    }

                    

                } else {
                  
                    header("Location: leader_board.php");

                }*/

                $login_session_array = array('reg_id' => $_SESSION['reg_id'], 'super_user' => $_SESSION['super_user'], 'first_name' => $_SESSION['first_name'], 'last_name' => $_SESSION['last_name']);
            	return $login_session_array;

            } else {
                //echo '<p class="error">Username password combination is wrong!</p>';
            }

            
        }

		return $user_login_array;

	}




	function is_logged_in(){

		if(isset($_SESSION['reg_id']) && !empty($_SESSION['reg_id'])){
			return 1;
		} else {
			return 0;
		}

	}



?>