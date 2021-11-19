<?php
	include_once('header.php');
	include_once('header/permissions.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo($ks_config['title']); ?> | User Manager</title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<header>
			<?php include_once('nav_header.php'); ?>
		</header>
		<?php
			$user = ks_da_user_get($ks_db, (int) $_GET['user_id']);
		?>
		<h1><?php echo $user['name'] ?></h1>
		(ID <?php echo $user['id']; ?>, <?php echo $user['privilege']; ?>)<br>
		<a href='mailto:<?php echo $user['email']; ?>'><?php echo $user['email']; ?></a><br>
		<?php
			if(ks_can_manage_user($user['id'])) {
				?>
					<hr>
					<form action="user_change_password.php" method="post">
						<input type="hidden" name="user_id" value="<?php echo $user['id']; ?>"><br>

						New password: <input type="password" name="password"><br>
						Confirm new password: <input type="password" name="password_confirm"><br>

						<input type="submit" value="Change Password">
					</form>
					<hr>
					<form action="user_change_email.php" method="post">
						<input type="hidden" name="user_id" value="<?php echo $user['id']; ?>"><br>

						New e-mail address: <input type="email" name="email"><br>

						<input type="submit" value="Change e-mail address">
					</form>
					<hr>
					<form action="user_change_name.php" method="post">
						<input type="hidden" name="user_id" value="<?php echo $user['id']; ?>"><br>

						New name: <input type="text" name="name"><br>

						<input type="submit" value="Change name">
					</form>
					<?php
						if(ks_privilege() == 'admin' && $user['id'] !== $ks_logged_in_user['id']) {
					?>
						<hr>
						<form action="user_change_privilege.php" method="post">
							<input type="hidden" name="user_id" value="<?php echo $user['id']; ?>"><br>

							<select name="privilege">
								<?php
									foreach($ks_possible_privileges as $p) {
										?>
											<option value="<?php echo $p; ?>" <?php if($user['privilege'] === $p) { ?> selected <?php } ?>><?php echo htmlentities($p); ?></option>
										<?php
									}
								?>
							</select>

							<input type="submit" value="Change privilege">
						</form>
					<?php
						}
					?>
					<?php
						if(ks_privilege() == 'admin' && $user['privilege'] !== 'admin' && $user['id'] !== $ks_logged_in_user['id']) {
					?>
						<hr>
						<form action="user_delete.php" method="post">
							<input type="hidden" name="user_id" value="<?php echo $user['id']; ?>"><br>
							Confirm email address: <input type="text" name="email_confirm"><br>
							<input type="submit" value="Delete user">
						</form>
					<?php
						}
					?>
				<?php
			}
		?>
	</body>
</html>
