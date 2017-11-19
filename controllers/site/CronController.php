<?php

namespace controllers\site;

use \models\site\Apartment;
use \implementing\models\site\MySQLApartmentModel;

class CronController
{
	private $apartment;

	/**
	 * Sets apartment model
	 */
	public function __construct()
	{
		$this->apartment = new Apartment();
		$this->apartment->set_model(new MySQLApartmentModel());
	}
	
	/**
	 * Calls to function auto_withdraw_reserve
	 */
	public function auto_withdraw_reserve()
	{
		$this->apartment->auto_withdraw_reserve();
	}
}