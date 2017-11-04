<?php

namespace models\admin;

use \interfaces\models\admin\IPriceModel;

class Price
{
	private $model;

	public function set_model(IPriceModel $model)
	{
		$this->model = $model;
	}  

	public function upload(array $nums_prices)
	{
		return $this->model->upload($nums_prices);
	}
}