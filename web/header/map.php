<?php
use Location\Coordinate;

include_once('header.php');
include_once('header/permissions.php');
include_once('header/da_scan.php');

function ks_map(string $div_id, $render, $center = null, $zoom = 8) {
		$center = ($center === null) ? new Coordinate(40.22, -82.591) : $center;
	?>
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
		<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
		<script type="text/javascript">
			let mapOptions = {
				center: <?php echo json_encode(array($center->getLat(), $center->getLng())); ?>,
				zoom: <?php echo json_encode($zoom); ?>,
				minZoom: 3
			};

			let map = new L.map(<?php echo json_encode($div_id) ?>, mapOptions);

			let layer = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'}).addTo(map);

			<?php
				$render(function($location, $html) {
					?>
						{
							let marker = L.marker(<?php echo json_encode(array($location->getLat(), $location->getLng())); ?>, {}).addTo(map);
							let markerPopup = <?php echo json_encode($html); ?>;
							if(markerPopup) {
								marker.bindPopup(markerPopup);
							}
						}
					<?php
				});
			?>
		</script>
	<?php
}

// Return admin HTML for a scan if permissions are found, otherwise return an empty string.
function ks_map_scan_admin(int $scan_id) {
	if(ks_can_manage_scan($scan_id)) {
		return sprintf('<p><a href="scan_manager.php?scan_id=%d"><i>Manage</i></a></p>', $scan_id);
	}
	else {
		return '';
	}
}

function ks_map_scan(string $div_id, int $scan_id) {
	GLOBAL $ks_db;
	$scan = ks_da_scan_get($ks_db, $scan_id);

	ks_map($div_id, function($emit) use ($scan) {
		$emit($scan['location'], '');
	}, $scan['location'], 12);
}

function ks_map_card(string $div_id, int $card_id) {
	ks_map($div_id, function($emit) use ($card_id) {
		GLOBAL $ks_db;

		foreach($ks_db->query_array('SELECT latitude, longitude, description, scan_id FROM scan NATURAL JOIN card_scan WHERE card_id = $1', array($card_id)) as $row) {
			$location = new Coordinate((float) $row[0], (float) $row[1]);
			$description = $row[2];
			$scan_id = (int) $row[3];
			$emit($location, sprintf('<p>%s</p>', nl2br(htmlentities($description))) . ks_map_scan_admin($scan_id));
		}
	});
}

function ks_map_all(string $div_id) {
	ks_map($div_id, function($emit) {
		GLOBAL $ks_db;

		foreach($ks_db->query_array('SELECT latitude, longitude, description, card_id, scan_id FROM scan NATURAL JOIN card_scan') as $row) {
			$location = new Coordinate((float) $row[0], (float) $row[1]);
			$description = $row[2];
			$card_id = (int) $row[3];
			$scan_id = (int) $row[4];
			$emit($location, sprintf('<h1><a href="card_manager.php?card_id=%d">Card %d</a></h1><p>%s</p>', $card_id, $card_id, nl2br(htmlentities($description))) . ks_map_scan_admin($scan_id));
		}
	});
}
