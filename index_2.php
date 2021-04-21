<?php

  try {
    include("_config/config.php");
    include("_config/db_connect.php");
    include("_includes/header.php");
    include("_includes/functions.php");
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();     

  }


    /**
     * Set active season variables
     */
    $active_season = get_active_season();
    
    $GLOBALS["active_season_id"] = $active_season["id"];
    $GLOBALS["active_season_name"] = $active_season["name"];
    $GLOBALS["active_season_start_date"] = $active_season["start_date"];
    $GLOBALS["active_season_end_date"] = $active_season["end_date"];    

    $league_id = $GLOBALS['league_id'];
    $season_id = $GLOBALS["active_season_id"];

?>

<script>
  $(document).ready(function() {

    $('#leaderboard').DataTable({
      searching: false,
      paging: false,
      info: false,
      order: [[ 9, "desc" ]]
    });

  });
</script>





<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
  <img src="images/swing_transparent_right_sm.png">&nbsp;&nbsp;&nbsp;
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item"><!--active-->
        <!--<a class="nav-link" href="#">About <span class="sr-only">(current)</span></a>-->
      </li>
      <li class="nav-item">
        <!--<a class="nav-link" href="#">FAQs</a>-->
      </li>      
    </ul>
    <ul class="navbar-nav ml-auto">
      <!--<li class="nav-item"><a class="nav-link" href="#">Front Office</a></li>-->     
    </ul>
  </div>
</nav>

<!-- style="background: transparent url('images/HRP_TitleGraphic-01.png') no-repeat center center /cover;" -->
<div class="container-fluid h-100 hr_hitter_heads">
  <div class="row align-items-center h-100">
    <div class="col-sm-4 text-center">
      <img src="images/HomeRunPool-03.png" style="max-width:78%;max-height:78%;"><br /> &nbsp; 
    </div>
  </div>
</div>

<div class="jumbotron">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <!-- include leader board-->
        <?php
          include("leader_board.php");
        ?>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">


  <?php  

    // Get league teams
    $league_teams = get_league_teams($league_id,$season_id);
    // Count how many teams are returned from the get_league_teams query  
    $league_team_count = $league_teams->rowCount();

    $numOfCols = 3;
    $rowCount = 0;
    $teams = $league_team_count;
  ?>

  <div class="row">

    <?php
      while ($row = $league_teams->fetch(PDO::FETCH_ASSOC)) {
        print '<div class="col-md-4">';
          print '<div class="container table-responsive">';
            print '<span style="font-size:26px;">' . $row['team_name'] . "</span>";

            $team_id = $row['team_id'];            

            // Get league team players
            $injury_query = get_league_team_players($league_id,$season_id,$team_id);
            // Count the rows returned from the injury_query query
            $no=$injury_query->rowCount();
            //$num_rows = $injury_query->fetchColumn(); <i class="far fa-id-badge"></i>

            if($no > 0){ 
             print '<span class="fa-stack" style="color:#df691a; margin-top:-20px;">';            
              print '<a tabindex="1" data-toggle="popover"  data-html="true" data-trigger="focus" title="Injury Report" data-placement="bottom" data-content="';
             
              while ($row2 = $injury_query->fetch(PDO::FETCH_ASSOC)) {
                print $row2['FirstName'] .' '. $row2['LastName'] . '&nbsp;&nbsp;&nbsp;'. $row2['playing_probability'] .'&nbsp;&nbsp;&nbsp;('. $row2['injury_desc'] .')<br />';              
              }
              print'">&nbsp;<i class="fa fa-ambulance"></i></a>';   
              print '</span>';            
            }   

             

            //print '<a tabindex="0" class="btn btn-lg btn-danger" role="button" data-toggle="popover" data-trigger="click" title="Dismissible popover" data-placement="bottom" data-content="And here some amazing content. Its very engaging. Right?">Dismissible popover</a>';      

           
            // Get past year's champions
            $champ_query = get_champions($team_id,$league_id);

            while ($row2 = $champ_query->fetch(PDO::FETCH_ASSOC)) {
              $trophy_row = '<span class="fa-stack" style="color:#df691a; margin-top:-20px;">';
              $trophy_row .= '<i class="fa fa-trophy fa-stack-2x"></i>';
              $trophy_row .= '<span class="fa fa-stack-1x">';
              $trophy_row .= '<span style="font-size:12px; color:#fff; margin-top:-7px; display:block;">';
              $trophy_row .= $row2['year'];
              $trophy_row .= '</span>';
              $trophy_row .= '</span>';
              $trophy_row .= '</span>';
              
              print $trophy_row;
            }

            unset($champ_query);            

            /**
             * include file to display the rows and columns for the team's tables
             */
            include('team_table.php');

          print '</div>';
        print '</div>';

        $rowCount++;

        if($rowCount % $numOfCols == 0) {
          print '</div><div class="row">';
        }
      }
      unset($league_teams);
    ?>
  </div>
</div>

<!-- Footer -->
<footer class="page-footer font-small special-color-dark pt-4">

  <!-- Footer Elements -->
  <div class="container-fluid">

    <!-- Social buttons -->
    <!--
    <ul class="list-unstyled list-inline text-center">
      <li class="list-inline-item">
        <a class="btn-floating btn-fb mx-1">
          <i class="fab fa-facebook-f"> </i>
        </a>
      </li>
      <li class="list-inline-item">
        <a class="btn-floating btn-tw mx-1">
          <i class="fab fa-twitter"> </i>
        </a>
      </li>
      <li class="list-inline-item">
        <a class="btn-floating mx-1">
          <i class="fas fa-baseball-ball"></i>
        </a>
      </li>
    </ul>
  -->
    <!-- Social buttons -->

  </div>
  <!-- Footer Elements -->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">&copy; <?php print date("Y"); ?> Copyright:
    <a href="https://www.homerunpool.com"> homerunpool.com</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->


<!-- START Bootstrap-Cookie-Alert -->
<!--
<div class="alert text-center cookiealert" role="alert">
    This site uses cookies to provide you with a great user experience. By continuing to use this website, you consent to the use of cookies in accordance with our <a href="#">Cookie Policy</a>

    <button type="button" class="btn btn-primary btn-sm acceptcookies" aria-label="Close">
        I agree
    </button>
</div>
-->

<!-- Include cookiealert script -->
<!--
<script src="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.js"></script>
-->

  </body>
</html>
