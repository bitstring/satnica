<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <link rel="stylesheet" href="decor.css" type="text/css" >
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
   <title>Satnica install script</title>
</head>
<body>
<div class="container">
<?php 
	if (isset($_POST['user'])) {
		// 2nd stage
		$user = $_POST['user'];
		$password = $_POST['password'];
		$host = $_POST['host'];
		$database = $_POST['database'];
		
		$def_pass = "abc123";
		
		$link = mysql_connect($host,$user,$password);
		if (!$link) {
			echo "<p>Unable to connect to database: " . mysql_error() . "</p>
			<p>Go <a href='javascript: history.go(-1)'>back</a></p>";
		} else {
			echo "<p>Connection succesefull, checking database...</p>";
			
			mysql_query("SET NAMES cp1250", $link);
			if (mysql_select_db($database, $link)) {
				echo "<p>Database exists...</p>";
			} else {
				echo "<p>No database, creating one...";
				$sql = 'CREATE DATABASE ' . $database;
				if (mysql_query($sql, $link)) {
					echo "Done";
					mysql_select_db($database, $link);
				} else {
					die("Failed :(</p>");
				}
			}
			
			echo "<p>Creating tables";
			
			$sql = "CREATE TABLE IF NOT EXISTS `tarife` (
				  `id` int(11) NOT NULL auto_increment,
				  `naziv` varchar(250) NOT NULL,
				  `dnevni` decimal(5,2) NOT NULL,
				  `nocni` decimal(5,2) NOT NULL,
				  `ndnevni` decimal(5,2) NOT NULL,
				  `nnocni` decimal(5,2) NOT NULL,
				  `bdnevni` decimal(5,2) NOT NULL,
				  `bnocni` decimal(5,2) NOT NULL,
				  PRIMARY KEY  (`id`),
				  UNIQUE KEY `id` (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1";
			if (mysql_query($sql, $link)) {
				echo ".";
			} else {
				die("Failed :(</p><p>" . mysql_error() . "</p>");
			}
			
			$sql = "CREATE TABLE IF NOT EXISTS `user` (
			  `id` int(11) NOT NULL auto_increment,
			  `email` varchar(250) NOT NULL,
			  `pass` varchar(250) NOT NULL,
			  `active` tinyint(1) NOT NULL,
			  `confirm` varchar(250) NOT NULL,
			  `tarifa` int(11),
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `id` (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1";
			if (mysql_query($sql, $link)) {
				echo ".";
			} else {
				die("Failed :(</p><p>" . mysql_error() . "</p>");
			}
			
			$sql = "CREATE TABLE IF NOT EXISTS `worksheet` (
			  `id` int(11) NOT NULL auto_increment,
			  `id_tarifa` int(11) NOT NULL,
			  `id_user` int(11) NOT NULL,
			  `dnevni` int(11) NOT NULL,
			  `nocni` int(11) NOT NULL,
			  `ndnevni` int(11) NOT NULL,
			  `nnocni` int(11) NOT NULL,
			  `bdnevni` int(11) NOT NULL,
			  `bnocni` int(11) NOT NULL,
			  `start` datetime NOT NULL,
			  `end` datetime NOT NULL,
			  `komentar` varchar(250) NOT NULL,
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `id` (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1";
			if (mysql_query($sql, $link)) {
				echo ".Done</p>";
			} else {
				die("Failed :(</p><p>" . mysql_error() . "</p>");
			}
			
			echo "<p>Creating default user...";
			
			$sql = "INSERT INTO `user` VALUES (NULL, 'admin', '" . sha1($def_pass) . "', 1, 'admin', NULL)"; 
			if (mysql_query($sql, $link)) {
				echo "Done</p><p>User 'admin' with password: '$def_pass'</p>";
			} else {
				die("Failed :(</p><p>" . mysql_error() . "</p>");
			}
			
			echo "<p>Saving config...";
			
			$dat = '<?php $host="' . $host . 
					'"; $user="' . $user .
					'"; $pass="' . $password .
					'"; $dbase="' . $database . '"; ?>';

			$fp = fopen('data.txt', 'w');
			if ($fp) {
				fwrite($fp, $dat);
				fclose($fp);
				echo "Done</p>";
			} else {
				echo "Failed</p><p>Unable to save config. Please save this to 'connect-data.php':</p><textarea>" . $dat . "</textarea>";
			}
			
			echo "<p>Installation complete! Delete install.php</p>";
		}
	} else {
		// 1st stage
		echo '
	<table class="simple"><form name="config" method="post" action="install.php">
		<tr>
			<td class="data" colspan="2">Server config</td>
		</tr>
		<tr>
			<td class="info">MySQL user:</td>
			<td class="data"><input type="text" name="user" value="" size=20></td>
		</tr>
		<tr>
			<td class="info">MySQL pass:</td>
			<td class="data"><input type="password" name="password" value="" size=20></td>
		</tr>
		<tr>
			<td class="info">MySQL host:</td>
			<td class="data"><input type="text" name="host" value="localhost" size=20></td>
		</tr>
		<tr>
			<td class="info">MySQL db:</td>
			<td class="data"><input type="text" name="database" value="satnica" size=20></td>
		</tr>
		<tr>
		<td class="final" colspan="2"><input type="submit" value="Continue"></td>
		</tr>
	</form></table>';
	}

?>
</div></body>
</html>

