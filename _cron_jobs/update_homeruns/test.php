<?php

try {
		include("../_config/_config.php");
		include("../_config/_db_config.php");
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}


$mung = get_season_id26('2021-regular');

print_r($mung);

function get_season_id26($season){
/*
		try {
			$configs = include("../_config/config.php");
    		include("../_config/db_connect.php");
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}*/
		$dbh = $GLOBALS['dbh'];

		/*$stmt = $dbh->prepare('CALL sp_get_season_id_by_name(?)');
		$stmt->bindParam(1, $season, PDO::PARAM_STR, 15);
		$stmt->execute();*/
		$stmt = $dbh->prepare('SELECT id FROM lkp_seasons WHERE slug = ?');
		$stmt->bindParam(1, $season, PDO::PARAM_STR, 15);
		$stmt->execute();
		


		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$id = $row['id'];
		}

		if($id > 0){
			return $id;
		} else {
			return 0;
		}

	}


?>