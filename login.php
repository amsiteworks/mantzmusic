<?php #mantzmusic.com/login.php
	require ('./stuff/config.php');	
	$page_title="Mantz Music - Account Login";
	include ('./includes/header.php');
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		require (MYSQL);
		
		// Validate email
		if (!empty($_POST['email'])){
			$e = mysqli_real_escape_string($dbc, $_POST['email']);
		} else {
			$e = FALSE;
			echo '<p class="error">Please enter your email address</p>';
		}
		// Validate password
		if (!empty($_POST['pass'])){
			$p = mysqli_real_escape_string($dbc, $_POST['pass']);
		} else {
			$p = FALSE;
			echo '<p class="error">Please enter your email address</p>';
		}
		// Validation Passed
		if ($e && $p){
			//Query registered user database
			$q = "SELECT user_id, user_fname, user_lname, user_level FROM  entity_user WHERE (user_email='$e' AND user_password=SHA1('$p')) AND user_active IS NULL";
			$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " .mysqli_error($dbc));
			
			if (@mysqli_num_rows($r) == 1) {
				$_SESSION = mysqli_fetch_array($r, MYSQLI_ASSOC);
				mysqli_free_result($r);
				mysqli_close($dbc);
				
				// Redirect user
				$url = BASE_URL . 'index.php';
				ob_end_clean();
				header("Location: $url");
				exit();
			} else {
				echo '<p class="error">Oops! Either your email and password did not match or you have not yet activated your account.</p>';
			}
		} else {
			echo '<p class="error">Please try again.</p>';
		}
		mysqli_close($dbc);
	} // End of Submit conditional
?>

<h1>Account Login</h1>
	<p>Your browser must be set to allow cookies to log in.</p>
    <form action="./login.php" method="post">
    	<fieldset>
        <p><b>Email Address:</b><input type="text" name="email" size="20" maxlength="60" /></p>
        <p><b>Password:</b><input type="password" name="pass" size="20" maxlength="20" /></p>
        <div align="center"><input type="submit" name="submit" value="Login" /></div>
        </fieldset>
	</form>
<?php
	include ('./includes/footer.php');
?>
