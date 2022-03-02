<?php

    $date = date("Ymd",strtotime("now"));

    include('/home1/homeruo9/public_html/lawton_chiles_death_pool/_includes/sparql_query_dispatcher.php');
    include('/home1/homeruo9/public_html/lawton_chiles_death_pool/_includes/query_all_qids.php');
    include('/home1/homeruo9/public_html/lawton_chiles_death_pool/_config/db_config.php');
    include('email_config.php');


    // get all celebs that are flagged as NOT dead from the database
	$get_alive_celebs = $dbh->prepare('select * from celebrities where dead = 0');
	$get_alive_celebs->execute();	
	
    // loop through all NOT dead celebrities
	while ($alive_celeb = $get_alive_celebs->fetch(PDO::FETCH_ASSOC)) {	

		// loop through all of our celebrities we're pulling from wikidata.org
		foreach($queryResult["results"]["bindings"] as  $key => $value) {

			// if a celebrity is dead (per wikidata.org) via an "RIP" data element, then enter into this "if" condition to update the celebrity death and update team points
			if(array_key_exists("RIP", $value)){				

				// get celebrity QID (Q number is the unique identifier of a data item on Wikidata) from the query we made to Wikidata
				$qid_url = $value["item"]["value"];
				$qid = substr($qid_url, strrpos($qid_url, '/' )+1);

				// compare the qid we have in our database to the qid we pulled from wikidata. If they match, then eneter into this "if" condition
				if($alive_celeb["wikidata_qid"] == $qid){	

					$dead_celeb_name = $alive_celeb["celeb_name"];				
				
					// set isdead flag value and date of death parameters to update each celebrity in the database
					$isdead =  1;							
					$deaddate = date('Y-m-d H:i:s', strtotime($value["RIP"]["value"]));

					// update celebrity db table with isdead flag and date of death
					$update_dods = $dbh->prepare('CALL update_deaths(:qid,:isdead,:deaddate)');
					$update_dods->bindParam('qid', $qid, PDO::PARAM_STR,15);
					$update_dods->bindParam('isdead', $isdead, PDO::PARAM_INT);
					$update_dods->bindParam('deaddate', $deaddate, PDO::PARAM_STR);
					$update_dods->execute();


					

					// get each team's celebrities so we can loop throguh them and update their points 
					$get_team_roster_player = $dbh->prepare('select tr.team_roster_id, c.celeb_name,tr.sort from celebrities c inner join team_rosters tr ON tr.celeb_id = c.celeb_id where c.wikidata_qid = :qid order by c.celeb_id');
					$get_team_roster_player->bindParam('qid', $qid, PDO::PARAM_STR, 15);			
					$get_team_roster_player->execute();

					// enter loop from previous query to update each team's celebrity record (i.e. points)
					while ($dead_celeb = $get_team_roster_player->fetch(PDO::FETCH_ASSOC)) {						

						// calculate points for each team's dead celebrities and set "points" variable and value 
						if($dead_celeb["sort"] == 99){
							$points = 20;
						} else {
							$points = 10 - $dead_celeb["sort"];
						}

						// set variable and value of unique team_roster_id to update each team's celebrity's ponts
						$team_roster_id = $dead_celeb["team_roster_id"];

						// query to update each team's points
						$update_team_roster_points = $dbh->prepare('update team_rosters set points = :points where team_roster_id = :team_roster_id');
						$update_team_roster_points->bindParam('points', $points, PDO::PARAM_INT);
						$update_team_roster_points->bindParam('team_roster_id', $team_roster_id, PDO::PARAM_INT);
						$update_team_roster_points->execute();						
						
					}
					unset($get_team_roster_player);	

					// create array with the recent dead celebrity and their death date to be output on the webpage and to be sent via email/text
					$recently_passed = array(
						'celeb_name' => $dead_celeb_name,
						'dod' => $deaddate
					);

					$recently_passed_array[] = $recently_passed;				

				}

			}

		}
		
	}
	unset($update_dods);
	unset($get_alive_celebs);    			
										

					
	/*
	foreach($queryResult["results"]["bindings"] as  $key => $value) {	

		$update_dods = $dbh->prepare('CALL update_deaths(:qid,:isdead,:deaddate)');
		
		if(array_key_exists("RIP", $value)){

			$qid_url = $value["item"]["value"];
			$qid = substr($qid_url, strrpos($qid_url, '/' )+1);

			$isdead =  1;							
			$deaddate = date('Y-m-d H:i:s', strtotime($value["RIP"]["value"]));	

			$update_dods->bindParam('qid', $qid, PDO::PARAM_STR,15);
			$update_dods->bindParam('isdead', $isdead, PDO::PARAM_INT);
			$update_dods->bindParam('deaddate', $deaddate, PDO::PARAM_STR);
			$update_dods->execute();


			$get_team_roster_player = $dbh->prepare('select tr.team_roster_id, c.celeb_name,tr.sort from celebrities c inner join team_rosters tr ON tr.celeb_id = c.celeb_id where c.wikidata_qid = :qid order by c.celeb_id');
			$get_team_roster_player->bindParam('qid', $qid, PDO::PARAM_STR, 15);			
			$get_team_roster_player->execute();

			while ($dead_celeb = $get_team_roster_player->fetch(PDO::FETCH_ASSOC)) {

				$celeb_name = $dead_celeb["celeb_name"];

				if($dead_celeb["sort"] == 99){
					$points = 20;
				} else {
					$points = 10 - $dead_celeb["sort"];
				}

				$team_roster_id = $dead_celeb["team_roster_id"];

				$update_team_roster_points = $dbh->prepare('update team_rosters set points = :points where team_roster_id = :team_roster_id');
				$update_team_roster_points->bindParam('points', $points, PDO::PARAM_INT);
				$update_team_roster_points->bindParam('team_roster_id', $team_roster_id, PDO::PARAM_INT);
				$update_team_roster_points->execute();

				$recently_passed = array(
					'celeb_name' => $celeb_name
				);

				$recently_passed_array[] = $recently_passed;
			}
			unset($update_team_roster_points);
			unset($get_team_roster_player);

		}

		unset($update_dods);					
		

	}
	*/




	$tz = 'America/New_York';
	$timestamp = time();
	$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
	$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
	$todays_date_format  = $dt->format('n/j/Y, g:ia');


	if (!empty($recently_passed_array)) {

		$subject = "Deathpool update ".$todays_date_format;

		$body = "The following celebrities have perished \r\n\r\n";

		foreach ($recently_passed_array as $key => $value) {

			$body .= $value['celeb_name']  . " -- " . date('m/d/Y', strtotime($value['dod'])) ."\r\n";

		}

	} else {

		$subject = "No celebrities have perished since the last cron run. ".$todays_date_format;

		$body = "";

	}


	

	$send_mail = mail($to_email, $subject, $body, $headers);
	
