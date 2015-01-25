<?php # Content Portal login functions for mantzmusic.com
	
function redirect_user ($page = '../index.php'){
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	$url=rtrim($url, '/\\');
	$url .='/'.$page;
	header("Location: $url");
	exit();
}

function check_login($dbc, $email='', $pw=''){
	$err=array();
	if(empty($email)){
		$err[]='Please enter your email address.';
	} else {
		$e=mysqli_real_escape_string($dbc, trim($email));
	}
	if(empty($pw)){
		$err[]='Please enter your password.';
	} else {
		$p=mysqli_real_escape_string($dbc, trim($pw));
	}
}
?>
