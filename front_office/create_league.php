<?php
  try {
      include("../_config/config.php");
      include("../_includes/header.php");
      include("../_includes/functions.php");
    } catch (PDOException $e) {}

    /*if(!isset($_SESSION['reg_id'])){
      $redirect_url = "../login.php?redirect=" . $_SERVER['REQUEST_URI'];
      header("Location: ".$redirect_url);
    }*/

    if(!is_super_user()){
        print "Only the Super User is allowed back here!";
        exit();
    }
    
?>


<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />


<form method="post" action="create_league_process.php" name="create-league-form">
    <!--
    <div class="form-element">
        <label>Team Role</label>
        <input type="radio" name="role_id" value="3" />&nbsp;Commissioner&nbsp;&nbsp;&nbsp;<input type="radio" name="role_id" value="2" />&nbsp;Manager
    </div>
    -->
    <div class="form-element">
        <label>League Name</label>
        <input type="text" name="league_name" required />
    </div>
    <div class="form-element">
        <label>League Description</label>
        <input type="text" name="league_desc" required />
    </div>
    <div class="form-element">
        <label>League Type</label>
        <input type="text" name="league_type" required />
    </div>
    <div class="form-element">
        <label>Number of Teams Allowed</label>
        <input type="text" name="teams_allowed" required />
    </div>
    <div class="form-element">
        <label>Number of Players per Team</label>
        <input type="text" name="players_per_team" required />
    </div>
    <!--
    <div class="form-element">
        <label>Team Logo</label>
        <input type="file" name="team_logo" />
    </div>
    -->

    <button type="submit" name="create-league" value="Create League">Create League</button>
</form>
