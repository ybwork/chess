<?php

/*
	Статусы квартир:
		- 1 (свободна)
		- 2 (забронирована)
		- 3 (продана)
		- 4 (оплаченная бронь)
		- 5 (бронь риэлтора)

	Роли пользователь:
		- 1 (Администратор)
		- 2 (Старший менеджер)
		- 3 (Менеджер)
		- 4 (Риэлтор)
		- 5 (Руководитель)
*/

use \routers\YBRouter;
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