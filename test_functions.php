<?php

include("_config/config.php");
include("_config/db_connect.php");
include("_includes/functions.php");


$api_id = 1;
$season = '2020-preseason';
$reg_id = 1;
$league_id = 10;

$mung = list_of_seasons();




print "<pre>";
print_r($mung);
print "</pre>";



?>

