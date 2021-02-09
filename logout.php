<?php

	try {
		include('_config/config.php');
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}
   
	session_start();

	// destroy all sessions
	session_destroy();	

	header("Location: ".$GLOBALS['base_url']);

?>