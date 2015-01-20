<?php
	$config = new Phalcon\config\Adapter\Ini('../apps/user/config/config.ini');


	$loader = new \Phalcon\Loader();

	$loader->registerNamespaces(array(
					'User\Controllers' => $config->application->controllersDir,
					'User\Models' => $config->application->modelsDir,
					'User\Views' => $config->application->viewsDir,
					'User\Plugins' => $config->application->pluginsDir,
					'User\Auth' => $config->application->authDir
			)
	)->register();
