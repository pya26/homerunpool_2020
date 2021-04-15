<?php

    try {
        include("../_config/config.php");
        include("../_includes/header.php");
        include("../_includes/functions.php");
    } catch (PDOException $e) {}

    if(!is_super_user()){
        print "Only the Super User is allowed back here!";
        exit();
    }

?>

<script>
(function($) {
    $(function() {
        window.fs_test = $('.player_ids').fSelect();
    });
})(jQuery);
</script>

<form method="post" id="add_league_team_form" action="add_league_team_process.php" name="add_league_team_form">
    <div class="form-element">
        <label>League</label>
        <?php print leagues_select_menu() ?>
    </div>
    <div class="form-element">
        <label>Team</label>
        <?php
        $teams_select = '<select name="team_id" id="teams"><option value=""></option>';
        foreach (get_all_teams() as $key => $value) {
            $teams_select .= '<option value="';
            $teams_select .= $value['team_id'];
            $teams_select .= '">';
            $teams_select .= $value['team_name'];
            $teams_select .= '</option>';
        }
         $teams_select .= '</select>';
         print $teams_select;
        ?>
    </div>
    <div class="form-element">
        <label>Players</label>
        <select id="player_ids" class="player_ids" name="player_ids[]" multiple="multiple">
          <?php
            foreach (get_all_players() as $key => $value) {
              print '<option value='.$key.'>'.$value.'</option>';
              //print $checkbox = '<input class="player_ids" type="checkbox" name="player_id[]" value="'.$key.'" />' . $value . '<input type="text" name="sort" size="2"/><br />';
            }
          ?>
        </select>

    </div>
    <div class="form-element">
        <label>Seasons</label>
        <?php
        $seasons_select = '<select name="season_id" id="seasons"><option value=""></option>';
        foreach (list_of_seasons() as $key => $value) {
            $seasons_select .= '<option value="';
            $seasons_select .= $value['id'];
            $seasons_select .= '">';
            $seasons_select .= $value['name'];
            $seasons_select .= '</option>';
        }
         $seasons_select .= '</select>';
         print $seasons_select;
        ?>
    </div>
    <div class="form-element">
        <label>Sort</label>

    </div>


    <button type="submit" name="add-league-team" value="Add Players to Team">Add Players to Team</button>
</form>
