<?php include_once("header.php"); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
		<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
		<title><?php echo($ks_config['title']); ?></title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<header>
			<?php include_once('nav_header.php'); ?>
		</header>
		<div id="map" style="width: 100%; height: 75vh;"></div>
		<script type="text/javascript">
			let mapOptions = {
				center: [40.22, -82.591],
				zoom: 8,
				minZoom: 3
			};

			let map = new L.map('map', mapOptions);

			let layer = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'}).addTo(map);

			// Find scan locations to add to map
			<?php
				function get_scan_locations() 
				{
					GLOBAL $ks_db;
					try {
						$scan_locations = $ks_db->query("SELECT latitude, longitude, description, card_id FROM scan NATURAL JOIN card_scan");
						
						// Grab columns from query results
						$scan_latitudes = pg_fetch_all_columns($scan_locations, 0);
						$scan_longitudes = pg_fetch_all_columns($scan_locations, 1);
						$description = pg_fetch_all_columns($scan_locations, 2);
						$card_id = pg_fetch_all_columns($scan_locations, 3);

						return json_encode(array_map(null, $scan_latitudes, $scan_longitudes, $description, $card_id));
					} catch (Exception $e) {
						echo 'Error occured while locating scans: ' . $e;
						return [];
					}
				}
			?>

			// Add scan locations to map
			var scan_locations = <?php echo get_scan_locations() . '' ?>;
			for (let i = 0; i < scan_locations.length; i++) {
				// Retrieve values from JSON arrays
				let latitude = parseFloat(scan_locations[i][0]);
				let longitude = parseFloat(scan_locations[i][1]);
				let description = scan_locations[i][2];
				let card_id = scan_locations[i][3];

				L.marker([latitude, longitude], {title: description}).addTo(map).bindPopup("<h1>Card " + card_id + "</h1><p>" + description + "</p>");
			}
		</script>
	</body>
</html>
