<?php

namespace controllers\site;

use \components\Paginator;
use \implementing\paginators\YBPaginator;
use \components\Helper;
use \implementing\helpers\YBHelper;
use \components\Validator;
use \implementing\validators\YBValidator;
use \models\site\Buyer;
use \implementing\models\site\MySQLBuyerModel;

class BuyerController
{
	private $model;
	private $helper;
	private $validator;

	public function __construct()
	{
		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator);
		$this->validator->check_auth();

        $roles = ['admin', 'manager', 'realtor'];
        $this->validator->check_access($roles);
        
		$this->model = new Buyer();
		$this->model->set_model(new MySQLBuyerModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());
	}

	public function show()
	{
		$apartment_id = (int) $_GET['apartment_id'];
		$buyer = $this->model->show($apartment_id);

		if ($buyer) {
			$response['status'] = 'success';
			$response['id'] = $buyer['id'];
			$response['seller_id'] = $buyer['seller_id'];
			$response['name'] = $buyer['name'];
			$response['surname'] = $buyer['surname'];
			$response['phone'] = $buyer['phone'];
			$response['email'] = $buyer['email'];
		} else {
			$response['status'] = 'fail';
			$response['message'] = 'Что то пошло не так, порпобуйте позже';
		}

		echo json_encode($response);
		return true;
	}
}