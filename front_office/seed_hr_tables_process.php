<?php

	// Include functions, configurations, & database cennection files
	include("../_config/config.php");
	include("_config/db_connect.php");
	include("../_includes/functions.php");


	// set URL parameter variables
	//?season=2019-regular
	if(isset($_GET['season'])){
		$season = $_GET['season'];
		$season_id = get_season_id($season);
	} else {
		$season_id = 0;
	}


	// Get array of all player ids in the players atble
	$all_db_players_array = get_all_players();

	// Get array of all Player IDs from each hr month via season id
	$february_hr_players_array = get_monthly_hrs_for_season('hrs_february',$season_id);
	$march_hr_players_array = get_monthly_hrs_for_season('hrs_march',$season_id);
	$april_hr_players_array = get_monthly_hrs_for_season('hrs_april',$season_id);
	$may_hr_players_array = get_monthly_hrs_for_season('hrs_may',$season_id);
	$june_hr_players_array = get_monthly_hrs_for_season('hrs_june',$season_id);
	$july_hr_players_array = get_monthly_hrs_for_season('hrs_july',$season_id);
	$august_hr_players_array = get_monthly_hrs_for_season('hrs_august',$season_id);
	$september_hr_players_array = get_monthly_hrs_for_season('hrs_september',$season_id);
	$october_hr_players_array = get_monthly_hrs_for_season('hrs_october',$season_id);
	$november_hr_players_array = get_monthly_hrs_for_season('hrs_november',$season_id);


	/**
	 * STEPS FOR EACH MONTH BLOCK
	 * 1. check if players db array is NOT empty AND if the monthly hr table is empty based on player_id and season_id
	 * 1a. if #1 is true then insert all player records into the monthly hr table
	 * 2. check if there is a difference bbetween the players tabkle and monthly hr table
	 * 2a. if there is no difference from the check in #2, do nothing
	 * 2b. if there is a difference found in #2, then insert the new records into the monthly hr table
	 */

	$msg = '';

	//FEBRUARY
	if(!empty($all_db_players_array) && empty($february_hr_players_array)){
		insert_hrs_february_stub_records($all_db_players_array,$season_id);
		$msg .= 'All players inserted for February ' . $season . '<br />';

	} else {
		$february_diff = array_diff($all_db_players_array, $february_hr_players_array);

		if(empty($february_diff)){
			$msg .= 'Nothing to update for February ' . $season . '<br />';
		} else {
			insert_hrs_february_stub_records($february_diff,$season_id);
			$msg .= 'Inserted missing records February ' . $season . '<br />';
		}
	}




	//MARCH
	if(!empty($all_db_players_array) && empty($march_hr_players_array)){
		insert_hrs_march_stub_records($all_db_players_array,$season_id);
		$msg .= 'All players inserted for March ' . $season . '<br />';
	} else {
		$march_diff = array_diff($all_db_players_array, $march_hr_players_array);

		if(empty($march_diff)){
			$msg .= 'Nothing to update for March ' . $season . '<br />';
		} else {
			insert_hrs_march_stub_records($march_diff,$season_id);
			$msg .= 'Inserted missing records March ' . $season . '<br />';
		}
	}



	//APRIL
	if(!empty($all_db_players_array) && empty($april_hr_players_array)){
		insert_hrs_april_stub_records($all_db_players_array,$season_id);
		$msg .= 'All players inserted for April ' . $season . '<br />';
	} else {
		$april_diff = array_diff($all_db_players_array, $april_hr_players_array);

		if(empty($april_diff)){
			$msg .= 'Nothing to update for April ' . $season . '<br />';
		} else {
			insert_hrs_april_stub_records($april_diff,$season_id);
			$msg .= 'Inserted missing records April ' . $season . '<br />';
		}
	}



	//MAY
	if(!empty($all_db_players_array) && empty($may_hr_players_array)){
		insert_hrs_may_stub_records($all_db_players_array,$season_id);
		$msg .= 'All players inserted for May ' . $season . '<br />';
	} else {
		$may_diff = array_diff($all_db_players_array, $may_hr_players_array);

		if(empty($may_diff)){
			$msg .= 'Nothing to update for May ' . $season . '<br />';
		} else {
			insert_hrs_may_stub_records($may_diff,$season_id);
			$msg .= 'Inserted missing records May ' . $season . '<br />';
		}
	}




	//JUNE
	if(!empty($all_db_players_array) && empty($june_hr_players_array)){
		insert_hrs_june_stub_records($all_db_players_array,$season_id);
		$msg .= 'All players inserted for June ' . $season . '<br />';
	} else {
		$june_diff = array_diff($all_db_players_array, $june_hr_players_array);

		if(empty($june_diff)){
			$msg .= 'Nothing to update for June ' . $season . '<br />';
		} else {
			insert_hrs_june_stub_records($june_diff,$season_id);
			$msg .= 'Inserted missing records June ' . $season . '<br />';
		}
	}




	//JULY
	if(!empty($all_db_players_array) && empty($july_hr_players_array)){
		insert_hrs_july_stub_records($all_db_players_array,$season_id);
		$msg .= 'All players inserted for July ' . $season . '<br />';
	} else {
		$july_diff = array_diff($all_db_players_array, $july_hr_players_array);

		if(empty($july_diff)){
			$msg .= 'Nothing to update for July ' . $season . '<br />';
		} else {
			insert_hrs_july_stub_records($july_diff,$season_id);
			$msg .= 'Inserted missing records July ' . $season . '<br />';
		}
	}




	//AUGUST
	if(!empty($all_db_players_array) && empty($august_hr_players_array)){
		insert_hrs_august_stub_records($all_db_players_array,$season_id);
		$msg .= 'All players inserted for August ' . $season . '<br />';
	} else {
		$august_diff = array_diff($all_db_players_array, $august_hr_players_array);

		if(empty($august_diff)){
			$msg .= 'Nothing to update for August ' . $season . '<br />';
		} else {
			insert_hrs_august_stub_records($august_diff,$season_id);
			$msg .= 'Inserted missing records August ' . $season . '<br />';
		}
	}




	//SEPTEMBER
	if(!empty($all_db_players_array) && empty($september_hr_players_array)){
		insert_hrs_september_stub_records($all_db_players_array,$season_id);
		$msg .= 'All players inserted for September ' . $season . '<br />';
	} else {
		$september_diff = array_diff($all_db_players_array, $september_hr_players_array);

		if(empty($september_diff)){
			$msg .= 'Nothing to update for September ' . $season . '<br />';
		} else {
			insert_hrs_september_stub_records($september_diff,$season_id);
			$msg .= 'Inserted missing records September ' . $season . '<br />';
		}
	}




	//OCTOBER
	if(!empty($all_db_players_array) && empty($october_hr_players_array)){
		insert_hrs_october_stub_records($all_db_players_array,$season_id);
		$msg .= 'All players inserted for October ' . $season . '<br />';
	} else {
		$october_diff = array_diff($all_db_players_array, $october_hr_players_array);

		if(empty($october_diff)){
			$msg .= 'Nothing to update for October ' . $season . '<br />';
		} else {
			insert_hrs_october_stub_records($october_diff,$season_id);
			$msg .= 'Inserted missing records October ' . $season . '<br />';
		}
	}




	//NOVEMBER
	if(!empty($all_db_players_array) && empty($november_hr_players_array)){
		insert_hrs_november_stub_records($all_db_players_array,$season_id);
		$msg .= 'All players inserted for November ' . $season . '<br />';
	} else {
		$november_diff = array_diff($all_db_players_array, $november_hr_players_array);

		if(empty($november_diff)){
			$msg .= 'Nothing to update for November ' . $season . '<br />';
		} else {
			insert_hrs_november_stub_records($november_diff,$season_id);
			$msg .= 'Inserted missing records November ' . $season . '<br />';
		}
	}

	echo json_encode($msg);






?>
