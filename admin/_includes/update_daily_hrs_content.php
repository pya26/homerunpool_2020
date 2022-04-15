<div class="container-fluid px-4">
	<h1 class="mt-4">Update Daily Homeruns</h1>
	<ol class="breadcrumb mb-4">
	    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
	    <li class="breadcrumb-item active">Update Daily Homeruns</li>
	</ol>
	<div class="row gx-3 mb-3">	
	    

	
	<div class="row gx-3 mb-3">

	    <!-- 1 column that spans across all 12 grid sections-->
	    <div class="col col-md-3">
	        <div class="p-3 border bg-light">	        	
				<label for="date">Enter date of game to update homeruns (YYYYMMDD)</label>
				<input class="datepicker" id="hr_date" data-date-format="yyyymmdd">
				<button type="submit" class="btn btn-primary" id="daily_hr_form_submit">Update HRs</button>				
	        </div>	        	        
	    </div>

	    <div class="col col-md-9">
	        <div class="p-3 border bg-light">
	        	<div class="alert alert-success alert-dismissible fade hide" id="seed_hr_table_success_msg" role="alert"> A simple success alert with. Give it a click if you like. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
	        	<?php
	        		print '<div id="daily_hr_form_results"></div>';
	        	?>
			</div>	        
	    </div>	    

	</div>

	


	
	<div style="height: 100vh"></div>
</div>