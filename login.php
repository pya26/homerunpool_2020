<?php

	$url_components = parse_url($_SERVER['REQUEST_URI']);

	if(isset($url_components['query'])){
		parse_str($url_components['query'], $params);	
		$redirect_url = $params['redirect'];
	} else {
		$redirect_url = '';
	}

?>

<a href='admin_dashboard.php'>Back to admin dashboard</a><br /><br />





<form method="post" action="login_process.php" name="signin-form">
	<input type="hidden" name="redirect" value=<?php print $redirect_url; ?> />
    <div class="form-element">
        <label>Username</label>
        <input type="text" name="email" required />
    </div>
    <div class="form-element">
        <label>Password</label>
        <input type="password" name="pwd" required />
    </div>
    <button type="submit" name="login" value="login">Log In</button>
</form>
<a href="register.php">Register an Account</a>
