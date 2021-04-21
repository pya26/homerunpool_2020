<?php

  try {  
    include("_config/config.php"); 
    include("_includes/header.php");
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();     

  }

?>





<div class="row bg-primary">
  <div class="col-xl-12">
    <div class="container table-responsive-sm text-center">
      <h1>404</h1>Page Not found
    </div>
  </div>
</div>


<div class="container">
  <div class="row" style="background:transparent url('images/errors/ck.jpg') no-repeat center center /cover">
    <div class="col-lg-6">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <h2>Sorry, like Chuck Knoblauch throwing to a target, the destination you're looking for can't be found!</h2>
    </div>
    <div class="col-lg-6">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </div>
  </div>
</div>

<!--
<div class="jumbotron">
  <div class="container-fluid 404_knoblauck">
    <div class="row">
      <div class="col-sm-12 text-center">
       <iframe width="560" height="315" src="https://www.youtube.com/embed/dnJFklbt0es" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</div>
->



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