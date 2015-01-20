<?php
	/**
	 * 这个文件将所有的组件合并
	 */
	$config = new Phalcon\config\Adapter\Ini('../apps/account/config/config.ini');
	//Registering a dispatcher
	$di->set('dispatcher', function() use($di){
    $eventsManager = $di->getShared('eventsManager');
    // $security = new Admin\Plugins\SecurityPlugin($di);
    // $eventsManager->attach('dispatch', $security);

    $dispatcher = new Phalcon\Mvc\Dispatcher();

    //Bind the EventsManager to the Dispatchers
    $dispatcher->setEventsManager($eventsManager);

		$dispatcher->setDefaultNamespace("Account\Controllers\\");  //注意这里是反双斜杆的

		return $dispatcher;
	});

	$di->set('imagick', function(){
		return new Imagick('D:\\software install\\xampp\\htdocs\\Faeva2\\public\\img\\an2.jpg');
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


	//为什么这里的setBAseUrl没有定义的呢
	//原来是官网上的文档上的bug,
	$di->set('url', function(){
	    $url = new \Phalcon\Mvc\Url();
	    // $url->setBaseUrl('/');  其实是下面的uri才是正确的，
			$url->setBaseUri("/");
	    return $url;
	}, true);


	$di->set ( 'mongo', function () use($config) {
		$mongo = new MongoClient ( $config->mongoDatabase->path );
		return $mongo->selectDB ( $config->mongoDatabase->db_name );
	}, true );

	$di->set ( 'mongo2', function () use($config) {
		$mongo = new MongoClient ( $config->mongoDatabase2->path );
		return $mongo->selectDB ( $config->mongoDatabase2->db_name );
	}, true );

	$di->set('collectionManager', function () {
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
		});

		// Setting a default EventsManager
		$modelsManager = new Phalcon\Mvc\Collection\Manager ();
		$modelsManager->setEventsManager ( $eventsManager );
		return $modelsManager;
	}, true);

	$di->set("cookies",function(){
		$cookies =new \Phalcon\Http\Response\Cookies();
		$cookies->useEncryption(false);//禁用加密
		return $cookies;
	});
