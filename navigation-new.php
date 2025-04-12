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
      <!--
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
    -->
    </ul>
    <!--<div id="loginDiv">-->
      <ul class="navbar-nav ml-auto">
        <?php        
          if(is_logged_in()){
            print '<li class="nav-item"><a class="nav-link" href="#">Hello ' . $_SESSION['firstname'] . '!</a></li>';
            print '<li class="nav-item"><a class="nav-link" href="' . $GLOBALS['base_url'] . 'admin/index.php">Front Office</a></li>';
            print '<li class="nav-item"><a class="nav-link" href="logout.php">Logout <i class="fas fa-sign-out-alt"></i></a></li>';            
          } else {
            print '<li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#LogInModal">Login <i class="fas fa-sign-in-alt"></i></a></li>';
          }        
        ?>
        <!--<li class="nav-item"><a class="nav-link" href="#">Front Office</a></li>-->       
      <!--</ul>-->
    <div>
  </div>
</nav>