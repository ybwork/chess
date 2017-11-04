<?php

namespace models\site;

use \interfaces\models\site\IBuyerModel;

class Buyer
{
	private $model;

	public function set_model(IBuyerModel $model)
	{
		$this->model = $model;
	}  

	public function show(int $id)
	{
		return $this->model->show($id);
	}
}