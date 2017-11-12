<?php

namespace implementing\models\admin;

use \components\Validator;
use \implementing\validators\YBValidator;
use \components\DBConnection;
use \implementing\dbconnections\MySQLConnection;
use \interfaces\models\admin\IDealModel;

class MySQLDealModel implements IDealModel
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

	public function get_all_by_offset_limit(int $offset, int $limit)
	{
		$db = $this->db_connection->get_connection();

		$sql = "SELECT a.num, u.name as seller_name, u.surname as seller_surname, u.patronymic as seller_patronymic, u.phone as seller_phone, b.name as buyer_name, b.surname as buyer_surname, b.phone as buyer_phone, p_a.time_purchase FROM purchased_apartments p_a JOIN users u ON p_a.seller_id = u.id JOIN buyers b ON p_a.buyer_id = b.id JOIN apartments a ON p_a.apartment_id = a.id WHERE a.status = 3 ORDER BY p_a.time_purchase DESC LIMIT :offset, :limit";

       	$query = $db->prepare($sql);

       	$query->bindValue(':offset', $offset, \PDO::PARAM_INT);
		$query->bindValue(':limit', $limit, \PDO::PARAM_INT);
       	
		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}

	public function count()
	{
		$db = $this->db_connection->get_connection();
		
		$sql = 'SELECT COUNT(*) FROM purchased_apartments';

		$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}
}