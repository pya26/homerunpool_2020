<div class="container-fluid px-4">
	<h1 class="mt-4">Registered Users</h1>
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
	                            $table_row .= '<td><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editUser">Edit</button></td>';
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