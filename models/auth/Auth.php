<?php

namespace models\auth;

use \interfaces\models\auth\IAuthModel;

class Auth
{
    private $model;

    public function set_model(IAuthModel $model)
    {
    	$this->model = $model;
    }  

    public function login(array $data, array $user)
    {
        return $this->model->login($data, $user);
    }
}