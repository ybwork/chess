<?php

namespace controllers\admin;

use \components\Helper;
use \implementing\helpers\YBHelper;
use \components\Validator;
use \implementing\validators\YBValidator;
use \models\admin\SettingReserve;
use \implementing\models\admin\MySQLSettingReserveModel;

class SettingReserveController
{
	private $model;
	private $helper;
	private $validator;
	private $paginator;

	/**
	 * Sets validator, access, helper, model
	 */
	public function __construct()
	{
		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator);
		$this->validator->check_auth();

        $roles = ['admin'];
        $this->validator->check_access($roles);
        
		$this->model = new SettingReserve();
		$this->model->set_model(new MySQLSettingReserveModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());
	}

	/**
	 * Shows all settings reserve
	 *
	 * @return html view
	 */
	public function index()
	{
		$settings = $this->model->get_all();

		require_once(ROOT . '/views/admin/setting-reserve/index.php');
		return true;
	}

	/**
	 * Collects data for create setting
	 *
	 * @return json and/or http header with status code
	 */
	public function create()
	{
		$this->validator->check_request($_POST);

		$data['realtor'] = (int) $_POST['realtor'];
		$data['manager'] = (int) $_POST['manager'];
		
		$this->model->create($data);
	}

	/**
	 * Collects data for selected setting
	 *
	 * @return data in json
	 */
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

	/**
	 * Collects data for update setting
	 *
	 * @return json and/or http header with status code
	 */
	public function update()
	{
		$this->validator->check_request($_POST);

		$data['id'] = (int) $_POST['id'];
		$data['realtor'] = (int) $_POST['realtor'];
		$data['manager'] = (int) $_POST['manager'];

		$this->model->update($data);
	}
	
	/**
	 * Collects data for delete setting
	 *
	 * @return json and/or http header with status code
	 */
	public function delete()
	{
		$this->validator->check_request($_POST);
		
		$id = (int) $_POST['id'];
		$this->model->delete($id);
	}
}