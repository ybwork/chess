<?php

namespace models\admin;

use \interfaces\models\admin\IWindowModel;

class Window
{
	private $model;

    /**
     * Sets model
     *
     * IWindowModel $model - object implementing interface IWindowModel
     */
	public function set_model(IWindowModel $model)
	{
		$this->model = $model;
	}

	/**
	 * Gets all windows
	 *
	 * @return result of the function get_all
	 */
	public function get_all()
	{
		return $this->model->get_all();
	}

	/**
	 * Gets all windows by offset/limit
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
	 * Creates window
	 *
	 * @param $data - data window
	 * @return result of the function create
	 */
	public function create(array $data)
	{
		return $this->model->create($data);
	}

	/**
	 * Show window
	 *
	 * @param $id - window id
	 * @return result of the function show
	 */
	public function show(int $id)
	{
		return $this->model->show($id);
	}

	/**
	 * Updates window
	 *
	 * @param $data - new data window
	 * @return result of the function update
	 */
	public function update(array $data)
	{
		return $this->model->update($data);
	}

	/**
	 * Deletes window
	 *
	 * @param $id - window id
	 * @return result of the function delete
	 */
	public function delete(int $id)
	{
		return $this->model->delete($id);
	}

	/**
	 * Counts windows
	 *
	 * @return result of the function count
	 */
	public function count()
	{
		return $this->model->count();
	}
}