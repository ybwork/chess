<?php

namespace controllers\admin;

use \components\Paginator;
use \paginators\YBPaginator;
use \components\Helper;
use \helpers\YBHelper;
use \components\Validator;
use \validators\YBValidator;
use \models\admin\Window;
use \implementing\models\admin\MySQLWindowModel;

class WindowController
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

		$this->model = new Window();
		$this->model->set_model(new MySQLWindowModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());
	}

	public function index()
	{
		$limit = 20;
		$page = $this->helper->get_page();
		$offset = ($page - 1) * $limit;

		$window_count = $this->model->count();
		$total = $window_count[0]['COUNT(*)'];
		$index = '?page=';

		$windows = $this->model->get_all_by_offset_limit($offset, $limit);

		$paginator = $this->paginator = new Paginator();
		$paginator->set_paginator(new YBPaginator($total, $page, $limit, $index));

		require_once(ROOT . '/views/admin/window/index.php');
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
		$window = $this->model->show($id);

		$response['id'] = (int) $window['id'];
		$response['name'] = $window['name'];

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