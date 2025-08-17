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
            $team_table .= '<td><a href="https://www.mlb.com/player/'.$player['mlb_url'].'" target="_blank">'.$player['name'].'</a></td>';            
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