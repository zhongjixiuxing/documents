<?php
	$config = new Phalcon\config\Adapter\Ini('../apps/account/config/config.ini');

	$loader = new \Phalcon\Loader();

	$loader->registerNamespaces(array(
					'Account\Controllers' => $config->application->controllersDir,
					'Account\Models' => $config->application->modelsDir,
					'Account\Views' => $config->application->viewsDir,
					'Account\Plugins' => $config->application->pluginsDir,
					'Account\Auth' => $config->application->authDir
			)
	)->register();
