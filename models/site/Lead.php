<?php

namespace models\site;

use \interfaces\models\site\ILeadModel;

class Lead
{
	private $model;

	public function set_model(ILeadModel $model)
	{
		$this->model = $model;
	}  

	public function get_success_implement()
	{
		return $this->model->get_success_implement();
	}

	public function get_reserved()
	{
		return $this->model->get_reserved();
	}

	public function get_paid_reserve()
	{
		return $this->model->get_paid_reserve();
	}

	public function get_closed_not_implement()
	{
		return $this->model->get_closed_not_implement();
	}

	public function create(array $data)
	{
		return $this->model->delete($data);
	}

	public function lead(array $data)
	{
		return $this->model->lead($data);
	}
}