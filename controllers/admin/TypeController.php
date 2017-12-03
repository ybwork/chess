<?php

namespace controllers\admin;

use \components\Paginator;
use \implementing\paginators\YBPaginator;
use \components\Helper;
use \implementing\helpers\YBHelper;
use \components\Validator;
use \implementing\validators\YBValidator;
use \models\admin\Type;
use \implementing\models\admin\MySQLTypeModel;

class TypeController
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
        
		$this->model = new Type();
		$this->model->set_model(new MySQLTypeModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());

		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator);
	}

	/**
	 * Shows all types
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

			$type_count = $this->model->count();
			$total = $type_count[0]['COUNT(*)'];
			$index = '?page=';

			$types = $this->model->get_all_by_offset_limit($offset, $limit);

			$this->paginator->set_params($total, $page, $limit, $index);
		*/

		$types = $this->model->get_all();

		require_once(ROOT . '/views/admin/type/index.php');
		return true;
	}

	/**
	 * Collects data for create type
	 *
	 * @return json and/or http header with status code
	 */
	public function create()
	{
		$this->validator->check_request($_POST);

		$data['type'] = $_POST['type'];
		
		$this->model->create($data);
	}

	/**
	 * Collects data for update type
	 *
	 * @return json and/or http header with status code
	 */
	public function update()
	{
		$this->validator->check_request($_POST);

		$data['id'] = (int) $_POST['id'];
		$data['type'] = $_POST['type'];

		$this->model->update($data);
	}
	
	/**
	 * Collects data for delete type
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