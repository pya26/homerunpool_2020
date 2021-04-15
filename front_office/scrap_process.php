<?php


    // include functions, configurations, and database configurations file  
    include("../_config/config.php");
    include("../_config/db_connect.php"); 
    include("../_includes/functions.php");

    if(!is_super_user()){
        print "Only the Super User is allowed back here!";
        exit();
    }

    
	foreach($_POST['test'] as $value){
	  print $value . '<br />';
	}


?>
