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

	public function index()
	{
		$limit = 2;
		$page = $this->helper->get_page();
		$offset = ($page - 1) * $limit;

		$glazing_count = $this->model->count();
		$total = $glazing_count[0]['COUNT(*)'];
		$index = '?page=';

		$glazings = $this->model->get_all_by_offset_limit($offset, $limit);

		$paginator = $this->paginator->set_params($total, $page, $limit, $index);

		require_once(ROOT . '/views/admin/glazing/index.php');
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
		$glazing = $this->model->show($id);

		$response['id'] = (int) $glazing['id'];
		$response['name'] = $glazing['name'];

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