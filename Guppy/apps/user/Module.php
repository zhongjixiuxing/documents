<?php

namespace User;

class Module
{

  public function registerAutoloaders()
  {
    require_once "../apps/user/config/loader.php";
  }

  /**
   * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
   */
  public function registerServices($di)
  {
    // echo "user module registerServices....";
    require_once '../apps/user/config/services.php';
  }

}
