<?php

include_once('header/da_card.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$owner_id = (int) $_POST['user_id'];
	$latitude = (float) $_POST['latitude'];
	$longitude = (float) $_POST['longitude'];
	$time = time();

	$card_id = ks_da_card_add($ks_db, new Location\Coordinate($latitude, $longitude), time(), $owner_id);

	header('Location: ' . 'card_manager.php?card_id=' . $card_id);
	die();
}
