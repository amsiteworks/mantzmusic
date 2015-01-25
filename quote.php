<?php #Quote results page for mantzmusic.com
	require ('./stuff/config.php');
	$page_title="Mantz Music - Your Instant Quote";
	include ('./includes/header.php');
	
	// Functions to calculate quote
	function calcOL(){
		if ($_POST['olType'] == '2Track') {
			$q = 200;
		}
		if ($_POST['olType'] == 'Multitrack'){
			$mi = $_POST['micInputs'];
			if ($mi == '3-4'){$q = 250;}
			else if ($mi == '5-8'){$q = 350;}
			else if ($mi == '9-16'){$q = 500;}
			else $q = 'Houston we have a problem';
		}
		return $q;
	}
	
	function calcSR(){
		$sd= $_POST['studioDays'];
		if ($sd >= 5){
			$q = $sd * 200;
		}
		else $q = $sd * 250;
		return $q;
	}
	
	function calcMx(){
		$tc = $_POST['trackCount'];
		$ms = $_POST['mixSongs'];
		if ($tc == '16orless'){
			$q = $ms * 50;
		}
		else if ($tc == '17-24'){
			$q = $ms * 80;
		}
		else if ($tc == '25-48'){
			$q = $ms * 100;
		}
		else if ($tc == '48-96'){
			$q = $ms * 150;
		}
		else if ($tc == '96ormore'){
			$q = $ms * 200;
		}
		else $q = 'Houston we have a problem.';
		if (is_numeric($q) && $ms >= 10){
			$q *= .9;
		}
		return $q;
	}
	
	function calcMs(){
		$ms = $_POST['masterSongs'];
		$mm = $_POST['mastMinutes'];
		if ($ms >= 10){
			$q = $ms * 20;
		}
		else if ($ms >= 4){
			$q = $ms * 25;
		}
		else if ($ms >= 1){
			$q = $ms * 30;
		}
		else $q = 'Houston we have a problem';
		if (is_numeric($q) && $mm > 80){
			$q *= 1.2;
		}
		return $q;
	}
	
	// Function calls
	$ol = 0;
	$sr = 0;
	$mx = 0;
	$ms = 0;
	$quo = 0;
	
	if (isset($_POST['serviceTypeOL'])){
		$ol = calcOl();
	}
	if (isset($_POST['serviceTypeSR']) && !isset($_POST['serviceTypeOL'])){
		$sr = calcSR();
	}
	if (isset($_POST['serviceTypeMx']) && !isset($_POST['serviceTypeOL'])){
		$mx += calcMx();
	}
	if (isset($_POST['serviceTypeMs']) && !isset($_POST['serviceTypeOL'])){
		$ms += calcMs();
	}
	$quo = $ol + $sr + $ms + $mx;
	// Page Output
	$quote = '<h2>Here is your instant quote:</h2>';
	$quote .= '<h1>$'.$quo.'</h1>';
	echo $quote;
	include ('./includes/footer.php');
?>
