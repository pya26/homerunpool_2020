<?php


    include("_config/config.php");
    include("_config/db_connect.php");
    include("_includes/functions.php");


    global $wrongPwdErr, $accountNotExistErr, $emailPwdErr, $verificationRequiredErr, $email_empty_err, $pass_empty_err;

    $dbh = $GLOBALS['dbh'];

    $email_signin = $_GET['email'];
    $password_signin = $_GET['pwd'];

    // clean data 
    $user_email = filter_var($email_signin, FILTER_SANITIZE_EMAIL);
    //$pswd = mysqli_real_escape_string($connection, $password_signin);

    // Query if email exists in db
    $check_email = $dbh->prepare("SELECT * From registered_users WHERE email = :email");
    $check_email->bindParam('email', $email_signin, PDO::PARAM_STR, 150);
    $check_email->execute();
    $rowCount = $check_email->rowCount();

    
    if(!empty($email_signin) && !empty($password_signin)){
        /*if(!preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,20}$/", $password_signin)) {
            $wrongPwdErr = 'Password should be between 6 to 20 charcters long, contains atleast one special chacter, lowercase, uppercase and a digit.';
            
            $wrongPwdErr_array = array('msg_code' => 1, 'msg' => $wrongPwdErr);
            echo json_encode($wrongPwdErr_array);

        }*/
        // Check if email exist
        if($rowCount <= 0) {
            $accountNotExistErr = 'User account does not exist.';
            
            $accountNotExistErr_array = array('msg_code' => 2, 'msg' => $accountNotExistErr);
            echo json_encode($accountNotExistErr_array);

        } else {

            // Fetch user data and store in php session
            while($row = $check_email->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['reg_id'];
            }

            unset($check_email);


            //Update user's login token
            /*$token = md5(rand().time());
            
            $update_token = $dbh->prepare("UPDATE registered_users SET token = :token WHERE reg_id = :reg_id");
            $update_token->bindParam('token', $token, PDO::PARAM_STR, 255);
            $update_token->bindParam('reg_id', $id, PDO::PARAM_INT);
            $update_token->execute();*/
            $update_token = update_reg_users_token($id);

            


            $get_reg_user = $dbh->prepare("SELECT * From registered_users WHERE email = :email");
            $get_reg_user->bindParam('email', $email_signin, PDO::PARAM_STR, 150);
            $get_reg_user->execute();

            while($row = $get_reg_user->fetch(PDO::FETCH_ASSOC)) {

                //Check if logged in user is an administrator.  If so set a "Super User" session to 1
                if($row['role_id'] == 4){
                    $_SESSION['super_user'] = 1;
                } else {
                    $_SESSION['super_user'] = 0;
                }
                $id            = $row['reg_id'];
                $firstname     = $row['first_name'];
                $lastname      = $row['last_name'];
                $email         = $row['email'];
                $mobilenumber   = $row['mobile_number'];
                $pass_word     = $row['password'];
                $token         = $row['token'];
                $is_active     = $row['status_id'];
            }

            unset($get_reg_user);

            

            // Verify password
            $password = password_verify($password_signin, $pass_word);

            // Allow only verified user
            if($is_active == 'A') {
                if($email_signin == $email && $password_signin == $password) {

                    $_SESSION['reg_id'] = $id;
                    $_SESSION['firstname'] = $firstname;
                    $_SESSION['lastname'] = $lastname;
                    $_SESSION['email'] = $email;
                    $_SESSION['mobilenumber'] = $mobilenumber;
                    $_SESSION['token'] = $token;

                    $login_session_array = array('msg_code' => 0,'reg_id' => $_SESSION['reg_id'], 'super_user' => $_SESSION['super_user'], 'first_name' => $_SESSION['firstname'], 'last_name' => $_SESSION['lastname']);
                    echo json_encode($login_session_array);

                } else {
                    $emailPwdErr = 'Either email or password is incorrect.';

                    $emailPwdErr_array = array('msg_code' => 3, 'msg' => $emailPwdErr);
                    echo json_encode($emailPwdErr_array);

                }

            } elseif ($is_active == 'D') {
                $verificationRequiredErr = 'Your account is currently pending deletion.';

                $verificationRequiredErr_array = array('msg_code' => 4, 'msg' => $verificationRequiredErr);
                echo json_encode($verificationRequiredErr_array);

            } elseif ($is_active == 'S') {
                $verificationRequiredErr = 'Your account is currently suspended. Please contact your league commissioner to resolve this issue.';

                $verificationRequiredErr_array = array('msg_code' => 4, 'msg' => $verificationRequiredErr);
                echo json_encode($verificationRequiredErr_array);

            } elseif ($is_active == 'P') {
                $verificationRequiredErr = 'Your account is currently pending confirmation. Please check your email and click the link to confirm your email address.';

                $verificationRequiredErr_array = array('msg_code' => 4, 'msg' => $verificationRequiredErr);
                echo json_encode($verificationRequiredErr_array);

            } elseif ($is_active == 'I') {
                $verificationRequiredErr = 'Your account is currently inactive. Please contact your league commissioner to resolve this issue.';

                $verificationRequiredErr_array = array('msg_code' => 4, 'msg' => $verificationRequiredErr);
                echo json_encode($verificationRequiredErr_array);

            }

        }

    } else {
        if(empty($email_signin)){
            $email_empty_err = "Email not provided.";

            $emailPwdErr_array = array('msg_code' => 5, 'msg' => $email_empty_err);
            echo json_encode($emailPwdErr_array);

        }
        
        if(empty($password_signin)){
            $pass_empty_err = "Password not provided.";

            $pass_empty_err_array = array('msg_code' => 6, 'msg' => $pass_empty_err);
            echo json_encode($pass_empty_err_array);

        }            
    }



    














?>
