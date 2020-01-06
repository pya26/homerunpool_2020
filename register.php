<?php
  try {
      include("_includes/header.php");
    } catch (PDOException $e) {}
?>

<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />




<form method="post" action="register_process.php" name="signup-form">
    <div class="form-element">
        <label>First Name</label>
        <input type="text" name="firstname" required />
    </div>
    <div class="form-element">
        <label>Last Name</label>
        <input type="text" name="lastname" required />
    </div>
    <div class="form-element">
        <label>Username</label>
        <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
    </div>
    <div class="form-element">
        <label>Email</label>
        <input type="email" name="email" required />
    </div>
    <div class="form-element">
        <label>Password</label>
        <input type="password" name="password" required />
    </div>
    <button type="submit" name="register" value="register">Register</button>
</form>
