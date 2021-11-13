<?php include_once('header/session.php'); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo($ks_config['title']); ?> | Logout</title>
	</head>
	<body>
		<?php
			if($ks_logged_in_user) {
				echo("You have been logged out, " . htmlentities($ks_logged_in_user['name']));
			}
			else {
				echo("You were not logged in.");
			}
		?>
		<?php ks_session_clear(); ?>
	</body>
</html>

