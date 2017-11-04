<?php

namespace controllers\admin;

use \components\Paginator;
use \paginators\YBPaginator;
use \components\Helper;
use \helpers\YBHelper;
use \components\Validator;
use \validators\YBValidator;
use \models\admin\SettingReserve;
use \implementing\models\admin\MySQLSettingReserveModel;

class SettingReserveController
{
	private $model;
	private $helper;
	private $validator;
	private $paginator; 

	public function __construct()
	{
		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator);

        $roles = ['admin'];
        $this->validator->check_access($roles);
        
		$this->model = new SettingReserve();
		$this->model->set_model(new MySQLSettingReserveModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());
	}

	public function index()
	{
		$settings = $this->model->get_all();

		require_once(ROOT . '/views/admin/setting-reserve/index.php');
		return true;
	}

	public function create()
	{
		$this->validator->check_request($_POST);

		$data['realtor'] = $_POST['realtor'];
		$data['manager'] = $_POST['manager'];
		
		$this->model->create($data);
	}

	public function edit()
	{
		$id = (int) $this->helper->get_id();
		$settings = $this->model->show($id);

		$response['id'] = (int) $settings['id'];
		$response['realtor'] = $settings['realtor'];
		$response['manager'] = $settings['manager'];

		echo json_encode($response);
		return true;
	}

	public function update()
	{
		$this->validator->check_request($_POST);

		$data['id'] = (int) $_POST['id'];
		$data['realtor'] = $_POST['realtor'];
		$data['manager'] = $_POST['manager'];

		$this->model->update($data);
	}

	public function delete()
	{
		$this->validator->check_request($_POST);
		
		$id = (int) $_POST['id'];
		$this->model->delete($id);
	}
}