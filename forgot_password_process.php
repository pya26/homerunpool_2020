<?php


    /* Connect to a MySQL database using driver invocation */
    try { 
        include("_includes/functions.php");   
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        die();
    }

    $email = $_GET['email'];

    echo json_encode(forgot_password($email));


?>