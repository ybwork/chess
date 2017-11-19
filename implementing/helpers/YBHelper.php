<?php

namespace implementing\helpers;

use \interfaces\helpers\IHelper;

class YBHelper implements IHelper
{
    /**
     * Makes correct value from select field
     *
     * @param $field - name field
     * @param $request - data from POST request
     * @return field with data or empty string
     */
	public function get_select2_value(string $field, array $request)
    {
    	if (array_key_exists("$field", $request)) {
    		$data = [];

    		foreach ($request["$field"] as $key => $value) {
    			$data[$key] = (int) $value;
    		}
		} else {
			$data = '';
		}

		return $data;
    }

    /**
     * Makes correct value from select checkbox
     *
     * @param $field - name field
     * @param $request - data from POST request
     * @return field with data or empty string
     */
	public function get_checkbox_value(string $field, array $request)
    {
    	if (array_key_exists("$field", $request)) {
    		$data = [];
    		
    		foreach ($request["$field"] as $key => $value) {
    			$data[$key] = (int) $value;
    		}
		} else {
			$data = '';
		}

		return $data;
    }

    /**
     * Gets current page from $_GET
     *
     * @return number page
     */
    public function get_page()
    {
    	if (!$_GET) {
			$page = 1;
        } else {        	
			if (isset($_GET['page'])) {
				$page = $_GET['page'];
			} else {
				$page = 1;
			}
        }

        return $page;
    }
    
    /**
     * Gets current page from current url
     *
     * @return number page
     */
    public function get_id()
    {
        $arr = explode('/', $_SERVER['REQUEST_URI']);
        return $id = (int) end($arr);
    }
}