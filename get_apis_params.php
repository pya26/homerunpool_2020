<?php

	
	try {		
	    include("_config/config.php");
	    include("_config/db_connect.php");
	    include("_includes/functions.php");
	    include("_includes/header.php");
	  } catch (PDOException $e) {
	    echo 'Connection failed: ' . $e->getMessage();
	    die();
	  }
	  
	print "<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />";

 	$result = $dbh->query("SELECT * FROM msf_apis");
	$result->execute();	
	
	$api_array = array(''=>'--- Select an API ---');
	$api_array = [];
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$api_array[] = ['api_id' => $row['api_id'], 'api_name' => $row['api_name'], 'api_url' => $row['api_url'], 'api_desc' => $row['api_desc']];
	}

	/**
	 * display select menu of msf api names
	 */
	$api_form = dynamic_select($api_array, 'api_menu', 'APIs:', '');

	print $api_form;

	print '<div class="result"></div>';