<?php
	$team_players = $dbh->prepare("SELECT p.PlayerID, p.FirstName, p.LastName, p.MLBID FROM league_team_players ltp LEFT JOIN players p ON p.PlayerID = ltp.player_id WHERE ltp.league_id = ? AND ltp.season_id = ? AND ltp.status_id = 'A' AND ltp.team_id = {$team_id} ORDER BY ltp.sort ASC");
	$team_players->bindParam(1, $league_id, PDO::PARAM_INT, 11);
    $team_players->bindParam(2, $season_id, PDO::PARAM_INT, 11);
	$team_players->execute();
?>




<table id="team_table" class="table table-striped table-hover table-secondary table-sm" style="width:100%; border-color: #fff;">
	<thead>
		<tr>
			<th>Player</th>
			<th>Mar</th>
			<th>Apr</th>
			<th>May</th>
			<th>June</th>
			<th>July</th>
			<th>Aug</th>
			<th>Sept</th>
		</tr>
	</thead>
	<tbody>
		<?php
			while ($row = $team_players->fetch(PDO::FETCH_ASSOC)) {

				$player_id = $row['PlayerID'];

				$injured_players = get_injured_players($player_id);

				/*$new_arr = array_column($injured_players, 'player_id');

				$mung =  array_search($player_id,$new_arr);
				*/
				
				if($injured_players == 1){
					$player_row = '<tr class="injured_yellow">';
				} else {
					$player_row = '<tr>';
				}
					
					//$mlb_player_slug = strtolower($row['FirstName'].'-'.$row['LastName'].'-'.$row['MLBID'].'?stats=gamelogs-r-hitting-mlb&year=2021');
					if (strpos($row['FirstName'], '.') !== false) {
					   $fname = str_replace(".","-", $row['FirstName']);
					} else {
						$fname = $row['FirstName'] . '-';
					}
					
					//$fname = str_replace(".","-", $row['FirstName']);

					$lname_array_to_search = array(' Jr',' Jr.');
					$lname = str_replace($lname_array_to_search,"-jr", $row['LastName']);
					$lname = str_replace(".","", $lname);
					$lname = str_replace("'","-", $lname);

					//$mlb_player_slug = trim(strtolower($fname.$lname.'-'.$row['MLBID']));//.'?stats=gamelogs-r-hitting-mlb&year=2021'
					
					$mlb_player_slug = $row['MLBID'];
					
					$player_row .= '<td><a href="https://www.mlb.com/player/'.$mlb_player_slug.'" target="_blank">'.$row['FirstName'][0].'. '.$row['LastName'].'</a></td>';

					$player_row .= '<td>';
						$march_player_total = $dbh->prepare('CALL get_player_march_total(?,?)');
						$march_player_total->bindParam(1, $player_id, PDO::PARAM_INT, 11);
						$march_player_total->bindParam(2, $season_id, PDO::PARAM_INT, 11);
						$march_player_total->execute();
						while ($row2 = $march_player_total->fetch(PDO::FETCH_ASSOC)) {
							$player_row .= $row2['march_total'];
						}
						unset($march_player_total);
					$player_row .= '</td>';

					$player_row .= '<td>';
						$april_player_total = $dbh->prepare('CALL get_player_april_total(?,?)');
						$april_player_total->bindParam(1, $player_id, PDO::PARAM_INT, 11);
						$april_player_total->bindParam(2, $season_id, PDO::PARAM_INT, 11);
						$april_player_total->execute();
						while ($row2 = $april_player_total->fetch(PDO::FETCH_ASSOC)) {
							$player_row .= $row2['april_total'];
						}
						unset($april_player_total);
					$player_row .= '</td>';

					$player_row .= '<td>';
						$may_player_total = $dbh->prepare('CALL get_player_may_total(?,?)');
						$may_player_total->bindParam(1, $player_id, PDO::PARAM_INT, 11);
						$may_player_total->bindParam(2, $season_id, PDO::PARAM_INT, 11);
						$may_player_total->execute();
						while ($row2 = $may_player_total->fetch(PDO::FETCH_ASSOC)) {
							$player_row .= $row2['may_total'];
						}
						unset($may_player_total);
					$player_row .= '</td>';

					$player_row .= '<td>';
						$june_player_total = $dbh->prepare('CALL get_player_june_total(?,?)');
						$june_player_total->bindParam(1, $player_id, PDO::PARAM_INT, 11);
						$june_player_total->bindParam(2, $season_id, PDO::PARAM_INT, 11);
						$june_player_total->execute();
						while ($row2 = $june_player_total->fetch(PDO::FETCH_ASSOC)) {
							$player_row .= $row2['june_total'];
						}
						unset($june_player_total);
					$player_row .= '</td>';

					$player_row .= '<td>';
						$july_player_total = $dbh->prepare('CALL get_player_july_total(?,?)');
						$july_player_total->bindParam(1, $player_id, PDO::PARAM_INT, 11);
						$july_player_total->bindParam(2, $season_id, PDO::PARAM_INT, 11);
						$july_player_total->execute();
						while ($row2 = $july_player_total->fetch(PDO::FETCH_ASSOC)) {
							$player_row .= $row2['july_total'];
						}
						unset($july_player_total);
					$player_row .= '</td>';

					$player_row .= '<td>';
						$august_player_total = $dbh->prepare('CALL get_player_august_total(?,?)');
						$august_player_total->bindParam(1, $player_id, PDO::PARAM_INT, 11);
						$august_player_total->bindParam(2, $season_id, PDO::PARAM_INT, 11);
						$august_player_total->execute();
						while ($row2 = $august_player_total->fetch(PDO::FETCH_ASSOC)) {
							$player_row .= $row2['august_total'];
						}
						unset($august_player_total);
					$player_row .= '</td>';

					$player_row .= '<td>';
						$september_player_total = $dbh->prepare('CALL get_player_september_total(?,?)');
						$september_player_total->bindParam(1, $player_id, PDO::PARAM_INT, 11);
						$september_player_total->bindParam(2, $season_id, PDO::PARAM_INT, 11);
						$september_player_total->execute();
						while ($row2 = $september_player_total->fetch(PDO::FETCH_ASSOC)) {
							$player_row .= $row2['september_total'];
						}
						unset($september_player_total);
					$player_row .= '</td>';

				$player_row .= '</tr>';
				print $player_row;
			}


				$team_column_totals = '<tr class="table-primary">';
					$team_column_totals .= '<td>TOTALS</td>';
					$team_column_totals .= '<td>';
						$team_players_march_total = $dbh->prepare('CALL get_team_players_march_total(?,?,?)');
						$team_players_march_total->bindParam(1, $league_id, PDO::PARAM_INT, 11);
						$team_players_march_total->bindParam(2, $team_id, PDO::PARAM_INT, 11);
						$team_players_march_total->bindParam(3, $season_id, PDO::PARAM_INT, 11);
						$team_players_march_total->execute();
						while ($row2 = $team_players_march_total->fetch(PDO::FETCH_ASSOC)) {
							$team_column_totals .= $row2['march_total'];
						}
						unset($team_players_march_total);
					$team_column_totals .= '</td>';

					$team_column_totals .= '<td>';
						$team_players_april_total = $dbh->prepare('CALL get_team_players_april_total(?,?,?)');
						$team_players_april_total->bindParam(1, $league_id, PDO::PARAM_INT, 11);
						$team_players_april_total->bindParam(2, $team_id, PDO::PARAM_INT, 11);
						$team_players_april_total->bindParam(3, $season_id, PDO::PARAM_INT, 11);
						$team_players_april_total->execute();
						while ($row2 = $team_players_april_total->fetch(PDO::FETCH_ASSOC)) {
							$team_column_totals .= $row2['april_total'];
						}
						unset($team_players_april_total);
					$team_column_totals .= '</td>';

					$team_column_totals .= '<td>';
						$team_players_may_total = $dbh->prepare('CALL get_team_players_may_total(?,?,?)');
						$team_players_may_total->bindParam(1, $league_id, PDO::PARAM_INT, 11);
						$team_players_may_total->bindParam(2, $team_id, PDO::PARAM_INT, 11);
						$team_players_may_total->bindParam(3, $season_id, PDO::PARAM_INT, 11);
						$team_players_may_total->execute();
						while ($row2 = $team_players_may_total->fetch(PDO::FETCH_ASSOC)) {
							$team_column_totals .= $row2['may_total'];
						}
						unset($team_players_may_total);
					$team_column_totals .= '</td>';

					$team_column_totals .= '<td>';
						$team_players_june_total = $dbh->prepare('CALL get_team_players_june_total(?,?,?)');
						$team_players_june_total->bindParam(1, $league_id, PDO::PARAM_INT, 11);
						$team_players_june_total->bindParam(2, $team_id, PDO::PARAM_INT, 11);
						$team_players_june_total->bindParam(3, $season_id, PDO::PARAM_INT, 11);
						$team_players_june_total->execute();
						while ($row2 = $team_players_june_total->fetch(PDO::FETCH_ASSOC)) {
							$team_column_totals .= $row2['june_total'];
						}
						unset($team_players_june_total);
					$team_column_totals .= '</td>';

					$team_column_totals .= '<td>';
						$team_players_july_total = $dbh->prepare('CALL get_team_players_july_total(?,?,?)');
						$team_players_july_total->bindParam(1, $league_id, PDO::PARAM_INT, 11);
						$team_players_july_total->bindParam(2, $team_id, PDO::PARAM_INT, 11);
						$team_players_july_total->bindParam(3, $season_id, PDO::PARAM_INT, 11);
						$team_players_july_total->execute();
						while ($row2 = $team_players_july_total->fetch(PDO::FETCH_ASSOC)) {
							$team_column_totals .= $row2['july_total'];
						}
						unset($team_players_july_total);
					$team_column_totals .= '</td>';

					$team_column_totals .= '<td>';
						$team_players_august_total = $dbh->prepare('CALL get_team_players_august_total(?,?,?)');
						$team_players_august_total->bindParam(1, $league_id, PDO::PARAM_INT, 11);
						$team_players_august_total->bindParam(2, $team_id, PDO::PARAM_INT, 11);
						$team_players_august_total->bindParam(3, $season_id, PDO::PARAM_INT, 11);
						$team_players_august_total->execute();
						while ($row2 = $team_players_august_total->fetch(PDO::FETCH_ASSOC)) {
							$team_column_totals .= $row2['august_total'];
						}
						unset($team_players_august_total);
					$team_column_totals .= '</td>';

					$team_column_totals .= '<td>';
						$team_players_september_total = $dbh->prepare('CALL get_team_players_september_total(?,?,?)');
						$team_players_september_total->bindParam(1, $league_id, PDO::PARAM_INT, 11);
						$team_players_september_total->bindParam(2, $team_id, PDO::PARAM_INT, 11);
						$team_players_september_total->bindParam(3, $season_id, PDO::PARAM_INT, 11);
						$team_players_september_total->execute();
						while ($row2 = $team_players_september_total->fetch(PDO::FETCH_ASSOC)) {
							$team_column_totals .= $row2['september_total'];
						}
						unset($team_players_september_total);
					$team_column_totals .= '</td>';

				$team_column_totals .= '</tr>';

				print $team_column_totals;
		?>
	</tbody>
</table>

