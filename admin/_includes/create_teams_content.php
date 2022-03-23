<div class="container-fluid px-4">
    <h1 class="mt-4">Create Teams</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Create Teams</li>
    </ol>
   

    
    <div class="row gx-3 mb-3">

        <!-- 1 column that spans across all 12 grid sections-->
        <div class="col col-md-3">
            <div class="p-3 border bg-light">
                <h5 class="text-success">Create Team</h5>   <!-- -->  
                <form class="row g-3 needs-validation bg-light" id="createTeamsForm" novalidate>                  
                    
                    <label for="" class="form-label h6">Registered Users</label>
                    <select class="form-select" aria-label="select" id="validationUser">
                        <option selected>Select a user...</option>
                        <?php
                            $reg_users = get_registered_users();
                            foreach ($reg_users as $key => $value) {
                                print '<option value="'.$value['reg_id'].'">'.$value['first_name'] . ' ' . $value['last_name'].'</option>';
                            }
                        ?>
                    </select>

                    <label for="" class="form-label h6">Team name</label>
                    <input type="text" class="form-control" id="validationTeamName" value="" required>

                    <label for="" class="form-label h6">Role</label>
                    <select class="form-select" aria-label="select" id="validationRole">
                        <option selected>Select a role...</option>
                        <?php
                            $roles = get_all_roles();
                            foreach ($roles as $key => $value) {
                                print '<option value="'.$value['role_id'].'">'.$value['role_name'].'</option>';
                            }
                        ?>
                    </select>



                    <button type="submit" class="btn btn-primary mt-3" id="createTeamButton">Submit</button>  
                </form> 



                
            </div>                      
        </div>

        <div class="col col-md-9">
            <div class="p-3 border bg-light">
                <h5 class="text-success">All Teams</h5>
                <?php
                    foreach (get_all_teams_users() as $key => $value) {
                        print '<span class="h6">'.$value["team_name"].'</span> - '.$value["first_name"] . ' ' . $value["last_name"] .'<br />';
                    }
                ?>

            </div>          
        </div>      

    </div>

    


    
    <div style="height: 100vh"></div>
</div>