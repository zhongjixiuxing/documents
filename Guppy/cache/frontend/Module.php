<?php

namespace Frontend;

class Module
{

  public function registerAutoloaders()
  {

    $loader = new \Phalcon\Loader();

    $loader->registerNamespaces(array(
      'Frontend\Controllers' => '../apps/frontend/controllers/',
      'Frontend\Controllers\Product' => '../apps/frontend/controllers/product',
      'Frontend\Models' => '../apps/frontend/models/'
    ));

    $loader->register();
  }

  /**
   * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
   */
  public function registerServices($di)
  {

    //Registering a dispatcher
    $di->set('dispatcher', function() {

      $dispatcher = new \Phalcon\Mvc\Dispatcher();

      $dispatcher->setDefaultNamespace("Frontend\Controllers\\");
      return $dispatcher;
    });

    //Registering the view component
    $di->set('view', function() {
      $view = new \Phalcon\Mvc\View();
      $view->setViewsDir('../apps/frontend/views/');
      return $view;
    });
  }

}
