<?php

namespace components;

use \interfaces\helpers\IHelper;

class Helper
{
	private $helper;

    /**
     * Sets helper 
     *
     * @param IHelper $helper - object implementing IHelper
     */
	public function set_helper(IHelper $helper)
	{
		$this->helper = $helper;
	}

    /**
     * Gets value from select field (used plugin select2.js) 
     *
     * @param $field - field name from form, request - data from form
     * @return returns the result of the function get_select2_value
     */
	public function get_select2_value(string $field, array $request)
    {
    	return $this->helper->get_select2_value($field, $request);
    }

    /**
     * Gets value from checkbox 
     *
     * @param $field - field name from form, request - data from form
     * @return returns the result of the function get_checkbox_value
     */
	public function get_checkbox_value(string $field, array $request)
    {
    	return $this->helper->get_checkbox_value($field, $request);
    }

    /**
     * Creates value from checkbox 
     *
     * @param $field - field name from form, data - data from form
     * @return returns the result of the function create_select2_data
     */
    public function create_select2_data(string $field, $data='')
    {
		return $this->helper->create_select2_data($field, $data);
    }

    /**
     * Makes a request to amocrm api
     *
     * @param $url - field name from form, data - data from form, method - form submission method
     * @return returns the result of the function do_query_to_amocrm_api
     */
    public function do_query_to_amocrm_api($url, $data='', $method='')
    {
    	return $this->helper->do_query_to_amocrm_api($url, $data, $method);
    }

    /**
     * Makes a auth to amocrm api
     *
     * @return returns the result of the function auth_amocrm
     */
    public function auth_amocrm()
    {
		return $this->helper->auth_amocrm();
    }

    /**
     * Gets number page with current url
     *
     * @return returns the result of the function get_page
     */
    public function get_page()
    {
    	return $this->helper->get_page();
    }

    public function get_id()
    {
        return $this->helper->get_id();
    }

    public function send_excel_file(array $files_names, array $emails, string $subject)
    {
        return $this->helper->send_excel_file($files_names, $emails, $subject);
    }
}