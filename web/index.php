<?php include_once("header.php"); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo($ks_config['title']); ?></title>
	</head>
	<body>
		<a href='login.php'>login</a>
		<a href='logout.php'>logout</a>
		<?php
		if($ks_logged_in_user) {
			echo("You are logged in, " . htmlentities($ks_logged_in_user['name']));
		}
		else {
			echo("You are not logged in.");
		}
		?>
	</body>
</html>
