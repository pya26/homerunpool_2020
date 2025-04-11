<?php
    $GLOBALS['base_url'] = 'https://www.homerunpool.com/';
	  $GLOBALS['base_path'] = '/home1/homeruo9/public_html';

    include("_config/config.php");
    include("_config/db_connect.php");
    include("_includes/header.php");
    include("_includes/functions.php");

    $active_season = get_active_season();
    
    $GLOBALS["active_season_id"] = $active_season["id"];
    $GLOBALS["active_season_name"] = $active_season["name"];
    $GLOBALS["active_season_start_date"] = $active_season["start_date"];
    $GLOBALS["active_season_end_date"] = $active_season["end_date"];    

    $league_id = $GLOBALS['league_id'];
    $season_id = $GLOBALS["active_season_id"];

    $stmt = $dbh->prepare("SELECT  
                              t.team_id,
                              t.team_name,
                              t.logo_image,
                              ru.first_name AS owner_fname,
                              ru.last_name AS owner_lname,

                              p.PlayerID,
                              p.FirstName,
                              p.LastName,
                              p.PrimaryPosition,

                              CASE 
                                  WHEN mht.month IN ('March', 'April') THEN 'March/April'
                                  ELSE mht.month
                              END AS month_group,

                              CASE 
                                  WHEN mht.month IN ('March', 'April') THEN 3
                                  WHEN mht.month = 'May' THEN 5
                                  WHEN mht.month = 'June' THEN 6
                                  WHEN mht.month = 'July' THEN 7
                                  WHEN mht.month = 'August' THEN 8
                                  WHEN mht.month = 'September' THEN 9
                                  WHEN mht.month = 'October' THEN 10
                              END AS month_order,

                              SUM(mht.total_hrs) AS total_hrs,

                              ip.injury_desc,
                              ip.playing_probability

                            FROM league_teams lt
                            JOIN teams t ON t.team_id = lt.team_id
                            JOIN registered_users ru ON ru.reg_id = t.reg_id
                            JOIN league_team_players ltp ON ltp.team_id = lt.team_id 
                                                        AND ltp.league_id = lt.league_id 
                                                        AND ltp.season_id = lt.season_id
                            JOIN players p ON p.PlayerID = ltp.player_id
                            LEFT JOIN monthly_hr_totals mht ON mht.player_id = p.PlayerID
                                                            AND mht.team_id = lt.team_id
                                                            AND mht.league_id = lt.league_id
                                                            AND mht.season_id = lt.season_id
                            LEFT JOIN injured_players ip ON ip.player_id = p.PlayerID

                            WHERE lt.league_id = 10
                            AND lt.season_id = 22
                            AND mht.month IS NOT NULL

                            GROUP BY 
                            t.team_id,
                            t.team_name,
                            t.logo_image,
                            ru.first_name,
                            ru.last_name,

                            p.PlayerID,
                            p.FirstName,
                            p.LastName,
                            p.PrimaryPosition,

                            ip.injury_desc,
                            ip.playing_probability,

                            lt.sort,
                            ltp.sort,

                            month_group,
                            month_order

                            ORDER BY lt.sort, ltp.sort");
    $stmt->execute();

    $champStmt = $dbh->prepare("
        SELECT team_id, year 
        FROM champions 
        WHERE league_id = :league_id
        ORDER BY year ASC");
    $champStmt->execute(['league_id' => 10]);
    $championships = [];
    
    while ($row = $champStmt->fetch(PDO::FETCH_ASSOC)) {
        $championships[$row['team_id']][] = $row['year'];
    }

    $injuries = [];

    $teams = [];
    $monthDisplayOrder = ['March/April', 'May', 'June', 'July', 'August', 'September'];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        $teamId = $row['team_id'];
        $playerId = $row['PlayerID'];
        $month = $row['month_group'];
        $monthHrs = (int) $row['total_hrs'];
    
        // Initialize team
        if (!isset($teams[$teamId])) {
            $teams[$teamId] = [
                'team_name' => $row['team_name'],
                'logo_image' => $row['logo_image'],
                'owner_name' => $row['owner_fname'] . ' ' . $row['owner_lname'],
                'championship_years' => $championships[$teamId] ?? [],
                'players' => [],
                'team_monthly_totals' => [], // Initialize team totals
            ];

            // Ensure all months exist with 0 values
            foreach ($monthDisplayOrder as $monthName) {
                $teams[$teamId]['team_monthly_totals'][$monthName] = 0;
            }
        }
    
        // Initialize player
        if (!isset($teams[$teamId]['players'][$playerId])) {
            $teams[$teamId]['players'][$playerId] = [
                'name' => substr($row['FirstName'], 0, 1) .'.' . ' ' . $row['LastName'],
                'position' => $row['PrimaryPosition'],
                'injury' => $row['injury_desc'] ?? '',
                'probability' => $row['playing_probability'] ?? '',
                'monthly_hrs' => [],
            ];

            // Initialize ALL months with 0s
            foreach ($monthDisplayOrder as $monthName) {
                $teams[$teamId]['players'][$playerId]['monthly_hrs'][$monthName] = 0;
            }
        }
    
        // Set monthly HRs
        $teams[$teamId]['players'][$playerId]['monthly_hrs'][$month] = $monthHrs;

        // Add to team month total
        $teams[$teamId]['team_monthly_totals'][$month] += $monthHrs;


        if (!empty($row['injury_desc']) && !empty($row['playing_probability'])) {
            $injuries[$playerId] = [
                'player_name' => $row['FirstName'] . ' ' . $row['LastName'],
                'team_name' => $teams[$teamId]['team_name'] ?? '',
                'injury_desc' => $row['injury_desc'],
                'playing_probability' => $row['playing_probability'],
            ];
        }
        
    }


    // Step 1: Clone the teams into a new array
    $leaderboard = array_values($teams); // array_values resets the keys

    // Step 2: Sort it by total season HRs (descending)
    usort($leaderboard, function ($a, $b) {
        $totalA = array_sum($a['team_monthly_totals']);
        $totalB = array_sum($b['team_monthly_totals']);
        return $totalB <=> $totalA;
    });
?>

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

<style>
  th.sortable {
    cursor: pointer;
    position: relative;
  }

  th.sortable::after {
    content: " ▲▼"; /* Display both arrows by default */
    font-size: 0.8em;
    position: absolute;
    right: 5px;
    color: #ccc; /* Light gray to indicate inactive state */
  }

  th.sortable.asc::after {
    content: " ▲"; /* Show only the ascending arrow when sorted */
    color: #ccc; /* Darker color to indicate active state */
  }

  th.sortable.desc::after {
    content: " ▼"; /* Show only the descending arrow when sorted */
    color: #ccc; /* Darker color to indicate active state */
  }
</style>

<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
  <img src="images/swing_transparent_right_sm.png">&nbsp;&nbsp;&nbsp;
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item"><!--active-->
        <!--<a class="nav-link" href="#">About <span class="sr-only">(current)</span></a>-->
      </li>
      <li class="nav-item">
        <!--<a class="nav-link" href="#">FAQs</a>-->
      </li>
      <!--
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
    -->
    </ul>
    <!--<div id="loginDiv">-->
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
        <!--<li class="nav-item"><a class="nav-link" href="#">Front Office</a></li>-->       
      <!--</ul>-->
    <div>
  </div>
</nav>

<!-- style="background: transparent url('images/HRP_TitleGraphic-01.png') no-repeat center center /cover;" -->
<div class="container-fluid h-100 hr_hitter_heads">
  <div class="row align-items-center h-100">
    <div class="col-sm-4 text-center">
      <img src="images/HomeRunPool-03.png" style="max-width:78%;max-height:78%;"><br /> &nbsp; 
    </div>
  </div>
</div>


<div class="jumbotron">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="container table-responsive-sm">
                    <div style="float:right;">
                      Last Updated: <?php print get_last_updated_date($league_id,$season_id);?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

                <div class="container table-responsive-sm">
                  
                  <h1><?php print $GLOBALS["active_season_name"]; ?> Season Leader Board</h1>  
                  <table id="leaderboard" class="table table-sm table-striped table-hover table-bordered border-primary" style="width:100%">
                    <thead>
                      <tr>
                        <th>Team</th>
                          <?php 
                            foreach ($monthDisplayOrder as $month) {
                              print "<th class='sortable' data-month=\"$month\">$month</th>";
                            }
                          ?>
                        <th class="sortable">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($leaderboard as $team) {
                          print "<tr>";
                          print "<td><strong>{$team['team_name']}</strong> ({$team['owner_name']})</td>";

                          $seasonTotal = 0;
                          foreach ($monthDisplayOrder as $month) {
                            $monthTotal = $team['team_monthly_totals'][$month] ?? 0;
                            print "<td>$monthTotal</td>";
                            $seasonTotal += $monthTotal;
                          }

                          print "<td>$seasonTotal</td>";
                          print "</tr>";
                        }  
                      ?>    
                    </tbody>
                  </table>

                </div>

            </div>
        </div>
    </div>
</div>





<div class="container-fluid">


  <?php  

    // Get league teams
    $league_teams = get_active_league_teams($league_id,$season_id);
    // Count how many teams are returned from the get_league_teams query  
    $league_team_count = $league_teams->rowCount();

    $numOfCols = 3;
    $rowCount = 0;
  ?>

    <div class="row">

    <?php
    foreach ($teams as $teamId => $team) {

      $teamInjuries = [];

      foreach ($team['players'] as $player) {
          if (!empty($player['injury'])) {
              $teamInjuries[] = "{$player['name']} -- {$player['injury']} ({$player['probability']})";
          }
      }
        
      print '<div class="col-md-4">';
      print '<div class="container table-responsive-sm">';
      $logo_path = $GLOBALS['base_url'].'images/logos/logoNA.png';
      $logo = "<img src=".$logo_path.">";
      print '<a tabindex="1" data-toggle="popover" id="team_info" data-html="true" data-trigger="focus" title="Team Info" data-placement="bottom" data-content="'.$logo.'"';
      print "<span style='font-size:26px;color:#fff;'>{$team['team_name']}</a> ({$team['owner_name']})</span>";
      
      if (!empty($teamInjuries)) {        
        print '<span class="fa-stack" style="color:#df691a; margin-top:-20px;">';            
        print '<a tabindex="1" data-toggle="popover"  data-html="true" data-trigger="focus" title="Injury Report" data-placement="bottom" data-content="';
          foreach ($teamInjuries as $injuryText) {
            print $injuryText . '<br>';
          }
        print'">&nbsp;<i class="fa fa-ambulance"></i></a>';   
        print '</span>';
      }  
           
        
        
        if (!empty($team['championship_years'])) {
            foreach ($team['championship_years'] as $year) {
                $trophy_row = '<span class="fa-stack" style="color:#df691a; margin-top:-20px;">';
                $trophy_row .= '<i class="fa fa-trophy fa-stack-2x"></i>';
                $trophy_row .= '<span class="fa fa-stack-1x">';
                $trophy_row .= '<span style="font-size:12px; color:#fff; margin-top:-7px; display:block;">';
                $trophy_row .= " $year ";
                $trophy_row .= '</span>';
                $trophy_row .= '</span>';
                $trophy_row .= '</span>';
              
              print $trophy_row;
            }
        }

        $team_table = '<table id="team_table" class="table table-striped table-hover table-secondary table-sm" style="width:100%; border-color: #fff;">';
        $team_table .= '<thead>';
        $team_table .= '<tr>';
        $team_table .= '<th>Player</th>';
        $team_table .= '<th>Mar/April</th>';
        $team_table .= '<th>May</th>';
        $team_table .= '<th>June</th>';
        $team_table .= '<th>July</th>';
        $team_table .= '<th>Aug</th>';
        $team_table .= '<th>Sept</th>';
        $team_table .= '</tr>';
        $team_table .= '</thead>';
        $team_table .= '<tbody>';
        foreach ($team['players'] as $playerId => $player) {

            $isInjured = !empty($player['injury']);
            
            $team_table .= $isInjured ? "<tr class='injured_yellow'>" : '<tr>';
            $team_table .= '<td>'.$player['name'].'</td>';            
            foreach ($player['monthly_hrs'] as $month => $hrs) {
                $team_table .= '<td>'.$hrs.'</td>';
            }
            $team_table .= '</tr>';
        }
        $team_table .= '<tr class="table-primary">';
        $team_table .= '<td>TOTALS</td>';
        $seasonTotal = 0;
        foreach ($monthDisplayOrder as $month) {
            $monthTotal = $team['team_monthly_totals'][$month];
            $team_table .= "<td>$monthTotal</td>";
            $seasonTotal += $monthTotal;
        }
       
        $team_table .= '</tr>';        
        $team_table .= '</tbody>';
        $team_table .= '</table>';

        print $team_table;

        print '</div>';
        print '</div>';

        $rowCount++;

        if($rowCount % $numOfCols == 0) {
          print '</div><div class="row">';
        }
        
      }
    ?>

    </div>
</div>




      <script>
        document.addEventListener("DOMContentLoaded", function () {
          const table = document.getElementById("leaderboard");

          // Add click event to each sortable column header
          table.querySelectorAll("th.sortable").forEach(header => {
            header.addEventListener("click", function () {
              const columnIndex = header.cellIndex; // Get the index of the clicked column
              const tbody = table.querySelector("tbody");
              const rows = Array.from(tbody.querySelectorAll("tr"));

              // Determine the current sort direction
              const isAscending = header.classList.contains("asc");
              table.querySelectorAll("th.sortable").forEach(th => th.classList.remove("asc", "desc")); // Reset classes
              header.classList.toggle("asc", !isAscending);
              header.classList.toggle("desc", isAscending);

              // Sort rows based on the column's numeric values
              rows.sort((a, b) => {
                const valA = parseFloat(a.cells[columnIndex]?.textContent.trim()) || 0;
                const valB = parseFloat(b.cells[columnIndex]?.textContent.trim()) || 0;
                return isAscending ? valA - valB : valB - valA; // Ascending or descending
              });

              // Append sorted rows back to the table body
              rows.forEach(row => tbody.appendChild(row));
            });
          });
        });
      </script>
  </body>
</html>


