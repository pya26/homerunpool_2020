<?php
  try {
    include("../_config/config.php");
    include("../_config/db_connect.php");
    include("../_includes/functions.php");
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();     

  }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include '_includes/header.php';
        ?>
    </head>
    <body class="sb-nav-fixed">
        <?php
            include '_includes/nav_bar.php';
        ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <?php
                                include '_includes/left_nav_admin.php';
                            ?>                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <?php
                            include '_includes/sidenav_footer.php';
                        ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>

                    <?php

                        if(isset($super_user_access) && $super_user_access == 1){
                            print $msg;
                            exit();
                        }

                    ?>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Cheatsheet</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Cheatsheet</li>
                        </ol>

                        <a href="https://getbootstrap.com/docs/5.0/getting-started/introduction/" target="_blank">Bootstrap 5 Documentation</a>


					<div class="alert alert-primary alert-dismissible fade show" role="alert">A simple primary alert with <a href="#" class="alert-link">an example link</a>. Give it a click if 	you like. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
					<div class="alert alert-secondary alert-dismissible fade show" role="alert"> A simple secondary alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
					<div class="alert alert-success alert-dismissible fade show" role="alert"> A simple success alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
					<div class="alert alert-danger alert-dismissible fade show" role="alert"> A simple danger alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
					<div class="alert alert-warning alert-dismissible fade show" role="alert"> A simple warning alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
					<div class="alert alert-info alert-dismissible fade show" role="alert"> A simple info alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
					<div class="alert alert-light alert-dismissible fade show" role="alert"> A simple light alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
					<div class="alert alert-dark alert-dismissible fade show" role="alert"> A simple dark alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>



					</div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <?php
                        include '_includes/footer.php';
                    ?>
                </footer>
            </div>
        </div>
            <?php
                include '_includes/footer_scripts.php';
            ?>
    </body>
</html>

