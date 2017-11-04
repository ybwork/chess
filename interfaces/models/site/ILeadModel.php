<?php

namespace interfaces\models\site;

interface ILeadModel
{
	public function get_success_implement();
	public function get_reserved();
	public function get_paid_reserve();
	public function get_closed_not_implement();
	public function create(array $data);
	public function lead(array $data);
}