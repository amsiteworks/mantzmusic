<?php #mantzmusic.com/logout.php
	require ('./stuff/config.php');	
	$page_title="Mantz Music - Account Logout";
	include ('./includes/header.php');
	
	if (!isset($_SESSION['user_fname'])){
		$url = BASE_URL . 'index.php';
		ob_end_clean();
		header("Location: $url");
		exit();
	} else {
		$_SESSION = array(); // Clears variables
		session_destroy(); // Clears session
		setcookie (session_name(), '', time()-3600); // Clears cookies
	}
	
	echo '<h2>You are now logged out</h2>';
	
	include ('./includes/footer.php');
?>