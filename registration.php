<?php #User registration page for mantzmusic.com
	require ('./stuff/config.php');
	$page_title="Mantz Music - Register Today";
	include ('./includes/header.php');
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		require(MYSQL);
		$trimmed=array_map('trim', $_POST);
		$fn = $ln = $cn = $e = $p = FALSE;
		
		if (preg_match('/^\s*[A-Z][a-z]{1,19}\s*$/', $trimmed['first_name'])) { // Validate first name
			$fn=mysqli_real_escape_string($dbc, $trimmed['first_name']);
		} else {
			echo '<p class="error">Please enter your first name</p>';
		}
		if (preg_match('/^\s*[A-Z][a-z]{1,39}\s*$/', $trimmed['last_name'])) { // Validate last name
			$ln=mysqli_real_escape_string($dbc, $trimmed['last_name']);
		} else {
			echo '<p class="error">Please enter your last name</p>';
		}
		if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) { // Validate email address
			$e = mysqli_real_escape_string($dbc, $trimmed['email']);
		}else{
			echo '<p class="error">Please enter a valid email address</p>';
		}
		if (filter_var($trimmed['company_name'], FILTER_SANITIZE_STRIPPED)) { // Validate company/org name
			$cn=mysqli_real_escape_string($dbc, $trimmed['company_name']);
		}
		if (preg_match('/^\s*(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?).{6,20}\s*$/', $trimmed['password1'])){ // Validate password
			if ($trimmed['password1'] == $trimmed['password2']) {
				$p = mysqli_real_escape_string($dbc, $trimmed['password1']);
			} else {
				echo '<p class="error">Your passwords did not match</p>';
			}
		} else {
			echo '<p class="error">Your password must be between 6 and 20 characters long and contain at least one uppercase letter, one lowercase letter, and one number.</p>';
		}
		if ($fn && $ln && $e && $p) { // If validation is successful
			if ($cn) { // Check if optional company name already exists in database
				$q = "SELECT orgname_id FROM mantzmusic.enum_orgname WHERE org_name='$cn'";
				$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL ERROR: ".mysqli_error($dbc));
				if (mysqli_num_rows($r) == 0) { // Add company to the database if it does not already exist
					$q = "INSERT INTO mantzmusic.enum_orgname (org_name) VALUES ('$cn')";
					$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL ERROR: ".mysqli_error($dbc));
					$q = "SELECT orgname_id FROM mantzmusic.enum_orgname WHERE org_name='$cn'"; 
					$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL ERROR: ".mysqli_error($dbc));
					if (mysqli_num_rows($r) == 1) {
						while($row=mysqli_fetch_assoc($r)){
							$_SESSION['cid'] = $row['orgname_id']; // Grab new company id to add to xref table
						}
					}
				}
			}
			$q = "SELECT user_id FROM mantzmusic.entity_user WHERE user_email='$e'";
			$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL ERROR: ".mysqli_error($dbc));
			if (mysqli_num_rows($r) == 0) {
				$a = md5(uniqid(rand(), true)); // Generate user activation code
				$q = "INSERT INTO mantzmusic.entity_user (user_email, user_password, user_fname, user_lname, user_active, user_regtime) VALUES ('$e', SHA1('$p'), '$fn', '$ln', '$a', NOW())";
				$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL ERROR: ".mysqli_error($dbc));
				if (mysqli_affected_rows($dbc) == 1) {
					$body = "Thank you for registering with Mantz Music. To activate your account, please click on this link:\n\n";
					$body.= BASE_URL.'activate.php?x='.urlencode($e)."&y=$a";
					mail($trimmed['email'],'Registration Confirmation', $body, 'From: activation@mantzmusic.com');
					echo '<h3>Thank you for registering with Mantz Music. A confimation email has been sent to your address. Please click the link in that email to activate your account.</h3>';
					if ($_SESSION['cid']) { // Insert company xref only if it exists
						$q = "SELECT user_id FROM mantzmusic.entity_user WHERE user_email='$e'";
						$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL ERROR: ".mysqli_error($dbc));
						if (mysqli_num_rows($r) == 1) {
							while($row=mysqli_fetch_assoc($r)){ // Grab user id for user_org xref table
								$_SESSION['uid'] = $row['user_id'];
							}
						}
						$cid=$_SESSION['cid'];
						$uid=$_SESSION['uid'];
						$q = "INSERT INTO mantzmusic.xref_user_org (org_id, user_id) VALUES ('$cid', '$uid')";
						$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL ERROR: ".mysqli_error($dbc));
					}
					include ('./includes/footer.php');
					exit();
				} else {
					echo '<p class="error">You could not be registered due to a system error. We apologize for the inconvenience.</p>';
				}
			} else {
				echo '<p class="error">That email address has already been registered. If you have forgotten your password, please reset it.</p>';
			}
		} else {
			echo '<p class="error">Please try again.</p>';
		}
		mysqli_close($dbc);
	} // End of Main Registration Conditional
?>

<h1>Register for your Mantz Music Account</h1>

<!-------Begin Form------>

<div id="regform">
	<form action="./registration.php" method="POST">
    	<fieldset>
            <p><b>First Name:</b><input type="text" name="first_name" size="20" maxlength="20" value="<?php if(isset($trimmed['first_name'])) echo $trimmed['first_name']; ?>" /></p>
            <p><b>Last Name:</b><input type="text" name="last_name" size="20" maxlength="40" value="<?php if(isset($trimmed['last_name'])) echo $trimmed['last_name']; ?>" /></p>
            <p><b>Organization Name:</b><input type="text" name="company_name" size="20" maxlength="45" value="<?php if(isset($trimmed['last_name'])) echo $trimmed['last_name']; ?>" /></p>
            <p><b>Email Address:</b> <input type="text" name="email" size="30" maxlength="60" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>" /> </p>
            <p><b>Password:</b> <input type="password" name="password1" size="20" maxlength="20" value="<?php if (isset($trimmed['password1'])) echo $trimmed['password1']; ?>" /> </p>
    
            <p><b>Confirm Password:</b> <input type="password" name="password2" size="20" maxlength="20" value="<?php if (isset($trimmed['password2'])) echo $trimmed['password2']; ?>" /></p>
        </fieldset>
        <div align="center"><input type="submit" name="submit" value="Register" /></div>
  	</form>
<!---------------------End Form------------------------->
<?php
include ('./includes/footer.php');
