<?php

	$url_vars_set = 0;
	$team_league_row_div_class = 'row gx-3 mb-3 d-none';
	$league_id = 0;
	$season_id = 0;
	$url_team_id = 0;
	if(isset($_GET["team_id"])){ 
		$url_team_id = $_GET["team_id"];
	}
	
	if(isset($_GET["league_id"]) && isset($_GET["season_id"]) && isset($_GET["class"])){
		$url_vars_set = 1;
		$league_id = $_GET["league_id"];
		$season_id = $_GET["season_id"];
		$class = $_GET["class"];
		$team_league_row_div_class = 'row gx-3 mb-3';
	}
	
?>
<div class="container-fluid px-4">
	<h1 class="mt-4">Set Team Players</h1>
	<ol class="breadcrumb mb-4">
	    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
	    <li class="breadcrumb-item active">Set Team Players</li>
	</ol>
	<div class="row gx-3 mb-3">
		
	    <!-- 1 column that spans across all 12 grid sections-->
	    <div class="col col-md-12">	        
	        <div class="p-3 border bg-light"> 
	        <h5 class="text-success">Set league and season to edit for the draft</h5>	        	    
				<form class="row g-3 needs-validation bg-light" id="agetLeagueSeasonForm" novalidate>					
					<div class="col-md-3">
						<?php $leagues = get_leagues(); ?>
						<label for="validationLeague" class="form-label h6">League</label>
						<select class="form-select" id="validationLeague">
							<option selected value="">Choose...</option> 
						<?php
							foreach ($leagues as $key => $value) {
								if($value["league_id"] == $league_id){
									print '<option value="'.$value["league_id"].'" selected>'.$value["league_name"].'</option>';
								} else {
									print '<option value="'.$value["league_id"].'">'.$value["league_name"].'</option>';
								}
							}
						?>             
						</select>
					</div>

					<div class="col-md-3">
						<?php $seasons = list_of_seasons(); ?>
						<label for="validationSeason" class="form-label h6">Season</label>
						<select class="form-select" id="validationSeason">
							<option selected value="">Choose...</option>
							<?php
								foreach ($seasons as $key => $value) {
									if($value["id"] == $season_id){
										print '<option value="'.$value["id"].'" selected>'.$value["name"].'</option>';
									} else {
										print '<option value="'.$value["id"].'">'.$value["name"].'</option>';
									}
								}
							?>             
						</select>
					</div>

					<div class="col-md-3 pt-4">						
						<button type="submit" class="btn btn-primary" id="add_league_season_draft">Submit</button>
					</div>					
				</form>
			</div>
		</div>
	</div>

	
	<?php print '<div class="'.$team_league_row_div_class.'" id="add_teams_to_league_div">'; ?>

	    <!-- 1 column that spans across all 12 grid sections-->
	    <div class="col col-md-3">
	        <div class="p-3 border bg-light">
	        	<h5 class="text-success">Add teams to league</h5>	<!-- -->  
	        	<form class="row g-3 needs-validation bg-light" id="addLeagueTeamsForm" novalidate>  
		        	<input type="hidden" name="league_id" id="league_id" value="<?php print $league_id; ?>">
		        	<input type="hidden" name="season_id" id="season_id" value="<?php print $season_id; ?>">
		        	
	        	    
					<select class="form-select" size="10" multiple aria-label="multiple select" id="validationTeams">
						<option selected>Select teams...</option>
						<?php
							$teams = get_all_teams_users();
							foreach ($teams as $key => $value) {
								print '<option value="'.$value["team_id"].'">'.$value["team_name"].' ('.$value["first_name"].' '.$value["last_name"].')</option>';
							}
						?>
					</select>
					<button type="submit" class="btn btn-primary mt-3" id="add_league_teams_draft">Submit</button>	
				</form>	



				<?php
					$player_list = get_all_players();
	        		print '<h5 class="text-success mt-5">Add players to team</h5>';
	        		print '<label for="playerListDraft" class="form-label text-primary">Find player</label>';
					print '<input class="form-control" list="playerlistOptions" id="playerListDraft" size="10" placeholder="Type to search for player...">';
					print '<datalist id="playerlistOptions">';
					foreach ($player_list as $key3 => $value3) {
						print '<option data-value='.$key3.' value="'.$value3.'">';
					}															
					print '</datalist><br />';
																		
					$draft_order_array = array(1 => '1',2 => '2',3 => '3',4 => '4',5 => '5',6 => '6');
					print '<label for="" class="form-label text-primary">Draft round</label>';
					print '<select class="form-select" id="playerDraftOrder">';
					print '<option selected>Select draft round</option>';
					foreach ($draft_order_array as $key4 => $value4) {
						print '<option value="'.$key4.'">'.$value4.'</option>';
					}														
					print '</select><br />';

					print '<label for="" class="form-label text-primary">Team</label>';
					print '<select class="form-select" id="team_id">';
					print '<option selected>Select team...</option>';	
						
						foreach ($teams as $key5 => $value5) {
							if($url_team_id == $value5["team_id"]){
								print '<option selected value="'.$value5["team_id"].'">'.$value5["team_name"].' ('.$value5["first_name"].' '.$value5["last_name"].')</option>';
							} else {
								print '<option value="'.$value5["team_id"].'">'.$value5["team_name"].' ('.$value5["first_name"].' '.$value5["last_name"].')</option>';
							}
						}
						
					print '</select><br />';

					print '<a href="" class="btn btn-primary" role="button" id="addDraftedPlayer">Add player to team</a>';
        			
        		?>	
	        </div>	        	        
	    </div>

	    <div class="col col-md-9">
	        <div class="p-3 border bg-light">
	        	
				<?php

	        		if($league_id > 0 && $season_id > 0){
	        			$league_name = get_leagues_by_id($league_id);
	        			$season_name = get_seasons_by_id($season_id);
	        			
	        			foreach ($season_name as $key => $value) {
	        				$display_season_name = $value["season_name"];	        				
	        			}
	        			
	        			foreach ($league_name as $key => $value) {
	        				$display_league_name = $value["league_name"];	        				
	        			}	        			

		        		$league_teams = get_all_league_teams($league_id,$season_id);        		 
		        		$num_teams = count($league_teams);

		        		$str = "&#8212";//&mdash htmlentities($str)
		        		print '<h4 class="text-success mb-3">'.$display_league_name . ' &mdash; ' . $display_season_name.' Season</h4>';

		        		

		        		if($num_teams > 0){
			        		print '<div class="container">';
								print '<div class="row">';
					        		foreach ($league_teams as $key => $value) {

					        			$team_players = get_league_team_players_draft($league_id,$season_id,$value["team_id"]);
		    							$num_team_players = count($team_players);

		    							if($num_team_players == 0){
		    								$delete_team_button = '<a href="delete_league_team_process.php?lt_id='.$value["league_teams_id"].'&league_id='.$league_id.'&season_id='.$season_id.'&class=0" class="btn btn-danger btn-sm" role="button">Delete team</a>';
		    							} else {
		    								$delete_team_button = '';
		    							}

					        			print '<div class="col-sm-4">';
					        			
					        				print '<table class="table table-striped table-hover border border-5">';
					        					print '<thead>';
													print '<tr>';      
														print '<th colspan="3"><span class="text-primary">'. $value["team_name"] .'</span></th>';
														print '<th style="text-align:right;">'.$delete_team_button.'</th>';
													print '</tr>';
													print '<tr>';      
														print '<td colspan="3">(';
															print $value["first_name"].' '.$value["last_name"] .')';
														print '</td>';
														print '<td style="text-align:right;">';
														print '<form action="edit_team_sort_process.php" method="POST">';
														print '<input type="hidden" name="league_teams_id" value="'.$value["league_teams_id"].'">';
														print '<input type="hidden" name="league_id" value="'.$league_id.'">';
														print '<input type="hidden" name="season_id" value="'.$season_id.'">';
															print '<select data-size="2" class="selectpicker" name="sort" id="team_sort">';																
																for ($x = 1; $x <= $num_teams; $x++) {
																	if($x == $value["sort"]){
																  		print '<option value="'.$x.'" selected>'.$x.'</option>';
																  	} else {
																  		print '<option value="'.$x.'">'.$x.'</option>';
																  	}
																}
															print '</select>';
															print '<input type="submit" value="Save order" class="btn btn-primary btn-sm">';
															//print '&nbsp;&nbsp;&nbsp;<a href="edit_team_sort_process.php?lt_id='.$value["league_teams_id"].'&league_id='.$league_id.'&season_id='.$season_id.'&class=0" class="btn btn-primary btn-sm btn-sm-kp" role="button">Save Order</a>';
														print '</form>';
														print '</td>';
													print '</tr>';
												print '</thead>';
												print '<tbody>';		    							
		    									
		    									

		    									if($num_team_players > 0){	    										
		    										
						    							foreach ($team_players as $key2 => $value2) {
															print '<tr>';
																print '<td>';
																	print $value2["FirstName"].' '.$value2["LastName"];																
																print '</td>';
																print '<td>&nbsp;&nbsp;</td>';
																print '<td>&nbsp;&nbsp;</td>';																
																print '<td style="text-align:right;">';														
																	print '<a href="delete_league_team_player_process.php?ltp_id='.$value2["league_team_player_id"].'&league_id='.$league_id.'&season_id='.$season_id.'&class=0" class="btn btn-outline-danger btn-sm" data-id="'.$value2["league_team_player_id"].'" id="deleteTeamPlayer" role="button">Delete player</a>';
																print '</td>';
															print '</tr>';
						    							}
						    						
				    							} else {
				    								print '<tr>';
														print '<td colspan="4">';
															print 'No players have been added to this team.';
														print '</td>';
													print '</tr>';
				    							}
					        				print '</table>';
					        			print '</div>';
					        			
									}
								print '</div>';
							print '</div>';
						} else {
							print "No teams have been added to this league yet.";
						}
					}
	        	?>		
				

	        </div>	        
	    </div>	    

	</div>

	


	
	<div style="height: 100vh"></div>
</div>