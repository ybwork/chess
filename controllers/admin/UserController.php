<?php

namespace controllers\admin;

use \components\Paginator;
use \implementing\paginators\YBPaginator;
use \components\Helper;
use \implementing\helpers\YBHelper;
use \components\Validator;
use \implementing\validators\YBValidator;
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

    /**
     * Sets validator, access, helper, base, group, role, apartment models
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

		$this->model = new User();
		$this->model->set_model(new MySQLUserModel());

		$this->role = new Role();
		$this->role->set_model(new MySQLRoleModel());

        $this->apartment = new Apartment();
        $this->apartment->set_model(new MySQLApartmentModel());

        $this->helper = new Helper();
        $this->helper->set_helper(new YBHelper());
	}

    /**
     * Shows all users
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

            $user_count = $this->model->count();
            $total = $user_count[0]['COUNT(*)'];
            $index = '?page=';

            $users = $this->model->get_all_by_offset_limit($offset, $limit);
            $this->paginator->set_params($total, $page, $limit, $index);
        */

        $users = $this->model->get_all();
        $roles = $this->role->get_all();

		require_once(ROOT . '/views/admin/user/index.php');
		return true;
	}

    /**
     * Collects data for create user
     *
     * @return status code
     */
	public function create()
	{
		$this->validator->check_request($_POST);

		$data['role_id'] = (int) $_POST['role'];
        $data['login'] = $_POST['login'];
        $data['name'] = $_POST['name'];
        $data['surname'] = $_POST['surname'];
        $data['patronymic'] = $_POST['patronymic'];
        $data['phone'] = $_POST['phone'];

        if ($_POST['password']) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } else {
            $data['password'] = $_POST['password'];
        }

		$this->model->create($data);
	}

    /**
     * Collects data for update user
     *
     * @return status code
     */
    public function update()
    {
        $this->validator->check_request($_POST);

        $data['id'] = (int) $_POST['id'];
        $data['role_id'] = (int) $_POST['role'];
        $data['login'] = $_POST['login'];
        $data['name'] = $_POST['name'];
        $data['surname'] = $_POST['surname'];
        $data['patronymic'] = $_POST['patronymic'];
        $data['phone'] = $_POST['phone'];
        $data['password'] = $_POST['password'];

        $this->model->update($data);
    }

    /**
     * Collects data for delete user
     *
     * @return status code
     */
    public function delete()
    {
        $this->validator->check_request($_POST);
        
        $id = (int) $_POST['id'];
        $this->model->delete($id);
    }
    
    /**
     * Logout user from system
     *
     * @return status code
     */
    public function logout() {
        unset($_SESSION['user']);
        unset($_SESSION['error_access']);
        header("Location: /login");
    }
}