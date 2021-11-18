<?php

include_once('header/da_user.php');
include_once('header/permissions.php');
include_once('header/messages.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$user_id = (int) $_POST['user_id'];

	if(ks_can_manage_user($user_id)) {
		$email = $_POST['email'];

		if(!empty($email)) {
			if(empty($ks_db->query_array('SELECT user_id FROM registered_user WHERE email = $1', array($email)))) {
				$ks_db->query('UPDATE registered_user SET email = $1 WHERE user_id = $2', array($email, $user_id));
				ks_push_message('Email changed');
			}
			else {
				ks_push_message('Cannot use that email address');
			}
		}
		else {
			ks_push_message('Email was empty');
		}
	}
	else {
		ks_push_message('Permission denied');
	}

	header('Location: ' . 'user_manager.php?user_id=' . $user_id);
	die();
}
