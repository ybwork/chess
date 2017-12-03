<?php

namespace models\admin;

use \interfaces\models\admin\ITypeModel;

class Type
{
	private $model;

	/**
	 * Sets model
	 *
	 * ITypeModel $model - object implementing interface ITypeModel
	 */
	public function set_model(ITypeModel $model)
	{
		$this->model = $model;
	}

	/**
	 * Gets all types
	 *
	 * @return result of the function get_all
	 */
	public function get_all()
	{
		return $this->model->get_all();
	}

	/**
	 * Gets all types by offset/limit
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
	 * Creates type
	 *
	 * @param $data - data type
	 * @return result of the function create
	 */
	public function create(array $data)
	{
		return $this->model->create($data);
	}

	/**
	 * Updates type
	 *
	 * @param $data - new data type
	 * @return result of the function update
	 */
	public function update(array $data)
	{
		return $this->model->update($data);
	}

	/**
	 * Deletes type
	 *
	 * @param $id - type id
	 * @return result of the function delete
	 */
	public function delete(int $id)
	{
		return $this->model->delete($id);
	}

	/**
	 * Counts types
	 *
	 * @return result of the function count
	 */
	public function count()
	{
		return $this->model->count();
	}
}