<?php

namespace implementing\models\site;

use \components\Validator;
use \validators\YBValidator;
use \components\DBConnection;
use \dbconnections\MySQLConnection;
use \interfaces\models\site\IBuyerModel;

class MySQLBuyerModel implements IBuyerModel
{
	private $db_connection;
	private $validator;

	public function __construct()
	{
		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator());

		$this->db_connection = new DBConnection();
		$this->db_connection->set_connection(new MySQLConnection);
	}

	public function show(int $id)
	{
		$db = $this->db_connection->get_connection();

		$sql = 'SELECT b.id, b.name, b.surname, b.phone, b.email, b_a.reservator_id FROM buyers_reservators_apartments b_a LEFT JOIN buyers b ON b_a.buyer_id = b.id WHERE b_a.apartment_id = :id';

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