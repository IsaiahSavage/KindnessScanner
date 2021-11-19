<?php

include_once('header.php');

/* Returns an array of information about a scan with keys:
id, location [Coordinate], time [UNIX epoch timestamp], description, card
Returns false if the scan does not exist. */
function ks_da_scan_get($ks_db, int $scan_id) {
	$row = $ks_db->query_next($ks_db->query('SELECT scan_id, latitude, longitude, EXTRACT(epoch FROM time), card_id, description FROM scan NATURAL JOIN card_scan WHERE scan_id = $1', array($scan_id)));
	if($row) {
		return array(
			'id' => (int) $row[0],
			'location' => new Location\Coordinate((float) $row[1], (float) $row[2]),
			'time' => (int) $row[3],
			'card' => $row[4],
			'description' => $row[5],
		);
	}
	else {
		return false;
	}
}

/* Delete a scan. */
function ks_da_scan_delete($ks_db, int $scan_id) {
	$ks_db->transaction(function($ks_db) use ($scan_id) {
		$ks_db->query('DELETE FROM card_scan WHERE scan_id = $1', array($scan_id));
		$ks_db->query('DELETE FROM scan WHERE scan_id = $1', array($scan_id));
	});
}
