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


	$update_token = update_reg_users_token(31);
	
	print_r($update_token);

?>




