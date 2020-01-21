<?php


    /* Connect to a MySQL database using driver invocation */
    try { 
        include("_includes/functions.php");   
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        die();
    }

    $email = $_GET['email'];
    $password = $_GET['pwd'];

    echo json_encode(user_login($email,$password));
/*
    include("_includes/header.php");
    include("_config/db_connect.php");



    if (isset($_POST['login'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = $dbh->prepare("SELECT * FROM registered_users WHERE email=:email AND status_id = 'A'");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (!$result) {

            echo '<p class="error">Username password combination is wrong!</p>';

        } else {

            if (password_verify($password, $result['password'])) {
                
                
                //Check if logged in user is an administrator.  If so set a "Super User" session to 1
                if($result['role_id'] == 4){
                    $_SESSION['super_user'] = 1;
                } else {
                    $_SESSION['super_user'] = 0;
                }

                $_SESSION['reg_id'] = $result['reg_id'];
                $reg_id = $_SESSION['reg_id'];
                //echo '<p class="success">Congratulations, you are logged in!</p>';        

                $query = $dbh->prepare("SELECT * FROM teams WHERE reg_id=:regid AND status_id = 'A'");
                $query->bindParam("regid", $reg_id, PDO::PARAM_STR);
                $query->execute();

                if ($query->rowCount() > 1) {

                    if($_POST['redirect'] == ''){
                        header("Location: front_office.php");
                    } else {
                        header("Location: " . $_POST['redirect']);
                    }

                    

                } else {
                  
                    header("Location: leader_board.php");

                }

            } else {
                echo '<p class="error">Username password combination is wrong!</p>';
            }
        }
    }
    */

?>
