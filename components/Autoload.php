<?php

/**
 * Registers given function as __autoload() implementation
 *
 * @param $class - autoload_function
 * @return true or false
 */
spl_autoload_register(function($class) {
	$paths = array(
		'/',
		'/components',
		'/models',
		'/controllers',
		
		'/interfaces',
		'/interfaces/models',
		'/interfaces/modules',
		'/interfaces/databases',
		
		'/implementing',
		'/implementing/databases',
		'/implementing/models',
		'/implementing/modules',

		'/modules',
	);

	foreach ($paths as $path) {
		$path_to_file = ROOT . $path . '/' . $class . '.php';
		$file = preg_replace('/\\\+/', '/', $path_to_file);

		if (file_exists($file)) {
			include_once $file;
		}
	}
});