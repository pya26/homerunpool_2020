<?php

date_default_timezone_set('America/New_York');

$timezone = date_default_timezone_get();

echo "The current server timezone is: " . $timezone;



$date = date('m/d/Y h:i:s a', time());

print '<br />'. $date;

print '<br />Just testing';



















?>

