<?php 

namespace models\admin;

use \interfaces\models\admin\IDealModel;

class Deal
{
	private $model;

	public function set_model(IDealModel $model)
	{
		$this->model = $model;
	}

	public function get_all_by_offset_limit(int $offset, int $limit)
	{
		return $this->model->get_all_by_offset_limit($offset, $limit);
	}

	public function count()
	{
		return $this->model->count();
	}
}