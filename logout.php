<?php

	try {
		include('_config/config.php');
		include('_includes/functions.php');
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}
   
	user_log_out();

?>