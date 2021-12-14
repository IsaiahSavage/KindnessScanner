<?php
	include_once('header.php');
	include_once('header/permissions.php');
	include_once('header/map.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo($ks_config['title']); ?> | Scan Manager</title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body id="scan-manager">
		<header>
			<?php include_once('nav_header.php'); ?>
		</header>
		<?php
			$scan = ks_da_scan_get($ks_db, (int) $_GET['scan_id']);
			$card = ks_da_card_get($ks_db, $scan['card']);
			$owner = ks_da_user_get($ks_db, $card['owner']);
		?>

		<h1>Scan #<?php echo $scan['id'] ?></h1>
		At <?php echo date('c', $scan['time']); ?><br>
		On <a href='card_manager.php?card_id=<?php echo $card['id'] ?>'>Card #<?php echo $card['id'] ?></a> registered to <?php echo htmlentities($owner['name']); ?>.
		<p>
			<?php echo nl2br(htmlentities($scan['description'])); ?>
		</p>

		<?php
			if(ks_can_manage_scan($scan['id'])) {
		?>
			<hr>
			<form action="scan_delete.php" method="post">
				<input type="hidden" name="scan_id" value="<?php echo $scan['id']; ?>">
				Confirm ID number of scan: <input type="number" name="scan_confirm"><br>
				<input type="submit" value="Delete scan">
			</form>
		<?php
			}
		?>

		<div id="map" style="width: 50%; height: 50vh;"></div>
		<?php ks_map_scan('map', $scan['id']); ?>
	</body>
</html>
