<?php

namespace implementing\models\admin;

use \components\Validator;
use \implementing\validators\YBValidator;
use \components\DBConnection;
use \implementing\dbconnections\MySQLConnection;
use \interfaces\models\admin\IPriceModel;

class MySQLPriceModel implements IPriceModel
{
	private $db_connection;
	private $validator;

	/**
	 * Sets validator, connection with db
	 */
	public function __construct()
	{
		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator());

		$this->db_connection = new DBConnection();
		$this->db_connection->set_connection(new MySQLConnection);
	}

	/**
	 * Uploads new prices apartments in db
	 *
	 * @return json and/or http headers with status code
	 */
	public function upload(array $nums_prices)
	{
		/*
			Made a transaction because updating a small amount of data (The amount of data will not increase)
		*/
		try {
			$db = $this->db_connection->get_connection();
			$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$db->beginTransaction();

	        $sql = "UPDATE apartments SET price = :price WHERE num = :num";

	       	$query = $db->prepare($sql);

	       	foreach ($nums_prices as $num_price) {
				$query->bindValue(':num', $num_price['num']);
				$query->bindValue(':price', $num_price['price']);
				
				$query->execute();
			}

			$db->commit();

			header('HTTP/1.0 200 OK', http_response_code(200));

			$response['message'] = 'Готово';

			echo json_encode($response);
			return true;
		} catch (\PDOException $e) {
			$db->rollBack();

			http_response_code(500);
			$this->validator->check_response('ajax');
		}
	}
}