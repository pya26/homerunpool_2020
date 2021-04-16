<?php

    include("_config/config.php");
    include("_config/db_connect.php");
    include("_includes/functions.php");

    $email_signin = $_GET['email'];
    $password_signin = $_GET['pwd'];

    user_login($email_signin,$password_signin);

?>
