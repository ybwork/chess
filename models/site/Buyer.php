<?php

namespace models\site;

use \interfaces\models\site\IBuyerModel;

class Buyer
{
	private $model;

    /**
     * Sets model
     *
     * IBuyerModel $model - object implementing interface IBuyerModel
     */
	public function set_model(IBuyerModel $model)
	{
		$this->model = $model;
	}

	/**
	 * Show buyer
	 *
	 * @param $id - buyer id
	 * @return result of the function show
	 */
	public function show(int $id)
	{
		return $this->model->show($id);
	}
}