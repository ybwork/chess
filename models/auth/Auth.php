<?php

namespace models\auth;

use \interfaces\models\auth\IAuthModel;

class Auth
{
    private $model;

    /**
     * Sets model
     *
     * IAuthModel $model - object implementing interface IAuthModel
     */
    public function set_model(IAuthModel $model)
    {
    	$this->model = $model;
    }

	/**
	 * Login user in system
	 * 
	 * @param $data - user data for check
	 * @param $user - user data for compare
	 * @return result of the function login
	 */
    public function login(array $data, array $user)
    {
        return $this->model->login($data, $user);
    }
}