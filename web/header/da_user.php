<?php

include_once('header.php');

/* Add a new user. Accepts array of params with keys:
name, email, password, privilege
Returns new user's ID. */
function ks_da_user_add($ks_db, array $params) {
	return $ks_db->query_next($ks_db->query('INSERT INTO registered_user (name, email, password, privilege) VALUES ($1, $2, $3, $4) RETURNING user_id',
		array($params['name'], $params['email'], password_hash($params['password'], PASSWORD_DEFAULT), $params['privilege'])))[0];
}

/* Verifies login information of e-mail and password.
Returns the user ID if the verification was successful, or `false` if it was not. */
function ks_da_user_verify($ks_db, string $email, string $password) {
	// Find the registered user for this e-mail address.
	$rows = $ks_db->query_array('SELECT user_id,password FROM registered_user WHERE email = $1', array($email));

	if(empty($rows)) {
		// No such user.
		return false;
	}
	else {
		// User found; check password against hash.
		$row = $rows[0];
		if(password_verify($password, $row[1])) {
			// Password OK, return ID.
			return $row[0];
		}
		else {
			// Pasword not OK.
			return false;
		}
	}
}

/* Returns an array of user information for the specified ID with keys:
id, name, email, privilege
Returns false if the user does not exist. */
function ks_da_user_get($ks_db, int $user_id) {
	$row = $ks_db->query_next($ks_db->query('SELECT user_id,name,email,privilege FROM registered_user WHERE user_id = $1', array($user_id)));
	if($row) {
		return array(
			'id' => $row[0],
			'name' => $row[1],
			'email' => $row[2],
			'privilege' => $row[3],
		);
	}
	else {
		return false;
	}
}
