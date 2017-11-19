<?php

namespace implementing\models\auth;

use \components\Validator;
use \implementing\validators\YBValidator;
use \interfaces\models\auth\IAuthModel;

class MySQLAuthModel implements IAuthModel
{
	private $validator;

    /**
     * Sets validator
     */
	public function __construct()
	{
		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator());
	}

    /**
     * Login user in system
     *
     * @param $data - user data
     * @param $user - data about exists users
     */
	public function login(array $data, array $user)
    {
        $data = $this->validator->validate($data, [
            'login' => 'Логин|empty|length_string',
        ]);

        if ($data['login'] != $user['login']) {
            return false;
        }

        if (password_verify($data['password'], $user['password'])) {
            return true;
        } else {
            return false;
        }
    }
}