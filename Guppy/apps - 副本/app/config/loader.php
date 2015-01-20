<?php
	$config = new Phalcon\config\Adapter\Ini('../apps/app/config/config.ini');

	$loader = new \Phalcon\Loader();

	$loader->registerNamespaces(array(
					'App\Controllers' => $config->application->controllersDir,
					'App\Models' => $config->application->modelsDir,
					'App\Views' => $config->application->viewsDir,
					'App\Plugins' => $config->application->pluginsDir,
			)
	)->register();
