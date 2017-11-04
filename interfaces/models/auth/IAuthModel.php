<?php

namespace interfaces\models\auth;

interface IAuthModel
{
	public function login(array $data, array $user);
}