<?php

include("_config/config.php");
include("_config/db_connect.php");
include("_includes/functions.php");


$api_id = 1;
$season = '2021-preseason';
$reg_id = 1;
$league_id = 10;

//$mung = list_of_seasons();
//$mung = get_api_url($api_id);
//$mung = list_of_seasons();
//$mung = season_select_menu();
//$mung = get_api_and_params($api_id);
//$mung = get_api_url($api_id);
//$mung = mysportsfeeds_api_request($url);
$mung = current_season();
//$mung = get_all_players();
//$mung = get_all_roster_statuses();

//$mung = get_all_hitter_positions();
//$mung = get_season_id($season);
//$mung = insert_players($player_info_response);

//$mung = insert_hrs_february_stub_records($player_ids_array,$season_id);
//$mung = insert_hrs_march_stub_records($player_ids_array,$season_id);
//$mung = insert_hrs_april_stub_records($player_ids_array,$season_id);
//$mung = insert_hrs_may_stub_records($player_ids_array,$season_id);
//$mung = insert_hrs_june_stub_records($player_ids_array,$season_id);
//$mung = insert_hrs_july_stub_records($player_ids_array,$season_id);
//$mung = insert_hrs_august_stub_records($player_ids_array,$season_id);
//$mung = insert_hrs_september_stub_records($player_ids_array,$season_id);
//$mung = insert_hrs_october_stub_records($player_ids_array,$season_id);
//$mung = insert_hrs_november_stub_records($player_ids_array,$season_id);

//$mung = get_registered_users();
//$mung = get_monthly_hrs_for_season($tablename,$season_id);
//$mung = get_leagues();
//$mung = leagues_select_menu();
//$mung = get_teams_by_id($reg_id);
//$mung = get_all_teams();
//$mung = get_leagues_by_id($league_id);
//$mung = get_status_name($status_id);
//$mung = get_roles_name($role_id);
//$mung = get_league_info($lid);
//$mung = get_registered_user_name($reg_id);

//$mung = date_format_table($date);

//$mung = user_login($email,$pwd);
//$mung = forgot_password($email);

//$mung = is_logged_in();

//$mung = check_active_email($email);
//$mung = get_player_league_teams_by_id($league_id,$team_id,$season_id);






print "<pre>";
print_r($mung);
print "</pre>";



?>

