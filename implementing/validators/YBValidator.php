<?php

namespace validators;

class YBValidator implements IValidator
{
	public function check_response(string $type_request='simple')
	{
		if (http_response_code() == 500 && $type_request == 'ajax') {
			header('HTTP/1.0 500 Internal Server Error', http_response_code());
			die();
		} else {
			include_once(ROOT . '/views/errors/500.php');
		}
	}

	public function clean($value)
	{
		if (is_array($value)) {
			$result = [];

			$i = 0;
			foreach ($value as $val) {
				$element = trim($val);
				$element = strip_tags($element);
				$element = stripslashes($element);
				$result[$i] = $element;

				$i++;
			}
		} else {		
			$result = trim($value);
			$result = strip_tags($result);
			$result = stripslashes($result);
		}

		return $result;
	}

	public function check_empty($value, string $field)
	{
		$response = [];

		if (is_string($value) && !$value) {
			header('HTTP/1.0 400 Bad Request', http_response_code(400));
			$response['message'] = 'Заполните все обязательные поля';
			echo json_encode($response);
			die();
		} elseif (is_int($value) && $value <= 0) {
			header('HTTP/1.0 400 Bad Request', http_response_code(400));
			$response['message'] = "Значение поля $field не может быть меньше или равно нулю";
			echo json_encode($response);
			die();
		} elseif (is_array($value) && count($value) == 0) {
			header('HTTP/1.0 400 Bad Request', http_response_code(400));
			$response['message'] = "Значение поля $field не может быть меньше или равно нулю";
			echo json_encode($response);
			die();
		} else {
			return true;
		}
	}

	public function check_length_string($value, string $field)
	{
		if (strlen($value) > 255) {
			header('HTTP/1.0 400 Bad Request', http_response_code(400));
			$response['message'] = "Значение поля $field должно быть меньшей длинны";
			echo json_encode($response);
			die();
		} else {
			return true;
		}
	}

	public function check_length_integer($value, string $field)
	{
		if (strlen($value) > 11) {
			header('HTTP/1.0 400 Bad Request', http_response_code(400));
			$response['message'] = "Значение поля $field должно быть меньшей длинны";
			echo json_encode($response);
			die();
		} else {
			return true;
		}	
	}

	public function check_empty_file($value, string $field)
	{
		if (count($value) < 1) {
			$_SESSION['errors'] = 'Файл не может быть пустым';
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit();
		} else {
			return true;
		}
	}

	public function check_email(string $value, string $field)
	{
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['errors'] = 'Неправильный формат email адреса';
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit();			
		} else {
			return true;
		}
	}

	public function check_request($request)
	{
		if (!$request) {
			header('Location: /');
		}
	}

    public function check_access(array $roles)
    {
    	$roles_values = [
    		'admin' => 1,
    		'manager' => 3,
    		'realtor' => 4
    	];

        if (!isset($_SESSION['user'])) {
            header('Location: /login');
        } else {
			$arr_compare_roles = [];
	    	foreach ($roles as $key => $role) {
	    		$arr_compare_roles[$key] = $roles_values[$role];
	    	}

			if (in_array($_SESSION['role_id'], $arr_compare_roles)) {
				return true;
			} else {
				header('Location: /');
			}
        }
    }

	public function validate(array $fields, array $rules): array
	{
		$fields_names = [];

		$data = [];
		foreach ($fields as $field => $value) {
			$сlean_value = $this->clean($value);

			if (array_key_exists($field, $rules)) {
				$field_name = explode('|', $rules[$field]);
				$fields_names[$field] = $field_name[0];
				
				$actions = explode('|', $rules[$field]);
				unset($actions[0]);
				foreach ($actions as $action) {
					$prefix = 'check_';
					$function = $prefix . $action;
					$this->$function($сlean_value, $fields_names[$field]);
				}

				if (is_string($сlean_value)) {
					$data[$field] = $сlean_value;
				} else {
					$data[$field] = $value;
				}
			} else {
				$data[$field] = $value;
			}
		}

		return $data;
	}
}