<?php



  try {
    $configs = include('_config/config.php');
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
  }
   
	session_start();
	/*unset($_SESSION['reg_id']);
	unset($_SESSION['super_user']);
	unset($_SESSION['first_name']);
	unset($_SESSION['last_name']);*/

	// destroy everything in this session
	session_destroy();	

	header("Location: ".$configs['base_url']);

	//header("Location: admin_dashboard.php");
?>