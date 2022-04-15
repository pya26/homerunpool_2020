<div class="container-fluid px-4">
	<h1 class="mt-4">Seed Monthly Homerun Tables</h1>
	<ol class="breadcrumb mb-4">
	    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
	    <li class="breadcrumb-item active">Seed HR Tables</li>
	</ol>
	<div class="row gx-3 mb-3">	
	    

	
	<div class="row gx-3 mb-3">

	    <!-- 1 column that spans across all 12 grid sections-->
	    <div class="col col-md-3">
	        <div class="p-3 border bg-light">
	        	<?php 
		        	$all_db_players_array = get_all_players();

		        	if(count($all_db_players_array) > 0){

						$seed_hrs_form = '<form id="seed_hrs_form">';
						$seed_hrs_form .= '<label for="select_season">Select a Season</label> ';
						$seed_hrs_form .= season_select_menu() . '<br /><br />';
						$seed_hrs_form .= '<br /><button type="submit" class="btn btn-primary" id="seed_hrs_form_submit">Submit</button></form>';
						
						print $seed_hrs_form;

					} else {
						print "The players table has not been seeded yet. Once it has, you will have the ability to seed the monthly homerun tables";
					}
				?>
	        </div>	        	        
	    </div>

	    <div class="col col-md-9">
	        <div class="p-3 border bg-light">
	        	
				<div class="alert alert-success alert-dismissible d-none" id="seed_hr_tables_success_msg" role="alert">
					The monthly homerun tables have been seeded with all Player IDs. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>

				<div class="alert alert-danger alert-dismissible d-none" id="seed_hr_tables_error_msg" role="alert">
					An error was encountered while seeding the monthly homerun tables. Please review the error logs. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>


				<div class="d-none" id="seed_hr_tables_spinner">
					<strong>Loading...</strong>
					<div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
				</div>

				<div id="hr_table_seed_results"></div>

			</div>	        
	    </div>	    

	</div>

	


	
	<div style="height: 100vh"></div>
</div>