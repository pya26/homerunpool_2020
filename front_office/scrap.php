<?php


    // include functions, configurations, and database configurations file  
    include("../_config/config.php");
    include("../_config/db_connect.php"); 
    include("../_includes/functions.php");

    if(!is_super_user()){
        print "Only the Super User is allowed back here!";
        exit();
    }


    print "<pre>";
    print_r(current_season());
    print "</pre>";

    /*$new_array = array(
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
*/

   
    if(!is_logged_in()){
        header('Location: http://localhost/sandbox/homerunpool_2020');
    }


?>
