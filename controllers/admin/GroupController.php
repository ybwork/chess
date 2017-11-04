<?php

namespace controllers\admin;

use \components\Paginator;
use \paginators\YBPaginator;
use \components\Helper;
use \helpers\YBHelper;
use \components\Validator;
use \validators\YBValidator;
use \implementing\models\admin\MySQLGroupModel;

class GroupController
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

		$this->model = new Group();
		$this->model->set_model(new MySQLGroupModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());

	}
	
	public function index()
	{
		$limit = 20;
		$page = $this->helper->get_page();
		$offset = ($page - 1) * $limit;

		$group_count = $this->model->count();
		$total = $group_count[0]['COUNT(*)'];
		$index = '?page=';

		$groups = $this->model->get_all_by_offset_limit($offset, $limit);

		$paginator = $this->paginator = new Paginator();
		$paginator->set_paginator(new YBPaginator($total, $page, $limit, $index));

		require_once(ROOT . '/views/admin/group/index.php');
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
		$group = $this->model->show($id);

		$response['id'] = (int) $group['id'];
		$response['name'] = $group['name'];

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