<?php
namespace User\Controllers;

use User\Models\User;


/**
*  User Manage Controller
*    1、用户登录注册的入口
*    2、提供个人用户信息信息的更改
*/
class TestController extends \Phalcon\Mvc\Controller{
    public function beforeExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher){
      $controllerName = $dispatcher->getControllerName();
      echo "<br>in controller controllerName : $controllerName";

      if($controllerName === "index"){
      }
    }

    public function serializeAction(){
      $user = User::findFirst();

      file_put_contents("../cache/cache-20150107.txt", serialize($user));

      echo "ok";
    }

    public function unserializeAction(){
      $user = unserialize(file_get_contents("../cache/cache-20150107.txt"));

      if($user){
        echo "ye .. is exist cache and user is : ";print_r($user);
      }else{
        echo "no , no nono";
      }

    }

    public function indexAction(){
      echo "<br> index ...";
      $dispatcher = $this->dispatcher;
      echo "<br>. dispatcher : ";
      print_r($dispatcher);
       $this->dispatcher->forward(array('controller' => 'power', 'action' => 'index'));
    }

}
