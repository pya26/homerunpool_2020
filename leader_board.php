<?php

try {
        include("_config/config.php");
        include("_config/db_connect.php");
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        die();
    }

/*
    print isset($_SESSION['reg_id']) . '<br />';
    print isset($_SESSION['lid']) . '<br />';




    if(!isset($_SESSION['reg_id']) && !isset($_GET['lid'])){
    	$redirect_url = "login.php?redirect=" . $_SERVER['REQUEST_URI'];
      header("Location: ".$redirect_url);
    } elseif (isset($_SESSION['reg_id']) && !isset($_GET['lid'])){
    	header("Location: front_office.php");
    } elseif (!isset($_SESSION['reg_id']) && isset($_GET['lid'])){
    	$redirect_url = "login.php?redirect=" . $_SERVER['REQUEST_URI'];
      header("Location: ".$redirect_url);
    }
    */

    /*
    if(!isset($_GET['lid'])){
      header("Location: login.php");
    }*/


    $stmt = $dbh->prepare("SELECT t.team_id, t.team_name FROM teams t LEFT JOIN league_teams lt ON lt.team_id = t.team_id WHERE t.status_id = 'A' AND lt.league_id = 10 AND lt.season_id = 10 AND lt.status_id = 'A'");
    $stmt->execute();



    //print_r($team_names);

?>

<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />

<h1>Leader Board</h1>

<?php
/*
$league_info = get_league_info($_GET['lid']);

foreach($league_info as $key => $value){

	$league_info_data = 'League Name: ' . $value['league_name'] . '<br />';
	$league_info_data .= 'League Description: ' . $value['league_desc'] . '<br />';
	$league_info_data .= 'Teams Allowed: ' . $value['teams_allowed'] . '<br />';
	$league_info_data .= 'Date Created: ' . date('n/j/Y',strtotime($value['date_created'])) . '<br />';
	$league_info_data .= 'Date Updated: ' . date('n/j/Y',strtotime($value['date_updated'])) . '<br />';
	$league_info_data .= 'Created By: ' . get_registered_user_name($value['created_by']) . '<br />';
	$league_info_data .= 'League Status: ' . get_status_name($value['status_id']) . '<br />';

}
print $league_info_data;
*/
?>
<div class="container table-responsive-sm">
    <h2>Dark Striped Table</h2>
    <p>Combine .table-dark and .table-striped to create a dark, striped table:</p>
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

              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $teamid = $row['team_id'];
                $seasonid = 10;

                $team_row = '<tr>';
                $team_row .= '<td>'.$row['team_name'].'</td>';
                $team_row .= '<td>';

                  $march_query = $dbh->prepare('CALL get_team_march_total(?,?)');
                  $march_query->bindParam(1, $teamid, PDO::PARAM_INT, 11);
                  $march_query->bindParam(2, $seasonid, PDO::PARAM_INT, 11);
                  $march_query->execute();
                  /*
                  $march_query = $dbh->prepare("SELECT SUM(march.total) AS march_total FROM hrs_march march WHERE march.player_id IN ( SELECT ltp.player_id FROM league_team_players ltp WHERE ltp.team_id = $teamid AND ltp.season_id = 10 AND ltp.status_id = 'A') AND march.season_id = 10");
                  $march_query->execute();
                  */
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
                $team_row .= '<td>3</td>';
                $team_row .= '<td>4</td>';
                $team_row .= '<td>5</td>';
                $team_row .= '<td>6</td>';
                $team_row .= '<td>7</td>';
                $team_row .= '<td>8</td>';
                $team_row .= '<td>50</td>';
                $team_row .= '</tr>';
                print $team_row;
              }
            ?>
          </tbody>
        </table>
  </div>



<div class="container table-responsive-sm">
    <h2>Dark Striped Table</h2>
    <p>Combine .table-dark and .table-striped to create a dark, striped table:</p>
    <table id="leaderboard" class="table table-sm table-striped table-hover table-bordered border-primary" style="width:100%">
          <thead>
              <tr>
                  <th>Player</th>
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
              <tr>
                  <td>Tiger Nixon</td>
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
                  <td>Garrett Winters</td>
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
                  <td>Ashton Cox</td>
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
                  <td>Cedric Kelly</td>
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
                  <td>Airi Satou</td>
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
              <tr>
                  <td>Brielle Williamson</td>
                  <td>8</td>
                  <td>7</td>
                  <td>6</td>
                  <td>5</td>
                  <td>4</td>
                  <td>3</td>
                  <td>2</td>
                  <td>1</td>
                  <td>90</td>
              </tr>
              <tr>
                  <td>Herrod Chandler</td>
                  <td>8</td>
                  <td>7</td>
                  <td>6</td>
                  <td>5</td>
                  <td>4</td>
                  <td>3</td>
                  <td>2</td>
                  <td>1</td>
                  <td>95</td>
              </tr>
              <tr>
                  <td>Rhona Davidson</td>
                  <td>8</td>
                  <td>7</td>
                  <td>6</td>
                  <td>5</td>
                  <td>4</td>
                  <td>3</td>
                  <td>2</td>
                  <td>1</td>
                  <td>85</td>
              </tr>
              <tr>
                  <td>Colleen Hurst</td>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                  <td>4</td>
                  <td>5</td>
                  <td>6</td>
                  <td>7</td>
                  <td>8</td>
                  <td>75</td>
              </tr>
              <tr>
                  <td>Sonya Frost</td>
                  <td>8</td>
                  <td>7</td>
                  <td>6</td>
                  <td>5</td>
                  <td>4</td>
                  <td>3</td>
                  <td>2</td>
                  <td>1</td>
                  <td>65</td>
              </tr>
              <tr>
                  <td>Jena Gaines</td>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                  <td>4</td>
                  <td>5</td>
                  <td>6</td>
                  <td>7</td>
                  <td>8</td>
                  <td>55</td>
              </tr>
              <tr>
                  <td>Quinn Flynn</td>
                  <td>8</td>
                  <td>7</td>
                  <td>6</td>
                  <td>5</td>
                  <td>4</td>
                  <td>3</td>
                  <td>2</td>
                  <td>1</td>
                  <td>45</td>
              </tr>
          </tbody>
          <tfoot>
              <tr>
                  <th>Player</th>
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
          </tfoot>
      </table>
  </div>
