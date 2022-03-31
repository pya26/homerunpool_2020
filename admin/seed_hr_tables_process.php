<?php

	include("../_config/config.php");
	include("../_config/db_connect.php");
	include("../_includes/functions.php");
	    

	$errors = [];
	$data = [];

	/*

	if(isset($_POST["selected_season"])){
		
		$season_id = $_POST["selected_season"];	
		$season = get_seasons_by_id($season_id);

		foreach ($season as $key => $value) {
			$season_name = $value["season_name"];
		}

	} else {

		exit();

	}
	*/
	

	$season_id = 16;	
	$season = get_seasons_by_id($season_id);

	foreach ($season as $key => $value) {
		$season_name = $value["season_name"];
	}



	// Get array of all player ids in the players atble
	$all_db_players_array = get_all_player_ids();	

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

	//$msg = '';



	//FEBRUARY
	if(!empty($all_db_players_array) && empty($february_hr_players_array)){
		
		$insert_feb = insert_hrs_february_stub_records($all_db_players_array,$season_id);		

		if ($insert_feb['success'] == false) {
		    $data['success'] = false;
		    $data['errors'] = $insert_feb['errors'];
		} else {
		    $data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['feb_message'] = 'All players inserted for February ' . $season_name . ' season';
		}		

	} else {
		
		$february_diff = array_diff($all_db_players_array, $february_hr_players_array);

		if(empty($february_diff)){

			$data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['feb_message'] = 'Nothing to update for February ' . $season_name . ' season';
			
		} else {
			
			$insert_feb = insert_hrs_february_stub_records($february_diff,$season_id);

			if($insert_feb['success'] == false) {
			    $data['success'] = false;
			    $data['errors'] = $insert_feb['errors'];
			} else {
			    $data['success'] = true;
			    $data['message'] = 'Success!';
			    $data['feb_message'] = 'Inserted missing records February ' . $season_name . ' season';
			}

		}
	}



	//MARCH
	if(!empty($all_db_players_array) && empty($march_hr_players_array)){	
		
		$insert_mar = insert_hrs_march_stub_records($all_db_players_array,$season_id);
		
		if($insert_mar['success'] == false) {
		    $data['success'] = false;
		    $data['errors'] = $insert_mar['errors'];
		} else {
		    $data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['mar_message'] = 'All players inserted for March ' . $season_name . ' season';
		}

	} else {	
		
		$march_diff = array_diff($all_db_players_array, $march_hr_players_array);

		if(empty($march_diff)){

			$data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['mar_message'] = 'Nothing to update for March ' . $season_name . ' season';

		} else {	
			
			$insert_mar = insert_hrs_march_stub_records($march_diff,$season_id);
			
			if($insert_mar['success'] == false) {	
			    $data['success'] = false;
			    $data['errors'] = $insert_mar['errors'];
			} else {	
			    $data['success'] = true;
			    $data['message'] = 'Success!';
			    $data['mar_message'] = 'Inserted missing records March ' . $season_name . ' season';
			}

		}
	}



	//APRIL
	if(!empty($all_db_players_array) && empty($april_hr_players_array)){
		
		$insert_apr = insert_hrs_april_stub_records($all_db_players_array,$season_id);

		if($insert_apr['success'] == false) {
		    $data['success'] = false;
		    $data['errors'] = $insert_apr['errors'];
		} else {
		    $data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['apr_message'] = 'All players inserted for April ' . $season_name . ' season';
		}

		
	} else {
		
		$april_diff = array_diff($all_db_players_array, $april_hr_players_array);

		if(empty($april_diff)){
			
			$data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['apr_message'] = 'Nothing to update for April ' . $season_name . ' season';

		} else {
			
			$insert_apr = insert_hrs_april_stub_records($april_diff,$season_id);
			
			if($insert_apr['success'] == false) {
			    $data['success'] = false;
			    $data['errors'] = $insert_apr['errors'];
			} else {
			    $data['success'] = true;
			    $data['message'] = 'Success!';
			    $data['apr_message'] = 'Inserted missing records April ' . $season_name . ' season';
			}
		}
	}



	//MAY
	if(!empty($all_db_players_array) && empty($may_hr_players_array)){
		
		$insert_may = insert_hrs_may_stub_records($all_db_players_array,$season_id);
		
		if($insert_may['success'] == false) {
		    $data['success'] = false;
		    $data['errors'] = $insert_may['errors'];
		} else {
		    $data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['may_message'] = 'All players inserted for May ' . $season_name . ' season';
		}

	} else {

		$may_diff = array_diff($all_db_players_array, $may_hr_players_array);

		if(empty($may_diff)){
			
			$data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['may_message'] = 'Nothing to update for May ' . $season_name . ' season';

		} else {
			
			$insert_may = insert_hrs_may_stub_records($may_diff,$season_id);

			if($insert_may['success'] == false) {
			    $data['success'] = false;
			    $data['errors'] = $insert_may['errors'];
			} else {
			    $data['success'] = true;
			    $data['message'] = 'Success!';
			    $data['may_message'] = 'Inserted missing records May ' . $season_name . ' season';
			}
			
		}
	}




	//JUNE
	if(!empty($all_db_players_array) && empty($june_hr_players_array)){
		
		$insert_jun = insert_hrs_june_stub_records($all_db_players_array,$season_id);

		if($insert_jun['success'] == false) {
		    $data['success'] = false;
		    $data['errors'] = $insert_jun['errors'];
		} else {
		    $data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['jun_message'] = 'All players inserted for June ' . $season_name . ' season';
		}
		
	} else {
		
		$june_diff = array_diff($all_db_players_array, $june_hr_players_array);

		if(empty($june_diff)){
			
			$data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['jun_message'] = 'Nothing to update for June ' . $season_name . ' season';

		} else {
			
			$insert_jun = insert_hrs_june_stub_records($june_diff,$season_id);
			
			if($insert_jun['success'] == false) {
			    $data['success'] = false;
			    $data['errors'] = $insert_jun['errors'];
			} else {
			    $data['success'] = true;
			    $data['message'] = 'Success!';
			    $data['jun_message'] = 'Inserted missing records June ' . $season_name . ' season';
			}
		}
	}




	//JULY
	if(!empty($all_db_players_array) && empty($july_hr_players_array)){
		
		$insert_jul = insert_hrs_july_stub_records($all_db_players_array,$season_id);

		if($insert_jul['success'] == false) {
		    $data['success'] = false;
		    $data['errors'] = $insert_jul['errors'];
		} else {
		    $data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['jul_message'] = 'All players inserted for July ' . $season_name . ' season';
		}
		
	} else {
		
		$july_diff = array_diff($all_db_players_array, $july_hr_players_array);

		if(empty($july_diff)){
			
			$data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['jul_message'] = 'Nothing to update for July ' . $season_name . ' season';

		} else {
			
			$insert_jul = insert_hrs_july_stub_records($july_diff,$season_id);

			if($insert_jul['success'] == false) {
			    $data['success'] = false;
			    $data['errors'] = $insert_jul['errors'];
			} else {
			    $data['success'] = true;
			    $data['message'] = 'Success!';
			    $data['jul_message'] = 'Inserted missing records July ' . $season_name . ' season';
			}
			
		}
	}




	//AUGUST
	if(!empty($all_db_players_array) && empty($august_hr_players_array)){
		
		$insert_aug = insert_hrs_august_stub_records($all_db_players_array,$season_id);

		if($insert_aug['success'] == false) {
		    $data['success'] = false;
		    $data['errors'] = $insert_aug['errors'];
		} else {
		    $data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['aug_message'] = 'All players inserted for August ' . $season_name . ' season';
		}
		
	} else {
		
		$august_diff = array_diff($all_db_players_array, $august_hr_players_array);

		if(empty($august_diff)){

			$data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['aug_message'] = 'Nothing to update for August ' . $season_name . ' season';
			
		} else {
			
			$insert_aug = insert_hrs_august_stub_records($august_diff,$season_id);

			if($insert_aug['success'] == false) {
			    $data['success'] = false;
			    $data['errors'] = $insert_aug['errors'];
			} else {
			    $data['success'] = true;
			    $data['message'] = 'Success!';
			    $data['aug_message'] = 'Inserted missing records for August ' . $season_name . ' season';
			}
			
		}
	}




	//SEPTEMBER
	if(!empty($all_db_players_array) && empty($september_hr_players_array)){
		
		$insert_sep = insert_hrs_september_stub_records($all_db_players_array,$season_id);

		if($insert_sep['success'] == false) {
		    $data['success'] = false;
		    $data['errors'] = $insert_sep['errors'];
		} else {
		    $data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['sep_message'] = 'All players inserted for September ' . $season_name . ' season';
		}
		
	} else {
		
		$september_diff = array_diff($all_db_players_array, $september_hr_players_array);

		if(empty($september_diff)){

			$data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['sep_message'] = 'Nothing to update for September ' . $season_name . ' season';
			
		} else {
			
			$insert_sep = insert_hrs_september_stub_records($september_diff,$season_id);

			if($insert_sep['success'] == false) {
			    $data['success'] = false;
			    $data['errors'] = $insert_sep['errors'];
			} else {
			    $data['success'] = true;
			    $data['message'] = 'Success!';
			    $data['sep_message'] = 'Inserted missing records for September ' . $season_name . ' season';
			}
			
		}
	}




	//OCTOBER
	if(!empty($all_db_players_array) && empty($october_hr_players_array)){
		
		$insert_oct = insert_hrs_october_stub_records($all_db_players_array,$season_id);

		if($insert_oct['success'] == false) {
		    $data['success'] = false;
		    $data['errors'] = $insert_oct['errors'];
		} else {
		    $data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['oct_message'] = 'All players inserted for October ' . $season_name . ' season';
		}
		
	} else {
		
		$october_diff = array_diff($all_db_players_array, $october_hr_players_array);

		if(empty($october_diff)){
			
			$data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['oct_message'] = 'Nothing to update for October ' . $season_name . ' season';	

		} else {
			
			$insert_oct = insert_hrs_october_stub_records($october_diff,$season_id);

			if($insert_oct['success'] == false) {
			    $data['success'] = false;
			    $data['errors'] = $insert_oct['errors'];
			} else {
			    $data['success'] = true;
			    $data['message'] = 'Success!';
			    $data['oct_message'] = 'Inserted missing records for October ' . $season_name . ' season';
			}			

		}
	}




	//NOVEMBER
	if(!empty($all_db_players_array) && empty($november_hr_players_array)){
		
		$insert_nov = insert_hrs_november_stub_records($all_db_players_array,$season_id);

		if($insert_nov['success'] == false) {
		    $data['success'] = false;
		    $data['errors'] = $insert_nov['errors'];
		} else {
		    $data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['nov_message'] = 'All players inserted for November ' . $season_name . ' season';
		}
		

	} else {
		
		$november_diff = array_diff($all_db_players_array, $november_hr_players_array);

		if(empty($november_diff)){
			
			$data['success'] = true;
		    $data['message'] = 'Success!';
		    $data['nov_message'] = 'Nothing to update for November ' . $season_name . ' season';

		} else {
			
			$insert_nov = insert_hrs_november_stub_records($november_diff,$season_id);

			if($insert_nov['success'] == false) {
			    $data['success'] = false;
			    $data['errors'] = $insert_nov['errors'];
			} else {
			    $data['success'] = true;
			    $data['message'] = 'Success!';
			    $data['nov_message'] = 'Inserted missing records for November ' . $season_name . ' season';
			}
			

		}
	}


	

	echo json_encode($data);



?>
