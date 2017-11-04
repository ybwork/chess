<?php

namespace implementing\models\admin;

use \components\Validator;
use \validators\YBValidator;
use \components\DBConnection;
use \dbconnections\MySQLConnection;
use \interfaces\models\admin\IApartmentModel;

class MySQLApartmentModel implements IApartmentModel
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

        $sql = "SELECT id, num FROM apartments ORDER BY id DESC";

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

		$sql = "SELECT a.id, a.type_id, a.total_area_id, a.factual_area, a.floor, a.num, a.price, a.discount, a.status, t.type, t_a.total_area, GROUP_CONCAT(DISTINCT w.id, w.name SEPARATOR ', ') AS windows FROM apartments a JOIN apartments_windows a_w ON a.id = a_w.apartment_id JOIN windows w ON a_w.window_id = w.id JOIN types t ON a.type_id = t.id JOIN total_areas t_a ON a.total_area_id = t_a.id GROUP BY a.id ORDER BY id DESC LIMIT $offset, $limit";

       	$query = $db->prepare($sql);
       	
		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}

	public function get_available()
	{
		$db = $this->db_connection->get_connection();

		$sql = "SELECT id, num FROM apartments WHERE status = 1 ORDER BY id DESC";

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
			'type_id' => 'Тип|empty|length_integer',
			'total_area_id' => 'Общая площадь|empty|length_integer',
			'factual_area' => 'Фактическая площадь|empty|length_integer',
			'floor' => 'Этаж|empty|length_integer',
			'num' => 'Номер|empty|length_integer',
			'price' => 'Цена|empty|length_integer',
			'status' => 'Статус|empty|length_integer',	
			'window' => 'Окна|empty',
			'glazing' => 'Тип остекления|empty',
        ]);
        
        try {
        	$db = $this->db_connection->get_connection();
        	$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        	$db->beginTransaction();

		    $sql = 'INSERT INTO apartments (type_id, total_area_id, factual_area, price, discount, floor, num, status) VALUES (:type_id, :total_area_id, :factual_area, :price, :discount, :floor, :num, :status)';

		    $query = $db->prepare($sql);

			if ($data['discount'] == '') {
				$data['discount'] = NULL;
			}
			$query->bindValue(':type_id', $data['type_id'], \PDO::PARAM_INT);
			$query->bindValue(':total_area_id', $data['total_area_id'], \PDO::PARAM_INT);
			$query->bindValue(':factual_area', $data['factual_area'], \PDO::PARAM_STR);
			$query->bindValue(':price', $data['price'], \PDO::PARAM_INT);
			$query->bindValue(':discount', $data['discount'], \PDO::PARAM_INT);
			$query->bindValue(':floor', $data['floor'], \PDO::PARAM_INT);
			$query->bindValue(':num', $data['num'], \PDO::PARAM_INT);
			$query->bindValue(':status', $data['status'], \PDO::PARAM_INT);

		    $query->execute();

		    $apartment_id = $db->lastInsertId();

	        // For multiple insert
	        $fields = '';
		    foreach ($data['windows'] as $window_id) {
		    	$fields .= "(:apartment_id_$window_id, :window_id_$window_id), ";
		    }
		    $part_sql = substr($fields, 0, -2);

		    $sql = "INSERT INTO apartments_windows (apartment_id, window_id) VALUES $part_sql";
		   
		    $query = $db->prepare($sql);

		    foreach ($data['windows'] as $window_id) {
		    	$query->bindValue(":apartment_id_$window_id", $apartment_id, \PDO::PARAM_INT);
		    	$query->bindValue(":window_id_$window_id", $window_id, \PDO::PARAM_INT);
		    }
		    
		    $query->execute();

		   	// For multiple insert
	        $fields = '';
		    foreach ($data['glazings'] as $glazing_id) {
		    	$fields .= "(:apartment_id_$glazing_id, :glazing_id_$glazing_id), ";
		    }
	    	$part_sql = substr($fields, 0, -2);

	    	$sql = "INSERT INTO apartments_glazings (apartment_id, glazing_id) VALUES $part_sql";

	    	$query = $db->prepare($sql);

		    foreach ($data['glazings'] as $glazing_id) {
		    	$query->bindValue(":apartment_id_$glazing_id", $apartment_id, \PDO::PARAM_INT);
		    	$query->bindValue(":glazing_id_$glazing_id", $glazing_id, \PDO::PARAM_INT);
		    }

		   	$query->execute();

		    $db->commit();

			header('HTTP/1.0 200 OK', http_response_code(200));
			$response['message'] = 'Готово';
			$response['data'] = $data;
			echo json_encode($response);
        } catch (\PDOException $e) {
        	$db->rollBack();

			http_response_code(500);
			$this->validator->check_response('ajax');
        }
	}

	public function show(int $id)
	{
		$db = $this->db_connection->get_connection();

		$sql = "SELECT a.id, a.type_id, a.total_area_id, a.factual_area, a.floor, a.num, a.price, a.discount, a.status, t.type, t_a.total_area, GROUP_CONCAT(DISTINCT w.id, w.name SEPARATOR ', ') AS windows, GROUP_CONCAT(DISTINCT g.id SEPARATOR ', ') AS glazings FROM apartments a LEFT JOIN apartments_windows a_w ON a.id = a_w.apartment_id LEFT JOIN windows w ON a_w.window_id = w.id LEFT JOIN types t ON a.type_id = t.id LEFT JOIN total_areas t_a ON a.total_area_id = t_a.id LEFT JOIN apartments_glazings a_g ON a.id = a_g.apartment_id LEFT JOIN glazings g ON a_g.glazing_id = g.id WHERE a.id = :id GROUP BY a.id";

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
        $data = $this->validator->validate($data, [
			'type_id' => 'Тип|empty|length_integer',
			'total_area_id' => 'Общая площадь|empty|length_integer',
			'factual_area' => 'Фактическая площадь|empty|length_integer',
			'floor' => 'Этаж|empty|length_integer',
			'num' => 'Номер|empty|length_integer',
			'price' => 'Цена|empty|length_integer',
			'status' => 'Статус|empty|length_integer',	
			'window' => 'Окна|empty',
			'glazing' => 'Тип остекления|empty',
        ]);

	    try {
		    $db = $this->db_connection->get_connection();
		    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		    $db->beginTransaction();

	        $sql = "UPDATE apartments SET type_id = :type_id, total_area_id = :total_area_id, factual_area = :factual_area, price = :price, discount = :discount, floor = :floor, num = :num, status = :status WHERE id = :id";

	        $query = $db->prepare($sql);

			if ($data['discount'] == '') {
				$data['discount'] = NULL;
			}
			$query->bindValue(':id', $data['id'], \PDO::PARAM_INT);
			$query->bindValue(':type_id', $data['type_id'], \PDO::PARAM_INT);
			$query->bindValue(':total_area_id', $data['total_area_id'], \PDO::PARAM_INT);
			$query->bindValue(':factual_area', $data['factual_area'], \PDO::PARAM_STR);
			$query->bindValue(':price', $data['price'], \PDO::PARAM_INT);
			$query->bindValue(':discount', $data['discount'], \PDO::PARAM_INT);
			$query->bindValue(':floor', $data['floor'], \PDO::PARAM_INT);
			$query->bindValue(':num', $data['num'], \PDO::PARAM_INT);
			$query->bindValue(':status', $data['status'], \PDO::PARAM_INT);
			
	        $query->execute();

	        $apartment_id = (int) $data['id'];

	        $sql = 'DELETE FROM apartments_windows WHERE apartment_id = :apartment_id';
	        $query = $db->prepare($sql);
	        $query->bindValue(':apartment_id', $apartment_id);
	        $query->execute();

	        $sql = 'DELETE FROM apartments_glazings WHERE apartment_id = :apartment_id';
	        $query = $db->prepare($sql);
	        $query->bindValue(':apartment_id', $apartment_id);
	        $query->execute();

	        // For multiple insert
	        $fields = '';
		    foreach ($data['windows'] as $window_id) {
		    	$fields .= "(:apartment_id_$window_id, :window_id_$window_id), ";
		    }
		    $part_sql = substr($fields, 0, -2);

		    $sql = "INSERT INTO apartments_windows (apartment_id, window_id) VALUES $part_sql";
		   
		    $query = $db->prepare($sql);

		    foreach ($data['windows'] as $window_id) {
		    	$query->bindValue(":apartment_id_$window_id", $apartment_id, \PDO::PARAM_INT);
		    	$query->bindValue(":window_id_$window_id", $window_id, \PDO::PARAM_INT);
		    }

		    $query->execute();
		    
		   	// For multiple insert
	        $fields = '';
		    foreach ($data['glazings'] as $glazing_id) {
		    	$fields .= "(:apartment_id_$glazing_id, :glazing_id_$glazing_id), ";
		    }
	    	$part_sql = substr($fields, 0, -2);

	    	$sql = "INSERT INTO apartments_glazings (apartment_id, glazing_id) VALUES $part_sql";

	    	$query = $db->prepare($sql);

		    foreach ($data['glazings'] as $glazing_id) {
		    	$query->bindValue(":apartment_id_$glazing_id", $apartment_id, \PDO::PARAM_INT);
		    	$query->bindValue(":glazing_id_$glazing_id", $glazing_id, \PDO::PARAM_INT);
		    }

		   	$query->execute();

		    $db->commit();

			header('HTTP/1.0 200 OK', http_response_code(200));
			$response['message'] = 'Готово';
			$response['data'] = $data;
			echo json_encode($response);
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
    		
    		$sql = 'DELETE FROM apartments WHERE id = :id';
    		$query = $db->prepare($sql);
    		$query->bindValue(':id', $id, \PDO::PARAM_INT);
    		$query->execute();

    		$sql = 'DELETE FROM apartments_windows WHERE apartment_id = :apartment_id';
    		$query = $db->prepare($sql);
    		$query->bindValue(':apartment_id', $id, \PDO::PARAM_INT);
    		$query->execute();

    		$sql = 'DELETE FROM apartments_glazings WHERE apartment_id = :apartment_id';
    		$query = $db->prepare($sql);
    		$query->bindValue(':apartment_id', $id, \PDO::PARAM_INT);
    		$query->execute();

    		$db->commit();

    		header('HTTP/1.0 200 OK', http_response_code(200));
			$response['message'] = 'Готово';
			echo json_encode($response);	
    	} catch (\PDOException $e) {
    		$db->rollBack();

    		http_response_code(500);
    		$this->validator->check_response('ajax');
    	}
	}

	public function count()
	{
		$db = $this->db_connection->get_connection();
		
		$sql = 'SELECT COUNT(*) FROM apartments';

		$query = $db->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			http_response_code(500);
			$this->validator->check_response();
		}
	}

	public function change_status(array $data, string $type, int $status)
	{
        foreach ($data["$type"] as $user_apartment) {
        	$db = \DB::get_connection();
            $sql = "UPDATE apartments a SET a.status = $status WHERE a.id = :user_apartment";
            $query = $db->prepare($sql);
            $query->bindParam(':user_apartment', $user_apartment);

            if ($query->execute()) {
                $result = 1;
            } else {
                $result = 0;
            }
        }

        if ($result) {
        	return true;
        } else {
        	return false;
        }
	}
}