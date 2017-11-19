<?php

namespace controllers\admin;

use \components\Paginator;
use \implementing\paginators\YBPaginator;
use \components\Helper;
use \implementing\helpers\YBHelper;
use \components\Validator;
use \implementing\validators\YBValidator;
use \models\admin\Role;
use \implementing\models\admin\MySQLRoleModel;

class RoleController
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

		$this->model = new Role();
		$this->model->set_model(new MySQLRoleModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());
	}

	/**
	 * Shows all roles
	 *
	 * @return html view
	 */
	public function index()
	{
		/*
			Заменить обычный вывод, когда появится js

			$limit = 2;
			$page = $this->helper->get_page();
			$offset = ($page - 1) * $limit;

			$role_count = $this->model->count();
			$total = $role_count[0]['COUNT(*)'];
			$index = '?page=';

			$roles = $this->model->get_all_by_offset_limit($offset, $limit);

			$this->paginator->set_params($total, $page, $limit, $index);
		*/

		$roles = $this->model->get_all();

		require_once(ROOT . '/views/admin/role/index.php');
		return true;
	}

	/**
	 * Collects data for create role
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
	 * Collects data for selected role
	 *
	 * @return data in json
	 */
	public function edit()
	{
		$id = (int) $this->helper->get_id();
		$role = $this->model->show($id);

		$response['id'] = (int) $role['id'];
		$response['name'] = $role['name'];

		echo json_encode($response);
		return true;
	}

	/**
	 * Collects data for update role
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
	 * Collects data for delete role
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