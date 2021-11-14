<?php

include_once('header/da_user.php');

session_start();

/* When the user is logged in, this will become an array with the keys:
name, email, privilege */
$ks_logged_in_user = false;

/* Log in this session for the specified user. */
function ks_session_load(int $user_id) {
	$_SESSION['user_id'] = $user_id;

	GLOBAL $ks_logged_in_user;
	GLOBAL $ks_db;
	$ks_logged_in_user = ks_da_user_get($ks_db, $user_id);
}

/* Clear the session information (log out). */
function ks_session_clear() {
	unset($_SESSION['user_id']);

	GLOBAL $ks_logged_in_user;
	$ks_logged_in_user = false;
}

/* Restore the session. */
if(isset($_SESSION['user_id'])) {
	ks_session_load($_SESSION['user_id']);
}
