<div class="container-fluid px-4">
    <h1 class="mt-4">Players</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Players
        </div>
        <div class="card-body">
            

            <table id="datatablesListPlayers" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Player ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Position</th>
                        <th scope="col">Team Abbr</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
                    
                        $get_all_players = $dbh->prepare("SELECT * FROM players");
                        $get_all_players->execute();
                                            
                        while ($row = $get_all_players->fetch(PDO::FETCH_ASSOC)) {                            
                            $table_row = '<tr>';
                            $table_row .= '<td>'.$row['PlayerID'].'</td>';
                            $table_row .= '<td>'.$row['FirstName'].'</td>';
                            $table_row .= '<td>'.$row['LastName'].'</td>';
                            $table_row .= '<td>'.$row['PrimaryPosition'].'</td>';
                            $table_row .= '<td>'.$row['TeamAbbr'].'</td>';
                            $table_row .= '<td>'.$row['status_id'].'</td>';
                            /*$table_row .= '<td><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editPlayerModal" id=editPlayer" value='.$row['PlayerID'].'">edit</button></td>';*/
                            $table_row .= '<td><a href="edit_player.php?player_id='.$row['PlayerID'].'" class="btn btn-primary btn-sm" role="button">Edit</a></td>';
                            
                            $table_row .= '</tr>';
                            print $table_row;                                                  
                        }
                    ?>
                
                </tbody>
            </table>

        </div>
    </div>
</div>