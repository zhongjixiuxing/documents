<?php
	$config = new Phalcon\config\Adapter\Ini('../apps/admin/config/config.ini');

	$loader = new \Phalcon\Loader();

	$loader->registerNamespaces(array(
					'Admin\Controllers' => $config->application->controllersDir,
					'Admin\Models' => $config->application->modelsDir,
					'Admin\Views' => $config->application->viewsDir,
					'Admin\Plugins' => $config->application->pluginsDir
			)
	)->register();
