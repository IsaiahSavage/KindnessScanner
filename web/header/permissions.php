<?php

include_once('header/session.php');
include_once('header/da_card.php');
include_once('header/da_user.php');

function ks_privilege() {
	GLOBAL $ks_logged_in_user;
	return $ks_logged_in_user && $ks_logged_in_user['privilege'];
}

function ks_can_manage_cards() {
	return ks_privilege() == 'admin';
}

function ks_can_manage_card(int $card_id) {
	GLOBAL $ks_db;
	GLOBAL $ks_logged_in_user;
	return ks_can_manage_cards() || ks_da_card_get($ks_db, $card_id)['owner'] == $ks_logged_in_user['id'];
}
