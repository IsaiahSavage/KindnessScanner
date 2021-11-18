<?php

include_once('header/da_user.php');
include_once('header/permissions.php');
include_once('header/messages.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$user_id = (int) $_POST['user_id'];

	if(ks_can_manage_user($user_id)) {
		$password = $_POST['password'];
		$password_confirm = $_POST['password_confirm'];

		if($password === $password_confirm) {
			ks_da_user_set_password($ks_db, $user_id, $password);
			ks_push_message('Password changed');
		}
		else {
			ks_push_message('Passwords did not match');
		}
	}
	else {
		ks_push_message('Permission denied');
	}

	header('Location: ' . 'user_manager.php?user_id=' . $user_id);
	die();
}
