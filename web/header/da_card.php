<?php

include_once('header.php');

/* Add a card to the database, created at a specific Coordinate and at the specified UNIX epoch timestamp, registered to the specified user.
Returns the card ID of the added card. */
function ks_da_card_add($ks_db, $creation_location, int $timestamp, int $user_id) {
	return $ks_db->transaction(function($ks_db) use ($creation_location, $timestamp, $user_id) {
		$card_id = $ks_db->query_next($ks_db->query('INSERT INTO card (creation_latitude, creation_longitude, creation_time) VALUES ($1, $2, to_timestamp($3)) RETURNING card_id', array($creation_location->getLat(), $creation_location->getLng(), $timestamp)))[0];
		$ks_db->query('INSERT INTO r_u_card (card_id, user_id) VALUES ($1, $2)', array($card_id, $user_id));
		$ks_db->t_commit();
		return $card_id;
	});
}

/* Returns an array of information about a card with keys:
id, creation_location [Coordinate], creation_timestamp [UNIX epoch timestamp], owner
Returns false if the card does not exist. */
function ks_da_card_get($ks_db, int $card_id) {
	$row = $ks_db->query_next($ks_db->query('SELECT card.card_id, creation_latitude, creation_longitude, extract(epoch FROM creation_time), user_id FROM card LEFT JOIN r_u_card ON card.card_id = r_u_card.card_id WHERE card.card_id = $1', array($card_id)));
	if($row) {
		return array(
			'id' => $row[0],
			'creation_location' => new Location\Coordinate((float) $row[1], (float) $row[2]),
			'creation_time' => $row[3],
			'owner' => $row[4],
		);
	}
	else {
		return false;
	}
}
