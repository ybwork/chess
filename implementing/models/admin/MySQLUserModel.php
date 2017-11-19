<?php

namespace implementing\models\admin;

use \components\Validator;
use \implementing\validators\YBValidator;
use \components\DBConnection;
use \implementing\dbconnections\MySQLConnection;
use \components\Helper;
use \implementing\helpers\YBHelper;
use \interfaces\models\admin\IUserModel;

class MySQLUserModel implements IUserModel
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
	 * Gets all users from db
	 *
	 * @return array data or http headers with status code
	 */
	public function get_all()
	{
		$db = $this->db_connection->get_connection();

        $sql = 'SELECT u.id, u.role_id, u.login, u.name, u.surname, u.patronymic, u.phone, u.password, r.name as role FROM users u JOIN roles r ON r.id = u.role_id WHERE u.role_id = 1 OR u.role_id = 2 OR u.role_id = 3 GROUP BY u.id ORDER BY u.id DESC';

       	$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response($type_request);
		}
	}

	/**
	 * Gets all users from db by offset/limit
	 *
	 * @param $offset - place for start
	 * @param $limit - record number limit
	 * @return array data or http headers with status code
	 */
	public function get_all_by_offset_limit(int $offset, int $limit)
	{
		$db = $this->db_connection->get_connection();

        $sql = 'SELECT u.id, u.role_id, u.login, u.name, u.surname, u.patronymic, u.phone, u.password, r.name as role FROM users u JOIN roles r ON r.id = u.role_id WHERE u.role_id = 1 OR u.role_id = 2 OR u.role_id = 3 GROUP BY u.id ORDER BY u.id DESC LIMIT :offset, :limit';

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
	 * Saves user in db
	 * 
	 * @param $data - data for save
	 * @return json and/or http headers with status code
	 */
	public function create(array $data)
	{
        $data = $this->validator->validate($data, [
            'role_id' => 'Роль|empty|is_integer',
            'login' => 'Логин|empty|length_string',
            'name' => 'Имя|empty|length_string',
            'surname' => 'Фамилия|empty|length_string',
            'patronymic' => 'Отчество|empty|length_string',
            'phone' => 'Телефон|empty|length_string',
            'password' => 'Пароль|empty|length_string',
        ]);

        $existing_user = $this->check_exists($data);
        if ($existing_user) {
            header('HTTP/1.0 400 Bad Request', http_response_code(400));

            $response['message'] = 'Пользователь с таким логином уже существует';

            echo json_encode($response);
            die();
        }

    	$db = $this->db_connection->get_connection();

	    $sql = 'INSERT INTO users (role_id, login, name, surname, patronymic, phone, password) VALUES (:role_id, :login, :name, :surname, :patronymic, :phone, :password)';

	    $query = $db->prepare($sql);

	    $query->bindValue(':role_id', $data['role_id'], \PDO::PARAM_INT);
	    $query->bindValue(':login', $data['login'], \PDO::PARAM_STR);
	    $query->bindValue(':name', $data['name'], \PDO::PARAM_STR);
	    $query->bindValue(':surname', $data['surname'], \PDO::PARAM_STR);
	    $query->bindValue(':patronymic', $data['patronymic'], \PDO::PARAM_STR);
	    $query->bindValue(':phone', $data['phone'], \PDO::PARAM_STR);
	    $query->bindValue(':password', $data['password'], \PDO::PARAM_STR);

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
	 * Gets user by id from db
	 * 
	 * @param $id - user id
	 * @return array data or http headers with status code
	 */
	public function show(int $id)
	{
		$db = $this->db_connection->get_connection();

		$sql = "SELECT u.id, u.login, u.name, u.surname, u.patronymic, u.phone, r.id as role_id, r.name as role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.id = :id GROUP BY u.id";

		$query = $db->prepare($sql);

		$query->bindValue(':id', $id);

		if ($query->execute()) {
			return $query->fetch(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response('ajax');
		}	
	}

	/**
	 * Updates selected user in db
	 * 
	 * @param $data - data for update
	 * @return json and/or http headers with status code
	 */
    public function update(array $data)
    {
        $data = $this->validator->validate($data, [
            'role_id' => 'Роль|empty|is_integer',
            'login' => 'Логин|empty|length_string',
            'name' => 'Имя|empty|length_string',
            'surname' => 'Фамилия|empty|length_string',
            'patronymic' => 'Отчество|empty|length_string',
            'phone' => 'Телефон|empty|length_string',
        ]);

        $existing_user = $this->check_exists($data);
        if ($existing_user && $existing_user['id'] != $data['id']) {
            header('HTTP/1.0 400 Bad Request', http_response_code(400));
            $response['message'] = 'Пользователь с таким логином уже существует';
            echo json_encode($response);
            die();
        }

        $db = $this->db_connection->get_connection();
       
        // На тот случай если пользователь хочет оставить старый пароль
        if (!$data['password']) {
            $condition = 'role_id = :role_id, login = :login, name = :name, surname = :surname, patronymic = :patronymic, phone = :phone'; 
        } else {
            $condition = 'role_id = :role_id, login = :login, name = :name, surname = :surname, patronymic = :patronymic, phone = :phone, password = :password';
        }

        $sql = "UPDATE users SET $condition WHERE id = :id";

        $query = $db->prepare($sql);

        $user_id = (int) $data['id'];
        $role_id = (int) $data['role_id'];
        $query->bindValue(':id', $user_id, \PDO::PARAM_INT);
        $query->bindValue(':role_id', $role_id, \PDO::PARAM_INT);
        $query->bindValue(':login', $data['login'], \PDO::PARAM_STR);
        $query->bindValue(':name', $data['name'], \PDO::PARAM_STR);
        $query->bindValue(':surname', $data['surname'], \PDO::PARAM_STR);
        $query->bindValue(':patronymic', $data['patronymic'], \PDO::PARAM_STR);
        $query->bindValue(':phone', $data['phone'], \PDO::PARAM_STR);
        if ($data['password']) {
            $password = password_hash($data['password'], PASSWORD_BCRYPT);
            $query->bindValue(':password', $password);
        }

        if ($query->execute()) {	
			header('HTTP/1.0 200 OK', http_response_code(200));

			$response['message'] = 'Готово';
			$response['data'] = $data;

			echo json_encode($response);
			return true;
        } else {
			http_response_code(500);
			$this->validator->check_response('ajax');
        }
    }

	/**
	 * Deletes selected user from db
	 * 
	 * @param $id - user id
	 * @return json and/or http headers with status code
	 */
    public function delete(int $id)
    {
		$db = $this->db_connection->get_connection();

		$sql = 'DELETE FROM users WHERE id = :id';

		$query = $db->prepare($sql);

		$query->bindValue(':id', $id, \PDO::PARAM_INT);

		if ($query->execute()) {		
			header('HTTP/1.0 200 OK', http_response_code(200));

			$response['message'] = 'Готово';

			echo json_encode($response);	
		} else {		
			http_response_code(500);
			$this->validator->check_response('ajax');
		}
    }

	/**
	 * Counts users in db
	 * 
	 * @return json and/or http headers with status code
	 */
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

	/**
	 * Checks user on exists
	 * 
	 * @return json and/or http headers with status code
	 */
    public function check_exists(array $data)
    {
        $data = $this->validator->validate($data, [
            'login' => 'Логин|empty|length_string',
        ]);

        $db = $this->db_connection->get_connection();

        $sql = "SELECT u.id, u.role_id, u.login, u.name, u.surname, u.phone, u.password, r.name AS role_name FROM users u INNER JOIN roles r ON u.role_id = r.id WHERE login = :login GROUP BY u.id";

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