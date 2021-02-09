<?php


    /* Connect to a MySQL database using driver invocation */
    try { 
        include("_config/config.php");
        include("_config/db_connect.php");
        include("_includes/functions.php");   
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        die();
    }

    $email = $_GET['email'];
    $password = $_GET['pwd'];

    

    echo json_encode(user_login($email,$password));

?>
