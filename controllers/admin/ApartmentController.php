<?php

namespace controllers\admin;

use \components\Paginator;
use \implementing\paginators\YBPaginator;
use \components\Helper;
use \implementing\helpers\YBHelper;
use \components\Validator;
use \implementing\validators\YBValidator;
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

	/**
	 * Sets validator, access, helper, base, type, total area, window, glazing models
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

	/**
	 * Transform string multiple data
	 *
	 * @param $data - array data apartment
	 * @param $multiple - multiple field name
	 * @return $new_multiple_values - array multiple values for selected field
	 */
	public function transform_multiple_data(array $data, string $multiple)
	{
        $new_multiple_values = [];
  	
       	if ($data[$multiple]) {
	        $multiple_values = explode(', ', $data[$multiple]);

	        $i = 0;
	        foreach ($multiple_values as $multiple_value) {
	        	$values = explode('-', $multiple_value);

	            $new_multiple_values[$i]['id'] = $values[0];
	            $new_multiple_values[$i]['name'] = $values[1];
	        	$i++;
	        }
       	}

        return $new_multiple_values;
	}

	/**
	 * Shows all apartments
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

			$apartment_count = $this->model->count();
			$total = $apartment_count[0]['COUNT(*)'];
			$index = '?page=';

			$apartments = $this->model->get_all_by_offset_limit($offset, $limit);
			$this->paginator->set_params($total, $page, $limit, $index);
		*/

        $apartments = [];

        $old_apartments = $this->model->get_all();

        $i = 0;
        foreach ($old_apartments as $old_apartment) {
            $apartments[$i]['id'] = $old_apartment['id'];
            $apartments[$i]['type_id'] = $old_apartment['type_id'];
            $apartments[$i]['type'] = $old_apartment['type'];
            $apartments[$i]['total_area_id'] = $old_apartment['total_area_id'];
            $apartments[$i]['total_area'] = $old_apartment['total_area'];
            $apartments[$i]['factual_area'] = $old_apartment['factual_area'];
            $apartments[$i]['floor'] = $old_apartment['floor'];
            $apartments[$i]['num'] = $old_apartment['num'];
            $apartments[$i]['price'] = $old_apartment['price'];
            $apartments[$i]['discount'] = $old_apartment['discount'];
            $apartments[$i]['status'] = $old_apartment['status'];
            $apartments[$i]['windows'] = $this->transform_multiple_data($old_apartment, 'windows');
            $apartments[$i]['glazings'] = $this->transform_multiple_data($old_apartment, 'glazings');
            $i++;
        }

        $types = $this->type->get_all();
		$total_areas = $this->total_areas->get_all();
		$windows = $this->window->get_all();
		$glazings = $this->glazing->get_all();

		require_once(ROOT . '/views/admin/apartment/index.php');
		return true;
	}

	/**
	 * Collects data for create apartment
	 *
	 * @return json and/or http header with status code
	 */
	public function create()
	{
		$this->validator->check_request($_POST);

		$data['type_id'] = (int) $_POST['type_id'];
		$data['total_area_id'] = (int) $_POST['total_area_id'];
		$data['factual_area'] = (int) $_POST['factual_area'];
		$data['floor'] = (int) $_POST['floor'];
		$data['num'] = (int) $_POST['num'];
		$data['price'] = (int) $_POST['price'];
		$data['discount'] = (int) $_POST['discount'];
		$data['status'] = (int) $_POST['status'];
		$data['windows'] = $this->helper->get_checkbox_value('window', $_POST);
		$data['glazings'] = $this->helper->get_checkbox_value('glazing', $_POST);
		
		$apartment_exists = $this->model->check_exists($data['num']);
		if ($apartment_exists) {
			header('HTTP/1.0 400 Bad request', http_response_code(400));

			$response['message'] = 'Квартира с таким номером уже существует';
			
			echo json_encode($response);
			die(); 
		} else {
			$this->model->create($data);
		}
	}

	/**
	 * Collects data for update apartment
	 *
	 * @return json and/or http header with status code
	 */
	public function update()
	{
		$this->validator->check_request($_POST);

		$data['id'] = (int) $_POST['id'];
		$data['type_id'] = (int) $_POST['type_id'];
		$data['total_area_id'] = (int) $_POST['total_area_id'];
		$data['factual_area'] = (int) $_POST['factual_area'];
		$data['floor'] = (int) $_POST['floor'];
		$data['num'] = (int) $_POST['num'];
		$data['price'] = (int) $_POST['price'];
		$data['discount'] = (int) $_POST['discount'];
		$data['status'] = (int) $_POST['status'];
		$data['windows'] = $this->helper->get_checkbox_value('window', $_POST);
		$data['glazings'] = $this->helper->get_checkbox_value('glazing', $_POST);

		$this->model->update($data);
	}
	
	/**
	 * Collects data for delete apartment
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