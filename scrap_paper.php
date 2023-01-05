<?php

try {
    include("_config/config.php");
    include("_config/db_connect.php");
    include("_includes/functions.php");
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();    

  }

//$date = date("Ymd",strtotime("-1 days"));
$date = "20220820";

$url = $GLOBALS['msf_api_v2_base_url'] . 'current_season.json?date=' . $date;

$season = mysportsfeeds_api_request($url);



$season_slug = $season->seasons[0]->slug;

$season_id = get_season_id($season_slug);

$url_hrs = $GLOBALS['msf_api_v2_base_url'] . $season_slug .'/date/' . $date . '/player_gamelogs.json'; //?player=Semien'

$hr_response = mysportsfeeds_api_request($url_hrs);

//check if more than 1 game was played this day



foreach($hr_response->gamelogs as $key => $val){
   $player_id = $val->player->id;
   $player_first_name = $val->player->firstName;
   $player_last_name = $val->player->lastName;
   $player_hrs = $val->stats->batting->homeruns;
	 
   //$hr_count = $hr_count + $val->stats->batting->homeruns;
   
   
   if($player_hrs > 0){   
   $homerun_array[] = ['player_id' => $player_id, 'firstName' => $player_first_name, 'lastName' => $player_last_name, 'homeruns' => $player_hrs]; 
   }
}


var_dump($homerun_array);

exit();


$sumArray2 = [];

foreach ($homerun_array as $agentInfo) {

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


print "<pre>";
print_r($gamelog_hr_array);
print "</pre>";
exit();





$table_string = 'hrs_july';
$hr_totals_stored_proc = 'update_july_homerun_totals';
$msg = "June";
$year = substr($date, 0, 4);
$month = substr($date, 4, 2);
$day = substr($date, 6, 2);

$column_name = "day" . ltrim($day, '0');


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

            //$total_hr = $current_array->stats->batting->homeruns + $search_array->stats->batting->homeruns;
            $dh_hrs = $current_array->stats->batting->homeruns + $search_array->stats->batting->homeruns;

            /*echo "duplicate found: " . $search_key ."  " . $current_array->player->id  . "  " . $current_array->player->firstName   . "  " . $current_array->player->lastName . $current_array->stats->batting->homeruns . "(" . $total_hr . ")<br>";*/

            if($dh_hrs > 0){
            $dh_hrs_array[] = ['player_id' => $current_array->player->id, 'firstName' => $current_array->player->firstName, 'lastName' => $current_array->player->lastName, 'homeruns' => $dh_hrs];
            }
            /* UPDATE QUERY */


            /*$stmt = $dbh->prepare("UPDATE " . $table_string . " SET " . $column_name  . " = " .$total_hr ." WHERE player_id = ". $playerid ." AND season_id = " . $season_id . "");
            $stmt->execute();

            unset($stmt);


            $sp_statement = "CALL ". $hr_totals_stored_proc . "(?,?)";

            $stmt = $dbh->prepare($sp_statement);
            $stmt->bindParam(1, $playerid, PDO::PARAM_INT, 11);
            $stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);
            $stmt->execute();

            unset($stmt);*/


          } 
      }
  }
  
}


$gamelog_hr_array = array_merge($single_game_hrs_array, $dh_hrs_array);

?>




<table>
  <tr style="vertical-align: top;">
    <td>
      <?php       
        print "Original HR Count "; print_r(count($homerun_array));       
      ?>
    </td>
    <td>
      <?php       
        print_r(count($single_game_hrs_array));       
      ?>
    </td>
    <td>
      <?php       
        print_r(count($dh_hrs_array));       
      ?>
    </td>
    <td>
      <?php       
        print_r(count($gamelog_hr_array));       
      ?>
    </td>
  </tr>
  <tr style="vertical-align: top;">
    <td>
      <?php
        print "<pre>";
        print_r($homerun_array);
        print "<pre>";
      ?>
    </td>

    <td>
      <?php
        print "<pre>";
        print_r($single_game_hrs_array);
        print "<pre>";
      ?>
    </td>

    <td>
      <?php
        print "<pre>";
        print_r($dh_hrs_array);
        print "<pre>";
      ?>
    </td>

    <td>
      <?php
        print "<pre>";
        print_r($gamelog_hr_array);
        print "<pre>";
      ?>
    </td>
  </tr>
</table>


