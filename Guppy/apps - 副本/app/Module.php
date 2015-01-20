<?php

namespace App;

use Phalcon\config\Adapter\Ini as Ini,
    Phalcon\Loader as Loader;

class Module
{

  public function registerAutoloaders(){
    require_once "../apps/app/config/loader.php";
  }


  /**
   * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
   */
  public function registerServices($di)
  {
    // echo "admin module registerServices....";

    require_once '../apps/app/config/services.php';
  }

}
