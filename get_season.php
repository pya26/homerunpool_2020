<?php

include("_config/config.php");

/*
	try {
		include("_includes/header.php");
		include("_includes/functions.php");
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
		die();
	}

   print "<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />";

	if(isset($_GET['api_id'])){

		$api_id = $_GET['api_id'];


		$season = get_api_url($api_id);

		if($season == 'error'){
			print 'Error occurred. It\'s likely there is an invalid ID or missing ID in the query string';
		} else {
			print $season['api_url'];
		}

	} else {
		print 'Undefined query string variable';
	}



	print 'Date: <input id="date" type="text"/>';

*/
	//$url = $_GET['url'];
	$url = 'https://api.mysportsfeeds.com/v2.1/pull/mlb/current_season.json?date=20200401';
	/* Connect to a MySQL database using driver invocation */
	try {
		include("_includes/functions.php");
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
		die();
	}

  	echo json_encode(mysportsfeeds_api_request($url));




	//print '<div class="result"></div>';
