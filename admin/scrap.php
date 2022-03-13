<?php
include("../_config/config.php");
include("../_config/db_connect.php");
include("../_includes/functions.php");


$url = "https://api.mysportsfeeds.com/v2.1/pull/mlb/players.json?";//?player=10224
$get_players = mysportsfeeds_api_request($url);

print "<pre>";
print_r($get_players);
print "</pre>";

foreach($get_players->players as $key => $value) {

	$count = $count +1;

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
		$dob = '';
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
		$throws = $value->player->handedness->throws;
	} else {
		$throws = '';
	}

	if(isset($value->player->officialImageSrc)){
		$mlb_image = $value->player->officialImageSrc;
	} else {
		$mlb_image = '';
	}

	foreach($value->player->externalMappings as $key2 => $value2){		
		
		if($value2->source == 'MLB.com'){			
			$mlbid = $value2->id;
		}
		
	}

	$status = 'A';


	/*$player_info = $player_id;
	$player_info .= '<br />'.$first_name;
	$player_info .= '<br />'.$last_name;
	$player_info .= '<br />'.$position;
	$player_info .= '<br />'.$jersey_num;
	$player_info .= '<br />'.$team_id;
	$player_info .= '<br />'.$team_abbr;
	$player_info .= '<br />'.$height;
	$player_info .= '<br />'.$weight;
	$player_info .= '<br />'.$dob;
	$player_info .= '<br />'.$age;
	$player_info .= '<br />'.$birth_city;
	$player_info .= '<br />'.$birth_country;
	$player_info .= '<br />'.$high_school;
	$player_info .= '<br />'.$college;
	$player_info .= '<br />'.$bats;
	$player_info .= '<br />'.$throws;
	$player_info .= '<br />'.$mlb_image;
	$player_info .= '<br />'.$mlbid;



	print $player_info . "<br /><br /><br />";*/


	//$stmt = $dbh->prepare("INSERT INTO players (PlayerID,FirstName,LastName,PrimaryPosition,JerseyNumber,TeamID,TeamAbbr,Height,Weight,DOB,Age,BirthCity,BirthCountry,HighSchool,College,Bats,Throws,MLBImage,MLBID,status_id) VALUES (:player_id,:first_name,:last_name,:position,:jersey_num,:team_id,:team_abbr,:height,:weight,:dob,:age,:birth_city,:birth_country,:high_school,:college,:bats,:throws,:mlb_image,:mlbid,:status)");
	/*$stmt = $dbh->prepare("UPDATE players SET FirstName=:first_name, LastName=:last_name, PrimaryPosition=:position, JerseyNumber=:jersey_num, TeamID=:team_id, TeamAbbr=:team_abbr, Height=:height, Weight=:weight, DOB=:dob,Age=:age, BirthCity=:birth_city, BirthCountry=:birth_country, HighSchool=:high_school, College=:college, Bats=:bats, Throws=:throws, MLBImage=:mlb_image, MLBID=:mlbid, status_id=:status	WHERE PlayerID = :player_id");*/
	/*$stmt->bindParam('player_id', $player_id, PDO::PARAM_INT);
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
	$stmt->bindParam('throws', $throws, PDO::PARAM_STR,1);
	$stmt->bindParam('mlb_image', $mlb_image, PDO::PARAM_STR,100);
	$stmt->bindParam('mlbid', $mlbid, PDO::PARAM_INT);
	$stmt->bindParam('status', $status, PDO::PARAM_STR,1);

	$stmt->execute();*/

	
}











?>