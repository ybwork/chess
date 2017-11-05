<?php

namespace controllers\admin;

use \components\Paginator;
use \paginators\YBPaginator;
use \components\Helper;
use \helpers\YBHelper;
use \components\Validator;
use \validators\YBValidator;
use \models\admin\TotalArea;
use \implementing\models\admin\MySQLTotalAreaModel;

class TotalAreaController
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
        
		$this->model = new TotalArea();
		$this->model->set_model(new MySQLTotalAreaModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());
	}

	public function index()
	{
		$limit = 20;
		$page = $this->helper->get_page();
		$offset = ($page - 1) * $limit;

		$total_area_count = $this->model->count();
		$total = $total_area_count[0]['COUNT(*)'];
		$index = '?page=';

		$total_areas = $this->model->get_all_by_offset_limit($offset, $limit);

		$paginator = $this->paginator = new Paginator();
		$paginator->set_paginator(new YBPaginator($total, $page, $limit, $index));

		require_once(ROOT . '/views/admin/total-area/index.php');
		return true;
	}

	public function create()
	{
		$this->validator->check_request($_POST);

		$data['total_area'] = $_POST['total_area'];
		
		$this->model->create($data);
	}

	public function edit()
	{
		$id = (int) $this->helper->get_id();
		$total_area = $this->model->show($id);

		$response['id'] = (int) $total_area['id'];
		$response['total_area'] = $total_area['total_area'];

		echo json_encode($response);
		return true;
	}

	public function update()
	{
		$this->validator->check_request($_POST);

		$data['id'] = (int) $_POST['id'];
		$data['total_area'] = $_POST['total_area'];

		$this->model->update($data);
	}

	public function delete()
	{
		$this->validator->check_request($_POST);
		
		$id = (int) $_POST['id'];
		$this->model->delete($id);
	}
}