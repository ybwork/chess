<?php

namespace implementing\models\admin;

use \components\Validator;
use \validators\YBValidator;
use \components\DBConnection;
use \dbconnections\MySQLConnection;
use \components\Helper;
use \helpers\YBHelper;
use \interfaces\models\admin\IUserModel;

class MySQLUserModel implements IUserModel
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

       	$sql = "SELECT u.id, u.role_id, u.login, u.name, u.surname, u.patronymic, u.password, r.name as role FROM users u JOIN roles r ON r.id = u.role_id GROUP BY u.id";

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

		$condition = '';

        switch ($_SESSION['role_id']) {
            case 1:
                $condition = "WHERE u.role_id = 1 OR u.role_id = 2 OR u.role_id = 3 OR u.role_id = 4 OR u.role_id = 5";
                break;
            case 2:
                $condition = "WHERE u.role_id = 3 OR u.role_id = 4";
                break;
            case 3:
                $condition = "WHERE u.role_id = 4";
                break;
        }

        $sql = "SELECT u.id, u.role_id, u.login, u.name, u.surname, u.patronymic, u.password, r.name as role FROM users u JOIN roles r ON r.id = u.role_id $condition GROUP BY u.id ORDER BY u.id DESC LIMIT $offset, $limit";

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
            'login' => 'Логин|empty|length_string',
            'name' => 'Имя|empty|length_string',
            'surname' => 'Фамилия|empty|length_string',
            'role' => 'Роль|empty',
            'password' => 'Пароль|empty|length_string',
        ]);

        try {
        	$db = $this->db_connection->get_connection();
        	$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        	$db->beginTransaction();

		    $sql = 'INSERT INTO users (role_id, login, name, surname, patronymic, password) VALUES (:role, :login, :name, :surname, :patronymic, :password)';

		    $query = $db->prepare($sql);

		    $query->bindValue(':role', $data['role'], \PDO::PARAM_INT);
		    $query->bindValue(':login', $data['login'], \PDO::PARAM_STR);
		    $query->bindValue(':name', $data['name'], \PDO::PARAM_STR);
		    $query->bindValue(':surname', $data['surname'], \PDO::PARAM_STR);
		    $query->bindValue(':patronymic', $data['patronymic'], \PDO::PARAM_STR);
		    $query->bindValue(':password', $data['password'], \PDO::PARAM_STR);

		    $query->execute();

		    $user_id = $db->lastInsertId();

		    if ($data['apartments']) {
			   	// For multiple insert
		        $fields = '';
			    foreach ($data['apartments'] as $apartment_id) {
			    	$fields .= "(:user_id_$apartment_id, :apartment_id_$apartment_id), ";
			    }
		    	$part_sql = substr($fields, 0, -2);

		    	$sql = "INSERT INTO users_apartments (user_id, apartment_id) VALUES $part_sql";

		    	$query = $db->prepare($sql);

			    foreach ($data['apartments'] as $apartment_id) {
			    	$query->bindValue(":user_id_$apartment_id", $user_id, \PDO::PARAM_INT);
			    	$query->bindValue(":apartment_id_$apartment_id", $apartment_id, \PDO::PARAM_INT);
			    }

			   	$query->execute();
		    }

		    $db->commit();

			header('HTTP/1.0 200 OK', http_response_code(200));
			$response['message'] = 'Готово';
			$response['data'] = $data;
			echo json_encode($response);
			return true;
        } catch (\PDOException $e) {
        	$db->rollBack();

			http_response_code(500);
			$this->validator->check_response('ajax');
        }
	}

	public function show(int $id)
	{
		$db = $this->db_connection->get_connection();

		$sql = "SELECT u.id, u.login, u.name, u.surname, u.patronymic, GROUP_CONCAT(DISTINCT r.id, r.name SEPARATOR ', ') AS roles, GROUP_CONCAT(DISTINCT u_a.apartment_id SEPARATOR ', ') AS apartments FROM users u INNER JOIN roles r ON u.role_id = r.id LEFT JOIN users_apartments u_a ON u.id = u_a.user_id WHERE u.id = :id GROUP BY u.id";

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
            'login' => 'Логин|empty|length_string',
            'name' => 'Имя|empty|length_string',
            'surname' => 'Фамилия|empty|length_string',
            'patronymic' => 'Отчество|empty|length_string',
            'role' => 'Роль|empty',
        ]);

        // Для проверки на существующего пользователя
        $existing_user = $this->check_exists($data);

        if ($existing_user && $existing_user['id'] != $data['id']) {
            header('HTTP/1.0 400 Bad Request', http_response_code(400));
            $response['message'] = 'Пользователь с таким логином уже существует';
            echo json_encode($response);
            die();
        }
       
	    try {
		    $db = $this->db_connection->get_connection();
		    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		    $db->beginTransaction();

	        // На тот случай если пользователь хочет оставить старый пароль
	        if (!$data['password']) {
	            $condition = 'role_id = :role_id, login = :login, name = :name, surname = :surname, patronymic = :patronymic'; 
	        } else {
	            $condition = 'role_id = :role_id, login = :login, name = :name, surname = :surname, patronymic = :patronymic, password = :password';
	        }

	        $sql = "UPDATE users SET $condition WHERE id = :id";

	        $query = $db->prepare($sql);

	        $user_id = (int) $data['id'];
	        $role = (int) $data['role'];
	        $query->bindValue(':id', $user_id, \PDO::PARAM_INT);
	        $query->bindValue(':role_id', $role, \PDO::PARAM_INT);
	        $query->bindValue(':login', $data['login'], \PDO::PARAM_STR);
	        $query->bindValue(':name', $data['name'], \PDO::PARAM_STR);
	        $query->bindValue(':surname', $data['surname'], \PDO::PARAM_STR);
	        $query->bindValue(':patronymic', $data['patronymic'], \PDO::PARAM_STR);
	        if ($data['password']) {
	            $password = password_hash($data['password'], PASSWORD_BCRYPT);
	            $query->bindValue(':password', $password);
	        }

	        $query->execute();

	        $sql = 'DELETE FROM users_apartments WHERE user_id = :user_id';
	        $query = $db->prepare($sql);
	        $query->bindValue(':user_id', $user_id);
	        $query->execute();

		    if ($data['apartments']) {
			   	// For multiple insert
		        $fields = '';
			    foreach ($data['apartments'] as $apartment_id) {
			    	$fields .= "(:user_id_$apartment_id, :apartment_id_$apartment_id), ";
			    }
		    	$part_sql = substr($fields, 0, -2);

		    	$sql = "INSERT INTO users_apartments (user_id, apartment_id) VALUES $part_sql";

		    	$query = $db->prepare($sql);

			    foreach ($data['apartments'] as $apartment_id) {
			    	$query->bindValue(":user_id_$apartment_id", $user_id, \PDO::PARAM_INT);
			    	$query->bindValue(":apartment_id_$apartment_id", $apartment_id, \PDO::PARAM_INT);
			    }

			   	$query->execute();
		    }

		    $db->commit();

			header('HTTP/1.0 200 OK', http_response_code(200));
			$response['message'] = 'Готово';
			$response['data'] = $data;
			echo json_encode($response);
			return true;
	    } catch (\PDOException $e) {
        	$db->rollBack();

			http_response_code(500);
			$this->validator->check_response('ajax');
	    }
    }

    public function delete(int $id)
    {
    	try {
    		$db = $this->db_connection->get_connection();
    		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    		$db->beginTransaction();

    		$sql = 'DELETE FROM users WHERE id = :id';
    		$query = $db->prepare($sql);
    		$query->bindValue(':id', $id, \PDO::PARAM_INT);
    		$query->execute();

    		$sql = 'DELETE FROM users_apartments WHERE user_id = :user_id';
    		$query = $db->prepare($sql);
    		$query->bindValue(':user_id', $id, \PDO::PARAM_INT);
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

	public function count()
	{
		$db = $this->db_connection->get_connection();
		
		$sql = 'SELECT COUNT(*) FROM users';

		$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}

    public function check_exists(array $data)
    {
        $data = $this->validator->validate($data, [
            'login' => 'Логин|empty|length_string',
        ]);

        $db = $this->db_connection->get_connection();

        $sql = "SELECT u.id, u.role_id, u.login, u.name, u.surname, u.password, r.name AS role_name FROM users u INNER JOIN roles r ON u.role_id = r.id WHERE login = :login GROUP BY u.id";

        $query = $db->prepare($sql);

        $query->bindValue(':login', $data['login']);

		if ($query->execute()) {
			return $query->fetch(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response('ajax');
		}
    }
}