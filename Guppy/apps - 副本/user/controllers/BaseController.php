<?php
namespace User\Controllers;


/**
*  User Base Controller
*    1、用户登录注册的入口
*    2、提供个人用户信息信息的更改
*/
class BaseController extends \Phalcon\Mvc\Controller{


    public function beforeExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher){

      $controllerName = $dispatcher->getControllerName();
      // echo "<br>in controller controllerName : $controllerName";

      $indentity = $this->session->get("indentity"); //获取用户的身份数据
      if(isset($userInfos)){

      }else{
        // $this->response->redirect('http://localhost/Faeva/user/user/index');  //用户还没有登录
      }
    }

    /**
    *  获取当前的所有以action为后缀的函数名
    *
    * @return array
    */
    public function getActions(){
      $className = get_class($this);
      $reflection = $this->di->get("reflection");  //获取自定义的中间件，用于获取反射对象
      $classObj = $reflection->getReflectionClass($className);
      $methods = $classObj->getMethods();

      $methodNames = [];
      foreach($methods as $method){
        $name = $method->getName();
        if(strpos($name, "Action") > 0){
          $methodNames[count($methodNames)] = $name;
        }
      }
      return $methodNames;
    }

    public function checkUser(){
      return true;
    }
}
