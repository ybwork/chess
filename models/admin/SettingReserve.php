<?php

namespace models\admin;

use \interfaces\models\admin\ISettingReserveModel;

class SettingReserve
{
	private $model;

	public function set_model(ISettingReserveModel $model)
	{
		$this->model = $model;
	}  

	public function get_all()
	{
		return $this->model->get_all();
	}

	public function create(array $data)
	{
		return $this->model->create($data);
	}

	public function show(int $id)
	{
		return $this->model->show($id);
	}

	public function update(array $data)
	{
		return $this->model->update($data);
	}

	public function delete(int $id)
	{
		return $this->model->delete($id);
	}
}