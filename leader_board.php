<?php

/*
    print isset($_SESSION['reg_id']) . '<br />';
    print isset($_SESSION['lid']) . '<br />';




    if(!isset($_SESSION['reg_id']) && !isset($_GET['lid'])){
    	$redirect_url = "login.php?redirect=" . $_SERVER['REQUEST_URI'];
      header("Location: ".$redirect_url);
    } elseif (isset($_SESSION['reg_id']) && !isset($_GET['lid'])){
    	header("Location: front_office.php");
    } elseif (!isset($_SESSION['reg_id']) && isset($_GET['lid'])){
    	$redirect_url = "login.php?redirect=" . $_SERVER['REQUEST_URI'];
      header("Location: ".$redirect_url);
    }
    */

    /*
    if(!isset($_GET['lid'])){
      header("Location: login.php");
    }*/

?>

<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />

<h1>Leader Board</h1>

<?php
/*
$league_info = get_league_info($_GET['lid']);

foreach($league_info as $key => $value){

	$league_info_data = 'League Name: ' . $value['league_name'] . '<br />';
	$league_info_data .= 'League Description: ' . $value['league_desc'] . '<br />';
	$league_info_data .= 'Teams Allowed: ' . $value['teams_allowed'] . '<br />';
	$league_info_data .= 'Date Created: ' . date('n/j/Y',strtotime($value['date_created'])) . '<br />';
	$league_info_data .= 'Date Updated: ' . date('n/j/Y',strtotime($value['date_updated'])) . '<br />';
	$league_info_data .= 'Created By: ' . get_registered_user_name($value['created_by']) . '<br />';
	$league_info_data .= 'League Status: ' . get_status_name($value['status_id']) . '<br />';

}
print $league_info_data;
*/
?>
<div class="container table-responsive-sm">
    <h2>Dark Striped Table</h2>
    <p>Combine .table-dark and .table-striped to create a dark, striped table:</p>
    <table id="leaderboard" class="table table-sm table-striped table-hover table-bordered border-primary" style="width:100%">
          <thead>
              <tr>
                  <th>Player</th>
                  <th>March</th>
                  <th>April</th>
                  <th>May</th>
                  <th>June</th>
                  <th>July</th>
                  <th>August</th>
                  <th>September</th>
                  <th>October</th>
                  <th>Total</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>Tiger Nixon</td>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                  <td>4</td>
                  <td>5</td>
                  <td>6</td>
                  <td>7</td>
                  <td>8</td>
                  <td>50</td>
              </tr>
          </tbody>
        </table>
  </div>



<div class="container table-responsive-sm">
    <h2>Dark Striped Table</h2>
    <p>Combine .table-dark and .table-striped to create a dark, striped table:</p>
    <table id="leaderboard" class="table table-sm table-striped table-hover table-bordered border-primary" style="width:100%">
          <thead>
              <tr>
                  <th>Player</th>
                  <th>March</th>
                  <th>April</th>
                  <th>May</th>
                  <th>June</th>
                  <th>July</th>
                  <th>August</th>
                  <th>September</th>
                  <th>October</th>
                  <th>Total</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>Tiger Nixon</td>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                  <td>4</td>
                  <td>5</td>
                  <td>6</td>
                  <td>7</td>
                  <td>8</td>
                  <td>50</td>
              </tr>
              <tr>
                  <td>Garrett Winters</td>
                  <td>8</td>
                  <td>7</td>
                  <td>6</td>
                  <td>5</td>
                  <td>4</td>
                  <td>3</td>
                  <td>2</td>
                  <td>1</td>
                  <td>40</td>
              </tr>
              <tr>
                  <td>Ashton Cox</td>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                  <td>4</td>
                  <td>5</td>
                  <td>6</td>
                  <td>7</td>
                  <td>8</td>
                  <td>30</td>
              </tr>
              <tr>
                  <td>Cedric Kelly</td>
                  <td>8</td>
                  <td>7</td>
                  <td>6</td>
                  <td>5</td>
                  <td>4</td>
                  <td>3</td>
                  <td>2</td>
                  <td>1</td>
                  <td>20</td>
              </tr>
              <tr>
                  <td>Airi Satou</td>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                  <td>4</td>
                  <td>5</td>
                  <td>6</td>
                  <td>7</td>
                  <td>8</td>
                  <td>10</td>
              </tr>
              <tr>
                  <td>Brielle Williamson</td>
                  <td>8</td>
                  <td>7</td>
                  <td>6</td>
                  <td>5</td>
                  <td>4</td>
                  <td>3</td>
                  <td>2</td>
                  <td>1</td>
                  <td>90</td>
              </tr>
              <tr>
                  <td>Herrod Chandler</td>
                  <td>8</td>
                  <td>7</td>
                  <td>6</td>
                  <td>5</td>
                  <td>4</td>
                  <td>3</td>
                  <td>2</td>
                  <td>1</td>
                  <td>95</td>
              </tr>
              <tr>
                  <td>Rhona Davidson</td>
                  <td>8</td>
                  <td>7</td>
                  <td>6</td>
                  <td>5</td>
                  <td>4</td>
                  <td>3</td>
                  <td>2</td>
                  <td>1</td>
                  <td>85</td>
              </tr>
              <tr>
                  <td>Colleen Hurst</td>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                  <td>4</td>
                  <td>5</td>
                  <td>6</td>
                  <td>7</td>
                  <td>8</td>
                  <td>75</td>
              </tr>
              <tr>
                  <td>Sonya Frost</td>
                  <td>8</td>
                  <td>7</td>
                  <td>6</td>
                  <td>5</td>
                  <td>4</td>
                  <td>3</td>
                  <td>2</td>
                  <td>1</td>
                  <td>65</td>
              </tr>
              <tr>
                  <td>Jena Gaines</td>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                  <td>4</td>
                  <td>5</td>
                  <td>6</td>
                  <td>7</td>
                  <td>8</td>
                  <td>55</td>
              </tr>
              <tr>
                  <td>Quinn Flynn</td>
                  <td>8</td>
                  <td>7</td>
                  <td>6</td>
                  <td>5</td>
                  <td>4</td>
                  <td>3</td>
                  <td>2</td>
                  <td>1</td>
                  <td>45</td>
              </tr>
          </tbody>
          <tfoot>
              <tr>
                  <th>Player</th>
                  <th>March</th>
                  <th>April</th>
                  <th>May</th>
                  <th>June</th>
                  <th>July</th>
                  <th>August</th>
                  <th>September</th>
                  <th>October</th>
                  <th>Total</th>
              </tr>
          </tfoot>
      </table>
  </div>
