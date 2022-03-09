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
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />  
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/custom_styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>        

        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/searchpanes/2.0.0/js/dataTables.searchPanes.min.js"></script>
        <script src="https://cdn.datatables.net/searchpanes/2.0.0/js/searchPanes.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script> 

        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/searchpanes/2.0.0/css/searchPanes.bootstrap5.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/select/1.3.4/css/select.bootstrap5.min.css" rel="stylesheet" />


    <script type="text/javascript" class="init">    

        $(document).ready(function() {
            var table = $('#datatablesRegisteredUsers').DataTable({
                searchPanes: {
                    initCollapsed: true
                }
            });
            table.searchPanes.container().prependTo(table.table().container());
            table.searchPanes.resizePanes();
        });

    </script>


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
                        <h1 class="mt-4">Edit Registered Users</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Registered Users</li>
                        </ol>


                        <div class="row gx-5 ">

                            <!-- 1 column that spans across all 12 grid sections-->
                            <div class="col col-md-12">
                                <div class="p-3 border bg-light">

                                   
                                    <table id="datatablesRegisteredUsers" class="table table-striped nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Reg ID</th>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col"># of Teams</th>
                                                <th scope="col"># of Leagues</th>                                                
                                                <th scope="col">Created</th>
                                                <th scope="col">Updated</th>
                                                <th scope="col">Status</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach (get_registered_users() as $key => $value) {
                                                    $date_created = strtotime($value["date_created"]);
                                                    $date_updated = strtotime($value["date_updated"]);


                                                    $table_row = '<tr>';
                                                    $table_row .= '<td>'.$value["reg_id"].'</td>';
                                                    $table_row .= '<td>'.$value["first_name"].'</td>';
                                                    $table_row .= '<td>'.$value["last_name"].'</td>';
                                                    $table_row .= '<td>'.$value["email"].'</td>';
                                                    $table_row .= '<td></td>';
                                                    $table_row .= '<td></td>';
                                                    $table_row .= '<td>'.date("m/d/Y",$date_created).'</td>';
                                                    $table_row .= '<td>'.date("m/d/Y",$date_updated).'</td>';
                                                    $table_row .= '<td>'.$value["status_name"].'</td>';
                                                    $table_row .= '<td><a href="#" class="btn btn-primary btn-sm" tabindex="-1" role="button" aria-disabled="true">Edit</a></td>';
                                                    $table_row .= '</tr>';

                                                    print $table_row;
                                                }
                                            ?>                                          
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>

  


                        
                        
                        

                       
                        
                        
                        <div style="height: 100vh"></div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website <?php print date('Y') ?></div>
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
        <script async src="js/validate.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
