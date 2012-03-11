<?php
session_start();
ob_start();// Hook output buffer 
require_once('connect-data.php');
ob_end_clean();//Clear output buffer

	// make connection with db
	if (!mysql_connect($host,$user,$pass)) {
		die('Unable to connect to databse: ' . mysql_error());
	}
	mysql_query("SET NAMES cp1250");
	mysql_select_db($dbase);


function test_user() { // test if user is logged in
	if (isset($_SESSION['user'])) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function title() { // echo page title
	// TODO: changeable title
	echo "satnica";
}

function logout() {
	session_unset();
	session_destroy();
	include('index.php'); // recursive inclusion :/ 
}

function login($user, $pass) {
	$sql="SELECT * FROM user WHERE email='$user' AND pass='". sha1($pass) ."' AND active=1";
	$res=mysql_query($sql);
	mysql_close();
	if (mysql_num_rows($res)!=0) {
		return array(mysql_result($res,0,"id"), mysql_result($res,0,"tarifa"));
	} else {
		return FALSE;
	}
}

function codeGen() {
    $length = 10;
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
    $string = "";    

    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }

    return $string;
}

?>