<?php

/* Establish error reporting. */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Turn PHP errors into Exceptions, for easier handling. */
function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
set_error_handler("exception_error_handler");

// Default configuration.
$ks_config = array(
	'title' => 'Kindness Scanner',
	'project_dir' => realpath(__DIR__ . '/..'),
);

// Include user-specified configuration.
include_once('config.php');

/* Include composer libraries. */
require_once $ks_config['project_dir'] . '/vendor/autoload.php';

/* Include database wrappers. */
include_once('header/db.php');
include_once('header/db_postgresql.php');

// Connect to the database.
$ks_db = new KSDBPSQL($ks_config['db_host'], $ks_config['db_port'], $ks_config['db_name'], $ks_config['db_user'], $ks_config['db_password']);

/* Establish the session. */
include_once('header/session.php');
