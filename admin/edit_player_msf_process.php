<?php

	include("../_config/config.php");
	include("../_config/db_connect.php");
	include("../_includes/functions.php");

	$errors = [];
	$data = [];

	// set file name of api
  	$api_file = 'players.json';

  	if(isset($_GET["player_id"]) && isset($_GET["league_id"]) && isset($_GET["season_id"])){
  		$player_id = $_GET["player_id"];
  		$league_id = $_GET["league_id"];
		$season_id = $_GET["season_id"];
  	} else {
  		exit();
  	}

  	
	

  	


  	$url_params = '?player=' . $player_id;

  	// set full url to be passed to the curl_request function 
    $url = $GLOBALS['msf_api_v2_base_url'] . $api_file . $url_params;


	$get_players = mysportsfeeds_api_request($url);




	foreach($get_players->players as $key => $value) {

		$player_id = $value->player->id;
		$first_name = replace_diacritic($value->player->firstName);
		$last_name = replace_diacritic($value->player->lastName);
		
		if(isset($value->player->primaryPosition)){
			$position = $value->player->primaryPosition;
		} else {
			$position = '';
		}
		
		if(isset($value->player->jerseyNumber)){
			$jersey_num = $value->player->jerseyNumber;
		} else {
			$jersey_num = '';
		}

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

		if(isset($value->player->height)){
			$height = $value->player->height;
		} else {
			$height = '';
		}

		if(isset($value->player->weight)){
			$weight = $value->player->weight;
		} else {
			$weight = '';
		}

		if(isset($value->player->birthDate)){
			$dob = $value->player->birthDate;
		} else {
			$dob = NULL;
		}

		if(isset($value->player->age)){
			$age = $value->player->age;
		} else {
			$age = '';
		}

		if(isset($value->player->birthCity)){
			$birth_city = $value->player->birthCity;
		} else {
			$birth_city = '';
		}

		if(isset($value->player->birthCountry)){
			$birth_country = $value->player->birthCountry;
		} else {
			$birth_country = '';
		}
		
		if(isset($value->player->highSchool)){
			$high_school = $value->player->highSchool;
		} else {
			$high_school = '';
		}

		if(isset($value->player->college)){
			$college = $value->player->college;
		} else {
			$college = '';
		}

		if(isset($value->player->handedness->bats)){
			$bats = $value->player->handedness->bats;
		} else {
			$bats = '';
		}

		if(isset($value->player->handedness->throws)){
			$throw_hand = $value->player->handedness->throws;
		} else {
			$throw_hand = '';
		}

		if(isset($value->player->officialImageSrc)){
			$mlb_image = $value->player->officialImageSrc;
		} else {
			$mlb_image = '';
		}

		foreach($value->player->externalMappings as $key2 => $value2){		
			
			if($value2->source == 'MLB.com'){			
				$mlb_id = $value2->id;
			}
			
		}

		$status = 'A';


		/*print $player_id . "<br />";
		print $first_name . "<br />";
		print $last_name . "<br />";
		print $position . "<br />";
		print $jersey_num . "<br />";
		print $team_id . "<br />";
		print $team_abbr . "<br />";
		print $height . "<br />";
		print $weight . "<br />";
		print $dob . "<br />";
		print $age . "<br />";
		print $birth_city . "<br />";
		print $birth_country . "<br />";
		print $high_school . "<br />";
		print $college . "<br />";
		print $bats . "<br />";
		print $throw_hand . "<br />";
		print $mlb_image . "<br />";
		print $mlb_id . "<br />";
		print $status . "<br />";*/

	}


	if (!empty($errors)) {
	    $data['success'] = false;
	    $data['errors'] = $errors;
	} else {
	    $data['success'] = true;
	    $data['message'] = 'Success!';
	}

	
	$stmt = $dbh->prepare("UPDATE players SET FirstName=:first_name, LastName=:last_name, PrimaryPosition=:position, JerseyNumber=:jersey_num, TeamID=:team_id, TeamAbbr=:team_abbr, Height=:height, Weight=:weight, DOB=:dob,Age=:age, BirthCity=:birth_city, BirthCountry=:birth_country, HighSchool=:high_school, College=:college, Bats=:bats, Throws=:throws, MLBImage=:mlb_image, MLBID=:mlbid, status_id=:status	WHERE PlayerID = :player_id");
	$stmt->bindParam('player_id', $player_id, PDO::PARAM_INT);
	$stmt->bindParam('first_name', $first_name, PDO::PARAM_STR, 30);
	$stmt->bindParam('last_name', $last_name, PDO::PARAM_STR, 50);
	$stmt->bindParam('position', $position, PDO::PARAM_STR, 3);
	$stmt->bindParam('jersey_num', $jersey_num, PDO::PARAM_INT);
	$stmt->bindParam('team_id', $team_id, PDO::PARAM_INT);
	$stmt->bindParam('team_abbr', $team_abbr, PDO::PARAM_STR, 5);
	$stmt->bindParam('height', $height, PDO::PARAM_STR, 5);
	$stmt->bindParam('weight', $weight, PDO::PARAM_STR, 8);
	$stmt->bindParam('dob', $dob, PDO::PARAM_STR, 10);
	$stmt->bindParam('age', $age, PDO::PARAM_INT);
	$stmt->bindParam('birth_city', $birth_city, PDO::PARAM_STR,75);
	$stmt->bindParam('birth_country', $birth_country, PDO::PARAM_STR,75);
	$stmt->bindParam('high_school', $high_school, PDO::PARAM_STR,100);
	$stmt->bindParam('college', $college, PDO::PARAM_STR,150);
	$stmt->bindParam('bats', $bats, PDO::PARAM_STR,1);
	$stmt->bindParam('throws', $throw_hand, PDO::PARAM_STR,1);
	$stmt->bindParam('mlb_image', $mlb_image, PDO::PARAM_STR,100);
	$stmt->bindParam('mlbid', $mlb_id, PDO::PARAM_INT);
	$stmt->bindParam('status', $status, PDO::PARAM_STR,1);
	$stmt->execute();
	


	//echo json_encode($data);

	header("Location: set_teams_players.php?league_id=".$league_id."&season_id=".$season_id."&class=0");
	
	exit();


	