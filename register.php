<?php
	
	$msg = "Register";
	
	// parse register attempt
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		
		$pass=sha1($pass);
		$key=codeGen();
		
		// prevent multiple users with same email
		$sql = "SELECT * FROM user WHERE email='$email'";
		$res = mysql_query($sql);
		
		if (mysql_num_rows($res)!=0) {
			$msg="Email allready regstrated. <a href='?a=reset'>Forgot your password?</a></div>";
		} else {				
			$sql="INSERT INTO user VALUES (NULL, '$email', '$pass', 0, '$key', 1)";
			$res = mysql_query($sql);
			mysql_close();
			
			$msg="Zahvaljujemo na registraciji. Kako bi ste bili u mogučnosti koristiti se portalom, potvrdite vašu registraciju.\n\n$website/confirm.php?user=$email&key=$key";
			mail($user,"Aktivacija za portal $website",$msg, $from);
			mail($admin_mail,"Novi korisnik na $website","Novi korisnik na stranici: $user",$from);
			
			$msg="Please check your mail to complete registration";
		}
	
	}
	// TODO: add username support
	// TODO: complete config with missing data
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
		<table class="simple"><form name="config" method="post" action="?a=register">
			<tr>
				<td class="data" colspan="2"><?php echo $msg; ?></td>
			</tr>
			<tr>
				<td class="info">Email:</td>
				<td class="data"><input type="text" name="email" value="" size=20></td>
			</tr>
			<tr>
				<td class="info">Password:</td>
				<td class="data"><input type="password" name="pass" value="" size=20></td>
			</tr>
			<tr>
			<td class="final" colspan="2"><input type="submit" value="Register"></td>
			</tr>
		</form></table>
	</div>
</body>
</html>