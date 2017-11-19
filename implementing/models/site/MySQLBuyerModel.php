<?php

namespace implementing\models\site;

use \components\Validator;
use \implementing\validators\YBValidator;
use \components\DBConnection;
use \implementing\dbconnections\MySQLConnection;
use \interfaces\models\site\IBuyerModel;

class MySQLBuyerModel implements IBuyerModel
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
	 * Gets buyer by id from db
	 * 
	 * @param $id - buyer id
	 * @return array data or http headers with status code
	 */
	public function show(int $id)
	{
		$db = $this->db_connection->get_connection();

		$sql = 'SELECT b.id, b.name, b.surname, b.phone, b.email, r_a.seller_id FROM reserved_apartments r_a LEFT JOIN buyers b ON r_a.buyer_id = b.id WHERE r_a.apartment_id = :id';

		$query = $db->prepare($sql);

		$query->bindValue(':id', $id, \PDO::PARAM_INT);

		if ($query->execute()) {
			return $query->fetch(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response('ajax');
		}
	}
}