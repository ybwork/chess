<?php

namespace models\admin;

use \interfaces\models\admin\IRoleModel;

class Role
{
	private $model;

	/**
	 * Sets model
	 *
	 * IRoleModel $model - object implementing interface IRoleModel
	 */
	public function set_model(IRoleModel $model)
	{
		$this->model = $model;
	}

	/**
	 * Gets all roles
	 *
	 * @return result of the function get_all
	 */
	public function get_all()
	{
		return $this->model->get_all();
	}

	/**
	 * Gets all roles by offset/limit
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
	 * Creates role
	 *
	 * @param $data - data role
	 * @return result of the function create
	 */
	public function create(array $data)
	{
		return $this->model->create($data);
	}

	/**
	 * Updates role
	 *
	 * @param $data - new data role
	 * @return result of the function update
	 */
	public function update(array $data)
	{
		return $this->model->update($data);
	}

	/**
	 * Deletes role
	 *
	 * @param $id - role id
	 * @return result of the function delete
	 */
	public function delete(int $id)
	{
		return $this->model->delete($id);
	}

	/**
	 * Counts roles
	 *
	 * @return result of the function count
	 */
	public function count()
	{
		return $this->model->count();
	}
}