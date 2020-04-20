<?php
  $stmt = $dbh->prepare("SELECT t.team_id, t.team_name FROM teams t LEFT JOIN league_teams lt ON lt.team_id = t.team_id WHERE t.status_id = 'A' AND lt.league_id = ?  AND lt.season_id = ? AND lt.status_id = 'A'");
  $stmt->bindParam(1, $leagueid, PDO::PARAM_INT, 11);
  $stmt->bindParam(2, $seasonid, PDO::PARAM_INT, 11);
  $stmt->execute();
?>

<div class="container table-responsive-sm">
  <h1>Leader Board</h1>
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
      <?php
        $team_cumulative_month_total = 0;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $teamid = $row['team_id'];

          $team_row = '<tr>';
          $team_row .= '<td>'.$row['team_name'].'</td>';

          $team_row .= '<td>';
            $march_query = $dbh->prepare('CALL get_team_march_total(?,?)');
            $march_query->bindParam(1, $teamid, PDO::PARAM_INT, 11);
            $march_query->bindParam(2, $seasonid, PDO::PARAM_INT, 11);
            $march_query->execute();
            while ($row2 = $march_query->fetch(PDO::FETCH_ASSOC)) {
              $team_row .= $row2['march_total'];
            }
            unset($march_query);
          $team_row .='</td>';

          $team_row .= '<td>';
            $april_query = $dbh->prepare('CALL get_team_april_total(?,?)');
            $april_query->bindParam(1, $teamid, PDO::PARAM_INT, 11);
            $april_query->bindParam(2, $seasonid, PDO::PARAM_INT, 11);
            $april_query->execute();
            while ($row3 = $april_query->fetch(PDO::FETCH_ASSOC)) {
              $team_row .=$row3['april_total'];
            }
            unset($april_query);
          $team_row .= '</td>';

          $team_row .= '<td>';
            $may_query = $dbh->prepare('CALL get_team_may_total(?,?)');
            $may_query->bindParam(1, $teamid, PDO::PARAM_INT, 11);
            $may_query->bindParam(2, $seasonid, PDO::PARAM_INT, 11);
            $may_query->execute();
            while ($row4 = $may_query->fetch(PDO::FETCH_ASSOC)) {
              $team_row .=$row4['may_total'];
            }
            unset($may_query);
          $team_row .= '</td>';

          $team_row .= '<td>';
            $june_query = $dbh->prepare('CALL get_team_june_total(?,?)');
            $june_query->bindParam(1, $teamid, PDO::PARAM_INT, 11);
            $june_query->bindParam(2, $seasonid, PDO::PARAM_INT, 11);
            $june_query->execute();
            while ($row5 = $june_query->fetch(PDO::FETCH_ASSOC)) {
              $team_row .=$row5['june_total'];
            }
            unset($june_query);
          $team_row .= '</td>';

          $team_row .= '<td>';
            $july_query = $dbh->prepare('CALL get_team_july_total(?,?)');
            $july_query->bindParam(1, $teamid, PDO::PARAM_INT, 11);
            $july_query->bindParam(2, $seasonid, PDO::PARAM_INT, 11);
            $july_query->execute();
            while ($row6 = $july_query->fetch(PDO::FETCH_ASSOC)) {
              $team_row .=$row6['july_total'];
            }
            unset($july_query);
          $team_row .= '</td>';

          $team_row .= '<td>';
            $august_query = $dbh->prepare('CALL get_team_august_total(?,?)');
            $august_query->bindParam(1, $teamid, PDO::PARAM_INT, 11);
            $august_query->bindParam(2, $seasonid, PDO::PARAM_INT, 11);
            $august_query->execute();
            while ($row7 = $august_query->fetch(PDO::FETCH_ASSOC)) {
              $team_row .=$row7['august_total'];
            }
            unset($august_query);
          $team_row .= '</td>';

          $team_row .= '<td>';
            $september_query = $dbh->prepare('CALL get_team_september_total(?,?)');
            $september_query->bindParam(1, $teamid, PDO::PARAM_INT, 11);
            $september_query->bindParam(2, $seasonid, PDO::PARAM_INT, 11);
            $september_query->execute();
            while ($row8 = $september_query->fetch(PDO::FETCH_ASSOC)) {
              $team_row .=$row8['september_total'];
            }
            unset($september_query);
          $team_row .= '</td>';

          $team_row .= '<td>';
            $october_query = $dbh->prepare('CALL get_team_october_total(?,?)');
            $october_query->bindParam(1, $teamid, PDO::PARAM_INT, 11);
            $october_query->bindParam(2, $seasonid, PDO::PARAM_INT, 11);
            $october_query->execute();
            while ($row9 = $october_query->fetch(PDO::FETCH_ASSOC)) {
              $team_row .=$row9['october_total'];
            }
            unset($october_query);
          $team_row .= '</td>';

          $team_row .= '<td>';
            $total_query = $dbh->prepare('CALL get_team_cumulative_month_total(?,?,?)');
            $total_query->bindParam(1, $teamid, PDO::PARAM_INT, 11);
            $total_query->bindParam(2, $seasonid, PDO::PARAM_INT, 11);
            $total_query->bindParam(3, $leagueid, PDO::PARAM_INT, 11);
            $total_query->execute();
            while ($row10 = $total_query->fetch(PDO::FETCH_ASSOC)) {
              $team_row .= $row10['team_total'];
            }
            unset($total_query);
          $team_row .= '</td>';

          $team_row .= '</tr>';
          print $team_row;
        }
        unset($stmt);
      ?>
    </tbody>
  </table>
</div>
