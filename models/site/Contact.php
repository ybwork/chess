<?php

namespace models\site;

use \interfaces\models\site\IContactModel;

class Contact
{
	private $model;

	public function set_model(IContactModel $model)
	{
		$this->model = $model;
	}  

	public function create(array $data, $lead_id='')
	{
		return $this->model->create($data, $lead_id);
	}
}