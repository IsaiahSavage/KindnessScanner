<?php
	include_once('header.php');
	include_once('header/permissions.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo($ks_config['title']); ?> | Settings</title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body id="user-manager">
		<header>
			<?php include_once('nav_header.php'); ?>
		</header>
		<?php
			$user = ks_da_user_get($ks_db, (int) $_GET['user_id']);
		?>
		<h1><?php echo $user['name'] ?></h1>
		(ID <?php echo $user['id']; ?>, <?php echo $user['privilege']; ?>)<br>
		<a href='mailto:<?php echo $user['email']; ?>'><?php echo $user['email']; ?></a><br>
		This user's cards have been scanned <?php
			$n = $ks_db->query_next($ks_db->query('SELECT count(scan_id) FROM card_scan NATURAL JOIN r_u_card WHERE user_id = $1', array($user['id'])))[0];
			printf('<b>%d</b> %s', $n, ($n === 1) ? 'time' : 'times');
		?>.<br>
		<?php
			if(ks_can_manage_cards()) {
		?>
			<hr>
			<form action="card_create.php" method="post">
				<input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

				<!-- TODO: Card location selection. -->
				<input type="hidden" name="latitude" id="latitude" value="0">
				<input type="hidden" name="longitude" id="longitude" value="0">

				<input type="submit" value="Create New Card">
			</form>
		<?php
			}
		?>
		<hr>
		Cards:
		<ul>
			<?php
				foreach($ks_db->query_array("SELECT card_id FROM card NATURAL JOIN r_u_card WHERE r_u_card.user_id = $1", array($user['id'])) as $row) {
					if(ks_can_manage_card($row[0])) {
						printf("<li><a href='card_manager.php?card_id=%d'>Card %d</a></li>\n", $row[0], $row[0]);
					}
				}
			?>
		</ul>
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
