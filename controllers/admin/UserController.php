<?php

namespace controllers\admin;

use \components\Paginator;
use \paginators\YBPaginator;
use \components\Helper;
use \helpers\YBHelper;
use \components\Validator;
use \validators\YBValidator;
use \models\admin\User;
use \implementing\models\admin\MySQLUserModel;
use \models\admin\Group;
use \implementing\models\admin\MySQLGroupModel;
use \models\admin\Role;
use \implementing\models\admin\MySQLRoleModel;
use \models\admin\Apartment;
use \implementing\models\admin\MySQLApartmentModel;

class UserController
{
	private $model;
	private $role;
    private $apartment;
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

		$this->model = new User();
		$this->model->set_model(new MySQLUserModel());

		$this->role = new Role();
		$this->role->set_model(new MySQLRoleModel());

        $this->apartment = new Apartment();
        $this->apartment->set_model(new MySQLApartmentModel());

        $this->helper = new Helper();
        $this->helper->set_helper(new YBHelper());
	}

	public function index()
	{
		$users = $this->model->get_all();
		$roles = $this->role->get_all();
        $available_apartments = $this->apartment->get_available();
        
        $limit = 20;
        $page = $this->helper->get_page();
        $offset = ($page - 1) * $limit;

        $user_count = $this->model->count();
        $total = $user_count[0]['COUNT(*)'];
        $index = '?page=';

        $users = $this->model->get_all_by_offset_limit($offset, $limit);

        $paginator = $this->paginator = new Paginator();
        $paginator->set_paginator(new YBPaginator($total, $page, $limit, $index));

		require_once(ROOT . '/views/admin/user/index.php');
		return true;
	}

	public function create()
	{
		$this->validator->check_request($_POST);

		$data['login'] = $_POST['login'];
		$data['name'] = $_POST['name'];
		$data['surname'] = $_POST['surname'];
        $data['patronymic'] = $_POST['patronymic'];
		$data['role'] = (int) $_POST['role'];
        $data['apartments'] = $this->helper->get_select2_value('apartments', $_POST);

        if ($_POST['password']) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } else {
            $data['password'] = $_POST['password'];
        }

		$this->model->create($data);
	}

    public function edit()
    {
        $id = (int) $this->helper->get_id();
        $user = $this->model->show($id);

        $response['id'] = (int) $user['id'];
        $response['login'] = $user['login'];
        $response['name'] = $user['name'];
        $response['surname'] = $user['surname'];
        $response['patronymic'] = $user['patronymic'];
        $response['roles'] = $user['roles'];
        $response['apartments'] = $user['apartments'];

        echo json_encode($response);
        return true;
    }

    public function update()
    {
        $this->validator->check_request($_POST);

        $data['id'] = (int) $_POST['id'];
        $data['login'] = $_POST['login'];
        $data['name'] = $_POST['name'];
        $data['surname'] = $_POST['surname'];
        $data['patronymic'] = $_POST['patronymic'];
        $data['role'] = (int) $_POST['role'];
        $data['apartments'] = $this->helper->get_select2_value('apartments', $_POST);
        $data['password'] = $_POST['password'];

        $this->model->update($data);
    }

    public function delete()
    {
        $this->validator->check_request($_POST);
        
        $id = (int) $_POST['id'];
        $this->model->delete($id);
    }

    public function logout() {
        unset($_SESSION['user']);
        unset($_SESSION['error_access']);
        header("Location: /login");
    }
}