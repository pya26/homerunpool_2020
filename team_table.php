<!--<div class="container table-responsive-sm">
    <h2>Team Name</h2>-->
<!--
	<span class="fa-stack fa-2x">
		<i class="fa fa-trophy fa-stack-2x" style="color:#df691a;"></i>
			<span class="fa fa-stack-1x" style="color:#fff;">
				<span style="font-size:16px; margin-top:-20px; display:block;">
					2009
				</span>
			</span>
	</span>
-->
<?php
	$team_id = $row['team_id'];
	$team_players = $dbh->prepare("SELECT p.PlayerID, p.FirstName, p.LastName FROM league_team_players ltp LEFT JOIN players p ON p.PlayerID = ltp.player_id WHERE ltp.league_id = 10 AND ltp.season_id = 10 AND ltp.status_id = 'A' AND ltp.team_id = {$team_id} ORDER BY ltp.sort ASC");
	$team_players->execute();
?>


	  
    <table id="team_table" class="table table-striped table-hover table-secondary table-sm" style="width:100%; border-color: #fff;">
		<thead>
			<tr>
				<th>Player</th>
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

				$player_row = '<tr>';
				$player_row .= '<td>'.$row['FirstName'].' '.$row['LastName'].'</td>';
				$player_row .= '<td>';

				$march_player_total = $dbh->prepare('CALL get_player_march_total(?,?)');
				$march_player_total->bindParam(1, $player_id, PDO::PARAM_INT, 11);
				$march_player_total->bindParam(2, $seasonid, PDO::PARAM_INT, 11);
				$march_player_total->execute();                  
				while ($row2 = $march_player_total->fetch(PDO::FETCH_ASSOC)) {
					$player_row .= $row2['march_total'];
				}
				unset($march_query);
				
				$player_row .= '</td>';
				$player_row .= '<td>3</td>';
				$player_row .= '<td>4</td>';
				$player_row .= '<td>5</td>';
				$player_row .= '<td>6</td>';
				$player_row .= '<td>7</td>';
				$player_row .= '</tr>';
				print $player_row;
			}
		?>
		<tr>
			<td>TOTAL</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
			
		</tbody>
    </table>
<!--</div>-->