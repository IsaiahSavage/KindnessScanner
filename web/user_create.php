<?php
	include_once('header.php');
	include_once('header/permissions.php');
	include_once('header/random.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo($ks_config['title']); ?> | User Creation</title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body id="user-create">
		<header>
			<?php include_once('nav_header.php'); ?>
		</header>
		<?php
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				if(ks_can_manage_users()) {
					$password = ks_generate_random_password();
					$user = ks_da_user_get($ks_db, ks_da_user_add($ks_db, array(
						'name' => $_POST['name'],
						'email' => $_POST['email'],
						'password' => $password,
						'privilege' => 'user',
					)));

					?>
						Created <a href='user_manager.php?user_id=<?php echo $user['id']; ?>'>User <?php echo $user['id']; ?></a><br>
						<?php echo $user['name']; ?> (<a href='mailto:<?php echo $user['email']; ?>'><?php echo $user['email']; ?></a>)
						Their password has been set to: <b><?php echo $password; ?></b>
					<?php
				}
		?>
		<?php
			}
		?>
	</body>
</html>
