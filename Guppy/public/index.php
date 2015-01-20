<?php

error_reporting(E_ALL);

//暂时使用绝对路径
require_once "D:\\software install\\xampp\\htdocs\\Faeva\\apps\\admin\\library\\Auth\\Exception.php";

class Application extends \Phalcon\Mvc\Application
{
	/**
	 * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
	 */
	protected function _registerServices()
	{

		$di = new \Phalcon\DI\FactoryDefault();

		$loader = new \Phalcon\Loader();

		/**
		 * We're a registering a set of directories taken from the configuration file
		 */
		$loader->registerDirs(
			array(
				__DIR__ . '/../apps/library/'
			)
		)->register();

		//Registering a router
		$di->set('router', function(){

			$router = new \Phalcon\Mvc\Router();

			$router->setDefaultModule("user");

			$router->add("/user/:controller/:action/:params", array(
				'module' => 'user',
				'controller' => 1,
				'action' => 2,
				'params' => 3,
			));

			$router->add("/client/:controller/:action/:params", array(
				'module' => 'client',
				'controller' => 1,
				'action' => 2,
				'params' => 3,
			));

			$router->add("/account/:controller/:action/:params", array(
				'module' => 'account',
				'controller' => 1,
				'action' => 2,
				'params' => 3,
			));

			$router->add("/admin", array(
				'module' => 'admin',
				'controller' => 'index',
				'action' => 'index',
			));

			$router->add("/image/:controller/:action/:params", array(
				'module' => 'image',
				'controller' => 1,
				'action' => 2,
				'params' => 3,
			));

			$router->add("/app/:controller/:action/:params", array(
				'module' => 'app',
				'controller' => 1,
				'action' => 2,
				'params' => 3,
			));

			return $router;
		});

		$this->setDI($di);
	}

	public function main()
	{
		date_default_timezone_set("Asia/Shanghai"); //设置php系统时间的时区

		$this->_registerServices();

		//Register the installed modules
		$this->registerModules(array(
			'app' => array(
				'className' => 'App\Module',
				'path' => '../apps/app/Module.php'
			),
			'image' => array(
				'className' => 'Image\Module',
				'path' => '../apps/Image/Module.php'
			),

			'account' => array(
				'className' => 'Account\Module',
				'path' => '../apps/account/Module.php'
			),

			'client' => array(
				'className' => 'Client\Module',
				'path' => '../apps/client/Module.php'
			),

			'user' => array(
				'className' => 'User\Module',
				'path' => '../apps/user/Module.php'
			)
		));

		echo $this->handle()->getContent();
	}

	function echoInfo($code, $msg){
		echo "{\"code\":$code, \"msg\":$msg}";
	}

}

// try{
	// $debug = new \Phalcon\Debug();
	// $debug->listen();
	
	$application = new Application();
	$application->main();
// }catch(\Phalcon\Exception $e){
// 		switch ($e->getCode()){
// 			case 1000:
// 				break;
// 			case 1001;
// 				$application->echoInfo('605', '');
// 		}


// 	$exception = new Admin\Auth\Exception($e);
// 	$exception->excute();
// 	$code = $e->getCode();
// 	if($code === 404){
// 		$dispatcher = $application->di->get("dispatcher");
// 		// header("location:/Faeva/admin/test/noFount_404");
// 		echo "<br> exception code : $code";
// 		$dispatcher->forward(array(
//                         'controller' => 'test',
//                         'action' => 'test'
//                     ));
// 	}
// 	echo "<br>exception msg : ".$e->getMessage();
// }
