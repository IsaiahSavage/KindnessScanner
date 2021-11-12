<?php

include_once('header.php');

/* Add a new user. Accepts array of params with keys:
name, email, password, privilege */
function ks_da_user_add($ks_db, array $params) {
	$ks_db->query('INSERT INTO registered_user (name, email, password, privilege) VALUES ($1, $2, $3, $4)',
		array($params['name'], $params['email'], password_hash($params['password'], PASSWORD_DEFAULT), $params['privilege']));
}
