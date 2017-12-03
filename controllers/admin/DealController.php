<?php

namespace controllers\admin;

use \components\Paginator;
use \implementing\paginators\YBPaginator;
use \components\Helper;
use \implementing\helpers\YBHelper;
use \components\Validator;
use \implementing\validators\YBValidator;
use \models\admin\Deal;
use \implementing\models\admin\MySQLDealModel;

class DealController
{
	private $model;
	private $helper;
	private $validator;
	private $paginator;

	/**
	 * Sets validator, access, paginator, helper, model
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

		$this->model = new Deal();
		$this->model->set_model(new MySQLDealModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());
	}

	/**
	 * Shows all dealings
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

			$deal_count = $this->model->count();
			$total = $deal_count[0]['COUNT(*)'];
			$index = '?page=';

			$dealings = $this->model->get_all_by_offset_limit($offset, $limit);

			$this->paginator->set_params($total, $page, $limit, $index);
		*/

		$dealings = $this->model->get_all();

		require_once(ROOT . '/views/admin/deal/index.php');
		return true;
	}
}