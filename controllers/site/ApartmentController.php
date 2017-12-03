<?php

namespace controllers\site;

use \components\Paginator;
use \implementing\paginators\YBPaginator;
use \components\Helper;
use \implementing\helpers\YBHelper;
use \components\Validator;
use \implementing\validators\YBValidator;
use \models\site\Apartment;
use \implementing\models\site\MySQLApartmentModel;
use \models\admin\SettingReserve;
use \implementing\models\admin\MySQLSettingReserveModel;

class ApartmentController
{
	private $model;
	private $settings_reserve;
	private $helper;
	private $validator;
	private $paginator;

	/**
	 * Sets validator, access, helper, model, setting reserve model
	 */
	public function __construct()
	{
		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator);
		$this->validator->check_auth();

        $roles = ['admin', 'manager', 'realtor'];
        $this->validator->check_access($roles);

		$this->model = new Apartment();
		$this->model->set_model(new MySQLApartmentModel());

		$this->settings_reserve = new SettingReserve();
		$this->settings_reserve->set_model(new MySQLSettingReserveModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());
	}

	/**
	 * Shows all apartment
	 *
	 * @return data in json
	 */
	public function index()
	{
		$condition = $_GET['operator'] . $_GET['field'] . $_GET['symbol'] . $_GET['floor'];

		$apartments = $this->model->get_all($condition);

		$response = [];
		if ($apartments) {
			$response['status'] = 'success';

			$i = 0;
			foreach ($apartments as $apartment) {			
				$response[$i]['id'] = $apartment['id'];
				$response[$i]['floor'] = $apartment['floor'];
				$response[$i]['num'] = $apartment['num'];
				$response[$i]['price'] = $apartment['price'];
				$response[$i]['status'] = $apartment['status'];
				$response[$i]['type'] = $apartment['type'];
				$response[$i]['total_area'] = $apartment['total_area'];
				$response[$i]['factual_area'] = $apartment['factual_area'];
				$response[$i]['windows'] = $apartment['windows'];
				$i++;
			}

			echo json_encode($response);
			return true;
		} else {
			http_response_code(500);
			$this->validator->check_response('ajax');
		}
	}

	/**
	 * Collects data for buy apartment
	 *
	 * @return json and/or http header with status code
	 */
	public function buy()
	{
		$this->validator->check_request($_POST);

		$data['apartment_id'] = $_POST['apartment_id'];
		$data['apartment_num'] = $_POST['apartment_num'];
		$data['name'] = $_POST['name'];
		$data['surname'] = $_POST['surname'];
		$data['phone'] = $_POST['phone'];
		$data['email'] = $_POST['email'];

		$this->model->buy($data);
	}

	/**
	 * Collects data for reserve apatment
	 *
	 * @return json and/or http header with status code
	 */
	public function reserve()
	{
		$this->validator->check_request($_POST);

		$data['apartment_id'] = (int) $_POST['apartment_id'];
		$data['apartment_num'] = $_POST['apartment_num'];
		$data['name'] = $_POST['name'];
		$data['surname'] = $_POST['surname'];
		$data['phone'] = $_POST['phone'];
		$data['email'] = $_POST['email'];

		$settings = $this->settings_reserve->get_all();
		$settings_reserve = array_shift($settings);

		switch ($_SESSION['role_id']) {
			case '3':
				$data['time_reserve'] = $settings_reserve['manager'];
				break;
			case '4':
				$data['time_reserve'] = $settings_reserve['realtor'];
				break;
			default:
				$data['time_reserve'] = '3';
		}

		$this->model->reserve($data);
	}
	
	/**
	 * Collects data for withdraw reserve apatment
	 *
	 * @return json and/or http header with status code
	 */
	public function withdraw_reserve()
	{
		$this->validator->check_request($_POST);

		$apartment_id = (int) $_POST['apartment_id'];

		$this->model->withdraw_reserve($apartment_id);
	}
}