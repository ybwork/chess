<?php

namespace models\admin;

use \interfaces\models\admin\IGlazingModel;

class Glazing
{
	private $model;

	/**
	 * Sets model
	 *
	 * IGlazingModel $model - object implementing interface IGlazingModel
	 */
	public function set_model(IGlazingModel $model)
	{
		$this->model = $model;
	}

	/**
	 * Gets all glazings
	 *
	 * @return result of the function get_all
	 */
	public function get_all()
	{
		return $this->model->get_all();
	}

	/**
	 * Gets all glazings by offset/limit
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
	 * Creates glazing
	 *
	 * @param $data - data glazing
	 * @return result of the function create
	 */
	public function create(array $data)
	{
		return $this->model->create($data);
	}

	/**
	 * Show glazing
	 *
	 * @param $id - glazing id
	 * @return result of the function show
	 */
	public function show(int $id)
	{
		return $this->model->show($id);
	}

	/**
	 * Updates glazing
	 *
	 * @param $data - new data glazing
	 * @return result of the function update
	 */
	public function update(array $data)
	{
		return $this->model->update($data);
	}

	/**
	 * Deletes glazing
	 *
	 * @param $id - glazing id
	 * @return result of the function delete
	 */
	public function delete(int $id)
	{
		return $this->model->delete($id);
	}

	/**
	 * Counts glazing
	 *
	 * @return result of the function count
	 */
	public function count()
	{
		return $this->model->count();
	}
}