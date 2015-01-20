<?php
  namespace App\Models;

  use \Phalcon\Mvc\Collection;
  /**
  * User Mongo Model
  */
  class App extends Collection{

    /**
    * connection to test document
    */
    public function getResource(){
        return "app";
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

    public static function getUserNameById($uid){
      $user = $this->getUserById($uid);
      if($user){
        return $user->name;
      }else{
        return null;
      }
    }

    /**
    *   根据id获取用户
    * @param string uid
    * @return User\Models\User / false
    */
    public static function getAppById($appId){
      $query = array();
      $query["appId"] = $appId;
      return App::findFirst(array($query));
    }
  }
