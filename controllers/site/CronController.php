<?php

namespace controllers\site;

use \components\Paginator;
use \paginators\YBPaginator;
use \components\Helper;
use \helpers\YBHelper;
use \components\Validator;
use \validators\YBValidator;
use \models\site\Apartment;
use \implementing\models\site\MySQLApartmentModel;
use \models\site\Lead;
use \implementing\models\site\AmoCRMLeadModel;

class CronController
{
	private $apartment;
	private $lead;
	private $helper;
	private $validator;
	private $paginator;

	public function __construct()
	{
		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator);

		$this->apartment = new Apartment();
		$this->apartment->set_model(new MySQLApartmentModel());

		$this->lead = new Lead();
		$this->lead->set_model(new AmoCRMLeadModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());
	}

	public function auto_withdraw_reserve()
	{
		$this->apartment->auto_withdraw_reserve();
	}

	// Повтор функции из ApartmentController чтобы не открывать доступы
	public function auto_actualize()
	{
		$implement_leads = json_decode($this->lead->get_success_implement(), true);
		if (isset($implement_leads)) {		
			$implement_apartments = [];
			foreach ($implement_leads['response']['leads'] as $implement_lead) {
				$name_num_implement_lead = explode('/', $implement_lead['name']);

				if (count($name_num_implement_lead) >= 2) {			
					$num_implement_lead = $name_num_implement_lead[1];
					array_push($implement_apartments, $num_implement_lead);
				}
			}
		}
		
		$reserve_leads = json_decode($this->lead->get_reserved(), true);
		if (isset($reserve_leads)) {		
			$reserve_apartments = [];
			foreach ($reserve_leads['response']['leads'] as $reserve_lead) {
				$name_num_reserve_lead = explode('/', $reserve_lead['name']);;

				if (count($name_num_reserve_lead) >= 2) {
					$num_reserve_lead = $name_num_reserve_lead[1];
					array_push($reserve_apartments, $num_reserve_lead);
				}
			}
		}

		$paid_reserve_leads = json_decode($this->lead->get_paid_reserve(), true);
		if (isset($paid_reserve_leads)) {		
			$paid_reserve_apartments = [];
			foreach ($paid_reserve_leads['response']['leads'] as $paid_reserve_lead) {
				$name_num_paid_reserve_lead = explode('/', $paid_reserve_lead['name']);;

				if (count($name_num_paid_reserve_lead) >= 2) {
					$num_paid_reserve_lead = $name_num_paid_reserve_lead[1];
					array_push($paid_reserve_apartments, $num_paid_reserve_lead);
				}
			}
		}

		$closed_not_implement_leads = json_decode($this->lead->get_closed_not_implement(), true);
		if (isset($closed_not_implement_leads)) {		
			$closed_not_implement_apartments = [];
			foreach ($closed_not_implement_leads['response']['leads'] as $closed_not_implement_lead) {
				$name_num_closed_not_implement_lead = explode('/', $closed_not_implement_lead['name']);;

				if (count($name_num_closed_not_implement_lead) >= 2) {
					$num_closed_not_implement_lead = $name_num_closed_not_implement_lead[1];
					array_push($closed_not_implement_apartments, $num_closed_not_implement_lead);
				}
			}
		}

		$this->apartment->actualize($implement_apartments, $reserve_apartments, $paid_reserve_apartments, $closed_not_implement_apartments);
	}
}