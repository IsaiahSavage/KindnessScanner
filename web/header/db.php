<?php

// General SQL error.
class KSSQLException extends Exception {};

// Database wrapper base.
class KSDB {

	/* Run the function `f` wrapped within a transaction. Any exception will cause rollback. `f` will be passed the database wrapper. `af` will occur upon success, after committing. `ef` will occur upon error, after rollback.
	Returns the return value of `f`. */
	public function transaction($f, $af = null, $ef = null) {
		$this->t_begin();
		try {
			$ret = $f($this);

			$this->t_commit();

			if($af !== null)
				$af($this);

			return $ret;
		}
		catch(Exception $e) {
			$this->t_rollback();

			if($ef !== null)
				$ef($this);

			throw $e;
		}
	}
}
