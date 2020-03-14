<?php
/*
try {
        include("_config/config.php");
        include("_config/db_connect.php");
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        die();
    }*/

    $leagueid = $GLOBALS['league_id'];
    $seasonid = $GLOBALS['season_id'];

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


    $stmt = $dbh->prepare("SELECT t.team_id, t.team_name FROM teams t LEFT JOIN league_teams lt ON lt.team_id = t.team_id WHERE t.status_id = 'A' AND lt.league_id = $leagueid  AND lt.season_id = $seasonid AND lt.status_id = 'A'");
    $stmt->execute();



    //print_r($team_names);

?>



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
    <!--<h2>Leader Board</h2>-->
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
                $leagueid = 10;
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
            ?>
          </tbody>
        </table>
  </div>

