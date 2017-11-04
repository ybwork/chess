<?php

namespace implementing\models\site;

use \components\Validator;
use \validators\YBValidator;
use \components\Helper;
use \helpers\YBHelper;
use \components\DBConnection;
use \dbconnections\MySQLConnection;
use \interfaces\models\site\ILeadModel;
use \models\site\Contact;
use \implementing\models\site\AmoCRMContactModel;

class AmoCRMLeadModel implements ILeadModel
{
	private $helper;
	private $validator;
	private $contact;

	public function __construct()
	{
		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator());

		$this->contact = new Contact();
		$this->contact->set_model(new AmoCRMContactModel);

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper);
	}

	public function get_success_implement()
	{
		$auth = $this->helper->auth_amocrm();

		if ($auth) {
			/*
				Выборка по колонкам: документы от клинта, дду, сдача в юстицию, юстиция, передача договора клиенту, оплата дду, поздравление
			*/
	        $url = '/private/api/v2/json/leads/list?status[]=16042321&status[]=15289882&status[]=16042324&status[]=16042327&status[]=16042330&status[]=16042333&status[]=16042336&status[]=142&tags=ТЕСЛА | дом';

	    	return $this->helper->do_query_to_amocrm_api($url);
		} else {
			return false;
		}
	}

	public function get_reserved()
	{
		$auth = $this->helper->auth_amocrm();

		if ($auth) {
			/*
				Выборка по колонкам: подписание брони инпк, подписание брони клиентом
			*/
			$url = '/private/api/v2/json/leads/list?status[]=16042315&status[]=15289879&tags=ТЕСЛА | дом';

	    	return $this->helper->do_query_to_amocrm_api($url);
		} else {
			return false;
		}
	}

	public function get_paid_reserve()
	{
		$auth = $this->helper->auth_amocrm();

		if ($auth) {
			/*
				Выборка по колонкам: оплата брони
			*/
			$url = '/private/api/v2/json/leads/list?status[]=16063342&tags=ТЕСЛА | дом';

			return $this->helper->do_query_to_amocrm_api($url);
		} else {
			return false;
		}
	}

	public function get_closed_not_implement()
	{
		$auth = $this->helper->auth_amocrm();

		if ($auth) {
			/*
				Выборка по колонкам: закрытые и не реализованные
			*/
			$url = '/private/api/v2/json/leads/list?status[]=143&tags=ТЕСЛА | дом';

			return $this->helper->do_query_to_amocrm_api($url);
		} else {
			return false;
		}
	}

	public function create(array $data)
	{
		$auth = $this->helper->auth_amocrm();

		if ($auth) {
			$name = 'Сделка' . ' №' . $data['apartment_num'] . '/' . $data['apartment_num'];
	        $url = '/private/api/v2/json/leads/set';
	        $method = 'POST';

	        $leads['request']['leads']['add'] = array(
	            array(
	                'name' => $name,
	                'status_id' => 15289873,
	                'price' => rand(5, 900000),
	                'tags' => 'ТЕСЛА | дом',
	                'created_user_id' => 15289867,
	            ),
	        );
			
			return $this->helper->do_query_to_amocrm_api($url, $leads, $method);
		} else {
			return false;
		}
	}

	public function lead(array $data)
	{
		$auth = $this->helper->auth_amocrm();

		if ($auth) {
			$lead = $this->create($data);

			$convert_lead = json_decode($lead, true);
			$lead_id = $convert_lead['response']['leads']['add'][0]['id'];

			if ($lead) {
				return $this->contact->create($data, $lead_id);
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}