<?php 

	session_start(); // Start the PHP session

	$_SESSION = array(); // Clear all session variables

	if (isset($_COOKIE[session_name()])) { // Check if the session cookie is set
		setcookie(session_name(), '', time()-86400, '/'); // Unset the session cookie by setting its expiration time to a past date
	}

	session_destroy(); // Destroy the session data

	// Redirecting the user to the login page with the action parameter set to logout
	header('Location: login.php?action=logout');

 ?>
