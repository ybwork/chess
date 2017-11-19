<?php

namespace controllers\admin;

use \components\Paginator;
use \implementing\paginators\YBPaginator;
use \components\Helper;
use \implementing\helpers\YBHelper;
use \components\Validator;
use \implementing\validators\YBValidator;
use \models\admin\Glazing;
use \implementing\models\admin\MySQLGlazingModel;

class GlazingController
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

		$this->paginator = new Paginator();
		$this->paginator->set_paginator(new YBPaginator());
        
		$this->model = new Glazing();
		$this->model->set_model(new MySQLGlazingModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());
	}

	/**
	 * Shows all glazings
	 *
	 * @return html view
	 */
	public function index()
	{

		/*
			Заменить обычный вывод, когда появится js

			$limit = 20;
			$page = $this->helper->get_page();
			$offset = ($page - 1) * $limit;

			$glazing_count = $this->model->count();
			$total = $glazing_count[0]['COUNT(*)'];
			$index = '?page=';

			$glazings = $this->model->get_all_by_offset_limit($offset, $limit);

			$this->paginator->set_params($total, $page, $limit, $index);
		*/

		$glazings = $this->model->get_all();

		require_once(ROOT . '/views/admin/glazing/index.php');
		return true;
	}

	/**
	 * Collects data for create glazing
	 *
	 * @return json and/or http header with status code
	 */
	public function create()
	{
		$this->validator->check_request($_POST);

		$data['name'] = $_POST['name'];
		
		$this->model->create($data);
	}

	/**
	 * Collects data for selected glazing
	 *
	 * @return data in json
	 */
	public function edit()
	{
		$id = (int) $this->helper->get_id();
		$glazing = $this->model->show($id);

		$response['id'] = (int) $glazing['id'];
		$response['name'] = $glazing['name'];

		echo json_encode($response);
		return true;
	}

	/**
	 * Collects data for update glazing
	 *
	 * @return json and/or http header with status code
	 */
	public function update()
	{
		$this->validator->check_request($_POST);

		$data['id'] = (int) $_POST['id'];
		$data['name'] = $_POST['name'];

		$this->model->update($data);
	}
	
	/**
	 * Collects data for delete glazing
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