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
    <!-- Vertically centered modal -->

<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="editUserForm" name="editUserForm" role="form">
          <div class="modal-body">   
            <div class="row">
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">First name</label>
                    <input type="text" class="form-control" id="validationCustom01" value="" required>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please enter a first name.</div>

                    <label for="validationCustom02" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="validationCustom02" value="" required>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please enter a last name.</div>

                    <label for="validationCustomEmail" class="form-label">Email</label>                            
                    <input type="text" class="form-control" id="validationCustomEmail" aria-describedby="inputGroupPrepend" required>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please enter an email.</div>

                    <label for="validationCustomMobile" class="form-label">Mobile Number</label>                            
                    <input type="text" class="form-control" id="validationCustomMobile" aria-describedby="inputGroupPrepend" required>
                    <div class="valid-feedback">Looks good!</div>
                    <!--<div class="invalid-feedback">Please enter an email.</div>-->

                    <label for="validationCustomPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="validationCustomPassword" placeholder="" />
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please enter a password.</div>

                    <label for="validationCustomMobile" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="validationCustomPasswordConfirm"  placeholder="" />
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please confirm correct password.</div>

                    <label for="validationCustomMobile" class="form-label" id="validationCustomStatus">Status</label>
                    <select class="form-select form-select-md">
                      <option selected>Open this select menu</option>
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please select status.</div>
                </div>
            </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="editUserSubmit">Submit</button>
      </div>
    </div>
  </div>
</div>


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
                        include '_includes/registered_users_content.php';
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
