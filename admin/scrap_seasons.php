<?php

    include("../_config/config.php");
    include("../_config/db_connect.php");
    include("../_includes/functions.php");

    $date = "20230330";
    

    /*************
     2023 Seasons
     Pre Season: 2/24/23 - 3/29/23
     Regular Season: 3/30/23 - 10/2/23
     Post Season: 

    **************/

    $url = $GLOBALS['msf_api_v2_base_url'] . 'current_season.json?date=' . $date;

    $season = mysportsfeeds_api_request($url);

    print "<pre>";
    print_r($season);
    print "</pre>";
?>