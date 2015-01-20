<?php
  namespace Admin\Models;

  /**
  * User Mongo Model
  */
  class User extends \Phalcon\Mvc\Collection{

    /**
    * connection to test document
    */
    public function getResource(){
        return "user";
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
