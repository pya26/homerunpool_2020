<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Bootstrap - Prebuilt Layout</title>
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
			<link rel="stylesheet" href="css/styles.css">

			<script>
				$(document).ready(function() {

				$('#leaderboard').DataTable({
					searching: false,
					paging: false,
					info: false,
					order: [[ 9, "desc" ]]
				});

				});
			</script>

		</head>

		<body>

			<?php
				include("_config/config.php");
				include("_config/db_connect.php");
				include("_includes/functions.php");
				/**
			     * Set active season variables
			     */
			    $active_season = get_active_season();
			    
			    $GLOBALS["active_season_id"] = $active_season["id"];
			    $GLOBALS["active_season_name"] = $active_season["name"];
			    $GLOBALS["active_season_start_date"] = $active_season["start_date"];
			    $GLOBALS["active_season_end_date"] = $active_season["end_date"];    

			    $league_id = $GLOBALS['league_id'];
			    $season_id = $GLOBALS["active_season_id"];
			?>			

			<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
				<img src="images/swing_transparent_right_sm.png">&nbsp;&nbsp;&nbsp;
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarNav">		
					<ul class="navbar-nav ml-auto">
						<?php        
							if(is_logged_in()){
								print '<li class="nav-item"><a class="nav-link" href="#">Hello ' . $_SESSION['firstname'] . '!</a></li>';
								print '<li class="nav-item"><a class="nav-link" href="' . $GLOBALS['base_url'] . 'admin/index.php">Front Office</a></li>';
								print '<li class="nav-item"><a class="nav-link" href="logout.php">Logout <i class="fas fa-sign-out-alt"></i></a></li>';            
							} else {
								print '<li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#LogInModal">Login <i class="fas fa-sign-in-alt"></i></a></li>';
							}        
						?> 
					</ul>
				<div>
			</nav>

			<!-- style="background: transparent url('images/HRP_TitleGraphic-01.png') no-repeat center center /cover;" -->
			<div class="container-fluid h-100 hr_hitter_heads">
				<div class="row align-items-center h-100">
					<div class="col-sm-4 text-center">
						<img src="images/HomeRunPool-03.png" width="" height="" style="max-width:78%;max-height:78%;"><br /> &nbsp; 
					</div>
				</div>
			</div>

			<div class="jumbotron">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-12">
							<!-- include leader board
							<?php								

								$stmt = $dbh->prepare("SELECT t.team_id, t.team_name FROM teams t LEFT JOIN league_teams lt ON lt.team_id = t.team_id WHERE t.status_id = 'A' AND lt.league_id = ?  AND lt.season_id = ? AND lt.status_id = 'A'");
								$stmt->bindParam(1, $league_id, PDO::PARAM_INT, 11);
								$stmt->bindParam(2, $season_id, PDO::PARAM_INT, 11);
								$stmt->execute();

							?>-->


							<div class="container table-responsive-sm">
								<h1><?php print $GLOBALS["active_season_name"]; ?> Season Leader Board</h1>  
								<table id="leaderboard" class="table table-sm table-striped table-hover table-bordered border-primary" style="width:100%">
									<thead>
										<tr>
											<th>Team</th>
											<th>March</th>
											<th>April</th>
											<th>May</th>
											<th>June</th>
											<th>July</th>
											<th>August</th>
											<th>September</th>
											<th>October</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<!--<?php
											while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {										
												$team_row = '<tr>';
													$team_row .= '<td>'.$row["team_name"].'</td>';
													$team_row .= '<td></td>';
													$team_row .= '<td></td>';
													$team_row .= '<td></td>';
													$team_row .= '<td></td>';
													$team_row .= '<td></td>';
													$team_row .= '<td></td>';
													$team_row .= '<td></td>';
													$team_row .= '<td></td>';
													$team_row .= '<td></td>';									
												$team_row .= '</tr>';
												print $team_row;
											}
										?>-->
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Team</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>

									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>


			



			<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
		    <script src="js/jquery.min.js"></script>
		    <!-- Include all compiled plugins (below), or include individual files as needed --> 
		   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		</body>
	</html>