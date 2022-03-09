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
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Static Navigation - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/custom_styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>        
        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />-->
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Start Bootstrap</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <?php
                                include 'left_nav_admin.php';
                            ?>                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Create User</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Create User</li>
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
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script async src="js/validate.js"></script>
    </body>
</html>

