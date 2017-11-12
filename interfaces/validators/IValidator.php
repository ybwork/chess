<?php

namespace interfaces\validators;

interface IValidator
{
	public function check_response(string $type_request);
	public function clean($value);
	public function check_empty($value, string $field);
	public function check_empty_file($value, string $field);
	public function check_length_string($value, string $field);
	public function check_length_integer($value, string $field);
	public function check_is_integer($value, string $field);
	public function check_email(string $value, string $field);
	public function check_request($request);
	public function check_access(array $roles);
	public function validate(array $fields, array $rules);
	public function check_auth();
}