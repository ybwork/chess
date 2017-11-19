<?php

/*
	Статусы квартир:
		- 1 (свободна)
		- 2 (забронирована)
		- 3 (продана)

	Роли пользователь:
		- 1 (Администратор)
		- 2 (Менеджер)
		- 3 (Риэлтор)
*/

use \implementing\routers\YBRouter;
use \components\Router;
		
// Config
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Connect files
define('ROOT', __DIR__);

require_once(ROOT . '/components/Router.php');
require_once(ROOT . '/components/Autoload.php');

// Start router
$router = new Router();
$router->set_router(new YBRouter());
$router->run();