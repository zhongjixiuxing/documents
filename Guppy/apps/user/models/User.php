<?php
  namespace User\Models;

  use \Phalcon\Mvc\Collection;
  /**
  * User Mongo Model
  */
  class User extends Collection{

    /**
    * connection to test document
    */
    public function getSource(){
        return "appUser";
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

    public static function getUser($query){

      $arr = [];
      $arr['email'] = '1965198272@qq.com';

      $user = User::findFirst(array($arr));

      $info = $user->toArray();

      echo "<br> user : "; print_r($info);

      return User::findFirst(array($query));
    }

    public static function register($query){
      $query['UserId'] = User::uuid();
      $user = new User();

      foreach(array_keys($query) as $key){
        $user->$key = $query[$key];
      }

      $user->save();
    }


    /**
    *   根据id获取用户
    * @param string uid
    * @return User\Models\User / false
    */
    public static function getUserById($uid){
      $query = array();
      $query["uid"] = $uid;
      return User::findFirst(array($query));
    }
    

    public static function uuid(){
      if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid =
              substr($charid, 0, 8).
              substr($charid, 8, 4).
              substr($charid,12, 4).
              substr($charid,16, 4).
              substr($charid,20,12);
            return $uuid;
        }
    }
  }
