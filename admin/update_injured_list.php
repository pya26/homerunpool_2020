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
                            include '_includes/update_injured_list_content.php';
                        ?>                        

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
