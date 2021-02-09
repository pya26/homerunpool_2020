<?php

	include("_config/config.php");
	include("_config/db_connect.php");
	include("_includes/functions.php");



	$url = 'https://api.mysportsfeeds.com/v2.1/pull/mlb/injuries.json?player=10872,11559';
	//$url = 'https://api.mysportsfeeds.com/v2.1/pull/mlb/injury_history.json?team=bos';
	
	$mung = mysportsfeeds_api_request($url);

	print "<pre>";
	print_r($mung);
	print "</pre>";

?>
