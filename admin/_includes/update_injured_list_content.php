<div class="container-fluid px-4">
	<h1 class="mt-4">Update Injured List</h1>
	<ol class="breadcrumb mb-4">
	    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
	    <li class="breadcrumb-item active">Update Injured List</li>
	</ol>
	<div class="row gx-3 mb-3">	
	    

	
	<div class="row gx-3 mb-3">

	    <!-- 1 column that spans across all 12 grid sections-->
	    <div class="col col-md-3">
	        <div class="p-3 border bg-light">
	        	<button type="submit" class="btn btn-primary" id="update_il_form_submit">Update IL</button>
	        </div>	        	        
	    </div>

	    <div class="col col-md-9">
	        <div class="p-3 border bg-light">
	        	
	        	<div class="alert alert-success alert-dismissible d-none" id="update_il_process_success_msg" role="alert">
	        		The Player's Injured List was successfully updated. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	        	</div>

	        	<div class="alert alert-danger alert-dismissible d-none" id="update_il_process_error_msg" role="alert">
				  An error was encountered while updating the Player's Injured List. Please review the error logs. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>

				
				<div class="d-none" id="il_spinner">
				  <strong>Loading...</strong>
				  <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
				</div>

				<div id="ir_list_results"></div>

			</div>	        
	    </div>	    

	</div>

	


	
	<div style="height: 100vh"></div>
</div>