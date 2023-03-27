<?php

    include("../_config/config.php");
    include("../_config/db_connect.php");
    include("../_includes/functions.php");

    $league_id = $_GET["league_id"];
    $season_id = $_GET["season_id"];

    $league_teams = get_all_league_teams($league_id,$season_id);

    var_dump($league_teams);

    ?>
    