<?php
	include_once('header/session.php');

	ks_session_clear();
	header('Location: index.php');
	die();

