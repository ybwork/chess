<?php

namespace interfaces\helpers;

interface IHelper
{
	public function get_select2_value(string $field, array $request);
	public function get_checkbox_value(string $field, array $request);
    public function get_page();
   	public function get_id();
}