<?php

	$GLOBALS['db_host'] = 'localhost';
	$GLOBALS['port'] = '10011';
	$GLOBALS['db_user'] = 'homeruo9_kevin';
	$GLOBALS['db_password'] = 'kelster26';
	$GLOBALS['db_name'] = 'homeruo9_homerunpool';
	/*$GLOBALS['db_host'] = 'localhost';
	$GLOBALS['port'] = '10011';
	$GLOBALS['db_user'] = 'root';
	$GLOBALS['db_password'] = 'root';
	$GLOBALS['db_name'] = 'local';*/
	$GLOBALS['msf_apikey_token'] = '4872abe5-9dae-4afb-88ec-52865a';
	$GLOBALS['msf_password'] = 'MYSPORTSFEEDS';
	$GLOBALS['msf_api_v2_base_url'] = 'https://api.mysportsfeeds.com/v2.1/pull/mlb/';
	$GLOBALS['config_base_path'] = 'C:\Users\kphillips\Local Sites\homerunpool\app\public';
	$GLOBALS['league_id'] = 10;

	if($_SERVER['DOCUMENT_ROOT'] == 'C:/Users/kphillips/Local Sites/homerunpool/app/public'){

		$GLOBALS['base_url'] = 'http://homerunpool.local/';
		$GLOBALS['base_path'] = 'http://homerunpool.local/';
		$GLOBALS['db_user'] = 'root';
		$GLOBALS['db_password'] = 'root';
		$GLOBALS['db_name'] = 'local';
	
	} elseif($_SERVER['DOCUMENT_ROOT'] == 'C:/wamp64/www') {

		$GLOBALS['base_url'] = 'http://localhost/sandbox/homerunpool_2020/';
		$GLOBALS['base_path'] = '/Users/kphillips/Local Sites/homerunpool/app/public';

	} else {
	
		/**
		 * set variables for bluehost
		 */
		$GLOBALS['base_url'] = 'https://www.homerunpool.com/';
		$GLOBALS['base_path'] = '/home1/homeruo9/public_html';
		
	}

	if(!isset($_SESSION)) {
    	session_start();
    }


?>
