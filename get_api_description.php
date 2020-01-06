<?php

  $api_id = $_GET['api_id'];

  /* Connect to a MySQL database using driver invocation */
  try { 
    include("_includes/functions.php");   
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
  }


  echo json_encode(get_api_and_params($api_id));
  

?>