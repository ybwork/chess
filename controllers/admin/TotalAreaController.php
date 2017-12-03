<?php

namespace controllers\admin;

use \components\Paginator;
use \implementing\paginators\YBPaginator;
use \components\Helper;
use \implementing\helpers\YBHelper;
use \components\Validator;
use \implementing\validators\YBValidator;
use \models\admin\TotalArea;
use \implementing\models\admin\MySQLTotalAreaModel;

class TotalAreaController
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
        
		$this->model = new TotalArea();
		$this->model->set_model(new MySQLTotalAreaModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());
	}

	/**
	 * Shows all totals areas
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

			$total_area_count = $this->model->count();
			$total = $total_area_count[0]['COUNT(*)'];
			$index = '?page=';

			$total_areas = $this->model->get_all_by_offset_limit($offset, $limit);

			$this->paginator->set_params($total, $page, $limit, $index);
		*/

		$total_areas = $this->model->get_all();

		require_once(ROOT . '/views/admin/total-area/index.php');
		return true;
	}

	/**
	 * Collects data for create total area
	 *
	 * @return json and/or http header with status code
	 */
	public function create()
	{
		$this->validator->check_request($_POST);

		$data['total_area'] = (int) $_POST['total_area'];
		
		$this->model->create($data);
	}

	/**
	 * Collects data for update total area
	 *
	 * @return json and/or http header with status code
	 */
	public function update()
	{
		$this->validator->check_request($_POST);

		$data['id'] = (int) $_POST['id'];
		$data['total_area'] = (int) $_POST['total_area'];

		$this->model->update($data);
	}

	/**
	 * Collects data for delete total area
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