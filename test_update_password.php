<?php
    
    include("_config/config.php");
    include("_includes/header.php");
    include("_config/db_connect.php");    

    $email = 'nolanphillips108@gmail.com';
    $password = 'Mbetts50';
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $query = $dbh->prepare("UPDATE registered_users SET password=:pwd WHERE EMAIL=:email");
    $query->bindParam("pwd", $password_hash, PDO::PARAM_STR);
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();


    print_r($query->rowCount());    

?>