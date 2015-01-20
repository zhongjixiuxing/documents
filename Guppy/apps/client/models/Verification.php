<?php
  namespace Client\Models;

  use \Phalcon\Mvc\Collection;
  /**
  * User Mongo Model
  */
  class Verification extends Collection{

    /**
    * connection to test document
    */
    public function getSource(){
        return "verification";
    }

  }
