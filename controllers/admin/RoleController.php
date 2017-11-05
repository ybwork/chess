<?php

namespace controllers\admin;

use \components\Paginator;
use \paginators\YBPaginator;
use \components\Helper;
use \helpers\YBHelper;
use \components\Validator;
use \validators\YBValidator;
use \models\admin\Role;
use \implementing\models\admin\MySQLRoleModel;

class RoleController
{
	private $model;
	private $helper;
	private $validator;
	private $paginator; 

	public function __construct()
	{
		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator);
		$this->validator->check_auth();
		
        $roles = ['admin'];
        $this->validator->check_access($roles);

		$this->model = new Role();
		$this->model->set_model(new MySQLRoleModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());
	}

	public function index()
	{
		$limit = 20;
		$page = $this->helper->get_page();
		$offset = ($page - 1) * $limit;

		$role_count = $this->model->count();
		$total = $role_count[0]['COUNT(*)'];
		$index = '?page=';

		$roles = $this->model->get_all_by_offset_limit($offset, $limit);

		$paginator = $this->paginator = new Paginator();
		$paginator->set_paginator(new YBPaginator($total, $page, $limit, $index));

		require_once(ROOT . '/views/admin/role/index.php');
		return true;
	}

	public function create()
	{
		$this->validator->check_request($_POST);

		$data['name'] = $_POST['name'];
		
		$this->model->create($data);
	}

	public function edit()
	{
		$id = (int) $this->helper->get_id();
		$role = $this->model->show($id);

		$response['id'] = (int) $role['id'];
		$response['name'] = $role['name'];

		echo json_encode($response);
		return true;
	}

	public function update()
	{
		$this->validator->check_request($_POST);

		$data['id'] = (int) $_POST['id'];
		$data['name'] = $_POST['name'];

		$this->model->update($data);
	}

	public function delete()
	{
		$this->validator->check_request($_POST);
		
		$id = (int) $_POST['id'];
		$this->model->delete($id);
	}
}