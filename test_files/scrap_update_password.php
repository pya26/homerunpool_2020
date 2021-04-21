<?php
    
    include('../_config/config.php');
    include('../_config/db_connect.php');
    include('../_includes/functions.php');

    $email = 'pya2626@gmail.com';
    $password = 'Kelster26';
    $password_hash = password_hash($password, PASSWORD_BCRYPT);


    //$query = $dbh->prepare("UPDATE registered_users SET password='$2y$10$n0rjDUsDBOA/WOBdso.E7uzMhGKE2iuZ1rO0dHLBl6eVl3nbiQha2' WHERE email='pya2626@gmail.com'");
    $query = $dbh->prepare("UPDATE registered_users SET password=:pwd WHERE email=:email");
    $query->bindParam("pwd", $password_hash, PDO::PARAM_STR);
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();


    print_r($query->rowCount());

    
    

?>