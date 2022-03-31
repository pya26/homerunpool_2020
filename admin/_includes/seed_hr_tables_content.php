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


						$preload_image = '<div style="max-width: 200px">';
						$preload_image .= '<img src="../images/baseball_loading_2.gif" id="Preloader" style="max-width:100%;display:none;"/>';
						$preload_image .= '</div>';
						print $preload_image;

					} else {
						print "The players table has not been seeded yet. Once it has, you will have the ability to seed the monthly homerun tables";
					}
				?>
	        </div>	        	        
	    </div>

	    <div class="col col-md-9">
	        <div class="p-3 border bg-light">
	        	hi
			</div>	        
	    </div>	    

	</div>

	


	
	<div style="height: 100vh"></div>
</div>