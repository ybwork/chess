<?php

namespace models\site;

use \interfaces\models\site\IApartmentModel;

class Apartment
{
	private $model;

	public function set_model(IApartmentModel $model)
	{
		$this->model = $model;
	}  

	public function get_all(string $condition='')
	{
		return $this->model->get_all($condition);
	}

	public function lead(array $data)
	{
		return $this->model->lead($data);
	}

	public function get_floors_types_aparts()
	{
		return $this->model->get_floors_types_aparts();
	}

	public function get_general_info_apartments()
	{
		return $this->model->get_general_info_apartments();
	}

	public function reserve(array $data)
	{
		return $this->model->reserve($data);
	}

	public function withdraw_reserve(int $apartment_id, int $buyer_id)
	{
		return $this->model->withdraw_reserve($apartment_id, $buyer_id);
	}

	public function auto_withdraw_reserve()
	{
		return $this->model->auto_withdraw_reserve();
	}

	public function actualize(array $closed_not_implement_apartments)
	{
		return $this->model->actualize($closed_not_implement_apartments);
	}

	public function auto_actualize()
	{
		return $this->model->auto_actualize();
	}
}