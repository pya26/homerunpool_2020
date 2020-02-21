<?php

  include("../_config/config.php");
  include("../_config/db_connect.php");

  foreach($_POST as $key => $value){
    $plt_array = explode("~", $key);
    $playerid = $plt_array[1];
    $leagueid = $plt_array[3];
    $seasonid = $plt_array[5];
    $teamid = $plt_array[7];

    $stmt = $dbh->prepare("UPDATE league_team_players SET sort = :sort WHERE  league_id = :league_id AND player_id = :player_id AND season_id = :season_id AND team_id = :team_id");

    $stmt->bindParam(':sort', $value, PDO::PARAM_INT, 11);
    $stmt->bindParam(':league_id', $leagueid, PDO::PARAM_INT, 11);
    $stmt->bindParam(':player_id', $playerid, PDO::PARAM_INT, 11);
    $stmt->bindParam(':season_id', $seasonid, PDO::PARAM_INT, 11);
    $stmt->bindParam(':team_id', $teamid, PDO::PARAM_INT, 11);
    $stmt->execute();

  }

  header("Location: add_league_team_players.php");
?>
