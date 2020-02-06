<?php

$configs = include("_config/config.php");
    
    $url = 'https://api.mysportsfeeds.com/v2.1/pull/mlb/current_season.json?date=20190901';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    $headers = array(
        "Content-type: application/json; charset=UTF-8",
        "Authorization: Basic " . base64_encode($configs['msf_apikey_token'] . ":" . $configs['msf_password']),
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Send the request & save response to $resp
    $resp = curl_exec($ch);
    
    $response = json_decode($resp);
    


    /*print "<pre>";
    print_r($response);
    print "</pre>";*/

    curl_close($ch);

    print $response->seasons[0]->slug;

?>