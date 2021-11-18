<?php include_once("header.php"); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
		<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
		<title><?php echo($ks_config['title']); ?></title>
	</head>
	<body>
		<header>
			<?php include_once('nav_header.php'); ?>
		</header>
		<div id="map" style="width: 100%; height: 75vh;"></div>
		<script type="text/javascript">
			let mapOptions = {
				center: [40.22, -82.591],
				zoom: 8
			};

			let map = new L.map('map', mapOptions);

			let layer = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'}).addTo(map);

			/* TODO: Add markers from all cards */
			<?php /*
				GLOBAL $ks_db;
				$card_locations = $ks_db->query("SELECT latitude, longitude FROM scan");
				echo $card_locations;
			?>
			var card_locations = <?php echo '["' . implode('", "', $card_locations) . '"]' ?>;
			-- Remove this entire line in order to use -- */ ?>
		</script>
	</body>
</html>
