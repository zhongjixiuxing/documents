<?php
namespace Admin\Controllers;

  use Phalcon\Mvc\Controller,
      Phalcon\Mvc\Dispatcher,
      Phalcon\Exception,
      Admin\Models\Power as Power,
      Admin\Models\Mycol as Mycol,
      Admin\Controllers\IndexController as IndexController;

require_once "../global/GlobalUtil.php";

/**
*   Role Controller
*       1、本控制类提供角色的增删改查动作
*
*   注意要点：
*       为类防止外部攻击， 在进行此控制器操作之前必须要进行用户的身份角色校验
*
*/
  class TestController extends Controller{

    public function indexAction(){
      echo "TestController indexAction..";
    }

    //测试在Models初始化是可以根据需要选择不同的数据库
    public function testMongo2Action(){
      $users = Mycol::find();

      echo "<br> users : ".count($users);
      foreach($users as $user){
        echo "<br> name : ".$user->name;
      }
    }

    //测试cookie的存取
    public function testCookieAction(){
      $cookie = $this->cookies;
      if($this->cookies->has("hang")){ //判断cookies中是否存在键
        $hang =$this->cookies->get("hang");//取cookie对象
        echo "<br> cookie hang: ".$hang->getValue();  //取cookie中value；
      }else{
        echo "<br> no hang cookies..";
        $this->cookies->set("hang","my name is hang",time()+ 10);//设置键值 10秒后过期
      }
    }

    //测试增添一个角色记录到数据库中
    public function testPowerAction(){
      $appId = "A234";
      $creflection = $this->di->get("controllerReflection");
      $class = $creflection->getClass("index");
      $methods = $class->getMethods();
      $actions = [];

      $power = new Power();
      $power->appId = $appId;
      $power->powers = [];

      $conts = $creflection->getConts();
      if(isset($conts)){
        foreach($conts as $cont){
          $class = $creflection->getClass($cont);
          $methods = $class->getMethods();
          $actions = [];

          $power->powers[count($power->powers)] = [];
          $power->powers[count($power->powers) - 1]["name"] = $cont;
          $power->powers[count($power->powers) - 1]["name"] = $cont;
          $power->powers[count($power->powers) - 1]['pid'] = GlobalUtil::uuid();
          $power->powers[count($power->powers) - 1]["controller"] = $cont;
          $power->powers[count($power->powers) - 1]['options'] = [];
          $arr = [];
          $arr["options"] = [];
          foreach($methods as $method){
            $name = $method->getName();
            if(strpos($name, "Action") > 0){
              $actions[count($actions)] = $name;
              $index = strpos($name, "Action");
              $name = substr($name, 0, $index);
              $size = count($power->powers[count($power->powers) - 1]['options']);
              $power->powers[count($power->powers) - 1]['options'][count($power->powers[count($power->powers) - 1]['options'])] = [];
              $power->powers[count($power->powers) - 1]['options'][count($power->powers[count($power->powers) - 1]['options']) - 1]["oid"] = GlobalUtil::uuid();
              $power->powers[count($power->powers) - 1]['options'][count($power->powers[count($power->powers) - 1]['options']) - 1]["name"] = $name;
              $power->powers[count($power->powers) - 1]['options'][count($power->powers[count($power->powers) - 1]['options']) - 1]["action"] = $name;
            }
          }
        }

        $power->save();
      }
    }

    //测试phalcon 中的volt模板
    public function testVoltAction(){
      $this->view->value = "hello , my name is anxing...";
      echo "hlls";
    }

    //测试phalcon的转发
    public function testAction(){
      echo "<br> testAction...";
      $dispatcher = $this->di->get("dispatcher");
      $dispatcher->forward(array(
                        'controller' => 'test',
                        'action' => 'index'
                    ));
      echo "ok ...";
    }

    public function noFount_404Action(){
      echo "<br> yse , this is TestController noFount_404Action...";
    }

    //测试php的反射机制
    public function testReflectionMethodAction($info){
      echo "<br>testController tstREflectionMehod..<br>";
      $class = $this->di->get("cla");
      $methods = $class->getMethods();
      foreach($methods as $method){
        echo "<br> method name : ".$method->name;
        if($method->name === "indexAction"){
          echo "<br> yes ...";
          $intance = new IndexController();
          $method->invoke($intance);  //无参数执行
          //$method->invokeArgs($class, array($info));
        }
      }
    }

    //测试phalcon中的异常
    public function testExceptionAction($id){
      if($id === "123")
        throw new Exception('Can`t find user by id = ' . $id, 404);
      else{
        echo "<br> id is not 123";
      }
    }

  }
