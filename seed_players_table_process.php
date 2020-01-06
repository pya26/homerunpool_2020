<?php

  // include functions, configurations, and database configurations file
  include("_includes/functions.php");
  $configs = include("_config/config.php");
  include("_config/db_connect.php"); 

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

  // Call function to return all players in database
  $player_db_ids = get_all_players();
  // count all player records return from get_all_players() for use later in the if statements
  $db_count = count($player_db_ids);

  
  // set the URL parameters sent in the query string of the ajax call, and build the query string that will appended to the URL to pass into curl_request function
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

  // set full url to be passed to the curl_request function 
  $url = $configs['msf_api_v2_base_url'] . $api_file . $url_params;

  // call the API function to request all players info that was selected (season,statuses, positions)  and set variable for the response. I named the response variable
  // $player_info_response even though it will return all player info, but I'm only using it to build an array of the ID's to pass into another API call
  $player_info_response = mysportsfeeds_api_request($url);

  // create an array of only the player id's from the players api response
  $player_api_ids = array();
  $count2 = 0;
  foreach($player_info_response->players as $key => $value) {
  	$player_api_ids[] = $value->player->id;
    $count2 ++;
  }



  // compare player id array from the players API to the player id array from the DB
  $compare_all_api_db_players = array_diff($player_api_ids, $player_db_ids);

 
  /**
  * If there are records in the players DB table, AND there are players that exist in the players API that are not in the players DB table, 
  * then insert the new records into the players table. This will seed the initial monthly homeruns tables with Player IDs and selected season ID's
  */
  if($db_count > 0 && !empty($compare_all_api_db_players)){

    // create a comma delimited list of player id's from the $compare_all_api_db_players array
    $list = implode(',', $compare_all_api_db_players);

    $remaining_elements_to_process = 0;
    //print 'Characters in String - ' . strlen($list) . '<br />';
    //print 'Elements in array - ' . count($compare_all_api_db_players) . '<br />';
    if(strlen($list > 1500)){
      //print count($compare_all_api_db_players) . '<br />';
      $avg_chars_in_each_element = strlen($list) / count($compare_all_api_db_players);
      $round_avg_chars_in_each_element = round($avg_chars_in_each_element);
      //print 'Rounded average number of characters in each element - ' . $round_avg_chars_in_each_element  . '<br />';

      $max_items_to_process = 1500 / $round_avg_chars_in_each_element;
      //print $max_items_to_process  . '<br />';
     /* print '<pre>';
      print_r(array_slice($compare_all_api_db_players, 0, $max_items_to_process));
      print '</pre>';*/
      $list = implode(',', array_slice($compare_all_api_db_players, 0, $max_items_to_process));
      //print $subset_list;
      /*print '<br />';
      print '<pre>';
      print_r(array_slice($compare_all_api_db_players, 0, 1500));
      print '</pre>';*/
      //print 'Players left to process - ' . count($compare_all_api_db_players) . '<br />';
      if(count($compare_all_api_db_players) > $max_items_to_process){
        $remaining_elements_to_process = count($compare_all_api_db_players) - $max_items_to_process;
        //print $remaining_elements_to_process;
        //$remaining_elements_to_process_msg .= 'There are ' . $remaining_elements_to_process . ' players left to process.  Please run this script again.';
        $remaining_elements_to_process = $remaining_elements_to_process;
      }
    }
   

    // build url to pass to the api by passing a list of the player ID's to retun each player's information
    $url = $configs['msf_api_v2_base_url'] . $api_file . '?player=' . $list;


   
    // call players API
    $player_info_response_compared = mysportsfeeds_api_request($url);

    insert_players($player_info_response_compared);

    $msg = 'We inserted missing record(s).  The database had records, but was missing 1 or more from the requested API.';
    if($remaining_elements_to_process > 0){
      $msg .= 'There are <strong>' . $remaining_elements_to_process . '</strong> remaining players to insert. Please click the button to run the same script again until all player records have been added.';
    }

    echo json_encode($msg);



  } elseif ($db_count > 0 && empty($compare_all_api_db_players)) {   

    echo json_encode("We didn't have to update anything. The database has records, but nothing to update from the requested API.");



  } elseif($db_count == 0 && !empty($compare_all_api_db_players)){
    // INSERT EVERYTHING FROM API

    $player_info_response = mysportsfeeds_api_request($url);

    insert_players($player_info_response); 

    echo json_encode("There were no existing records in the database. So, we inserted everything from the requested API.");



  } else {

    echo json_encode("nothing was in db and nothing was in api, so do nothing");



  }




  
?>



