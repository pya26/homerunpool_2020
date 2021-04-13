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


	$date = date("Ymd",strtotime("-1 days"));	

	$url = $GLOBALS['msf_api_v2_base_url'] . 'current_season.json?date=' . $date;
	$season = mysportsfeeds_api_request($url);

	$season_slug = $season->seasons[0]->slug;

	print $season_slug;

	$season_id = get_season_id($season_slug);



	print '<br />' . $season_id;

?>




