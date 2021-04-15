<?php

  try {
    include("../_config/config.php"); 
    include("../_includes/header.php");
    include("../_config/db_connect.php");
    include("../_includes/functions.php");    
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
  }

    if(!is_super_user()){
        print "Only the Super User is allowed back here!";
        exit();
    }

  print "<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />";

  $seed_players_form = '<form id="seed_players_form">';

  $seed_players_form .= '<label for="select_season">Select a Season</label> ';
  $seed_players_form .= season_select_menu() . '<br /><br />';

  $seed_players_form .= 'Select player roster statuses to be included when seeding the players table:'; 
  $status_array = get_all_roster_statuses();
  $seed_players_form .= '<label for="roster_status[]" class="error"></label><br />';
  $seed_players_form .= '<input type="checkbox" id="check_all_roster_status"> Check all<br />';
  foreach($status_array as $roster_status_name ){
    $seed_players_form .= '<input type="checkbox" class="rosterStatusCheckBoxClass" id="roster_status" name="roster_status" value="'.$roster_status_name['roster_status_name'].'"> '.$roster_status_name['roster_status_name'] . " (" . $roster_status_name['roster_status_desc'].")<br />";
  }

  $seed_players_form .= '<br />Select which player positions should be seeded into the database:';
  $position_array = get_all_hitter_positions();
  $seed_players_form .= '<label for="position[]" class="error"></label><br />';
  $seed_players_form .= '<input type="checkbox" id="check_all_positions"> Check all<br />';
  foreach($position_array as $key => $value ){
    $seed_players_form .= '<input type="checkbox" class="positionCheckBoxClass" id="position" name="position" value="'.$key.'"> '.$value.'<br />';
  }
  $seed_players_form .= '<br /><input id="seed_players_form_submit" type="submit" value="Seed Players DB" /></form>';

  print $seed_players_form;

  $preload_image = '<div style="max-width: 200px">';
  $preload_image .= '<img src="'.$GLOBALS['base_path'].'images/baseball_loading_2.gif" id="Preloader" style="max-width:100%;display:none;"/>';
  $preload_image .= '</div>';
  print $preload_image;

  print '<div id="player_seed_display_msg"></div>';

?>