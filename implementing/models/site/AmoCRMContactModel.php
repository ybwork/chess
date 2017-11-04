<?php

namespace implementing\models\site;

use \components\Validator;
use \validators\YBValidator;
use \components\Helper;
use \helpers\YBHelper;
use \components\DBConnection;
use \dbconnections\MySQLConnection;
use \interfaces\models\site\IContactModel;

class AmoCRMContactModel implements IContactModel
{
	private $helper;
	private $validator;

	public function __construct()
	{
		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper);
	}

	public function create(array $data, $lead_id='')
	{
		$auth = $this->helper->auth_amocrm();

		if ($auth) {	
			$url = '/private/api/v2/json/contacts/set';

			$name = $data['name'] . ' ' . $data['surname'] . ' [' . 'кв.' . $data['apartment_num'] . '] ' . '[' . $_SESSION['user_name_surname'] . ']';

			$method = 'POST';

	        $contacts['request']['contacts']['add'] = array(
	            array(
	                'name' => $name,
	                'linked_leads_id' => array(
	                	$lead_id
	                ),
	                'tags' => 'Шахматка, ТЕСЛА | дом',
	                'custom_fields' => array(
	                    array(
	                        'id' => 105089,
	                        'values' => array(
	                            array(
	                                'value' => $data['phone'],
	                                'enum' => 'WORK'
	                            ),
	                        )
	                    ),
	                    array(
	                        'id' => 105091,
	                        'values' => array(
	                            array(
	                                'value' => $data['email'],
	                                'enum' => 'WORK',
	                            ),
	                        )
	                    ),
	                ),
	            ),
	        );

	       	return $this->helper->do_query_to_amocrm_api($url, $contacts, $method);
		} else {
			return false;
		}
	}
}