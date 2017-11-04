<?php

namespace implementing\models\admin;

use \components\Validator;
use \validators\YBValidator;
use \components\DBConnection;
use \dbconnections\MySQLConnection;
use \interfaces\models\admin\ITypeModel;

class MySQLTypeModel implements ITypeModel
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

	public function get_all()
	{
		$db = $this->db_connection->get_connection();

        $sql = "SELECT id, type FROM types ORDER BY id DESC";

       	$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}

	public function get_all_by_offset_limit(int $offset, int $limit)
	{
		$db = $this->db_connection->get_connection();

		$sql = "SELECT id, type FROM types ORDER BY id DESC LIMIT $offset, $limit";

       	$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}

	public function create(array $data)
	{
        $data = $this->validator->validate($data, [
            'type' => 'Тип|empty|length_string',
        ]);

		$db = $this->db_connection->get_connection();

		$sql = 'INSERT INTO types (type) VALUES (:type)';

		$query = $db->prepare($sql);

		$query->bindValue(':type', $data['type'], \PDO::PARAM_STR);

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

	public function show(int $id)
	{
		$db = $this->db_connection->get_connection();

		$sql = 'SELECT id, type FROM types WHERE id = :id';

		$query = $db->prepare($sql);

		$query->bindValue(':id', $id, \PDO::PARAM_INT);

		if ($query->execute()) {
			return $query->fetch(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response('ajax');
		}
	}

	public function update(array $data)
	{
		$db = $this->db_connection->get_connection();

        $data = $this->validator->validate($data, [
            'type' => 'Тип|empty|length_string',
        ]);

		$sql = 'UPDATE types SET type = :type WHERE id = :id';

		$query = $db->prepare($sql);

		$id = (int) $data['id'];
		$query->bindValue(':id', $id, \PDO::PARAM_INT);
		$query->bindValue(':type', $data['type'], \PDO::PARAM_STR);

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

	public function delete(int $id)
	{
		$db = $this->db_connection->get_connection();

		$sql = 'DELETE FROM types WHERE id = :id';

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

	public function count()
	{
		$db = $this->db_connection->get_connection();
		
		$sql = 'SELECT COUNT(*) FROM types';

		$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}
}