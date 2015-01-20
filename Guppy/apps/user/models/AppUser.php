<?php
  namespace User\Models;

  use \Phalcon\Mvc\Collection,
      \Phalcon\Exception,
      User\Models\Verification,
      Phalcon\Mvc\Model\Validator\Email as EmailValidator;
  /**
  * User Mongo Model
  */
  class AppUser extends Collection{

    private static $privateField = array(
      'UserId' => 0,
      'createDate' => 0
    );

    /**
    * connection to test document
    */
    public function getSource(){
        return "appUser";
    }

    /**
    * 判断是否为私有的字段（私有字段不可以修改）
    */
    public static function isPrivateField($field){
      return array_key_exists($field, self::$privateField);
    }

    public function beforeCreate(){
      $this->UserId = self::uuid();
      $this->createDate = self::getService('mongoDate');
    }

    public function beforeUpdate(){
    }

    public function beforeSave(){
    }


    //邮箱校验
    public function validation_back()
    {
        $this->validate(new EmailValidator(array(
            'field' => 'email'
        )));
        if ($this->validationHasFailed() == true) {
            throw new Exception('email', 1001);
            return false;
        }
    }

    /**
    *  检索数据库中是否存在某个字段
    *　@param $arr 检索参数数组0
    *  @return bool
    */
    public static function isExistField($arr){
      if(count($arr)){
        foreach ($arr as $key => $value){
          $result = AppUser::findFirst(array(array($key => $value)));
          if($result)
            return true;
        }
      }
      return false;
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
      $result = AppUser::find(array($query));

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
      return AppUser::findFirst(array($query));
    }

    public static function updatePwdByEmail($email, $emailUtil){
      $query = array();
      $query['email'] = $email;

      $user = User::findFirst(array($query));
      if($user){
        $verification = new Verification();
        $verification->UserId = $user->UserId;
        $verification->vCode = User::uuid();
        $verification->status = true;
        $verification->createDate = date('Y-m-d H:i:s');
        $verification->save();

        $emailUtil->sendUpdatePwd($user->toArray(), $verification->vCode);

      }else{
        return 609;
      }
    }

    public static function updatePwdByEmail2($UserId, $vCode, $pwd){
      $query = array();
      $query['UserId'] = $UserId;
      $query['vCode'] = $vCode;
      $verification = Verification::findFirst(array($query));
      if($verification){
        if($verification->status){
          $user = User::findFirst(array(array('UserId' => $UserId)));
          if($user){
            $user->password = $pwd;
            if($user->save())
              return 0;
            else
              return 600;
          }else{
            return 613;
          }
        }else{
          return 615;
        }
      }else{
        return 600;
      }
    }

    public static function register($query){
      if(AppUser::findFirst(array(array('loginname' => $query['loginname'])))){
        return 602;
      }else if(AppUser::findFirst(array(array('email' => $query['email'])))){
        return 603;
      }

      $user = new AppUser();
      foreach(array_keys($query) as $key){
        $user->$key = $query[$key];
      }

      if(!$user->save()){
          throw new Exception('系统错误！');
      }
    }

    /**
    *   根据id获取用户
    * @param string uid
    * @return User\Models\User / false
    */
    public static function getUserById($uid){
      $query = array();
      $query["uid"] = $uid;
      return AppUser::findFirst(array($query));
    }

    public static function updatePwd($userId, $oldPassword, $newPassword){
      $user = AppUser::findFirst(array(array('UserId' => $userId)));
      if($user){
        if($user->password === $oldPassword){
          $user->password = $newPassword;
          $user->save();
        }else{
          return 611;
        }
      }else{
        return 600;
      }
    }


    public static function getService($serviceName){
      $user = new AppUser();
      $di = $user->getDi();
      $service= $di->get($serviceName);
      return $service;
    }

    //生产32为的UUID
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
