
<?php

  try {
    include("../_config/config.php");
    include("../_includes/header.php");
    include("../_config/db_connect.php");
    include("../_includes/functions.php");
  } catch (PDOException $e) {}


  $league_id = $_POST['league_id'];
  $team_id = $_POST['team_id'];
  $season_id = $_POST['season_id'];
  $status_id = 'A';


  $sort_order = 1;
  foreach($_POST['player_ids'] as $value){

    $player_id = $value;

    $stmt = $dbh->prepare("INSERT INTO league_team_players (league_id, team_id, player_id, season_id, status_id) VALUES (?,?,?,?,?)");

    $stmt->bindParam(1, $league_id, PDO::PARAM_INT, 11);
    $stmt->bindParam(2, $team_id, PDO::PARAM_INT, 11);
    $stmt->bindParam(3, $player_id, PDO::PARAM_INT, 11);
    $stmt->bindParam(4, $season_id, PDO::PARAM_INT, 11);
    $stmt->bindParam(5, $status_id, PDO::PARAM_STR, 1);

    if($stmt->execute()){
      $insert_success = 1;
    } else {
      $insert_success = 0;
    }

    $sort_order++;

  }


  if($insert_success == 1){

    $get_player_league_teams = get_player_league_teams_by_id($league_id,$team_id,$season_id);

    $league_team_player_sort_form = '<form method="post" id="add_league_team_player_sort_form" action="add_league_team_player_sort_form_process.php" name="add_league_team_player_sort_form">';
    $league_team_player_sort_form .= '<div class="form-group">';
    foreach($get_player_league_teams as $value){
      $fieldname = 'playerid~'.$value['player_id'].'~leagueid~'.$league_id.'~seasonid~'.$season_id.'~teamid~'.$team_id;
      $league_team_player_sort_form .= '<label class="col-form-label" for="inputDefault">'.$value['first_name'].' '.$value['last_name'].'</label>';
      $league_team_player_sort_form .= '<input type="text" class="form-control" name="'.$fieldname.'">';
    }
    $league_team_player_sort_form .= '</div>';
    $league_team_player_sort_form .= '<button type="submit" value="Sort Players">Sort Players</button>';
    $league_team_player_sort_form .= '</form>';
    print $league_team_player_sort_form;
  }

?>
