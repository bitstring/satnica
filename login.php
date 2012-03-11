<?php
	
	$msg = "Log in";
	// parse login attempt
	if (isset($_POST['user'])) {
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		
		// test in database
		$id = login($user,$pass);
		if ($id) {
			$_SESSION['user'] = $user;
			$_SESSION['id'] = $id[0];
			$_SESSION['tarifa'] = $id[1];
		} else {
			$msg = "Wrong username or password";
		}
	}
	
	if (!test_user()) {

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<link rel="stylesheet" href="decor.css" type="text/css" >
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
	<title><?php title(); ?></title>
</head>
<body>
	<div class="container">
		<table class="simple"><form name="config" method="post">
			<tr>
				<td class="data" colspan="2"><?php echo $msg; ?></td>
			</tr>
			<tr>
				<td class="info">User:</td>
				<td class="data"><input type="text" name="user" value="" size=20></td>
			</tr>
			<tr>
				<td class="info">Password:</td>
				<td class="data"><input type="password" name="pass" value="" size=20></td>
			</tr>
			<tr>
			<td class="final" colspan="2"><input type="submit" value="Log in"></td>
			</tr>
		</form></table>
	</div>
</body>
</html>

<?php } ?>