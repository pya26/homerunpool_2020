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
                  
                  <h1><?php print $season_name; ?> Season Leader Board</h1>  
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