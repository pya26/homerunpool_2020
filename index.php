<?php
	/**
	 * Include Header
	 */
	include('_includes/header.php');

?>	

<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />
Home page <br /><br />

Date: <input id="date" type="text"/>

 <script type="text/javascript">
	$(document).ready(function(){
		//$("#date").datepicker();
		//$("#date").datepicker("setDate", new Date());
		$("#date").datepicker({			
			dateFormat: 'yymmdd',
			minDate: new Date()
		});
		
	    $("#date").datepicker( "option", "showAnim", "slideDown" );
	    
	});
</script>


<?php

	/**
	 * Include Footer
	 */
	include('_includes/footer.php');


?>