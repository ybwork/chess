<?php

namespace interfaces\routers;

interface IRouter
{
	public function get_url();
	public function activate_handlers($handlers);
	public function run();
}