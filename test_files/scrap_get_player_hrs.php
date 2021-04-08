<?php

//$date = $_GET['date'];
$date = '20210405';

include("../_config/config.php");
include("../_config/db_connect.php");
include("../_includes/functions.php");


$url = $GLOBALS['msf_api_v2_base_url'] . 'current_season.json?date=' . $date;
$season = mysportsfeeds_api_request($url);

$season_slug = $season->seasons[0]->slug;

$season_id = get_season_id($season_slug);

$url_hrs = $GLOBALS['msf_api_v2_base_url'] . '2021-regular/date/' . $date . '/player_gamelogs.json?player=12590';


$hr_response = mysportsfeeds_api_request($url_hrs);



print "<pre>";
print_r($hr_response);
print "</pre>";


?>