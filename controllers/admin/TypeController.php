<?php

namespace controllers\admin;

use \components\Paginator;
use \paginators\YBPaginator;
use \components\Helper;
use \helpers\YBHelper;
use \components\Validator;
use \validators\YBValidator;
use \models\admin\Type;
use \implementing\models\admin\MySQLTypeModel;

class TypeController
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
        
		$this->model = new Type();
		$this->model->set_model(new MySQLTypeModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());

		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator);
	}

	public function index()
	{
		$limit = 20;
		$page = $this->helper->get_page();
		$offset = ($page - 1) * $limit;

		$type_count = $this->model->count();
		$total = $type_count[0]['COUNT(*)'];
		$index = '?page=';

		$types = $this->model->get_all_by_offset_limit($offset, $limit);

		$paginator = $this->paginator = new Paginator();
		$paginator->set_paginator(new YBPaginator($total, $page, $limit, $index));

		require_once(ROOT . '/views/admin/type/index.php');
		return true;
	}

	public function create()
	{
		$this->validator->check_request($_POST);

		$data['type'] = $_POST['type'];
		
		$this->model->create($data);
	}

	public function edit()
	{
		$id = (int) $this->helper->get_id();
		$type = $this->model->show($id);

		$response['id'] = (int) $type['id'];
		$response['type'] = $type['type'];

		echo json_encode($response);
		return true;
	}

	public function update()
	{
		$this->validator->check_request($_POST);

		$data['id'] = (int) $_POST['id'];
		$data['type'] = $_POST['type'];

		$this->model->update($data);
	}

	public function delete()
	{
		$this->validator->check_request($_POST);
		
		$id = (int) $_POST['id'];
		$this->model->delete($id);
	}
}