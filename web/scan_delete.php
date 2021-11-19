<?php

include_once('header/da_scan.php');
include_once('header/permissions.php');
include_once('header/messages.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$scan_confirm = (int) $_POST['scan_confirm'];

	$scan = ks_da_scan_get($ks_db, (int) $_POST['scan_id']);

	if(ks_can_manage_scan($scan['id'])) {
		if($scan['id'] !== $scan_confirm) {
			ks_push_message('Confirmation ID did not match');
		}
		else {
			ks_da_scan_delete($ks_db, $scan['id']);
			ks_push_message('Scan deleted');
			header('Location: ' . 'card_manager.php?card_id=' . $scan['card']);
			die();
		}
	}
	else {
		ks_push_message('Permission denied');
	}

	header('Location: ' . 'scan_manager.php?scan_id=' . $scan['id']);
	die();
}

