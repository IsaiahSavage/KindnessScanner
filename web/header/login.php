<?php

include_once('header/da_user.php');

/* Log in the user. Updates the session information and $ks_logged_in_user.
Returns boolean for successful login. */
function ks_login(string $email, string $password) {
	GLOBAL $ks_db;
	$user_id = ks_da_user_verify($ks_db, $email, $password);
	if($user_id) {
		// Login info OK, actually log in.
		ks_session_load($user_id);
		return true;
	}
	else {
		// Bad login.
		return false;
	}
}
