<?php
  try {
      include("../_config/config.php");
      include("../_includes/header.php");
      include("../_includes/functions.php");
    } catch (PDOException $e) {}

    if(!isset($_SESSION['reg_id'])){
      $redirect_url = "login.php?redirect=" . $_SERVER['REQUEST_URI'];
      header("Location: ".$redirect_url);
    }

?>

<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />


<form method="post" action="create_team_process.php" name="create-team-form">
    <div class="form-element">
        <label>Registered User</label>
        <!--<input type="text" name="username" pattern="[a-zA-Z0-9]+" required />-->
        <?php
        $reg_users_select = '<select name="reg_id" id="reg_users"><option value=""></option>';
        foreach (get_registered_users() as $key => $value) {
            $reg_users_select .= '<option value="';
            $reg_users_select .= $value['reg_id'];
            $reg_users_select .= '">';
            $reg_users_select .= $value['first_name'] . ' ' . $value['last_name'];
            $reg_users_select .= '</option>';
        }
         $reg_users_select .= '</select>';
         print $reg_users_select;
        ?>
    </div>
    <div class="form-element">
        <label>Team Role</label>
        <input type="radio" name="role_id" value="3" />&nbsp;Commissioner&nbsp;&nbsp;&nbsp;<input type="radio" name="role_id" value="2" />&nbsp;Manager
    </div>
    <div class="form-element">
        <label>Team Name</label>
        <input type="text" name="team_name" required />
    </div>
    <div class="form-element">
        <label>Team Description</label>
        <input type="text" name="team_desc" />
    </div>
    <!--
    <div class="form-element">
        <label>Team Logo</label>
        <input type="file" name="team_logo" />
    </div>
    -->
    <div class="form-element">
        <label>Join League</label>
        <!--<input type="text" name="username" pattern="[a-zA-Z0-9]+" required />-->
        <?php print leagues_select_menu() ?>
    </div>

    <button type="submit" name="create-team" value="Create Team">Create Team</button>
</form>
