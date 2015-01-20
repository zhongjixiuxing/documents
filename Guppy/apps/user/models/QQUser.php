<?php
  namespace User\Models;

  use \Phalcon\Mvc\Collection,
      \Phalcon\Exception,
      User\Models\Verification,
      Phalcon\Mvc\Model\Validator\Email as EmailValidator;
  /**
  * User Mongo Model
  */
  class QQUser extends Collection{
  /**
    * connection to test document
    */
    public function getSource(){
        return "qqUser";
    }

    public static function getUser($info){
      $qqUser = QQUser::findFirst(array(array('openId' => $info['openId'])));
      if($qqUser){
          $UserId = $qqUser->UserId;
          if($UserId){
            $user = AppUser::findFirst(array(array('UserId' => $UserId)));
            return $user;
          }else{
            foreach(array_keys($info) as $key){
              if($key === 'openId' || $key === 'Assess_Token'){
                continue;
              }else{
                $qqUser->$key = $info[$key];
              }
            }

            $appUser = new AppUser();
            $appUser->UserId = self::uuid();
            $appUser->createDate = self::getService('mongoDate');
            $appUser->gender = $info['gender'];
            $appUser->province = $info['province'];
            $appUser->city = $info['city'];
            $appUser->year = $info['year'];

            $qqUser->UserId = $appUser->UserId;

            $qqUser->save();
            $appUser->save();

            return $appUser;
          }
          return 600;
      }else{ //QQ用户第一次登陆
        $qqUser = new QQUser();
        $qqUser->openId = $info['openId'];
        $qqUser->Access_Token = $info['Assess_Token'];
        $qqUser->createDate = self::getService('mongoDate');
        if($qqUser->save()){
          return 614;
        }
        return 600;
      }
    }

    public static function getService($serviceName){
      $user = new AppUser();
      $di = $user->getDi();
      $service= $di->get($serviceName);
      return $service;
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
