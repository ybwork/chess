<?php

namespace models\admin;

use \interfaces\models\admin\IApartmentModel;

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
	 * @return result of the function get_all
	 */
	public function get_all()
	{
		return $this->model->get_all();
	}

	/**
	 * Gets all apartments by offset/limit
	 * 
	 * @param $offset - plece for start query
	 * @param $limit - limit records on each query
	 * @return result of the function get_all_by_offset_limit
	 */
	public function get_all_by_offset_limit(int $offset, int $limit)
	{
		return $this->model->get_all_by_offset_limit($offset, $limit);
	}

	/**
	 * Gets all apartments with status 1
	 *
	 * @return result of the function get_available
	 */
	public function get_available()
	{
		return $this->model->get_available();
	}

	/**
	 * Creates aparment
	 *
	 * @param $data - data apartment
	 * @return result of the function create
	 */
	public function create(array $data)
	{
		return $this->model->create($data);
	}

	/**
	 * Show apartment
	 *
	 * @param $id - aparment id
	 * @return result of the function show
	 */
	public function show(int $id)
	{
		return $this->model->show($id);
	}

	/**
	 * Updates apartment
	 *
	 * @param $data - new data apartment
	 * @return result of the function update
	 */
	public function update(array $data)
	{
		return $this->model->update($data);
	}

	/**
	 * Deletes apartment
	 *
	 * @param $id - apartment id
	 * @return result of the function delete
	 */
	public function delete(int $id)
	{
		return $this->model->delete($id);
	}

	/**
	 * Counts apartments
	 *
	 * @return result of the function count
	 */
	public function count()
	{
		return $this->model->count();
	}

	/**
	 * Checks apartment on exists
	 *
	 * @param $apartment_num - num apartment
	 * @return result of the function check_exists
	 */
	public function check_exists(int $apartment_num)
	{
		return $this->model->check_exists($apartment_num);
	}
}