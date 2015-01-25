<?php #Mantz Music Configuration Script

/*  mantzmusic.com created by Anthony Mantz to serve as an informational site with the functionality for light e-commerce.
 *	This file sets database connections and error handling constants to be used by mantzmusic.com
 */
 
 // *********************************** //
 // ********** BASE SETTINGS ********** //
 
 // Flag for live status (True=Live, False=Test)
 define('LIVE', FALSE);
 
 // Admin contact address
 define('EMAIL', 'amantz@amsiteworks.com');
 
 // Site URL base for redirects
 define('BASE_URL', 'http://localhost/mantzmusic/');
 
 // MYSQL Connection Location
 define('MYSQL', '/applications/XAMPP/xamppfiles/htdocs/mm_mysqli_connect.php');
 
 // Set site's default timezone
 date_default_timezone_set ('America/Los_Angeles');
 
 // ********** BASE SETTINGS ********* //
 // ********************************** //
 
 // ************************************** //
 // ********** ERROR MANAGEMENT ********** //
 
 // Error Handler
 function mm_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {
	
	$message="An error occured in script '$e_file' on line $e_line: $e_message\n";
	$message.= "Date/Time: " .date('n-j-Y H:i:s')."\n";
	
	if(!LIVE) { // site is in development mode, show full error messages
		echo '<div class="error">'.nl2br($message);
		echo '<pre>'.print_r($e_vars, 1)."\n";
		debug_print_backtrace();
		echo '</pre></div>';
	}
	else { // site is in live mode, suppress errors from browser and notify webmaster instead
		$body = $message. "\n".print_r ($e_vars, 1);
		mail(EMAIL, 'Site Error!', $body, 'From: system@mantzmusic.com');
		if ($e_number != E_NOTICE) {
			echo '<div class="error">A system error occured. We apologize for the inconvenience.</div><br />';
		}
	} // end of !LIVE IF
 } // end of function
 set_error_handler('mm_error_handler');
 
 // ********************************** //
 // ********** SITE GLOBALS ********** //
 
 $ql = '<h3><a href="./quoteform.php">Get Quote</a></h3>';
 