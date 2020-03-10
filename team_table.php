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
	$team_players = $dbh->prepare("SELECT p.FirstName, p.LastName FROM league_team_players ltp LEFT JOIN players p ON p.PlayerID = ltp.player_id WHERE ltp.league_id = 10 AND ltp.season_id = 10 AND ltp.status_id = 'A' AND ltp.team_id = {$team_id} ORDER BY ltp.sort ASC");
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
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
		<?php	
			while ($row = $team_players->fetch(PDO::FETCH_ASSOC)) {
				$player_row = '<tr>';
				$player_row .= '<td>'.$row['FirstName'].' '.$row['LastName'].'</td>';
				$player_row .= '<td>2</td>';
				$player_row .= '<td>3</td>';
				$player_row .= '<td>4</td>';
				$player_row .= '<td>5</td>';
				$player_row .= '<td>6</td>';
				$player_row .= '<td>7</td>';
				$player_row .= '<td>50</td>';
				$player_row .= '</tr>';
				print $player_row;
			}
		?>
			<!--
			<tr>
				<td>Carl Yastrzemski</td>
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
				<td>5</td>
				<td>6</td>
				<td>7</td>
				<td>8</td>
				<td>50</td>
			</tr>
			<tr>
				<td>Fred Lynn</td>
				<td>8</td>
				<td>7</td>
				<td>6</td>
				<td>5</td>
				<td>4</td>
				<td>3</td>
				<td>2</td>
				<td>1</td>
				<td>40</td>
			</tr>
			<tr>
				<td>Dwight Evans</td>
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
				<td>5</td>
				<td>6</td>
				<td>7</td>
				<td>8</td>
				<td>30</td>
			</tr>
			<tr>
				<td>Jim Rice</td>
				<td>8</td>
				<td>7</td>
				<td>6</td>
				<td>5</td>
				<td>4</td>
				<td>3</td>
				<td>2</td>
				<td>1</td>
				<td>20</td>
			</tr>
			<tr>
				<td>Mike Greenwell</td>
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
				<td>5</td>
				<td>6</td>
				<td>7</td>
				<td>8</td>
				<td>10</td>
			</tr>
			-->
		</tbody>
    </table>
<!--</div>-->