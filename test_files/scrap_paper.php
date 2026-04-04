<?php

	/*print_r(__DIR__);
	print "<br />";
	print_r(dirname(__FILE__));
	print "<br />";
    print_r(dirname(__DIR__, 1));
    */

    include('../_config/config.php');
    include('../_config/db_connect.php');
    include('../_includes/functions.php');


	
	// set file name of api
  	$api_file = 'players.json';

  	$url_params = '?player=mike-trout';	


  	// set full url to be passed to the curl_request function 
    $url = $GLOBALS['msf_api_v2_base_url'] . $api_file . $url_params;

    $players = mysportsfeeds_api_request($url);

    print "<pre>";
    print_r($players);
    print "</pre>";

    

?>




