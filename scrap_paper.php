<?php

	//try {
		$configs = include("_config/config.php");
    	include("_config/db_connect.php");
		include("_includes/functions.php");
	/*} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
		die();
	}*/

	print "<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />";

	/*print "<strong>Current Season</strong><br />";
	print current_season() . "<br /><br />";

	print "<strong>List Season</strong><br />";
	print_r(season_select_menu());
	print "<br /><br />";*/


// set URL parameter variables
  if(isset($_GET['season'])){
    $season = $_GET['season'];
    $season_id = get_season_id($season);
  } else {
    $season_id = 0;
  }
  if(isset($_GET['rosterstatus'])){
    $rosterstatus = $_GET['rosterstatus'];
  }
  if(isset($_GET['position'])){
    $position = $_GET['position'];
  }

  // set file name of api
  $api_file = 'players.json';



 $url_params = '?';
  if(isset($season)){
    $url_params .= 'season=' . $season . '&';
  } else {
    $url_params .= 'season=' . current_season() . '&';
  }

  if(isset($rosterstatus)){
    $url_params .= 'rosterstatus=' . $rosterstatus . '&';
  }
  if(isset($position)){
    $url_params .= 'position=' . $position;
  }

  // set URL parameter variables
  if(isset($_GET['season'])){
    $season = $_GET['season'];
    $season_id = get_season_id($season);
  } else {
    $season_id = 0;
  }
  if(isset($_GET['rosterstatus'])){
    $rosterstatus = $_GET['rosterstatus'];
  }
  if(isset($_GET['position'])){
    $position = $_GET['position'];
  }

$url = $configs['msf_api_v2_base_url'] . $api_file . $url_params;

print $url . '<br />';

// call the API function to request all players info that was selected (season,statuses, positions)  and set variable for the response. I named the response variable
// $player_id_response even though it will return all player info, but I'm only using it to build an array of the ID's to pass into another API call
$player_id_response = mysportsfeeds_api_request($url);

// create an array of only the player id's from the players api response
$player_api_ids = array();
$count2 = 0;
foreach($player_id_response->players as $key => $value) {
	$player_api_ids[] = $value->player->id;
$count2 ++;
}
	
$hrs_feb_records = get_monthly_hrs_for_season('hrs_february',$season_id);
//$compare_feb = array_diff($player_api_ids, $hrs_feb_records);

print count($player_api_ids);

  



?>
