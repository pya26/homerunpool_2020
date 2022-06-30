<?php

try {
    include("_config/config.php");
    include("_config/db_connect.php");
    include("_includes/functions.php");
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();    

  }

//$date = date("Ymd",strtotime("-1 days"));
$date = "20220607";

$url = $GLOBALS['msf_api_v2_base_url'] . 'current_season.json?date=' . $date;

$season = mysportsfeeds_api_request($url);



$season_slug = $season->seasons[0]->slug;

$season_id = get_season_id($season_slug);

$url_hrs = $GLOBALS['msf_api_v2_base_url'] . $season_slug .'/date/' . $date . '/player_gamelogs.json'; //?player=Semien'

$mung = mysportsfeeds_api_request($url_hrs);

//check if more than 1 game was played this day


/*$hr_count = 0;
foreach($mung->gamelogs as $key => $val){
   $player_id = $val->player->id;
   $player_first_name = $val->player->firstName;
   $player_last_name = $val->player->lastName;
   $player_hrs = $val->stats->batting->homeruns;
	 
   $hr_count = $hr_count + $val->stats->batting->homeruns;
   
   print $player_id . ' -- ' . $player_first_name  . ' ' . $player_last_name  . '('.$player_hrs.')<br />';
}*/


$table_string = 'hrs_june';
$hr_totals_stored_proc = 'update_june_homerun_totals';
$msg = "June";
$year = substr($date, 0, 4);
$month = substr($date, 4, 2);
$day = substr($date, 6, 2);

$column_name = "day" . ltrim($day, '0');


//echo "<br>find arrays with duplicate value for 'name'<br>";
foreach ($mung->gamelogs as $current_key => $current_array) {
  /*echo "current key: " . $current_array->player->id  . "  " . $current_array->player->firstName   . "  " . $current_array->player->lastName . "  " . $current_array->stats->batting->homeruns;
   echo "<br>";*/

   $playerid = $current_array->player->id;
   $homeruns = $current_array->stats->batting->homeruns;



   $stmt = $dbh->prepare("UPDATE " . $table_string . " SET " . $column_name  . " = " .$homeruns ." WHERE player_id = ". $playerid ." AND season_id = " . $season_id . "");
            $stmt->execute();

            unset($stmt);


            $sp_statement = "CALL ". $hr_totals_stored_proc . "(?,?)";

            $stmt = $dbh->prepare($sp_statement);
            $stmt->bindParam(1, $playerid, PDO::PARAM_INT, 11);
            $stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);
            $stmt->execute();

            unset($stmt);
   
   


  foreach ($mung->gamelogs as $search_key => $search_array) {
      if ($search_array->player->id == $current_array->player->id) {

          if ($search_key != $current_key) {

            $total_hr = $current_array->stats->batting->homeruns + $search_array->stats->batting->homeruns;

            echo "duplicate found: " . $search_key ."  " . $current_array->player->id  . "  " . $current_array->player->firstName   . "  " . $current_array->player->lastName . $current_array->stats->batting->homeruns . "(" . $total_hr . ")<br>";
            /* UPDATE QUERY */


            $stmt = $dbh->prepare("UPDATE " . $table_string . " SET " . $column_name  . " = " .$total_hr ." WHERE player_id = ". $playerid ." AND season_id = " . $season_id . "");
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
  }
  
}




/*print $hr_count;*/

/*print "<pre>";
print_r($mung->gamelogs);
print "</pre>";
exit();*/



























?>

