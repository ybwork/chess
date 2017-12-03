<?php

namespace models\admin;

use \interfaces\models\admin\ITotalAreaModel;

class TotalArea
{
	private $model;

	/**
	 * Sets model
	 *
	 * ITotalAreaModel $model - object implementing interface ITotalAreaModel
	 */
	public function set_model(ITotalAreaModel $model)
	{
		$this->model = $model;
	} 

	/**
	 * Gets all totals areas
	 *
	 * @return result of the function get_all
	 */
	public function get_all()
	{
		return $this->model->get_all();
	}

	/**
	 * Gets all totals areas by offset/limit
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
	 * Creates total area
	 *
	 * @param $data - data total area
	 * @return result of the function create
	 */
	public function create(array $data)
	{
		return $this->model->create($data);
	}

	/**
	 * Updates total area
	 *
	 * @param $data - new data total area
	 * @return result of the function update
	 */
	public function update(array $data)
	{
		return $this->model->update($data);
	}

	/**
	 * Deletes total area
	 *
	 * @param $id - total area id
	 * @return result of the function delete
	 */
	public function delete(int $id)
	{
		return $this->model->delete($id);
	}

	/**
	 * Counts total area
	 *
	 * @return result of the function count
	 */
	public function count()
	{
		return $this->model->count();
	}
}