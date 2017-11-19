<?php

namespace implementing\models\site;

use \components\Validator;
use \implementing\validators\YBValidator;
use \components\DBConnection;
use \implementing\dbconnections\MySQLConnection;
use \interfaces\models\site\IApartmentModel;

class MySQLApartmentModel implements IApartmentModel
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
	 * Gets all apartment from db
	 *
	 * @param $condition - conditiono for query
	 * @return array data or http headers with status code
	 */
	public function get_all(string $condition='')
	{
		$db = $this->db_connection->get_connection();

        $sql = "SELECT a.id, a.factual_area, a.floor, a.num, a.price, a.status, t.type, t_a.total_area, GROUP_CONCAT(DISTINCT w.name SEPARATOR ', ') AS windows FROM apartments a JOIN types t ON a.type_id = t.id JOIN total_areas t_a ON a.total_area_id = t_a.id JOIN apartments_windows a_w ON a.id = a_w.apartment_id JOIN windows w ON a_w.window_id = w.id $condition GROUP BY a.id ORDER BY a.num";

       	$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}

	/**
	 * Buy apartment
	 * 
	 * @param $data - data about seller and buyer
	 * @return json and/or http headers with status code
	 */
	public function buy(array $data)
	{
        $data = $this->validator->validate($data, [
			'name' => 'Имя|empty|length_string',
			'surname' => 'Фамилия|empty|length_string',
        ]);

        try {
        	$db = $this->db_connection->get_connection();
        	$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        	$db->beginTransaction();

			$sql = 'UPDATE apartments SET status = :status WHERE num = :num';
			$query = $db->prepare($sql);
			$query->bindValue(':num', $data['apartment_num'], \PDO::PARAM_INT);
			$query->bindValue(':status', 3, \PDO::PARAM_INT);
			$query->execute();

			$sql = 'INSERT INTO buyers (name, surname, phone, email) VALUES (:name, :surname, :phone, :email)';
			$query = $db->prepare($sql);
			$query->bindValue(':name', $data['name'], \PDO::PARAM_STR);
			$query->bindValue(':surname', $data['surname'], \PDO::PARAM_STR);
			$query->bindValue(':phone', $data['phone'], \PDO::PARAM_STR);
			$query->bindValue(':email', $data['email'], \PDO::PARAM_STR);
			$query->execute();

			$sql = 'INSERT INTO purchased_apartments (buyer_id, seller_id, apartment_id) VALUES (:buyer_id, :seller_id, :apartment_id)';
			$query = $db->prepare($sql);
			$buyer_id = (int) $db->lastInsertId();
			$seller_id = (int) $_SESSION['user'];
			$query->bindValue(':buyer_id', $buyer_id, \PDO::PARAM_INT);
			$query->bindValue(':seller_id', $seller_id, \PDO::PARAM_INT);
			$query->bindValue(':apartment_id', $data['apartment_id'], \PDO::PARAM_INT);
			$query->execute();

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

	/**
	 * Gets statistics of apartments by floor/type
	 *
	 * @return array data or json with http status code
	 */
	public function get_floors_types_aparts()
	{
		$db = $this->db_connection->get_connection();

		$sql = "SELECT a.floor, SUM(CASE WHEN a.type_id = 1 AND a.status = 1 THEN 1 ELSE 0 END) AS '1', SUM(CASE WHEN a.type_id = 4 AND a.status = 1 THEN 1 ELSE 0 END) AS '4', SUM(CASE WHEN a.type_id = 2 AND a.status = 1 THEN 1 ELSE 0 END) AS '2', SUM(CASE WHEN a.type_id = 3 AND a.status = 1 THEN 1 ELSE 0 END) AS '3' FROM apartments a GROUP BY a.floor";

		$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}

	/**
	 * Gets info about apartments
	 *
	 * @return array data or json with http status code
	 */
	public function get_general_info_apartments()
	{
		$db = $this->db_connection->get_connection();

		$sql = "SELECT a.type_id, a.total_area_id, t.type, t_a.total_area, COUNT(*) summary, SUM(a.status = 1) free FROM apartments a JOIN types t ON a.type_id = t.id JOIN total_areas t_a ON a.total_area_id = t_a.id GROUP BY a.type_id, a.total_area_id";

		$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}

	/**
	 * Reserve apartment
	 *
	 * @param $data - data about seller and buyers
	 * @return json and/or http headers with status code
	 */
	public function reserve(array $data)
	{
        $data = $this->validator->validate($data, [
			'name' => 'Имя|empty|length_string',
			'surname' => 'Фамилия|empty|length_string',
        ]);

        try {
        	$db = $this->db_connection->get_connection();
        	$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        	$db->beginTransaction();

		    $sql = 'INSERT INTO buyers (name, surname, phone, email) VALUES (:name, :surname, :phone, :email)';
		    $query = $db->prepare($sql);
			$query->bindValue(':name', $data['name'], \PDO::PARAM_STR);
			$query->bindValue(':surname', $data['surname'], \PDO::PARAM_STR);
			$query->bindValue(':phone', $data['phone'], \PDO::PARAM_STR);
			$query->bindValue(':email', $data['email'], \PDO::PARAM_STR);
		    $query->execute();

		    $buyer_id = $db->lastInsertId();
		    $sql = 'INSERT INTO reserved_apartments (buyer_id, seller_id, apartment_id, time_end_reserve) VALUES (:buyer_id, :seller_id, :apartment_id, :time_end_reserve)';
		    $query = $db->prepare($sql);

			$time_reserve = $data['time_reserve'];
			$time_end_reserve = date('Y-m-d H:i:s', strtotime("+$time_reserve day"));
		    $seller_id = (int) $_SESSION['user'];

			$query->bindValue(':buyer_id', $buyer_id, \PDO::PARAM_INT);
			$query->bindValue(':apartment_id', $data['apartment_id'], \PDO::PARAM_INT);
			$query->bindValue(':seller_id', $seller_id, \PDO::PARAM_INT);
			$query->bindValue(':time_end_reserve', $time_end_reserve, \PDO::PARAM_STR);
		    $query->execute();

		   	if ($_SESSION['role_id'] == 4) {
				$status = 5;
			} else {
				$status = 2;
			}
	    	$sql = 'UPDATE apartments SET status = :status WHERE id = :apartment_id';
	    	$query = $db->prepare($sql);
	    	$query->bindValue(':apartment_id', $data['apartment_id'], \PDO::PARAM_INT);
	    	$query->bindValue(':status', $status, \PDO::PARAM_INT);
		   	$query->execute();

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

	/**
	 * Withdraw reserve apartment
	 *
	 * @param $apartment_id - apartment id
	 * @return json and/or http headers with status code
	 */
	public function withdraw_reserve(int $apartment_id)
	{
    	$db = $this->db_connection->get_connection();

    	$sql = 'UPDATE apartments SET status = 1 WHERE id = :apartment_id';

    	$query = $db->prepare($sql);

    	$query->bindValue(':apartment_id', $apartment_id, \PDO::PARAM_INT);

	   	if ($query->execute()) {
			header('HTTP/1.0 200 OK', http_response_code(200));

			$response['message'] = 'Готово';

			echo json_encode($response);
			return true;
	   	} else {   		
			http_response_code(500);
			$this->validator->check_response('ajax');
	   	}
	}

	/**
	 * Auto withdraw reserve apartment (for cron)
	 *
	 * @return json and/or http headers with status code
	 */
	public function auto_withdraw_reserve()
	{
        try {
        	$db = $this->db_connection->get_connection();
        	$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        	$db->beginTransaction();

        	$cur_date = date('Y-m-d H:i:s');
			$sql = 'SELECT buyer_id, apartment_id, time_end_reserve FROM reserved_apartments WHERE time_end_reserve < :cur_date';
			$query = $db->prepare($sql);
			$query->bindValue(':cur_date', $cur_date);
			$query->execute();

			$buyers_apartments = [];
			$i = 0;
			while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
				$buyers_apartments[$i]['buyer_id'] = $row['buyer_id'];
				$buyers_apartments[$i]['apartment_id'] = $row['apartment_id'];
				$i++;
			}

			if (count($buyers_apartments) > 0) {
				foreach ($buyers_apartments as $buyer_apartment) {
					$sql = 'UPDATE apartments SET status = 1 WHERE id = :apartment_id';
					$query = $db->prepare($sql);
					$query->bindValue(':apartment_id', $buyer_apartment['apartment_id']);
					$query->execute();
				}
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