<?php

include_once('header/session.php');

if(!isset($_SESSION['messages'])) {
	$_SESSION['messages'] = array();
}

function ks_push_message(string $message) {
	array_push($_SESSION['messages'], $message);
}

function ks_pop_messages() {
	$ret = $_SESSION['messages'];
	$_SESSION['messages'] = array();
	return $ret;
}
