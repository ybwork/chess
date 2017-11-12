<?php

namespace controllers\site;

use \models\site\Apartment;
use \implementing\models\site\MySQLApartmentModel;

class CronController
{
	private $apartment;

	public function __construct()
	{
		$this->apartment = new Apartment();
		$this->apartment->set_model(new MySQLApartmentModel());
	}

	public function auto_withdraw_reserve()
	{
		$this->apartment->auto_withdraw_reserve();
	}
}