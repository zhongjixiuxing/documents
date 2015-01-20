<?php
  namespace Admin\Models;

  use \Phalcon\Mvc\Collection;

  /**
  *  Role model
  *
  * --table : role
  */
  class Role extends Collection{
    public function getResource(){
      return "role";
    }
  }
