<?php

include_once('header.php');

echo("Creating database...\n");

$ks_db->transaction(function($ks_db) {
	/* Tables. */
	$ks_db->query('CREATE TABLE registered_user(user_id SERIAL PRIMARY KEY, name TEXT NOT NULL, email TEXT NOT NULL UNIQUE, password TEXT NOT NULL, privilege TEXT NOT NULL)');
	$ks_db->query('CREATE TABLE card(card_id SERIAL PRIMARY KEY, creation_latitude NUMERIC(9,6) NOT NULL, creation_longitude NUMERIC(9,6) NOT NULL, creation_time TIMESTAMP WITH TIME ZONE NOT NULL)');
	$ks_db->query('CREATE TABLE scan(scan_id SERIAL PRIMARY KEY, latitude NUMERIC(9,6) NOT NULL, longitude NUMERIC(9,6) NOT NULL, time TIMESTAMP WITH TIME ZONE NOT NULL, description TEXT NOT NULL)');
	$ks_db->query('CREATE TABLE r_u_card(card_id INTEGER PRIMARY KEY, user_id INTEGER)');
	$ks_db->query('CREATE TABLE card_scan(scan_id INTEGER PRIMARY KEY, card_id INTEGER)');

	/* Foreign keys. */
	$ks_db->query('ALTER TABLE r_u_card ADD CONSTRAINT fk_r_u_card_card FOREIGN KEY (card_id) REFERENCES card (card_id)');
	$ks_db->query('ALTER TABLE r_u_card ADD CONSTRAINT fk_r_u_card_user FOREIGN KEY (user_id) REFERENCES registered_user (user_id)');
	$ks_db->query('ALTER TABLE card_scan ADD CONSTRAINT fk_card_scan_scan FOREIGN KEY (scan_id) REFERENCES scan (scan_id)');
	$ks_db->query('ALTER TABLE card_scan ADD CONSTRAINT fk_card_scan_card FOREIGN KEY (card_id) REFERENCES card (card_id)');

	/* Indexes. */
	$ks_db->query('CREATE INDEX idx_name ON registered_user(name)');
	$ks_db->query('CREATE INDEX idx_email ON registered_user(email)');
	$ks_db->query('CREATE INDEX idx_description ON scan(description)');
}, function($ks_db) {
	echo("Successfully created new database.\n");
}, function($ks_db) {
	echo("Failed to create database, rolling back...\n");
});
