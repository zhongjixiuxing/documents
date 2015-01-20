<?php
	$config = new Phalcon\config\Adapter\Ini('../apps/client/config/config.ini');



	$loader = new \Phalcon\Loader();

	$loader->registerNamespaces(array(
					'Client\Controllers' => $config->application->controllersDir,
					'Client\Models' => $config->application->modelsDir,
					'Client\Views' => $config->application->viewsDir,
					'Client\Plugins' => $config->application->pluginsDir,
					'Client\Auth' => $config->application->authDir
			)
	)->register();
