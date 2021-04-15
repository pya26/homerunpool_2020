<?php
	/**
	 * Include Header
	 */
    include("../_config/config.php");
	include('../_includes/header.php');
	include("../_includes/functions.php");

    if(!is_super_user()){
        print "Only the Super User is allowed back here!";
        exit();
    }

?>

<style>
	.submenu  {
		display:none;
	}
</style>


<div id="menu_div_1" style="border:solid 1px; width:50%;">Test 1</div>
<div id="sub_menu_div_1" class="submenu">
  This is the paragraph to end all paragraphs.  You
  should feel <em>lucky</em> to have seen such a paragraph in
  your life.  Congratulations!
</div>
<div id="menu_div_2" style="border:solid 1px; width:50%;">Test 2</div>
<div id="sub_menu_div_2" class="submenu">
  This is the paragraph to end all paragraphs.  You
  should feel <em>lucky</em> to have seen such a paragraph in
  your life.  Congratulations!
</div>




<?php

	/**
	 * Include Footer
	 */
	include('../_includes/footer.php');


?>
