<?php

    $new_array = array(
        'playerid~10609~leagueid~10~seasonid~10' => '5',
        'playerid~10726~leagueid~10~seasonid~10' => '4',
        'playerid~10734~leagueid~10~seasonid~10' => '1',
        'playerid~10756~leagueid~10~seasonid~10' => '3',
        'playerid~10966~leagueid~10~seasonid~10' => '6',
        'playerid~12233~leagueid~10~seasonid~10' => '2'
    );

    print '<pre>';
    print_r($new_array);
    print '<pre>';

    foreach($new_array as $key => $value){
        $plt_array = explode("~", $key);
        $playerid = $plt_array[1];
        $leagueid = $plt_array[3];
        $seasonid = $plt_array[5];

        print $playerid.'<br />';
        print $leagueid.'<br />';
        print $seasonid.'<br />';
        print $value.'<br /><br />';

    }



?>
