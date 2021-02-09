<?php

  try {      
      include("_config/config.php");
      include("_config/db_connect.php");
      include("_includes/functions.php");
      include("_includes/header.php");
      
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      die();
    }

    if(!isset($_SESSION['reg_id'])){
      $redirect_url = "login.php?redirect=" . $_SERVER['REQUEST_URI'];
      header("Location: ".$redirect_url);
    }

?>

<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />

<h1>Front Office</h1>

<?php

/*
print "<pre>";
print_r(get_leagues());
print "</pre>";
print_r($_SESSION['reg_id']);

<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Instrument</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>Name</th>
      <th>Instrument</th>
    </tr>
  </tfoot>
  <tbody>
    <tr>
      <td>John Lennon</td>
      <td>Rhythm Guitar</td>
    </tr>
    <tr>
      <td>Paul McCartney</td>
      <td>Bass</td>
    </tr>
    <tr>
      <td>George Harrison</td>
      <td>Lead Guitar</td>
    </tr>
    <tr>
      <td>Ringo Starr</td>
      <td>Drums</td>
    </tr>
  </tbody>
</table>
*/

print "<h3>My Teams</h3>";
$list_teams = get_teams_by_id($_SESSION['reg_id']);

$teams_table = '<table border="1">';
$teams_table .= '<thead>';
$teams_table .= '<tr><th>Team Name</th><th>League Name</th><th>Status</th><th>Date Created</th><th>Date Updated</th></tr>';
$teams_table .= '</thead>';

foreach($list_teams as $key => $value){

  $stmt = $dbh->prepare("SELECT lt.league_id, l.league_name FROM league_teams lt INNER JOIN leagues l ON l.league_id = lt.league_id WHERE lt.team_id = ?");
  $stmt->bindParam(1, $value['team_id'], PDO::PARAM_INT, 11);
  $stmt->execute();

  $teams_table .= '<tbody><tr>';
  $teams_table .= '<td>' . $value['team_name'] . '</td>';
  $teams_table .= '<td>' . $stmt->rowCount() . '</td>';
  

  //$team_line = $value['team_id'] . ' - ' . $value['team_name'] . ' (edit team)';
/*
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $league = $row['league_name'];
      $teams_table .= '<td>' . $league . '</td>';
    }
*/
  /*
  if(!$stmt->rowCount()){
    $league = ' <button type="submit" name="create-league-front-office" value="Create League">Create League</button>';
    $teams_table .= '<td>' . $league . '</td>';
  } else {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $league = $row['league_name'];
      $teams_table .= '<td>' . $league . '</td>';
    }
  }*/

  $teams_table .= '<td>' . get_status_name($value['status_id']) . '</td>';
  $teams_table .= '<td>' . $value['date_created'] . '</td>';
  $teams_table .= '<td>' . $value['date_updated'] . '</td>';  
  
}

  $teams_table .= '</tr>';
  $teams_table .= '</tbody>';
  $teams_table .= '</table>';

  print $teams_table;


print "<h3>My Leagues</h3>";

$list_leagues = get_leagues_by_id($_SESSION['reg_id']);

foreach($list_leagues as $key => $value){

  if($value['status_id'] == 'A'){
    $league_name_info = '<a href="leader_board.php?lid='.$value['league_id'].'">'. $value['league_name'] .'</a>';
  } else {
    $league_name_info = $value['league_name'];
  }

  print $league_name_info .' - '. get_status_name($value['status_id']) . ' - ' . get_roles_name($value['role_id']) .'<br />';
}





?>

