<?php

	$dbname = $GLOBALS['db_name'];
	$dbhost = $GLOBALS['db_host'];
	$dbuser = $GLOBALS['db_user'];
	$dbpassword = $GLOBALS['db_password'];

	$dsn = 'mysql:dbname=' . $dbname .';host=' . $dbhost .';';

	$dbh = new PDO($dsn, $dbuser, $dbpassword,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

?>