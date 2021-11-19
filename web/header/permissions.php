<?php

include_once('header/session.php');
include_once('header/da_card.php');
include_once('header/da_user.php');

$ks_possible_privileges = array("user", "admin");

function ks_privilege() {
	GLOBAL $ks_logged_in_user;
	return $ks_logged_in_user ? $ks_logged_in_user['privilege'] : false;
}

function ks_can_manage_cards() {
	return ks_privilege() === 'admin';
}

function ks_can_manage_users() {
	return ks_privilege() === 'admin';
}

function ks_can_manage_scans() {
	return ks_privilege() === 'admin';
}

function ks_can_manage_user(int $user_id) {
	GLOBAL $ks_logged_in_user;
	return ks_can_manage_users() || ($ks_logged_in_user && $user_id === $ks_logged_in_user['id']);
}

function ks_can_manage_card(int $card_id) {
	GLOBAL $ks_db;
	GLOBAL $ks_logged_in_user;
	return ks_can_manage_cards() || ($ks_logged_in_user && ks_da_card_get($ks_db, $card_id)['owner'] === $ks_logged_in_user['id']);
}

function ks_can_manage_scan(int $scan_id) {
	return ks_can_manage_scans();
}
