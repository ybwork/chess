<?php

namespace implementing\models\admin;

use \components\Validator;
use \implementing\validators\YBValidator;
use \components\DBConnection;
use \implementing\dbconnections\MySQLConnection;
use \interfaces\models\admin\IWindowModel;

class MySQLWindowModel implements IWindowModel
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
	 * Gets all windows from db
	 *
	 * @return array data or http headers with status code
	 */
	public function get_all()
	{
		$db = $this->db_connection->get_connection();

        $sql = 'SELECT id, name FROM windows ORDER BY id DESC';

       	$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}

	/**
	 * Gets all windows from db by offset/limit
	 *
	 * @param $offset - place for start
	 * @param $limit - record number limit
	 * @return array data or http headers with status code
	 */
	public function get_all_by_offset_limit(int $offset, int $limit)
	{
		$db = $this->db_connection->get_connection();

		$sql = "SELECT id, name FROM windows ORDER BY id DESC LIMIT :offset, :limit";

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
	 * Saves window in db
	 * 
	 * @param $data - data for save
	 * @return json and/or http headers with status code
	 */
	public function create(array $data)
	{
        $data = $this->validator->validate($data, [
            'name' => 'Имя|empty|length_string',
        ]);

		$db = $this->db_connection->get_connection();

		$sql = 'INSERT INTO windows (name) VALUES (:name)';

		$query = $db->prepare($sql);

		$query->bindValue(':name', $data['name'], \PDO::PARAM_STR);

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
	 * Gets window by id from db
	 * 
	 * @param $id - window id
	 * @return array data or http headers with status code
	 */
	public function show(int $id)
	{
		$db = $this->db_connection->get_connection();

		$sql = 'SELECT id, name FROM windows WHERE id = :id';

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
	 * Updates selected window in db
	 * 
	 * @param $data - data for update
	 * @return json and/or http headers with status code
	 */
	public function update(array $data)
	{
		$db = $this->db_connection->get_connection();

        $data = $this->validator->validate($data, [
            'name' => 'Имя|empty|length_string',
        ]);

		$sql = 'UPDATE windows SET name = :name WHERE id = :id';

		$query = $db->prepare($sql);

		$id = (int) $data['id'];
		$query->bindValue(':id', $id, \PDO::PARAM_INT);
		$query->bindValue(':name', $data['name'], \PDO::PARAM_STR);

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
	 * Deletes selected window from db
	 * 
	 * @param $id - window id
	 * @return json and/or http headers with status code
	 */
	public function delete(int $id)
	{
		$db = $this->db_connection->get_connection();

		$sql = 'DELETE FROM windows WHERE id = :id';

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
	 * Counts glazings in db
	 * 
	 * @return json and/or http headers with status code
	 */
	public function count()
	{
		$db = $this->db_connection->get_connection();
		
		$sql = 'SELECT COUNT(*) FROM windows';

		$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}
}