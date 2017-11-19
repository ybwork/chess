<?php

namespace models\admin;

use \interfaces\models\admin\IPriceModel;

class Price
{
	private $model;

	/**
	 * Sets model
	 *
	 * IPriceModel $model - object implementing interface IPriceModel
	 */
	public function set_model(IPriceModel $model)
	{
		$this->model = $model;
	}  

	/**
	 * Uploads new prices
	 *
	 * @param $nums_prices - num apartment with price
	 * @return result of the function upload 
	 */
	public function upload(array $nums_prices)
	{
		return $this->model->upload($nums_prices);
	}
}