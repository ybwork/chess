<?php

namespace helpers;

interface IHelper
{
	public function get_select2_value(string $field, array $request);
	public function get_checkbox_value(string $field, array $request);
    public function create_select2_data(string $field, $data='');
    public function do_query_to_amocrm_api($url, $data='', $method='');
    public function auth_amocrm();
    public function get_page();
   	public function get_id();
   	public function send_excel_file(array $files_names, array $emails, string $subject);
}