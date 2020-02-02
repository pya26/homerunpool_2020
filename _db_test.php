<?php

$configs = array(
      'db_host' => 'localhost',
      'db_user' => 'root',
      'db_password' => '',
      'db_name' => 'homerunpool',
      'msf_apikey_token' => '3e610f3c-19bb-400c-b0b6-887575',
      'msf_password' => 'MYSPORTSFEEDS',
      'msf_api_v2_base_url' => 'https://api.mysportsfeeds.com/v2.1/pull/mlb/',
      'base_url' => 'http://localhost/sandbox/homerunpool_2020/',
  );

$dbname = $configs['db_name'];
$dbhost = $configs['db_host'];
$dbuser = $configs['db_user'];
$dbpassword = $configs['db_password'];
$dsn = 'mysql:dbname=' . $dbname .';host=' . $dbhost .';';



$dbh = new PDO($dsn, $dbuser, $dbpassword,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$email = "kphillips@entnet.org";
$query = $dbh->prepare("SELECT * FROM registered_users WHERE email=:email AND status_id = 'A'");
$query->bindParam("email", $email, PDO::PARAM_STR);
$query->execute();

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
  $name = $row['first_name'] . ' ' . $row['last_name'];
}



print_r($name);




?>
