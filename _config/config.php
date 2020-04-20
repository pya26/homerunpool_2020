<?php

	$GLOBALS['db_host'] = 'localhost';
	$GLOBALS['db_user'] = 'homeruo9_kevin';
	$GLOBALS['db_password'] = 'kelster26';
	$GLOBALS['db_name'] = 'homeruo9_homerunpool';
	$GLOBALS['msf_apikey_token'] = '8cba6612-b899-4bd5-9d83-2db6e3';
	$GLOBALS['msf_password'] = 'MYSPORTSFEEDS';
	$GLOBALS['msf_api_v2_base_url'] = 'https://api.mysportsfeeds.com/v2.1/pull/mlb/';
	//$GLOBALS['base_url'] = 'http://localhost/sandbox/homerunpool_2020/';
	//$GLOBALS['base_path'] = '/sandbox/homerunpool_2020/';
	$GLOBALS['config_base_path'] = 'C:\laragon\www\sandbox\homerunpool_2020';
	$GLOBALS['league_id'] = 10;
	$GLOBALS['season_id'] = 10;

	if($_SERVER['CONTEXT_DOCUMENT_ROOT'] == 'C:/laragon/www'){

		$GLOBALS['base_url'] = 'http://localhost/sandbox/homerunpool_2020/';
		$GLOBALS['base_path'] = '/sandbox/homerunpool_2020/';
	
	} elseif($_SERVER['CONTEXT_DOCUMENT_ROOT'] == 'C:/wamp64/www') {

		$GLOBALS['base_url'] = 'http://localhost/sandbox/homerunpool_2020/';
		$GLOBALS['base_path'] = '/sandbox/homerunpool_2020/';

	} else {
	/**
	* set variables for bluehost
	*/
		$GLOBALS['base_url'] = 'https://www.homerunpool.com/';
		$GLOBALS['base_path'] = '/home1/homeruo9/public_html';
	}

	$leagueid = $GLOBALS['league_id'];
	$seasonid = $GLOBALS['season_id'];



?>
