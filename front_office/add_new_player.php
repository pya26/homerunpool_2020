<?php

  // include functions, configurations, and database configurations file
  
  include("../_config/config.php");
  include("../_config/db_connect.php"); 
  include("../_includes/functions.php");

    if(!is_super_user()){
        print "Only the Super User is allowed back here!";
        exit();
    }

  // set file name of api
  $api_file = 'players.json?player=Kazuma-Okamoto'; 

  // set full url to be passed to the curl_request function 
  $url = $GLOBALS['msf_api_v2_base_url'] . $api_file;

  $player_info_response = mysportsfeeds_api_request($url);

  //$mung = insert_players($player_info_response);

  /*print "<pre>";
  print_r($mung);
  print "</pre>";*/

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