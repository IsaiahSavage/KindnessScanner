<?php

include_once('header/da_user.php');
include_once('header/permissions.php');
include_once('header/messages.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$user_id = (int) $_POST['user_id'];

	if(ks_privilege() == 'admin') {
		$privilege = $_POST['privilege'];

		if(in_array($privilege, $ks_possible_privileges, true)) {
			$ks_db->query('UPDATE registered_user SET privilege = $1 WHERE user_id = $2', array($privilege, $user_id));
			ks_push_message('Privilege changed');
		}
		else {
			ks_push_message('Privilege was not valid');
		}
	}
	else {
		ks_push_message('Permission denied');
	}

	header('Location: ' . 'user_manager.php?user_id=' . $user_id);
	die();
}
