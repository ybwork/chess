<?php

namespace models\site;

use \interfaces\models\site\IApartmentModel;

class Apartment
{
	private $model;

    /**
     * Sets model
     *
     * IApartmentModel $model - object implementing interface IApartmentModel
     */
	public function set_model(IApartmentModel $model)
	{
		$this->model = $model;
	}  

	/**
	 * Gets all aparments
	 *
	 * @param $condition - condition for query
	 * @return result of the function get_all
	 */
	public function get_all(string $condition='')
	{
		return $this->model->get_all($condition);
	}

	/**
	 * Buy aparment
	 *
	 * @param $data - data about buyer and seller
	 * @return result of the function buy
	 */
	public function buy(array $data)
	{
		return $this->model->buy($data);
	}

	/**
	 * Gets statistics of apartments by floor/type
	 *
	 * @return array data or json with http status code
	 */
	public function get_floors_types_aparts()
	{
		return $this->model->get_floors_types_aparts();
	}

	/**
	 * Gets info about apartments
	 *
	 * @return array data or json with http status code
	 */
	public function get_general_info_apartments()
	{
		return $this->model->get_general_info_apartments();
	}

	/**
	 * Reserve apartment
	 *
	 * @param $data - data about seller and buyers
	 * @return json and/or http headers with status code
	 */
	public function reserve(array $data)
	{
		return $this->model->reserve($data);
	}

	/**
	 * Withdraw reserve apartment
	 *
	 * @param $apartment_id - apartment id
	 * @return json and/or http headers with status code
	 */
	public function withdraw_reserve(int $apartment_id)
	{
		return $this->model->withdraw_reserve($apartment_id);
	}
	
	/**
	 * Auto withdraw reserve apartment (for cron)
	 *
	 * @return json and/or http headers with status code
	 */
	public function auto_withdraw_reserve()
	{
		return $this->model->auto_withdraw_reserve();
	}
}