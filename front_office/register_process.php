<?php
    include("../_config/config.php");
    include("../_includes/header.php");
    include("../_config/db_connect.php");
    include("../_includes/functions.php");

    if(!is_super_user()){
        print "Only the Super User is allowed back here!";
        exit();
    }



    if (isset($_POST['register'])) {

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        //$username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $status_id = 'A';

        $query = $dbh->prepare("SELECT * FROM registered_users WHERE EMAIL=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();


        if ($query->rowCount() > 0) {
            echo '<p class="error">The email address is already registered!</p>';
        }

        if ($query->rowCount() == 0) {
            $query = $dbh->prepare("INSERT INTO registered_users(first_name,last_name,email,password,status_id) VALUES (:firstname,:lastname,:email,:password_hash,:status_id)");
            $query->bindParam("firstname", $firstname, PDO::PARAM_STR,50);
            $query->bindParam("lastname", $lastname, PDO::PARAM_STR,125);
            $query->bindParam("email", $email, PDO::PARAM_STR,150);
            $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR,255);
            $query->bindParam("status_id", $status_id, PDO::PARAM_STR,1);
            $result = $query->execute();

            if ($result) {
                echo '<p class="success">Your registration was successful!</p>';
                header("Location: register.php");
            } else {
                echo '<p class="error">Something went wrong!</p>';
            }
        }
    }

?>
