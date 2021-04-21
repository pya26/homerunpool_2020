<?php

	/*print_r(__DIR__);
	print "<br />";
	print_r(dirname(__FILE__));
	print "<br />";
    print_r(dirname(__DIR__, 1));
    */

    include('../_config/config.php');
    include('../_config/db_connect.php');
    include('../_includes/functions.php');


	
	$email = "pya2626@gmail.com";

	$mung = get_reg_user_by_email($email);



    print_r($mung->rowCount());

?>




