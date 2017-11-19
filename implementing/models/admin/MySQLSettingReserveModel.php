<?php

namespace implementing\models\admin;

use \components\Validator;
use \implementing\validators\YBValidator;
use \components\DBConnection;
use \implementing\dbconnections\MySQLConnection;
use \interfaces\models\admin\ISettingReserveModel;

class MySQLSettingReserveModel implements ISettingReserveModel
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
	 * Gets all settings reserve from db
	 *
	 * @return array data or http headers with status code
	 */
	public function get_all()
	{
		$db = $this->db_connection->get_connection();

        $sql = "SELECT id, realtor, manager FROM settings_reserve ORDER BY id DESC";

       	$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}

	/**
	 * Saves setting reserve in db
	 * 
	 * @param $data - data for save
	 * @return json and/or http headers with status code
	 */
	public function create(array $data)
	{
        $data = $this->validator->validate($data, [
            'realtor' => 'Риэлтор|empty|is_integer}length_integer',
            'manager' => 'Менеджер|empty|is_integer}length_integer',
        ]);

		$db = $this->db_connection->get_connection();

		$sql = 'INSERT INTO settings_reserve (realtor, manager) VALUES (:realtor, :manager)';

		$query = $db->prepare($sql);

		$query->bindValue(':realtor', $data['realtor'], \PDO::PARAM_INT);
		$query->bindValue(':manager', $data['manager'], \PDO::PARAM_INT);

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
	 * Gets settings reserve by id from db
	 * 
	 * @param $id - setting reserve id
	 * @return array data or http headers with status code
	 */
	public function show(int $id)
	{
		$db = $this->db_connection->get_connection();

		$sql = 'SELECT id, realtor, manager FROM settings_reserve WHERE id = :id';

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
	 * Updates selected setting reserve in db
	 * 
	 * @param $data - data for update
	 * @return json and/or http headers with status code
	 */
	public function update(array $data)
	{
        $data = $this->validator->validate($data, [
            'realtor' => 'Риэлтор|empty|is_integer}length_integer',
            'manager' => 'Менеджер|empty|is_integer}length_integer',
        ]);

		$db = $this->db_connection->get_connection();

		$sql = 'UPDATE settings_reserve SET realtor = :realtor, manager = :manager WHERE id = :id';

		$query = $db->prepare($sql);

		$id = (int) $data['id'];
		$query->bindValue(':id', $id, \PDO::PARAM_INT);
		$query->bindValue(':realtor', $data['realtor'], \PDO::PARAM_STR);
		$query->bindValue(':manager', $data['manager'], \PDO::PARAM_STR);

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
	 * Deletes selected setting reserve from db
	 * 
	 * @param $id - setting reserve id
	 * @return json and/or http headers with status code
	 */
	public function delete(int $id)
	{
		$db = $this->db_connection->get_connection();

		$sql = 'DELETE FROM settings_reserve WHERE id = :id';

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
}