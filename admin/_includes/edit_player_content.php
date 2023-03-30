<?php

    if(isset($_GET["player_id"])){

        $playerid = $_GET["player_id"];
        $player = get_player_by_id($playerid);


    } else {
        print '<div class="alert alert-danger alert-dismissible fade show" role="alert"> No Access! The Player ID was not passed to this page. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        exit();
    }
    
?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><?php print $player["FirstName"] . " ". $player["LastName"] ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"><a href="index.php">Dashboard</a></li>
    </ol>


    

    <div class="row g-3">
        <div class="col-md-2">

            
            <?php
                if($player["MLBImage"] != ''){
                    print '<img class="img-fluid" src="'.$player["MLBImage"].'" alt="'.$player["FirstName"] . " ". $player["LastName"].'">';
                } else {
                    $placeholder = '<svg class="bd-placeholder-img img-thumbnail" width="213" height="320" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="image placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">';
                    $placeholder .= '<title>A generic square placeholder image with a white border around it, making it resemble a photograph taken with an old instant camera</title>';
                    $placeholder .= '<rect width="100%" height="100%" fill="#868e96"></rect>';
                    $placeholder .= '<text x="15%" y="50%" fill="#dee2e6" dy=".3em">Photo Not Available</text>';
                    $placeholder .= '</svg>';
                    print $placeholder;
                }

                
                   
            ?>
             
        </div>
        <div class="col-md-10">
            <?php 
                $player_details = '<strong>Player ID: </strong>'.$player["PlayerID"].'<br />';
                $player_details .= '<strong>Name: </strong>'.$player["FirstName"] . " ". $player["LastName"].'<br />';
                $player_details .= '<strong>Primary Position: </strong>'.$player["PrimaryPosition"].'<br />';
                $player_details .= '<strong>Jersey Number: </strong>'.$player["JerseyNumber"].'<br />';
                $player_details .= '<strong>Team ID: </strong>'.$player["TeamID"].'<br />';
                $player_details .= '<strong>Team Abbr: </strong>'.$player["TeamAbbr"].'<br />';
                $player_details .= '<strong>Height: </strong>'.$player["Height"].'<br />';
                $player_details .= '<strong>Weight: </strong>'.$player["Weight"].'<br />';
                $player_details .= '<strong>DOB: </strong>'.$player["DOB"].'<br />';
                $player_details .= '<strong>Age: </strong>'.$player["Age"].'<br />';
                $player_details .= '<strong>Birth City: </strong>'.$player["BirthCity"].'<br />';
                $player_details .= '<strong>Birth Country: </strong>'.$player["BirthCountry"].'<br />';
                $player_details .= '<strong>High School: </strong>'.$player["HighSchool"].'<br />';
                $player_details .= '<strong>College: </strong>'.$player["College"].'<br />';
                $player_details .= '<strong>Bats: </strong>'.$player["Bats"] .'<br />';
                $player_details .= '<strong>Throws: </strong>'.$player["Throws"] .'<br />';
                $player_details .= '<strong>MLB ID: </strong>'.$player["MLBID"].'<br />';
                $player_details .= '<strong>Status: </strong>'.get_status_name($player["status_id"]).'<br />';
                $mlb_com_profile_page = "https://www.mlb.com/player/".$player["MLBID"];
                $player_details .= '<strong>MLB.com Profile: </strong> <a href="'.$mlb_com_profile_page.'" target="_blank">Click here</a>';
                


                print $player_details;
            ?>
        </div>
    </div>


 

    <form class="row g-3 needs-validation bg-light mt-3" novalidate>
        <input type="hidden" class="form-control" id="validationPlayerID" value="<?php print $player["PlayerID"];?>" required>
        <div class="col-md-3">
            <label for="validationFirstName" class="form-label h6">First Name</label>
            <input type="text" class="form-control" id="validationFirstName" maxlength="30" value="<?php print $player["FirstName"];?>" required>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please enter a first name.</div>
        </div>
        <div class="col-md-3">
            <label for="validationLastName" class="form-label h6">Last Name</label>
            <input type="text" class="form-control" id="validationLastName" maxlength="50" value="<?php print $player["LastName"]; ?>" required>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please enter a last name.</div>
        </div>
        <div class="col-md-3">
            <label for="validationPrimaryPosition" class="form-label h6">Primary Position</label>
            <input type="text" class="form-control" id="validationPrimaryPosition" maxlength="3" value="<?php print $player["PrimaryPosition"]; ?>">
        </div>
        <div class="col-md-3">
            <label for="validationJerseyNumber" class="form-label h6">Jersey Number</label>
            <input type="text" class="form-control" id="validationJerseyNumber" maxlength="11" value="<?php print $player["JerseyNumber"]; ?>">
        </div>



        <div class="col-md-3">
            <label for="validationTeamID" class="form-label h6">Team ID</label>
            <input type="text" class="form-control" id="validationTeamID" maxlength="11" value="<?php print $player["TeamID"]; ?>">
        </div>
        <div class="col-md-3">
            <label for="validationTeamAbbr" class="form-label h6">Team Abbr</label>
            <input type="text" class="form-control" id="validationTeamAbbr" maxlength="5" value="<?php print $player["TeamAbbr"]; ?>">
        </div>
        <div class="col-md-3">
            <label for="validationHeight" class="form-label h6">Height</label>
            <?php 
                print "<input type='text' class='form-control' id='validationHeight' maxlength='5' value=".$player["Height"].">";
            ?>
        </div>
        <div class="col-md-3">
            <label for="validationWeight" class="form-label h6">Weight</label>
            <input type="text" class="form-control" id="validationWeight" maxlength="8" value="<?php print $player["Weight"]; ?>">
        </div>


        <div class="col-md-3">
            <label for="validationDOB" class="form-label h6">DOB</label>
            <input type="date" data-provide="datepicker" id="dob" class="form-control" value="<?php print $player["DOB"]; ?>">
        </div>
        <div class="col-md-3">
            <label for="validationAge" class="form-label h6">Age</label>
            <input type="text" class="form-control" id="validationAge" maxlength="11" value="<?php print $player["Age"]; ?>">
        </div>
        <div class="col-md-3">
            <label for="validationBirthCity" class="form-label h6">Birth City</label>
            <input type="text" class="form-control" id="validationBirthCity" maxlength="75" value="<?php print $player["BirthCity"]; ?>">
        </div>
        <div class="col-md-3">
            <label for="validationBirthCountry" class="form-label h6">Birth Country</label>
            <input type="text" class="form-control" id="validationBirthCountry" maxlength="50" value="<?php print $player["BirthCountry"]; ?>">
        </div>


        <div class="col-md-3">
            <label for="validationHighSchool" class="form-label h6">High School</label>
            <input type="text" class="form-control" id="validationHighSchool" maxlength="100" value="<?php print $player["HighSchool"]; ?>">
        </div>
        <div class="col-md-3">
            <label for="validationCollege" class="form-label h6">College</label>
            <input type="text" class="form-control" id="validationCollege" maxlength="150" value="<?php print $player["College"]; ?>">
        </div>
        <div class="col-md-3">
            <label for="validationBats" class="form-label h6">Bats</label>
            <select class="form-select" id="validationBats" required>
                <option selected value="">Choose...</option>
                <?php
                    if($player["Bats"] == 'L'){
                        $option = '<option value="L" selected>Left</option>';
                        $option .= '<option value="R">Right</option>';
                        $option .= '<option value="S">Switch</option>';
                        print $option;
                    } elseif ($player["Bats"] == 'R') {
                        $option = '<option value="L">Left</option>';
                        $option .= '<option value="R" selected>Right</option>';
                        $option .= '<option value="S">Switch</option>';
                        print $option;
                    } elseif ($player["Bats"] == 'R') {
                        $option = '<option value="L">Left</option>';
                        $option .= '<option value="R">Right</option>';
                        $option .= '<option value="S" selected>Switch</option>';
                        print $option;
                    } else {
                        $option = '<option value="L">Left</option>';
                        $option .= '<option value="R">Right</option>';
                        $option .= '<option value="S">Switch</option>';
                        print $option;
                    }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="validationThrows" class="form-label h6">Throws</label>
            <select class="form-select" id="validationThrows">
                <option selected value="">Choose...</option>                     
                <?php 
                    if($player["Throws"] == 'L'){
                        print '<option value="L" selected>Left</option>';
                        print '<option value="R">Right</option>';
                    } elseif ($player["Throws"] == 'R') {
                        print '<option value="L">Left</option>';
                        print '<option value="R" selected>Right</option>';
                    } else {
                        print '<option value="L">Left</option>';
                        print '<option value="R">Right</option>';
                    }
                ?>
            </select>
        </div>


        <div class="col-md-3">
            <label for="validationMLBImage" class="form-label h6">MLB Image</label>
            <input type="text" class="form-control" id="validationMLBImage" maxlength="100" value="<?php print $player["MLBImage"]; ?>">
        </div>
        <div class="col-md-3">
            <label for="validationMLBID" class="form-label h6">MLB ID</label>
            <input type="text" class="form-control" id="validationMLBID" maxlength="11" value="<?php print $player["MLBID"]; ?>">
        </div>
        <div class="col-md-3">
            <label for="validationStatus" class="form-label h6">Status</label>
            <select class="form-select" id="validationStatus">
                <option selected value="">Choose...</option>
                <?php          
                    foreach (get_all_status() as $key => $value) {
                        if($value["status_id"] == $player["status_id"]){
                            print '<option value="'.$value["status_id"].'" selected>'.$value["status_name"].'</option>';
                        } else {
                            print '<option value="'.$value["status_id"].'">'.$value["status_name"].'</option>';
                        }
                    }
                ?>            
            </select>
        </div>
        <div class="col-12">
            <?php print '<input type="hidden" id="player_id" value="'.$playerid.'">'; ?>
            <button type="submit" class="btn btn-primary" id="update_player_manual">Update (save) Manual Changes</button>
            <button type="submit" class="btn btn-secondary" id="update_player_msf">Update from MSF</button>
        </div>


    </form>

  
   
                



          
    
</div>