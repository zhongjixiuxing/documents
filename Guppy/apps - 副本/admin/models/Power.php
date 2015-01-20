<?php
  namespace Admin\Models;

  use \Phalcon\Mvc\Collection;

  /**
  *  Role model
  *
  * --table : role
  */
  class Power extends Collection{
    public function getResource(){
      return "power";
    }
  }
