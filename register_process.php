<?php
    include("_includes/header.php");
    include("_config/db_connect.php");



    if (isset($_POST['register'])) {

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $query = $dbh->prepare("SELECT * FROM registered_users WHERE EMAIL=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();


        if ($query->rowCount() > 0) {
            echo '<p class="error">The email address is already registered!</p>';
        }

        if ($query->rowCount() == 0) {
            $query = $dbh->prepare("INSERT INTO registered_users(first_name,last_name,email,password) VALUES (:firstname,:lastname,:email,:password_hash)");
            $query->bindParam("firstname", $firstname, PDO::PARAM_STR);
            $query->bindParam("lastname", $lastname, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
            $result = $query->execute();

            if ($result) {
                echo '<p class="success">Your registration was successful!</p>';
            } else {
                echo '<p class="error">Something went wrong!</p>';
            }
        }
    }

?>
