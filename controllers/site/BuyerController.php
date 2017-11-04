<?php

namespace controllers\site;

use \components\Helper;
use \helpers\YBHelper;
use \components\Validator;
use \validators\YBValidator;
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
			$response['reservator_id'] = $buyer['reservator_id'];
			$response['name'] = $buyer['name'];
			$response['surname'] = $buyer['surname'];
			$response['phone'] = $buyer['phone'];
			$response['email'] = $buyer['email'];
		} elseif (count($buyer) <= 0) {
			$response['status'] = 'fail_amo';
			$response['message'] = 'Квартира забронированна в amoCRM. Снимите бронь в amoCRM, перейдите в шахматку и сделайте актуализацию. После этого вы можете создать новую бронь в шахматке.';
		} else {
			$response['status'] = 'fail';
			$response['message'] = 'Что то пошло не так, порпобуйте позже';
		}

		echo json_encode($response);
		return true;
	}
}