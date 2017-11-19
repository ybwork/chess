<?php

namespace components;

use \interfaces\routers\IRouter;

class Router
{
	private $router;

	/**
     * Sets implementing for IRouter interface
     *
     * @param IRouter $router - object implementing IRouter
     */
	public function set_router(IRouter $router)
	{
		$this->router = $router;
	}

	/**
	 * Gets current url
	 *
	 * @return result of the function get_url
	 */
	public function get_url()
	{
		return $this->router->get_url();
	}

	/**
	 * Creates new object based on controller
	 *
	 * @param $handlers - controller and method names
	 * @return result of the function activate_handlers
	 */
	public function activate_handlers($handlers)
	{
		return $this->router->activate_handlers($handlers);
	}
	
	/**
	 * Runs router
	 *
	 * @return result of the function run
	 */
	public function run()
	{
		return $this->router->run();
	}
}