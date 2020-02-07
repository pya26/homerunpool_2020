<?php

include("_config/config.php");
include("_config/db_connect.php");
include("_includes/functions.php");

//$mung = list_of_seasons();




$url = 'https://api.mysportsfeeds.com/v2.1/pull/mlb/current_season.json?date=20191002';

$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        $headers = array(
            'Content-type: application/json; charset=UTF-8',
            "Authorization: Basic " . base64_encode($GLOBALS['msf_apikey_token'] . ":" . $GLOBALS['msf_password']),
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Send the request & save response to $resp
        $resp = curl_exec($ch);
        $response = json_decode($resp);

        curl_close($ch);


        print '<pre>';
        print_r($response);
        print '</pre>';




?>