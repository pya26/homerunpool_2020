<?php
// filepath: /c:/wamp64/www/sandbox/homerunpool_2020/refactored_index.php

include("_config/config.php");
include("_config/db_connect.php");
include("_includes/header.php");
include("_includes/functions.php");

try {
    $active_season = get_active_season();
    $GLOBALS["active_season_id"] = $active_season["id"];
    $GLOBALS["active_season_name"] = $active_season["name"];
    $GLOBALS["active_season_start_date"] = $active_season["start_date"];
    $GLOBALS["active_season_end_date"] = $active_season["end_date"];
    $league_id = $GLOBALS['league_id'];
    $season_id = $GLOBALS["active_season_id"];

    $league_teams = get_active_league_teams($league_id, $season_id);
    $league_team_count = $league_teams->rowCount();
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

function get_team_info($league_id, $season_id, $team_id) {
    $injury_query = get_league_team_players($league_id, $season_id, $team_id);
    $injuries = [];
    while ($row = $injury_query->fetch(PDO::FETCH_ASSOC)) {
        $injuries[] = $row;
    }

    $champ_query = get_champions($team_id, $league_id);
    $champions = [];
    while ($row = $champ_query->fetch(PDO::FETCH_ASSOC)) {
        $champions[] = $row;
    }

    return ['injuries' => $injuries, 'champions' => $champions];
}

?>

<script>
$(document).ready(function() {
    $('#leaderboard').DataTable({
        searching: false,
        paging: false,
        info: false,
        order: [[9, "desc"]]
    });
});
</script>

<div class="container-fluid">
    <div class="row">
        <?php
        $numOfCols = 3;
        $rowCount = 0;

        while ($row = $league_teams->fetch(PDO::FETCH_ASSOC)) {
            $team_info = get_team_info($league_id, $season_id, $row['team_id']);
            $logo_path = strlen(trim($row['logo_image'])) > 0 ? 'http://localhost/sandbox/homerunpool_2020/images/logos/' . $row['logo_image'] : $GLOBALS['base_url'] . 'images/logos/logoNA.png';
            $logo = "<img src='" . $logo_path . "'>";

            echo '<div class="col-md-4">';
            echo '<div class="container table-responsive-sm">';
            echo '<a tabindex="1" data-toggle="popover" id="team_info" data-html="true" data-trigger="focus" title="Team Info" data-placement="bottom" data-content="' . $logo . '">';
            echo '<span style="font-size:26px;color:#fff;">' . $row['team_name'] . '</span></a>';

            if (count($team_info['injuries']) > 0) {
                echo '<span class="fa-stack" style="color:#df691a; margin-top:-20px;">';
                echo '<a tabindex="1" data-toggle="popover" data-html="true" data-trigger="focus" title="Injury Report" data-placement="bottom" data-content="';
                foreach ($team_info['injuries'] as $injury) {
                    echo $injury['FirstName'] . ' ' . $injury['LastName'] . '&nbsp;&nbsp;&nbsp;' . $injury['playing_probability'] . '&nbsp;&nbsp;&nbsp;(' . $injury['injury_desc'] . ')<br />';
                }
                echo '">&nbsp;<i class="fa fa-ambulance"></i></a></span>';
            }

            foreach ($team_info['champions'] as $champion) {
                echo '<span class="fa-stack" style="color:#df691a; margin-top:-20px;">';
                echo '<i class="fa fa-trophy fa-stack-2x"></i>';
                echo '<span class="fa fa-stack-1x">';
                echo '<span style="font-size:12px; color:#fff; margin-top:-7px; display:block;">' . $champion['year'] . '</span>';
                echo '</span></span>';
            }

            echo ' (' . $row['first_name'] . ' ' . $row['last_name'] . ')';
            include('team_table.php');
            echo '</div></div>';

            $rowCount++;
            if ($rowCount % $numOfCols == 0) {
                echo '</div><div class="row">';
            }
        }
        unset($league_teams);
        ?>
    </div>
</div>

<?php include("_includes/footer.php"); ?>