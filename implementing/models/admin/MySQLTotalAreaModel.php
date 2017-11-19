<?php

namespace implementing\models\admin;

use \components\Validator;
use \implementing\validators\YBValidator;
use \components\DBConnection;
use \implementing\dbconnections\MySQLConnection;
use \interfaces\models\admin\ITotalAreaModel;

class MySQLTotalAreaModel implements ITotalAreaModel
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
	 * Gets all totals areas from db
	 *
	 * @return array data or http headers with status code
	 */
	public function get_all()
	{
		$db = $this->db_connection->get_connection();

        $sql = "SELECT id, total_area FROM total_areas ORDER BY id DESC";

       	$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}

	/**
	 * Gets all totals areas from db by offset/limit
	 *
	 * @param $offset - place for start
	 * @param $limit - record number limit
	 * @return array data or http headers with status code
	 */
	public function get_all_by_offset_limit(int $offset, int $limit)
	{
		$db = $this->db_connection->get_connection();

		$sql = "SELECT id, total_area FROM total_areas ORDER BY id DESC LIMIT :offset, :limit";

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

	/**
	 * Saves total area in db
	 * 
	 * @param $data - data for save
	 * @return json and/or http headers with status code
	 */
	public function create(array $data)
	{
        $data = $this->validator->validate($data, [
            'total_area' => 'Общая площадь|empty|is_integer|length_integer',
        ]);

		$db = $this->db_connection->get_connection();

		$sql = 'INSERT INTO total_areas (total_area) VALUES (:total_area)';

		$query = $db->prepare($sql);

		$query->bindValue(':total_area', $data['total_area'], \PDO::PARAM_INT);

		if ($query->execute()) {
			header('HTTP/1.0 200 OK', http_response_code(200));

			$response['message'] = 'Готово';
			$response['data'] = $data;

			echo json_encode($response);
		} else {
			http_response_code(500);
			$this->validator->check_response('ajax');
		}
	}

	/**
	 * Gets total area by id from db
	 * 
	 * @param $id - total area id
	 * @return array data or http headers with status code
	 */
	public function show(int $id)
	{
		$db = $this->db_connection->get_connection();

		$sql = 'SELECT id, total_area FROM total_areas WHERE id = :id';

		$query = $db->prepare($sql);

		$query->bindValue(':id', $id, \PDO::PARAM_INT);

		if ($query->execute()) {
			return $query->fetch(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response('ajax');
		}
	}

	/**
	 * Updates selected total area in db
	 * 
	 * @param $data - data for update
	 * @return json and/or http headers with status code
	 */
	public function update(array $data)
	{
        $data = $this->validator->validate($data, [
            'total_area' => 'Общая площадь|empty|is_integer|length_integer',
        ]);

		$db = $this->db_connection->get_connection();

		$sql = 'UPDATE total_areas SET total_area = :total_area WHERE id = :id';

		$query = $db->prepare($sql);

		$id = (int) $data['id'];
		$query->bindValue(':id', $id, \PDO::PARAM_INT);
		$query->bindValue(':total_area', $data['total_area'], \PDO::PARAM_INT);

		if ($query->execute()) {
			header('HTTP/1.0 200 OK', http_response_code(200));

			$response['message'] = 'Готово';
			$response['data'] = $data;

			echo json_encode($response);
		} else {
			http_response_code(500);
			$this->validator->check_response('ajax');
		}
	}

	/**
	 * Deletes selected total area from db
	 * 
	 * @param $id - total area id
	 * @return json and/or http headers with status code
	 */
	public function delete(int $id)
	{
		$db = $this->db_connection->get_connection();

		$sql = 'DELETE FROM total_areas WHERE id = :id';

		$query = $db->prepare($sql);

		$query->bindValue(':id', $id, \PDO::PARAM_INT);

		if ($query->execute()) {
			header('HTTP/1.0 200 OK', http_response_code(200));

			$response = [];
			$response['message'] = 'Готово';

			echo json_encode($response);
		} else {
			http_response_code(500);
			$this->validator->check_response('ajax');
		}
	}

	/**
	 * Counts total area in db
	 * 
	 * @return array data or http headers with status code
	 */
	public function count()
	{
		$db = $this->db_connection->get_connection();
		
		$sql = 'SELECT COUNT(*) FROM total_areas';

		$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}
}