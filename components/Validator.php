<?php

namespace components;

use \interfaces\validators\IValidator;

class Validator
{
	private $validator;

	public function set_validator(IValidator $validator)
	{
		$this->validator = $validator;
	}

	public function check_response(string $type_request='simple')
	{
		return $this->validator->check_response($type_request);
	}

	public function clean($value)
	{
		return $this->validator->clean($value);
	}

	public function check_empty($value, string $field)
	{
		return $this->validator->check_empty($value, $field);
	}

	public function check_empty_file($value, string $field)
	{
		return $this->validator->check_empty_file($value, $field);
	}

	public function check_length_string($value, string $field)
	{
		return $this->validator->check_length_string($value, $field);
	}

	public function check_length_integer($value, string $field)
	{
		return $this->validator->check_length_integer($value, $field);
	}

    public function check_is_integer($value, string $field)
    {
        return $this->validator->check_is_integer($value, $field);
    }

	public function check_email(string $value, string $field)
	{
		return $this->validator->check_email($value, $field);
	}

	public function check_request($request)
	{
		return $this->validator->check_request($request);
	}

    public function check_access(array $roles)
    {
    	return $this->validator->check_access($roles);
    }

    public function check_auth()
    {
    	return $this->validator->check_auth();
    }

	public function validate(array $fields, array $rules)
	{
		return $this->validator->validate($fields, $rules);
	}
}