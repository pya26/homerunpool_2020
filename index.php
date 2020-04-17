<?php

  try {
    include("_config/config.php");
    include("_config/db_connect.php");
    include("_includes/header.php");
    include("_includes/functions.php");
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
  }

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

<!-- ------- FORGOT FORM ------- -->
<div class="modal fade" id="ForgotModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-primary">
      <div class="modal-header">
          <h5 class="modal-title" id="loginModalLongTitle">Forgot your password?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <div id="error_msg"></div>
        <form id="forgot_form">
          <!-- Form Title -->
          <div class="form-heading text-center">
            <p class="title-description">We'll email you a link to reset it.</p>
          </div>

          <div class="form-group">
            <input type="text" id="email" class="form-control" placeholder="Your E-mail Address" required />
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-md btn-primary">Send Mail</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
<!-- ------- FORGOT FORM ends ------- -->


<!-- ------- LOGIN ------- -->
<div class="modal fade" id="LogInModal" tabindex="-1" role="dialog" aria-labelledby="loginModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-primary">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLongTitle">Please Sign-in</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="login_form">
          <div class="modal-body">
            <div id="error_msg"></div>
            <div class="form-group">
              <label for="email1">Email address</label>
              <input type="email" class="form-control" id="email_uname" aria-describedby="emailHelp" placeholder="Enter email" required />
            </div>
            <div class="form-group">
              <label for="password1">Password</label>
              <input type="password" class="form-control" id="password1" placeholder="Password" required />
            </div>
            <div class="row">
              <div class="col-md-6">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1" checked="">
                    <label class="custom-control-label" for="customCheck1">Remember Me</label>
                  </div>
              </div>
            </div>
            <div class="row justify-content-center">
              <div>
                  <label><a href="#" class="text-muted" data-toggle="modal" data-target="#ForgotModal" data-dismiss="modal">Forgot Password?</a></label>
              </div>
            </div>
            <div class="row justify-content-center">
              <div>
                  <label><a href="#" class="text-muted" data-toggle="modal" data-target="#CreateAccountModal" data-dismiss="modal">Create an Account</a></label>
              </div>
            </div>
          </div>
          <div class="modal-footer border-top-0 d-flex text-center">
            <button type="submit" class="btn btn-primary">Sign-in</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- ------- LOGIN Ends ------- -->


<!-- ------- Create Account ------- -->
<div class="modal fade" id="CreateAccountModal" tabindex="-1" role="dialog" aria-labelledby="CreateAccountModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-primary">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLongTitle">Create an Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="create_account">
          <div class="modal-body">
            <div id="error_msg"></div>
            <div class="form-group">
              <label for="first_name">First Name</label>
              <input type="text" class="form-control" id="first_name" placeholder="Enter First Name" required />
            </div>
            <div class="form-group">
              <label for="last_name">Last Name</label>
              <input type="text" class="form-control" id="last_name" placeholder="Enter Last Name" required />
            </div>
            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="emai" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required />
            </div>
            <div class="form-group">
              <label for="password1">Password</label>
              <input type="password" class="form-control" id="password1" placeholder="Enter Password" required />
            </div>
          </div>
          <div class="modal-footer border-top-0 d-flex">
            <button type="submit" class="btn btn-primary">Create Account</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- ------- LOGIN Ends ------- -->



<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
  <img src="images/swing_transparent_right_sm.png">&nbsp;&nbsp;&nbsp;
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item"><!--active-->
        <a class="nav-link" href="#">About <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">FAQs</a>
      </li>
      <!--
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
    -->
    </ul>
    <ul class="navbar-nav ml-auto">
      <!--
      <?php
        if(is_logged_in()){
          print '<li class="nav-item"><a class="nav-link" href="#">Hello ' . $_SESSION['first_name'] . '!</a></li>' .'<li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i>Sign-out</a></li>';
        } else {
          print '<li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#LogInModal"><i class="fas fa-sign-in-alt"></i> Sign-in</a></li>';
        }
      ?>
      <li class="nav-item"><a class="nav-link" href="#">Front Office</a></li>
      -->
    </ul>
  </div>
</nav>

<div class="container-fluid">
  <!--<div class="row" style="background:transparent url('images/HRP_TitleGraphic-01.png') no-repeat center center /cover;">-->
  <div class="row" style="background: transparent url('images/HRP_TitleGraphic-01.png') no-repeat center center /cover;">
    <div class="col-sm-4 border">
      <img src="images/HomeRunPool-03.png" style="max-width:90%;max-height:95%;">   
    </div>
    <div class="col-sm-8 border"> 
    </div>
  </div>
</div>

<div class="jumbotron">
  <div class="container-fluid">
    <div class="row">
      <!--<div class="col-sm-4">
        <img src="images/HomeRunPool-01.png" style="max-width:100%;max-height:100%;">
      </div>-->
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
    $league_teams = $dbh->prepare("SELECT lt.team_id, t.team_name FROM league_teams lt LEFT JOIN teams t ON t.team_id = lt.team_id WHERE lt.league_id = 10 AND lt.season_id = 10 AND lt.status_id = 'A' ORDER BY lt.sort ASC");
    $league_teams->execute();
    $league_team_count = $league_teams->rowCount();

    $numOfCols = 3;
    $rowCount = 0;
    $teams = $league_team_count;
  ?>

  <div class="row">

    <?php
      while ($row = $league_teams->fetch(PDO::FETCH_ASSOC)) {
        print '<div class="col-md-4">';
          print '<div class="container table-responsive-sm">';
            print '<span style="font-size:26px;">' . $row['team_name'] . "</span>";

            $teamid = $row['team_id'];

            $champ_query = $dbh->prepare('SELECT year FROM champions WHERE team_id = ? AND league_id = ?');
            $champ_query->bindParam(1, $teamid, PDO::PARAM_INT, 11);
            $champ_query->bindParam(2, $leagueid, PDO::PARAM_INT, 11);
            $champ_query->execute();

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
    <!-- Social buttons -->

  </div>
  <!-- Footer Elements -->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2020 Copyright:
    <a href="http://www.homerunpool.com"> homerunpool.com</a>
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
