<?php

namespace controllers\admin;

use \components\Paginator;
use \paginators\YBPaginator;
use \components\Helper;
use \helpers\YBHelper;
use \components\Validator;
use \validators\YBValidator;
use \models\admin\Apartment;
use \implementing\models\admin\MySQLApartmentModel;
use \models\admin\Type;
use \implementing\models\admin\MySQLTypeModel;
use \models\admin\TotalArea;
use \implementing\models\admin\MySQLTotalAreaModel;
use \models\admin\Window;
use \implementing\models\admin\MySQLWindowModel;
use \models\admin\Glazing;
use \implementing\models\admin\MySQLGlazingModel;

class ApartmentController
{
	private $model;
	private $helper;
	private $validator;
	private $paginator;

	private $type;
	private $total_areas;
	private $window;
	private $glazing;

	public function __construct()
	{
		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator);

        $roles = ['admin'];
        $this->validator->check_access($roles);

		$this->model = new Apartment();
		$this->model->set_model(new MySQLApartmentModel());

		$this->type = new Type;
		$this->type->set_model(new MySQLTypeModel());

		$this->total_areas = new TotalArea;
		$this->total_areas->set_model(new MySQLTotalAreaModel());

		$this->window = new Window;
		$this->window->set_model(new MySQLWindowModel());

		$this->glazing = new Glazing;
		$this->glazing->set_model(new MySQLGlazingModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());
	}

	public function index()
	{
		$types = $this->type->get_all();
		$total_areas = $this->total_areas->get_all();
		$windows = $this->window->get_all();
		$glazings = $this->glazing->get_all();

		$limit = 20;
		$page = $this->helper->get_page();
		$offset = ($page - 1) * $limit;

		$apartment_count = $this->model->count();
		$total = $apartment_count[0]['COUNT(*)'];
		$index = '?page=';

		$apartments = $this->model->get_all_by_offset_limit($offset, $limit);

		$paginator = $this->paginator = new Paginator();
		$paginator->set_paginator(new YBPaginator($total, $page, $limit, $index));

		require_once(ROOT . '/views/admin/apartment/index.php');
		return true;
	}

	public function create()
	{
		$this->validator->check_request($_POST);

		$data['type_id'] = (int) $_POST['type_id'];
		$data['total_area_id'] = (int) $_POST['total_area_id'];
		$data['factual_area'] = $_POST['factual_area'];
		$data['floor'] = (int) $_POST['floor'];
		$data['num'] = (int) $_POST['num'];
		$data['price'] = (int) $_POST['price'];
		$data['discount'] = (int) $_POST['discount'];
		$data['status'] = (int) $_POST['status'];
		$data['windows'] = $this->helper->get_select2_value('window', $_POST);
		$data['glazings'] = $this->helper->get_checkbox_value('glazing', $_POST);
		
		$this->model->create($data);
	}

	public function edit()
	{
		$id = (int) $this->helper->get_id();
		$apartment = $this->model->show($id);

		$response['id'] = (int) $apartment['id'];
		$response['type_id'] = (int) $apartment['type_id'];
		$response['total_area_id'] = (int) $apartment['total_area_id'];
		$response['factual_area'] = $apartment['factual_area'];
		$response['floor'] = (int) $apartment['floor'];
		$response['num'] = (int) $apartment['num'];
		$response['price'] = (int) $apartment['price'];
		$response['discount'] = (int) $apartment['discount'];
		$response['status'] = (int) $apartment['status'];
		$response['windows'] = $apartment['windows'];
		$response['glazings'] = $apartment['glazings'];

		echo json_encode($response);
		return true;
	}

	public function update()
	{
		$this->validator->check_request($_POST);

		$data['id'] = (int) $_POST['id'];
		$data['type_id'] = (int) $_POST['type_id'];
		$data['total_area_id'] = (int) $_POST['total_area_id'];
		$data['factual_area'] = $_POST['factual_area'];
		$data['floor'] = (int) $_POST['floor'];
		$data['num'] = (int) $_POST['num'];
		$data['price'] = (int) $_POST['price'];
		$data['discount'] = (int) $_POST['discount'];
		$data['status'] = (int) $_POST['status'];
		$data['windows'] = $this->helper->get_select2_value('window', $_POST);
		$data['glazings'] = $this->helper->get_checkbox_value('glazing', $_POST);

		$this->model->update($data);
	}

	public function delete()
	{
		$this->validator->check_request($_POST);
		
		$id = (int) $_POST['id'];
		$this->model->delete($id);
	}
}