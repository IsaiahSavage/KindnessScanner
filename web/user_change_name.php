<?php

include_once('header/da_user.php');
include_once('header/permissions.php');
include_once('header/messages.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$user_id = (int) $_POST['user_id'];

	if(ks_can_manage_user($user_id)) {
		$name = $_POST['name'];

		if(!empty($name)) {
			$ks_db->query('UPDATE registered_user SET name = $1 WHERE user_id = $2', array($name, $user_id));
			ks_push_message('Name changed');
		}
		else {
			ks_push_message('Name was empty');
		}
	}
	else {
		ks_push_message('Permission denied');
	}

	header('Location: ' . 'user_manager.php?user_id=' . $user_id);
	die();
}
