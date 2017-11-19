<?php

namespace components;

use \interfaces\dbconnections\IDBConnection;

class DBConnection
{
	private $connection;

	/**
	 * Sets connection with db
	 *
	 * @param IDBConnection $connection - object implementing IDBConnection
	 */
	public function set_connection(IDBConnection $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * Gets connection with db
	 *
	 * @return result of the function get_connection
	 */
	public function get_connection()
	{
		return $this->connection->get_connection();
	}
}