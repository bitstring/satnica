<?php
require_once('helper.php');

	if (isset($_GET['a'])) {
		$action = $_GET['a'];
	} else {
		$action = "";
	}
	
	// test session
	if (!test_user() && $action!='register') {
		include('login.php');
		if (!test_user()) exit();
	}
	
	// choose action
	switch ($action) {
		case 'register': // registration form requested
			include('register.php');
			break;
		case 'logout': // log out requested
			logout();
			break;
		case 'reset': // reset password
			break;
		default: // display default page
			echo "<a href='?a=logout'>log out?</a>";
	}

?>