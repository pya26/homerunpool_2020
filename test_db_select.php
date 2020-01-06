<?php
	/**
	 * Include Header
	 */
	include('_includes/header.php');


	
	try {
		include("_config/db_connect.php");
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
		die();
	}


	//print_r($configs);
	$stmt = $dbh->prepare("SELECT PlayerID FROM players ORDER BY LastName ASC");
	$stmt->execute();

	$player_db_ids = array();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$player_db_ids[] = $row['PlayerID'];
	}

	$db_count = $stmt->rowCount();

	print $db_count;


	/**
	 * Include Footer
	 */
	include('_includes/footer.php');


?>