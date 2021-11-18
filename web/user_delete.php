<?php

include_once('header/da_user.php');
include_once('header/permissions.php');
include_once('header/messages.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$user_id = (int) $_POST['user_id'];
	$email_confirm = $_POST['email_confirm'];

	if(ks_privilege() == 'admin') {
		$user = ks_da_user_get($ks_db, $user_id);
		if($user['privilege'] === 'admin') {
			ks_push_message('Cannot delete an administrator');
		}
		else if($user['email'] !== $email_confirm) {
			ks_push_message('Confirmation email address did not match');
		}
		else {
			ks_da_user_delete($ks_db, $user_id);
			ks_push_message('User deleted');
			header('Location: ' . 'users_manager.php');
			die();
		}
	}
	else {
		ks_push_message('Permission denied');
	}

	header('Location: ' . 'user_manager.php?user_id=' . $user_id);
	die();
}
