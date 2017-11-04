<?php

namespace controllers\site;

use \components\Validator;
use \validators\YBValidator;
use \models\site\Apartment;
use \implementing\models\site\MySQLApartmentModel;

class HomeController
{
	private $model;

	public function __construct()
	{
		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator);

		$this->model = new Apartment();
		$this->model->set_model(new MySQLApartmentModel());
	}

	public function index()
	{
		$apartments = $this->model->get_all();
		$floors_types_aparts = $this->model->get_floors_types_aparts();
		$general_info_apartments = $this->model->get_general_info_apartments();
		
		require_once(ROOT . '/views/site/index.php');
		return true;	
	}
}