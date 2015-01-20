<?php

namespace Admin;

use Phalcon\config\Adapter\Ini as Ini,
    Phalcon\Loader as Loader;

class Module
{

  public function registerAutoloaders()
  {
    require_once "../apps/admin/config/loader.php";
  }

  /**
   * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
   */
  public function registerServices($di)
  {
    // echo "admin module registerServices....";

    require_once '../apps/admin/config/services.php';
  }

}
