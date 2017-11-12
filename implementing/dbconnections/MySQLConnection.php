<?php

namespace implementing\dbconnections;

use \interfaces\dbconnections\IDBConnection;

class MySQLConnection implements IDBConnection
{
	/**
	 * Return object for work with database
	 *
	 * @return {object} $db - object for work with database
	 */
	public function get_connection()
	{
		$path = ROOT . '/config/DB.php';
		$params = include($path);

		$dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
		$user = $params['user'];
		$password = $params['password'];

		$db = new \PDO($dsn, $user, $password);
		$db->exec('set names utf8');

		return $db;
	}
}