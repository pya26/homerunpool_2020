<?php

	try {
		include("_includes/header.php");
		include("_includes/functions.php");
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
		die();
	}

	$api_id = $_GET['id'];

	print "<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />";

	
	$url = get_api_url($api_id);

	$select_season_form = '<form id="select_season_form">';
	$select_season_form .= '<input id="date_for_season" type="text"/>';	
	$select_season_form .= '<input id="url" type="hidden" value="'.$url.'?date=" />';
	$select_season_form .= '<input id="select_season_form_submit" type="submit" value="Get Season" />';

	print $select_season_form;

	print "<div id='display_season'></div>";


?>