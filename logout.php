<?php
	session_start();
	unset($_SESSION['reg_id']);
	unset($_SESSION['super_user']);

	header("Location: admin_dashboard.php");
?>


