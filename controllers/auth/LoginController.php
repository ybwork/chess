<?php

namespace controllers\auth;

use \components\Paginator;
use \implementing\paginators\YBPaginator;
use \components\Helper;
use \implementing\helpers\YBHelper;
use \components\Validator;
use \implementing\validators\YBValidator;
use \models\auth\Auth;
use \implementing\models\auth\MySQLAuthModel;
use \models\admin\User;
use \implementing\models\admin\MySQLUserModel;

class LoginController
{
	private $model;
	private $user;
	private $helper;
	private $validator;

	/**
	 * Sets validator, helper, base and user models
	 */
	public function __construct()
	{
		$this->model = new Auth();
		$this->model->set_model(new MySQLAuthModel());

		$this->user = new User();
		$this->user->set_model(new MySQLUserModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());

		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator);
	}

	/**
	 * Shows form for login
	 *
	 * @return html view
	 */	
	public function index()
	{
		if (isset($_SESSION['user'])) {
			header('Location: /');
		}

        require_once(ROOT . '/views/auth/login.php');
        return true;
	}

	/**
	 * Logins user in system
	 *
	 * @return json and http header with status code
	 */
	public function login()
	{
		$this->validator->check_request($_POST);

        $data['login'] = $_POST['login'];
        $data['password'] = $_POST['password'];
        
		$user = $this->user->check_exists($data);
		if ($user) {
       		$auth = $this->model->login($data, $user);

       		if ($auth) {   			
				$_SESSION['user'] = $user['id'];
				$_SESSION['role_id'] = $user['role_id'];
				$_SESSION['user_name_surname'] = $user['name'] . ' ' . $user['surname'];
				$_SESSION['role_name'] = $user['role_name'];

				header('HTTP/1.0 200 OK', http_response_code(200));

				$response['message'] = 'Готово';

				echo json_encode($response);
       		} else {
	       		header('HTTP/1.0 400 Bad Request', http_response_code(400));

				$response['message'] = 'Неправильные логин или пароль';

				echo json_encode($response);
       		}
		} else {
       		header('HTTP/1.0 400 Bad Request', http_response_code(400));

			$response['message'] = 'Неправильные логин или пароль';
			
			echo json_encode($response);
		}
	}
}