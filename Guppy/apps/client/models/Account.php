<?php
  namespace Client\Models;

  use \Phalcon\Mvc\Collection;
  /**
  * User Mongo Model
  */
  class Account extends Collection{

    /**
    * connection to test document
    */
    public function getSource(){
        return "account";
    }

    public static function isExistName($name){
        $query = [];
        $query["name"] = $name;
        $result = User::find(array($query));

        if(count($result) > 0){
          return true;
        }else{
          return false;
        }
    }

    public static function isExistEmail($email){
      $query = [];
      $query["email"] = $email;
      $result = User::find(array($query));

      if(count($result) > 0){
        return true;
      }else{
        return false;
      }
    }
  }
