<?php

namespace models\admin;

use \interfaces\models\admin\ITotalAreaModel;

class TotalArea
{
	private $model;

	public function set_model(ITotalAreaModel $model)
	{
	  $this->model = $model;
	}  

	public function get_all()
	{
		return $this->model->get_all();
	}

	public function get_all_by_offset_limit(int $offset, int $limit)
	{
		return $this->model->get_all_by_offset_limit($offset, $limit);
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

	public function count()
	{
		return $this->model->count();
	}
}


// namespace Admin;

// use models\Model as Model;

// class TotalArea extends Model
// {	
// 	public $table = 'tesla_total_areas';

// 	public $fields_rules = [
// 		'total_area' => 'Общая площадь|empty|length',
// 	];

// 	public $fields_get_all = 'id, total_area';
// 	public $fields_show = 'id, total_area';
// 	public $order_by = 'id';
// }