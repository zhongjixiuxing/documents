<?php

	require_once "../apps/user/library/MyReflection.php";
	require_once "../global/ResizeImage.php";

/**
	* 这个文件将所有的组件合并
	*/
	require_once "../global/Email.php";
	$email = new Email();


	$config = new Phalcon\config\Adapter\Ini('../apps/user/config/config.ini');

	$di->set("mongoDate", function(){
			$mongoDate = new MongoDate(strtotime(date('Y-m-d H:i:s')));
			// echo "<br> type : ".date('Y-m-d H:i:s');
			return $mongoDate;
	});

	//Registering a dispatcher
	$di->set('dispatcher', function() use($di){

		$dispatcher = new \Phalcon\Mvc\Dispatcher();

		$dispatcher->setDefaultNamespace("User\Controllers\\");  //注意这里是反双斜杆的
		return $dispatcher;
	});

	//过滤器
	$di->set("filter", function(){
		$filter = new \Phalcon\Filter();
		// $filter->sanitize("some(one)@exa\mple.com", "email");
		return $filter;
	});

	// $di->setShared('assets', 'Phalcon\Assets\Manager');
	$di->set("assets", function(){
		return new \Phalcon\Assets\Manager();
	});

	//flash 闪存临时容器
	$di->set("flash", function(){
		//有两种闪存类型，一种直接输出到页面上， 另一种直接保存大session中，在整个会话都可以通用
		// return new \Phalcon\Flash\Direct(); //不知怎样操作direct方式，用着session方式先；
		return new \Phalcon\Flash\Session();
	});


	$di->set("reflection",  function(){
		return new MyReflection();
	});
	$di->set("auth", function(){
		return new User\Auth\MyAuth();
	});

	$di->set("resizeImage", function(){
		$resizeImage = new ResizeImage();
		return $resizeImage;
	});

	$di->set('url', function() use($config){
			$url = new \Phalcon\Mvc\Url();
			$url->setBaseUri($config->application->baseUri);
			return $url;
	}, true);

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
$di->set ( 'email', function () use($email){
		return $email;
});

	$di->set ( 'mongo', function () use($config) {
		$mongo = new MongoClient ( $config->mongoDatabase->path );
		return $mongo->selectDB ( $config->mongoDatabase->db_name );
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
