<?php

namespace Backend;

class Module
{

  public function registerAutoloaders()
  {

    $loader = new \Phalcon\Loader();

    $loader->registerNamespaces(array(
      'Backend\Controllers' => '../apps/backend/controllers/',
      'Backend\Models' => '../apps/backend/models/',
      'Backend\Views' => '../apps/backend/views'
    ));

    $loader->register();
  }


  /**
   * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
   */
  public function registerServices($di)
  {

    echo "backend module registerServices....";
    $di->set('url', function() {
		    $url = new \Phalcon\Mvc\Url();
		    $url->setBaseUri('\mvc\\');
		    return $url;
	  });

    //Registering a dispatcher
    $di->set('dispatcher', function() {

      $dispatcher = new \Phalcon\Mvc\Dispatcher();

      $dispatcher->setDefaultNamespace("Backend\Controllers\\");  //注意这里是反双斜杆的
      return $dispatcher;
    });

    //Registering the view component
    $di->set('view', function() {
      $view = new \Phalcon\Mvc\View();
      $view->setViewsDir('../apps/backend/views/');
      return $view;
    });
  }

}
