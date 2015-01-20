<?php
  namespace Account\Models;

  use \Phalcon\Mvc\Collection;
  /**
  * User Mongo Model
  */
  class App extends Collection{

    /**
    * connection to test document
    */
    public function getResource(){
        return "user";
    }

    public static function isExistName($name){
        $query = [];
        $query["name"] = $name;
        $result = App::find(array($query));

        if(count($result) > 0){
          return true;
        }else{
          return false;
        }
    }

    public static function getAppsByAcId($acId){
      $query = [];
      $query['acId'] = $acId;
      $apps = App::find(array($query));
      if($apps){
        return $apps;
      }else{
        return null;
      }
    }

    /**
    *   根据id获取用户
    * @param string uid
    * @return User\Models\User / false
    */
    public static function getAppById($appid){
      $query = array();
      $query["appid"] = $appid;
      return App::findFirst(array($query));
    }
  }
