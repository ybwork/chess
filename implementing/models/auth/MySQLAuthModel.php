<?php

namespace implementing\models\auth;

use \components\Validator;
use \validators\YBValidator;
use \interfaces\models\auth\IAuthModel;

class MySQLAuthModel implements IAuthModel
{
	private $validator;

	public function __construct()
	{
		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator());
	}

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