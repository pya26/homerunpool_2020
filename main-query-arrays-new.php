<?php
/**
   * Main query to get all teams in the league, all players for each team, and all their homeruns.
   * This query is also used to build the leaderboard.
   */
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

                          WHERE lt.league_id = :league_id
                          AND lt.season_id = :season_id
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
  $stmt->execute(['league_id' => $league_id, 'season_id' => $season_id]);
  
  // Query to get all past championships for the league
  $champStmt = $dbh->prepare("
      SELECT team_id, year 
      FROM champions 
      WHERE league_id = :league_id
      ORDER BY year ASC");
  $champStmt->execute(['league_id' => $league_id]);
  $championships = [];
  
  // Build the array of all championships for each team
  while ($row = $champStmt->fetch(PDO::FETCH_ASSOC)) {
      $championships[$row['team_id']][] = $row['year'];
  }

  // Instantiate the injuries array
  $injuries = [];

  // Instantiate the teams array
  $teams = [];
  // Initialize the month display order. This is used to ensure the months are displayed in the correct order in the table 
  $monthDisplayOrder = ['March/April', 'May', 'June', 'July', 'August', 'September'];

  /**
   * Loop through the results and build the teams array
   * The teams array will be used to build the leaderboard and the team tables
   */
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

  /**
   * For sorting the leaderboard...
   * 
   * Step 1: Reset the keys of the teams array to be sequential integers. This is important for the usort function to work correctly 
   * because it relies on the keys being sequential integers.
   * 
   * Step 2: Sort it (using usort()) by total season HRs (descending)
   */
  $leaderboard = array_values($teams); // array_values resets the keys

  usort($leaderboard, function ($a, $b) {
    $totalA = array_sum($a['team_monthly_totals']);
    $totalB = array_sum($b['team_monthly_totals']);
    return $totalB <=> $totalA;
  });
?>