<?php
	include_once('header.php');
	include_once('header/permissions.php');
	include_once('header/map.php');
	include_once('header/da_scan.php');
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
			$card = ks_da_card_get($ks_db, (int) $_GET['card_id']);
			$owner = ks_da_user_get($ks_db, $card['owner']);
		?>
		<h1>Card #<?php echo $card['id'] ?></h1>
		This card has been scanned <?php
			$n = $ks_db->query_next($ks_db->query('SELECT count(scan_id) FROM card_scan WHERE card_id = $1', array($card['id'])))[0];
			printf('<b>%d</b> %s', $n, ($n === 1) ? 'time' : 'times');
		?>.<br>
		Registered to <a href='user_manager.php?user_id=<?php echo $owner['id']; ?>'><?php echo $owner['name']; ?></a><br>
		Created at <?php echo date('c', $card['creation_time']); ?><br>

		<?php
			if(ks_can_manage_card($card['id'])) {
				printf("<a href='card_qr_pdf.php?card_id=%d'>Generate Card PDF</a><br>", $card['id']);
				$scan_url = sprintf('%s/scan.php?card_id=%d', $ks_config['root_url'], $card['id']);
				printf("Scan URL: <a href='%s'>%s</a><br>", htmlentities($scan_url), htmlentities($scan_url));
		?>
			<hr>
			<form action="card_delete.php" method="post">
				<input type="hidden" name="card_id" value="<?php echo $card['id']; ?>">
				Confirm email address of owner: <input type="email" name="email_confirm"><br>
				<input type="submit" value="Delete card">
			</form>
		<?php
			}
		?>

		<div id="map" style="width: 50%; height: 50vh;"></div>
		<?php ks_map_card('map', $card['id']); ?>
	</body>
</html>
