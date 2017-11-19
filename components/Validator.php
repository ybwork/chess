<?php

namespace components;

use \interfaces\validators\IValidator;

class Validator
{
	private $validator;

	/**
     * Sets implementing for IPaginator interface
     *
     * @param IValidator $validator - object implementing IValidator
     */
	public function set_validator(IValidator $validator)
	{
		$this->validator = $validator;
	}

    /**
     * Check status code response from server
     *
     * @param $type_request - simple or ajax
     * @return result of the function get
     */
	public function check_response(string $type_request='simple')
	{
		return $this->validator->check_response($type_request);
	}

    /**
     * Cleans values from slashes of tags 
     *
     * @param $value - value for cleaning
     * @return result of the function clean
     */
	public function clean($value)
	{
		return $this->validator->clean($value);
	}

    /**
     * Checks value on empty 
     *
     * @param $value - value for check
     * @param $field - field name
     * @return result of the function check_empty
     */
	public function check_empty($value, string $field)
	{
		return $this->validator->check_empty($value, $field);
	}

    /**
     * Checks file on empty 
     *
     * @param $value - file for check
     * @param $field - field name
     * @return result of the function check_empty_file
     */
	public function check_empty_file($value, string $field)
	{
		return $this->validator->check_empty_file($value, $field);
	}

    /**
     * Checks length string
     *
     * @param $value - string for check
     * @param $field - field name
     * @return result of the function check_length_string
     */
	public function check_length_string($value, string $field)
	{
		return $this->validator->check_length_string($value, $field);
	}

    /**
     * Checks length integer
     *
     * @param $value - number for check
     * @param $field - field name
     * @return result of the function check_length_integer
     */
	public function check_length_integer($value, string $field)
	{
		return $this->validator->check_length_integer($value, $field);
	}

    /**
     * Checks value on type integer
     *
     * @param $value - number for check
     * @param $field - field name
     * @return result of the function check_is_integer
     */
    public function check_is_integer($value, string $field)
    {
        return $this->validator->check_is_integer($value, $field);
    }

    /**
     * Checks email format
     *
     * @param $value - email for check
     * @param $field - field name
     * @return result of the function check_email
     */
	public function check_email(string $value, string $field)
	{
		return $this->validator->check_email($value, $field);
	}

    /**
     * Checks data request
     *
     * @param $request - data request
     * @return result of the function check_request
     */
	public function check_request($request)
	{
		return $this->validator->check_request($request);
	}

    /**
     * Checks access users to parts of the system
     *
     * @param $roles_groups - roles and groups this user
     * @return result of the function check_access
     */
    public function check_access(array $roles)
    {
    	return $this->validator->check_access($roles);
    }

    /**
     * Checks user auth
     *
     * @return result of the function check_auth
     */
    public function check_auth()
    {
    	return $this->validator->check_auth();
    }
    
    /**
     * Fulfills established validation rules
     *
     * @param $fields - field for check
     * @param $rules - rules validation
     * @return result of the function validate
     */
	public function validate(array $fields, array $rules)
	{
		return $this->validator->validate($fields, $rules);
	}
}