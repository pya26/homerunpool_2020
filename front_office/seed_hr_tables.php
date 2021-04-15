<?php

  try {
    include("../_config/config.php");
    include("../_config/db_connect.php");
    include("../_includes/header.php");
    include("../_includes/functions.php");
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
  }

    if(!is_super_user()){
        print "Only the Super User is allowed back here!";
        exit();
    }

	print "<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />";

	// Get array of all player ids in the players atble
	$all_db_players_array = get_all_players();

	if(count($all_db_players_array) > 0){

		$seed_hrs_form = '<form id="seed_hrs_form">';
		$seed_hrs_form .= '<label for="select_season">Select a Season</label> ';
		$seed_hrs_form .= season_select_menu() . '<br /><br />';
		$seed_hrs_form .= '<br /><input id="seed_hrs_form_submit" type="submit" value="Seed Players DB" /></form>';
		print $seed_hrs_form;


		$preload_image = '<div style="max-width: 200px">';
		$preload_image .= '<img src="images/baseball_loading_2.gif" id="Preloader" style="max-width:100%;display:none;"/>';
		$preload_image .= '</div>';
		print $preload_image;

	} else {
		print "The players table has not been seeded yet. Once it has, you will have the ability to seed the monthly homerun tables";
	}


	print '<div id="hr_seed_display_msg"></div>';


?>
