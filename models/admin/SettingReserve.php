<?php

namespace models\admin;

use \interfaces\models\admin\ISettingReserveModel;

class SettingReserve
{
	private $model;

	/**
	 * Sets model
	 *
	 * ISettingReserveModel $model - object implementing interface ISettingReserveModel
	 */
	public function set_model(ISettingReserveModel $model)
	{
		$this->model = $model;
	}

	/**
	 * Gets all settings reserve
	 *
	 * @return result of the function get_all
	 */
	public function get_all()
	{
		return $this->model->get_all();
	}

	/**
	 * Creates setting reserve
	 *
	 * @param $data - data setting reserve
	 * @return result of the function create
	 */
	public function create(array $data)
	{
		return $this->model->create($data);
	}

	/**
	 * Show setting reserve
	 *
	 * @param $id - setting reserve id
	 * @return result of the function show
	 */
	public function show(int $id)
	{
		return $this->model->show($id);
	}

	/**
	 * Updates setting reserve
	 *
	 * @param $data - new data setting reserve
	 * @return result of the function update
	 */
	public function update(array $data)
	{
		return $this->model->update($data);
	}

	/**
	 * Deletes setting reserve
	 *
	 * @param $id - setting reserve id
	 * @return result of the function delete
	 */
	public function delete(int $id)
	{
		return $this->model->delete($id);
	}
}