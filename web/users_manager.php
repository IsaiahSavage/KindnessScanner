<?php
	include_once('header.php');
	include_once('header/permissions.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo($ks_config['title']); ?> | Card Manager</title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<header>
			<?php include_once('nav_header.php'); ?>
		</header>
		<?php
			if(ks_can_manage_users()) {
		?>
			<ul>
				<?php
					foreach($ks_db->query_array("SELECT user_id,name,email,privilege FROM registered_user ORDER BY user_id") as $row) {
						printf("<li><a href='user_manager.php?user_id=%d'>%s</a> <a href='mailto:%s'>%s</a> (%s)</li>\n", $row[0], $row[1], $row[2], $row[2], $row[3]);
					}
				?>
			</ul>
				<hr>
				<form action="user_create.php" method="post">
					Name: <input type="text" name="name"><br>
					E-mail: <input type="email" name="email"><br>
					<input type="submit" value="Create New User">
				</form>
		<?php
			}
		?>
	</body>
</html>
