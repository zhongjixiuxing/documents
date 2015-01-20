<?php

	require_once "../apps/admin/library/ControllerReflection.php";

/**
	 * 这个文件将所有的组件合并
	 */
	$config = new Phalcon\config\Adapter\Ini('../apps/admin/config/config.ini');
	//Registering a dispatcher
	$di->set('dispatcher', function() use($di){

    $eventsManager = $di->getShared('eventsManager');

    // $security = new Admin\Plugins\SecurityPlugin($di);
    // $eventsManager->attach('dispatch', $security);

    $dispatcher = new Phalcon\Mvc\Dispatcher();

    //Bind the EventsManager to the Dispatcher
    $dispatcher->setEventsManager($eventsManager);

		$dispatcher->setDefaultNamespace("Admin\Controllers\\");  //注意这里是反双斜杆的

		return $dispatcher;
	});

	//Registering the view component
	$di->set('view', function() use($config) {
		$view = new \Phalcon\Mvc\View();
		$view->setViewsDir($config->application->viewsDir);

		$view->registerEngines(array(
			".volt" => 'Phalcon\Mvc\View\Engine\Volt',
			".phtml" => 'Phalcon\Mvc\View\Engine\Volt'
		));

		return $view;
	});

	$di->set("controllerReflection", function() {
		$class = new ControllerReflection();
		return $class;
	});

	$di->set ( 'mongo', function () use($config) {
		$mongo = new MongoClient ( $config->mongoDatabase->path );
		return $mongo->selectDB ( $config->mongoDatabase->db_name );
	}, true );

	$di->set ( 'mongo2', function () use($config) {
		$mongo = new MongoClient ( $config->mongoDatabase2->path );
		return $mongo->selectDB ( $config->mongoDatabase2->db_name );
	}, true );

		// Registering the collectionManager service
	$di->set ( 'collectionManager', function () {
		$eventsManager = new Phalcon\Events\Manager ();

		// Attach an anonymous function as a listener for "model" events
		$eventsManager->attach ( 'collection', function ($event, $model) {
			if (get_class ( $model ) == 'Users') {

				if ($event->getType () == 'beforeSave') {
					if ($model->name == 'Scooby Doo') {
						echo "Scooby Doo isn't a robot!";
						return false;
					}
				}
			}
			return true;
		} );

		// Setting a default EventsManager
		$modelsManager = new Phalcon\Mvc\Collection\Manager ();
		$modelsManager->setEventsManager ( $eventsManager );
		return $modelsManager;
	}, true );


	$di->set("cookies",function(){
		$cookies =new Phalcon\Http\Response\Cookies();
		$cookies->useEncryption(false);//禁用加密
		return $cookies;
	});
