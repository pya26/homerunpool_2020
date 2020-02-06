<?php

  try {
    $configs = include('../_config/config.php');
    include("../_includes/header.php");
    include("../_includes/functions.php");
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
  }



?>


<!--<input id="datepicker" width="276" data-date-format="yymmdd" />-->
<input type="text" id="datepicker">
   


    </body>
</html>
