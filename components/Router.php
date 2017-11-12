<?php

namespace components;

use \interfaces\routers\IRouter;

class Router
{
	private $router;

	public function set_router(IRouter $router)
	{
		$this->router = $router;
	}

	public function get_url()
	{
		return $this->router->get_url();
	}

	public function activate_handlers($handlers)
	{
		return $this->router->activate_handlers($handlers);
	}

	public function run()
	{
		return $this->router->run();
	}
}