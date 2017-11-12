<?php

namespace implementing\models\admin;

use \components\Validator;
use \implementing\validators\YBValidator;
use \components\DBConnection;
use \implementing\dbconnections\MySQLConnection;
use \interfaces\models\admin\IRoleModel;

class MySQLRoleModel implements IRoleModel
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

		$condition = '';

        switch ($_SESSION['role_id']) {
            case 1:
                $condition = "WHERE r.id = 1 OR r.id  = 2 OR r.id  = 3 OR r.id  = 4 OR r.id  = 5";
                break;
            case 2:
                $condition = "WHERE r.id  = 3 OR r.id = 4";
                break;
            case 3:
                $condition = "WHERE r.id  = 4";
                break;
        }

        $sql = "SELECT r.id, r.name FROM roles r $condition ORDER BY r.id DESC";

       	$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response($type_request);
		}
	}

	public function get_all_by_offset_limit(int $offset, int $limit)
	{
		$db = $this->db_connection->get_connection();

		$sql = "SELECT r.id, r.name FROM roles r $condition ORDER BY r.id DESC LIMIT :offset, :limit";

       	$query = $db->prepare($sql);

		$query->bindValue(':offset', $offset, \PDO::PARAM_INT);
		$query->bindValue(':limit', $limit, \PDO::PARAM_INT);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response($type_request);
		}
	}

	public function create(array $data)
	{
        $data = $this->validator->validate($data, [
            'name' => 'Имя|empty|length_string',
        ]);

		$db = $this->db_connection->get_connection();

		$sql = 'INSERT INTO roles (name) VALUES (:name)';

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

	public function show(int $id)
	{
		$db = $this->db_connection->get_connection();

		$sql = 'SELECT id, name FROM roles WHERE id = :id';

		$query = $db->prepare($sql);

		$query->bindValue(':id', $id);

		if ($query->execute()) {
			return $query->fetch(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response('ajax');
		}
	}

	public function update(array $data)
	{
        $data = $this->validator->validate($data, [
            'name' => 'Имя|empty|length_string',
        ]);

		$db = $this->db_connection->get_connection();

		$sql = 'UPDATE roles SET name = :name WHERE id = :id';

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

	public function delete(int $id)
	{
		$db = $this->db_connection->get_connection();

		$sql = 'DELETE FROM roles WHERE id = :id';

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
		
		$sql = 'SELECT COUNT(*) FROM roles';

		$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}
}