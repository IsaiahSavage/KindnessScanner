<?php

// PostgreSQL connection.
class KSDBPSQL
{
	protected $conn_id;
	protected $conn;

	/* Connect to the database with the appropriate parameters.
	Raises ErrorException on failure. */
	public function __construct(string $host, int $port, string $database, string $user, string $password) {
		$this->conn_id = sprintf("host='%s' port='%d' dbname='%s' user='%s'", $host, $port, $database, $user);
		$dbs = sprintf("%s password='%s'", $this->conn_id, $password);
		$this->conn = pg_connect($dbs);
		if(!$this->conn)
			die('Could not connect to database: ' . $dbs);
	}

	public function __destruct() {
		pg_close($this->conn);
	}

	/* Transaction wrappers. */
	public function t_begin() { $this->query("BEGIN"); }
	public function t_rollback() { $this->query("ROLLBACK"); }
	public function t_commit() { $this->query("COMMIT"); }

	/* Query with parameters. Placeholders are $1, $2, ..., $n
	Raises KSSQLException on failure. */
	public function query(string $query, array $params = array()) {
		$result = pg_query_params($this->conn, $query, $params);
		if($result) {
			return $result;
		}
		else {
			throw new KSSQLException(pg_last_error($this->conn));
		}
	}

	/* Fetches the next row of data as an array from a result, or false if there is no data left. */
	public function query_next($result) {
		return pg_fetch_row($result);
	}

	/* Wrapper around query() and query_next() that fetches all rows and returns an array of them. */
	public function query_array(string $query, array $params = array()) {
		$ret = array();
		$result = $this->query($query, $params);
		while($row = $this->query_next($result)) {
			array_push($ret, $row);
		}
		return $ret;
	}
};
