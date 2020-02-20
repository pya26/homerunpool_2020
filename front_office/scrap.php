<?php

    $new_array = array(
        'sort~10609' => '5',
        'sort~10726' => '4',
        'sort~10734' => '1',
        'sort~10756' => '3',
        'sort~10966' => '6',
        'sort~12233' => '2'
    );

    print '<pre>';
    print_r($new_array);
    print '<pre>';

    foreach($new_array as $key => $value){
        print substr($key,5).' = '.$value .'<br />';
    }


?>
