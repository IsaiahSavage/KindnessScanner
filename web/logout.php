<?php
	include_once('header/session.php');
	include_once('header/messages.php');

	ks_session_clear();

	ks_push_message('Logged out');
	header('Location: index.php');
	die();

