<?php

namespace interfaces\models\site;

interface IContactModel
{
	public function create(array $data, $lead_id='');
}