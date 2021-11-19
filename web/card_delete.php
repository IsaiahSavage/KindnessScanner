<?php

include_once('header/da_card.php');
include_once('header/da_user.php');
include_once('header/permissions.php');
include_once('header/messages.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email_confirm = $_POST['email_confirm'];

	$card = ks_da_card_get($ks_db, (int) $_POST['card_id']);
	$owner = ks_da_user_get($ks_db, $card['owner']);

	if(ks_can_manage_card($card['id'])) {
		if($owner['email'] !== $email_confirm) {
			ks_push_message('Confirmation email address did not match');
		}
		else {
			ks_da_card_delete($ks_db, $card['id']);
			ks_push_message('Card deleted');
			header('Location: ' . 'user_manager.php?user_id=' . $owner['id']);
			die();
		}
	}
	else {
		ks_push_message('Permission denied');
	}

	header('Location: ' . 'card_manager.php?card_id=' . $card['id']);
	die();
}

