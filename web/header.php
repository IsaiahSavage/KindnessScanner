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
);

// Include user-specified configuration.
include('config.php');

class KSDBPSQL
{
	protected $conn;

	public function __construct(string $host, int $port, string $database, string $user, string $password) {
		$dbs = sprintf("host='%s' port='%d' dbname='%s' user='%s' password='%s'", $host, $port, $database, $user, $password);
		$this->conn = pg_connect($dbs) || die('Could not connect to database: ' . $dbs);
	}
};

$ks_db = new KSDBPSQL($ks_config['db_host'], $ks_config['db_port'], $ks_config['db_name'], $ks_config['db_user'], $ks_config['db_password']);
